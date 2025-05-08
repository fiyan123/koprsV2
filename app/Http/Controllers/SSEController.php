<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SSEController extends Controller
{
    // public function denda_pinjaman()
    // {

    // }

    public function denda_pinjaman()
    {
        $response = new StreamedResponse(function () {
            // Header SSE
            $lastSentHash = null;

            while (true) {
                try {
                    $pinjamans = DB::table('pinjamans')
                        ->join('angsuran_pinjaman', 'pinjamans.id', '=', 'angsuran_pinjaman.pinjaman_id')
                        ->where('pinjamans.status', 'approved')
                        ->where('pinjamans.status_pinjaman', 'aktif')
                        ->whereNull('angsuran_pinjaman.tanggal_bayar')
                        ->select(
                            'pinjamans.id as pinjaman_id',
                            'pinjamans.user_id as pinjaman_user_id',
                            'pinjamans.nama',
                            'pinjamans.bunga',
                            'pinjamans.cicilan_pembayaran',
                            'pinjamans.tipe_durasi',
                            'pinjamans.status_pinjaman',
                            'angsuran_pinjaman.id as angsuran_id',
                            'angsuran_pinjaman.angsuran_ke',
                            'angsuran_pinjaman.jatuh_tempo',
                            'angsuran_pinjaman.tanggal_bayar',
                            'angsuran_pinjaman.status as status_angsuran'
                        )
                        ->get();

                    $hardcodedNow = Carbon::now();

                    // Kelompokkan berdasarkan pinjaman_id
                    $grouped = $pinjamans->groupBy('pinjaman_id');

                    $results = [];

                    foreach ($grouped as $pinjamanId => $angsuranList) {
                        $totalTelat = 0;
                        $totalDenda = 0;
                        $bunga = $angsuranList[0]->bunga;
                        $cicilan = $angsuranList[0]->cicilan_pembayaran;
                        $dendaPerHari = ($bunga / 100) * $cicilan;

                        $angsuranDetails = [];
                        $totalTelatBayar = 0; // Total telat bayar per pinjaman
                        $totalDendaPinjaman = 0; // Total denda per pinjaman

                        foreach ($angsuranList as $item) {
                            $jatuhTempo = Carbon::parse($item->jatuh_tempo);
                            $tanggalBayar = $item->tanggal_bayar ? Carbon::parse($item->tanggal_bayar) : $hardcodedNow;

                            $terlambat = $tanggalBayar->greaterThan($jatuhTempo);
                            $selisihHari = $terlambat ? $jatuhTempo->diffInDays($tanggalBayar) : 0;

                            $dendaSaatIni = $selisihHari * $dendaPerHari;
                            $totalDendaPinjaman += $dendaSaatIni;

                            if ($selisihHari > 0 && $item->status_angsuran !== 'lunas') {
                                $totalTelat += 1;
                                $totalTelatBayar += $selisihHari; // Menghitung total keterlambatan per pinjaman
                            }

                            // Update denda untuk angsuran tertentu
                            DB::table('angsuran_pinjaman')->where('id', $item->angsuran_id)->update([
                                'denda' => round($dendaSaatIni, 2),
                                'total_denda' => $selisihHari
                            ]);

                            $angsuranDetails[] = [
                                'angsuran_id' => $item->angsuran_id,
                                'angsuran_ke' => $item->angsuran_ke,
                                'jatuh_tempo' => $item->jatuh_tempo,
                                'tanggal_bayar' => $item->tanggal_bayar ?? $hardcodedNow->toDateString(),
                                'terlambat_hari' => $selisihHari,
                                'denda' => round($dendaSaatIni, 2),
                                'status_angsuran' => $item->status_angsuran,
                                'telat_bayar' => $selisihHari // Menambahkan telat bayar per angsuran
                            ];
                        }

                        $results[] = [
                            'pinjaman_id' => $pinjamanId,
                            'user_id' => $angsuranList[0]->pinjaman_user_id,
                            'nama' => $angsuranList[0]->nama,
                            'bunga' => $bunga,
                            'cicilan_pembayaran' => $cicilan,
                            'denda_per_hari' => round($dendaPerHari, 2),
                            'total_denda_semua' => round($totalDendaPinjaman, 2), // Total denda per pinjaman
                            'jumlah_kali_telat' => $totalTelat,
                            'total_telat_bayar' => $totalTelatBayar, // Total keterlambatan per pinjaman
                            'angsuran' => $angsuranDetails
                        ];
                    }

                    $currentData = [
                        'success' => true,
                        'message' => 'Denda dan jumlah keterlambatan berhasil dihitung.',
                        'data' => $results
                    ];

                    $currentHash = md5(json_encode($currentData));

                    // Only send updates if the data has changed
                    if ($lastSentHash !== $currentHash) {
                        echo 'data: ' . json_encode($currentData) . "\n\n";
                        $lastSentHash = $currentHash;
                    }

                    @ob_flush();
                    @flush();

                    // If connection is aborted, break out of the loop
                    if (connection_aborted()) break;

                    // Wait for 1 day (86400 seconds)
                    sleep(86400); // Wait for 24 hours
                } catch (\Exception $e) {
                    echo "event: error\n";
                    echo 'data: ' . json_encode(['error' => $e->getMessage()]) . "\n\n";
                    @ob_flush();
                    @flush();
                    break;
                }
            }
        });

        // Set headers for SSE
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }

    // public function denda_pinjaman()
    // {
    //     $pinjamans = DB::table('pinjamans')
    //         ->join('angsuran_pinjaman', 'pinjamans.id', '=', 'angsuran_pinjaman.pinjaman_id')
    //         ->where('pinjamans.status', 'approved')
    //         ->where('pinjamans.status_pinjaman', 'aktif')
    //         ->whereNull('angsuran_pinjaman.tanggal_bayar')
    //         ->select(
    //             'pinjamans.id as pinjaman_id',
    //             'pinjamans.user_id as pinjaman_user_id',
    //             'pinjamans.nama',
    //             'pinjamans.bunga',
    //             'pinjamans.cicilan_pembayaran',
    //             'pinjamans.tipe_durasi',
    //             'pinjamans.status_pinjaman',
    //             'angsuran_pinjaman.id as angsuran_id',
    //             'angsuran_pinjaman.angsuran_ke',
    //             'angsuran_pinjaman.jatuh_tempo',
    //             'angsuran_pinjaman.tanggal_bayar',
    //             'angsuran_pinjaman.status as status_angsuran'
    //         )
    //         ->get();

    //     $hardcodedNow = Carbon::now();

    //     // Kelompokkan berdasarkan pinjaman_id
    //     $grouped = $pinjamans->groupBy('pinjaman_id');

    //     $results = [];

    //     foreach ($grouped as $pinjamanId => $angsuranList) {
    //         $totalTelat = 0;
    //         $totalDenda = 0;
    //         $bunga = $angsuranList[0]->bunga;
    //         $cicilan = $angsuranList[0]->cicilan_pembayaran;
    //         $dendaPerHari = ($bunga / 100) * $cicilan;

    //         $angsuranDetails = [];
    //         $totalTelatBayar = 0; // Total telat bayar per pinjaman
    //         $totalDendaPinjaman = 0; // Total denda per pinjaman

    //         foreach ($angsuranList as $item) {
    //             $jatuhTempo = Carbon::parse($item->jatuh_tempo);
    //             $tanggalBayar = $item->tanggal_bayar ? Carbon::parse($item->tanggal_bayar) : $hardcodedNow;

    //             $terlambat = $tanggalBayar->greaterThan($jatuhTempo);
    //             $selisihHari = $terlambat ? $jatuhTempo->diffInDays($tanggalBayar) : 0;

    //             $dendaSaatIni = $selisihHari * $dendaPerHari;
    //             $totalDendaPinjaman += $dendaSaatIni;

    //             if ($selisihHari > 0 && $item->status_angsuran !== 'lunas') {
    //                 $totalTelat += 1;
    //                 $totalTelatBayar += $selisihHari; // Menghitung total keterlambatan per pinjaman
    //             }

    //             // Update denda untuk angsuran tertentu
    //             DB::table('angsuran_pinjaman')->where('id', $item->angsuran_id)->update([
    //                 'denda' => round($dendaSaatIni, 2),
    //                 'total_denda' => $selisihHari
    //             ]);

    //             $angsuranDetails[] = [
    //                 'angsuran_id' => $item->angsuran_id,
    //                 'angsuran_ke' => $item->angsuran_ke,
    //                 'jatuh_tempo' => $item->jatuh_tempo,
    //                 'tanggal_bayar' => $item->tanggal_bayar ?? $hardcodedNow->toDateString(),
    //                 'terlambat_hari' => $selisihHari,
    //                 'denda' => round($dendaSaatIni, 2),
    //                 'status_angsuran' => $item->status_angsuran,
    //                 'telat_bayar' => $selisihHari // Menambahkan telat bayar per angsuran
    //             ];
    //         }

    //         $results[] = [
    //             'pinjaman_id' => $pinjamanId,
    //             'user_id' => $angsuranList[0]->pinjaman_user_id,
    //             'nama' => $angsuranList[0]->nama,
    //             'bunga' => $bunga,
    //             'cicilan_pembayaran' => $cicilan,
    //             'denda_per_hari' => round($dendaPerHari, 2),
    //             'total_denda_semua' => round($totalDendaPinjaman, 2), // Total denda per pinjaman
    //             'jumlah_kali_telat' => $totalTelat,
    //             'total_telat_bayar' => $totalTelatBayar, // Total keterlambatan per pinjaman
    //             'angsuran' => $angsuranDetails
    //         ];
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Denda dan jumlah keterlambatan berhasil dihitung.',
    //         'data' => $results
    //     ]);
    // }


    public function getTotalNasabah()
    {
        return DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.id', 3)
            ->count();
    }

    // public function getTotalPinjaman()
    // {
    //     return DB::table('pinjamans')
    //         ->where('status', 'approved')
    //         ->where('status_pinjaman', 'aktif')
    //         ->sum('jumlah');
    // }
    public function getTotalSimpanan()
    {
        return DB::table('simpanans')
            ->count();
    }
    public function getTotalPinjaman()
    {
        return DB::table('pinjamans')
            ->where('status', 'approved')
            ->where('status_pinjaman', 'aktif')
            ->count();
    }

    public function TotalAllChart()
    {
        $response = new StreamedResponse(function () {
            // Header SSE

            $lastSentHash = null;

            while (true) {
                try {
                    $totalNasabah = $this->getTotalNasabah();
                    $totalPinjaman = $this->getTotalPinjaman();
                    $totalSimpanan = $this->getTotalSimpanan();

                    $currentData = [
                        'get_total_nasabah' => $totalNasabah,
                        'get_total_pinjaman' => $totalPinjaman,
                        'get_total_simpanan' => $totalSimpanan,
                    ];

                    $currentHash = md5(json_encode($currentData));

                    if ($lastSentHash !== $currentHash) {
                        echo 'data: ' . json_encode($currentData) . "\n\n";
                        $lastSentHash = $currentHash;
                    }

                    @ob_flush();
                    @flush();

                    // Jika koneksi terputus dari client
                    if (connection_aborted()) break;

                } catch (\Exception $e) {
                    echo "event: error\n";
                    echo 'data: ' . json_encode(['error' => $e->getMessage()]) . "\n\n";
                    @ob_flush();
                    @flush();
                    break;
                }

                sleep(1); // tunggu 1 detik
            }
        });

        // Set header untuk SSE
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }
}
