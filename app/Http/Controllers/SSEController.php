<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SSEController extends Controller
{
    public function getSaldoPerUser()
    {
        $data = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->leftJoin('simpanans as simpan', function ($join) {
                $join->on('users.id', '=', 'simpan.user_id')
                    ->where('simpan.status', '=', 'simpan');
            })
            ->leftJoin('simpanans as tarik', function ($join) {
                $join->on('users.id', '=', 'tarik.user_id')
                    ->where('tarik.status', '=', 'tarik');
            })
            ->leftJoin('simpanans as potong', function ($join) {
                $join->on('users.id', '=', 'potong.user_id')
                    ->where('potong.status', '=', 'potong');
            })
            ->where('roles.id', 3) // Filter hanya role_id = 3 (misalnya: santri)
            ->select(
                'users.*',
                DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) as total_simpan'),
                DB::raw('COALESCE(SUM(DISTINCT tarik.jumlah), 0) as total_tarik'),
                DB::raw('COALESCE(SUM(DISTINCT potong.jumlah), 0) as total_potong'),
                DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) - (COALESCE(SUM(DISTINCT tarik.jumlah), 0) + COALESCE(SUM(DISTINCT potong.jumlah), 0)) as saldo_akhir')
            )
            ->groupBy('users.id')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Data saldo akhir per user berhasil diambil.',
            'data' => $data
        ]);
    }
    public function getlaporanPinjam(Request $request)
    {
        $pinjam = DB::table('pinjamans')
            ->whereNotIn('pinjamans.status', ['rejected', 'pending'])
            ->where('pinjamans.status_pinjaman', '!=', 'tidak_aktif')
            ->join('angsuran_pinjaman', 'pinjamans.id', '=', 'angsuran_pinjaman.pinjaman_id')
            ->join('users', 'pinjamans.user_id', '=', 'users.id')
            ->select(
                'pinjamans.created_at',
                DB::raw('MAX(pinjamans.user_id) as user_id'),
                DB::raw('MAX(users.name) as user_name'),
                DB::raw('SUM(angsuran_pinjaman.denda) as jumlah_denda'),
                DB::raw('MAX(pinjamans.jumlah) as jumlah_pinjaman'),
                DB::raw('MAX(pinjamans.total_pembayaran) as total_bayar_pinjaman'),
                DB::raw('MAX(pinjamans.tipe_durasi) as tipe_durasi'),
                DB::raw('MAX(pinjamans.durasi) as durasi'),
                DB::raw('MAX(pinjamans.bunga) as bunga'),
                DB::raw('MAX(pinjamans.status) as status'),
                DB::raw('MAX(pinjamans.status_pinjaman) as status_pinjaman')
            )
            ->groupBy('pinjamans.created_at')
            ->get();
        // dd($pinjam);
        // Initialize total variables
        $total_jumlah_pinjaman_all = 0;
        $total_bayar_Pinjaman_all = 0;
        $total_jumlah_denda_all = 0;
        $total_jumlah_keuntungan = 0;
        $user_ids = [];

        // Calculate totals from the retrieved data
        foreach ($pinjam as $value) {
            // Sum up the totals
            $total_jumlah_pinjaman_all += $value->jumlah_pinjaman;
            $total_bayar_Pinjaman_all += $value->total_bayar_pinjaman;
            $total_jumlah_denda_all += $value->jumlah_denda;

            // Collect user_ids for counting unique users
            $user_ids[] = $value->user_id;
        }

        // Calculate total keuntungan
        $total_jumlah_keuntungan = ($total_bayar_Pinjaman_all - $total_jumlah_pinjaman_all) + $total_jumlah_denda_all;

        // Count unique user ids
        $total_user_pinjaman_all = count(array_unique($user_ids));

        // Return the response with totals included
        return response()->json([
            'success' => true,
            'message' => 'Data laporan pinjaman berhasil diambil.',
            'data' => $pinjam,
            'total_user_pinjaman_all' => $total_user_pinjaman_all,
            'total_jumlah_pinjaman_all' => number_format($total_jumlah_pinjaman_all, 2),
            'total_bayar_Pinjaman_all' => number_format($total_bayar_Pinjaman_all, 2),
            'total_jumlah_denda_all' => number_format($total_jumlah_denda_all, 2),
            'total_jumlah_keuntungan' => number_format($total_jumlah_keuntungan, 2)
        ]);
    }




    public function getlaporan(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        // Ambil data total simpan per user
        $simpan = DB::table('simpanans')
            ->join('users', 'simpanans.user_id', 'users.id')
            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status', 'users.name')
            ->where('status', 'simpan')
            ->groupBy('user_id', 'status', 'users.name')
            ->orderBy('user_id');

        if ($tahun) {
            $simpan->whereYear('simpanans.created_at', $tahun);
        }
        if ($bulan) {
            $simpan->whereMonth('simpanans.created_at', $bulan);
        }
        $simpan = $simpan->get();

        // Ambil data total tarik per user
        $tarik = DB::table('simpanans')
            ->join('users', 'simpanans.user_id', 'users.id')

            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status', 'users.name')
            ->where('status', 'tarik')
            ->groupBy('user_id', 'status', 'users.name')
            ->orderBy('user_id');

        if ($tahun) {
            $tarik->whereYear('simpanans.created_at', $tahun);
        }
        if ($bulan) {
            $tarik->whereMonth('simpanans.created_at', $bulan);
        }
        $tarik = $tarik->get();

        // Ambil data total potong per user
        $potong = DB::table('simpanans')
            ->join('users', 'simpanans.user_id', 'users.id')

            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status', 'users.name')
            ->where('status', 'potong')
            ->groupBy('user_id', 'status', 'users.name')
            ->orderBy('user_id');

        if ($tahun) {
            $potong->whereYear('simpanans.created_at', $tahun);
        }
        if ($bulan) {
            $potong->whereMonth('simpanans.created_at', $bulan);
        }
        $potong = $potong->get();

        // Menghitung saldo akhir per user (tarik + potong - simpan)
        $saldo = [];
        $total_simpan_jumlah = $simpan->sum('sum_jumlah');
        $total_tarik_jumlah = $tarik->sum('sum_jumlah');
        $total_potong_jumlah = $potong->sum('sum_jumlah');

        foreach ($simpan as $itemSimpan) {
            // Temukan data tarik dan potong berdasarkan user_id
            $tarikUser = $tarik->firstWhere('user_id', $itemSimpan->user_id);
            $potongUser = $potong->firstWhere('user_id', $itemSimpan->user_id);

            // Hitung saldo (tarik + potong - simpan)
            $sumTarik = $tarikUser ? $tarikUser->sum_jumlah : 0;
            $sumPotong = $potongUser ? $potongUser->sum_jumlah : 0;

            // Saldo akhir per user
            $saldo[$itemSimpan->user_id] = [
                'user_id' => $itemSimpan->user_id,
                'user_name' => $itemSimpan->name,
                'saldo_akhir' => $itemSimpan->sum_jumlah - ($sumTarik + $sumPotong),
                'status' => 'simpan'
            ];
        }

        // Menghitung total keseluruhan untuk status simpan, tarik, dan potong
        $total_simpan = [
            'count_user' => $simpan->count(),
            'count_jumlah' => $total_simpan_jumlah,
            'status' => 'simpan'
        ];

        $total_tarik = [
            'count_user' => $tarik->count(),
            'count_jumlah' => $total_tarik_jumlah,
            'status' => 'tarik'
        ];

        $total_potong = [
            'count_user' => $potong->count(),
            'count_jumlah' => $total_potong_jumlah,
            'status' => 'potong'
        ];

        // Menghitung total user keseluruhan (count_user_all)
        $all_user_ids = $simpan->pluck('user_id')->merge($tarik->pluck('user_id'))->merge($potong->pluck('user_id'))->unique();
        $count_user_all = $all_user_ids->count();

        // Menghitung count_jumlah_all (simpan - (tarik + potong))
        $count_jumlah_all = $total_simpan_jumlah - ($total_tarik_jumlah + $total_potong_jumlah);

        // Mengembalikan response dengan data dan total_all
        return response()->json([
            'success' => true,
            'message' => 'Data total simpanan, tarik, dan potong per user berhasil diambil',
            'data' => $saldo,
            'total_all' => [
                'count_user_simpan' => $total_simpan['count_user'],
                'count_user_tarik' => $total_tarik['count_user'],
                'count_user_potong' => $total_potong['count_user'],
                'count_user_all' => $count_user_all,
                'count_jumlah_simpan' => $total_simpan['count_jumlah'],
                'count_jumlah_tarik' => $total_tarik['count_jumlah'],
                'count_jumlah_potong' => $total_potong['count_jumlah'],
                'count_jumlah_all' => $count_jumlah_all
            ]
        ]);
    }

    // public function denda_pinjaman()
    // {

    // }
    public function getlaporanSimpan(Request $request)
    {
        // Ambil data total simpanan per user
        $data = DB::table('simpanans')
            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status')
            ->where('status', 'simpan')
            ->groupBy('user_id', 'status')
            ->orderBy('user_id')
            ->get();

        // Menghitung total keseluruhan (total jumlah dan total user)
        $total_all = [
            'count_user' => $data->count(),
            'count_jumlah' => $data->sum('sum_jumlah'),
            'status' => 'simpan'
        ];

        // Mengembalikan response dengan data dan total_all
        return response()->json([
            'success' => true,
            'message' => 'Data total simpanan per user berhasil diambil',
            'data' => $data,
            'total_all' => $total_all
        ]);
    }
    public function getlaporanTarik(Request $request)
    {
        // Ambil data total tarik per user
        $data = DB::table('simpanans')
            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status')
            ->where('status', 'tarik')
            ->groupBy('user_id', 'status')
            ->orderBy('user_id')
            ->get();

        // Menghitung total keseluruhan (total jumlah dan total user) untuk status tarik
        $total_all = [
            'count_user' => $data->count(),
            'count_jumlah' => $data->sum('sum_jumlah'),
            'status' => 'tarik'
        ];

        // Mengembalikan response dengan data dan total_all untuk status tarik
        return response()->json([
            'success' => true,
            'message' => 'Data total tarik per user berhasil diambil',
            'data' => $data,
            'total_all' => $total_all
        ]);
    }

    public function getlaporanPotong(Request $request)
    {
        // Ambil data total potong per user
        $data = DB::table('simpanans')
            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status')
            ->where('status', 'potong')
            ->groupBy('user_id', 'status')
            ->orderBy('user_id')
            ->get();

        // Menghitung total keseluruhan (total jumlah dan total user) untuk status potong
        $total_all = [
            'count_user' => $data->count(),
            'count_jumlah' => $data->sum('sum_jumlah'),
            'status' => 'potong'
        ];

        // Mengembalikan response dengan data dan total_all untuk status potong
        return response()->json([
            'success' => true,
            'message' => 'Data total potong per user berhasil diambil',
            'data' => $data,
            'total_all' => $total_all
        ]);
    }


    public function denda_pinjaman()
    {
        $response = new StreamedResponse(function () {
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
                    // $now = Carbon::parse('2025-09-11');


                    $now = Carbon::now();
                    $grouped = $pinjamans->groupBy('pinjaman_id');
                    $results = [];

                    foreach ($grouped as $pinjamanId => $angsuranList) {
                        $totalTelat = 0;
                        $totalDendaPinjaman = 0;
                        $totalTelatBayar = 0;

                        $first = $angsuranList[0];
                        $bunga = $first->bunga;
                        $cicilan = $first->cicilan_pembayaran;
                        $tipeDurasi = $first->tipe_durasi;

                        $dendaPerUnit = ($bunga / 100) * $cicilan;
                        $angsuranDetails = [];

                        foreach ($angsuranList as $item) {
                            $jatuhTempo = Carbon::parse($item->jatuh_tempo);
                            $tanggalBayar = $item->tanggal_bayar ? Carbon::parse($item->tanggal_bayar) : $now;

                            $terlambat = $tanggalBayar->greaterThan($jatuhTempo);

                            // Hitung selisih durasi sesuai tipe_durasi
                            $selisihDurasi = 0;
                            if ($terlambat) {
                                switch ($tipeDurasi) {
                                    case 'bulanan':
                                        $selisihDurasi = $jatuhTempo->diffInMonths($tanggalBayar);
                                        break;
                                    case 'tahunan':
                                        $selisihDurasi = $jatuhTempo->diffInYears($tanggalBayar);
                                        break;
                                    default: // harian
                                        $selisihDurasi = $jatuhTempo->diffInDays($tanggalBayar);
                                        break;
                                }
                            }

                            $dendaSaatIni = $selisihDurasi * $dendaPerUnit;
                            $totalDendaPinjaman += $dendaSaatIni;

                            if ($selisihDurasi > 0 && $item->status_angsuran !== 'lunas') {
                                $totalTelat++;
                                $totalTelatBayar += $selisihDurasi;
                            }

                            // Update ke DB
                            DB::table('angsuran_pinjaman')->where('id', $item->angsuran_id)->update([
                                'denda' => round($dendaSaatIni, 2),
                                'total_denda' => $selisihDurasi
                            ]);

                            $angsuranDetails[] = [
                                'angsuran_id' => $item->angsuran_id,
                                'angsuran_ke' => $item->angsuran_ke,
                                'jatuh_tempo' => $item->jatuh_tempo,
                                'tanggal_bayar' => $item->tanggal_bayar ?? $now->toDateString(),
                                'terlambat_durasi' => $selisihDurasi,
                                'denda' => round($dendaSaatIni, 2),
                                'status_angsuran' => $item->status_angsuran,
                                'unit_durasi' => $tipeDurasi
                            ];
                        }

                        $results[] = [
                            'pinjaman_id' => $pinjamanId,
                            'user_id' => $first->pinjaman_user_id,
                            'nama' => $first->nama,
                            'bunga' => $bunga,
                            'cicilan_pembayaran' => $cicilan,
                            'tipe_durasi' => $tipeDurasi,
                            'denda_per_' . $tipeDurasi => round($dendaPerUnit, 2),
                            'total_denda_semua' => round($totalDendaPinjaman, 2),
                            'jumlah_kali_telat' => $totalTelat,
                            'total_telat_bayar' => $totalTelatBayar,
                            'angsuran' => $angsuranDetails
                        ];
                    }

                    $currentData = [
                        'success' => true,
                        'message' => 'Denda dan keterlambatan berhasil dihitung.',
                        'data' => $results
                    ];

                    $currentHash = md5(json_encode($currentData));
                    if ($lastSentHash !== $currentHash) {
                        echo 'data: ' . json_encode($currentData) . "\n\n";
                        $lastSentHash = $currentHash;
                    }

                    @ob_flush();
                    @flush();

                    if (connection_aborted()) break;

                    sleep(86400); // 24 jam
                } catch (\Exception $e) {
                    echo "event: error\n";
                    echo 'data: ' . json_encode(['error' => $e->getMessage()]) . "\n\n";
                    @ob_flush();
                    @flush();
                    break;
                }
            }
        });

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
        $data =  DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.id', 3)
            ->count();
        return response()->json([
            'success' => true,
            'message' => 'Data total simpanan, tarik, dan potong per user berhasil diambil',
            'data' => $data,
        ]);
    }
    public function getTotalSimpanan()
    {
        // Ambil data total simpan per user
        $simpan = DB::table('simpanans')
            ->join('users', 'simpanans.user_id', 'users.id')
            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status', 'users.name')
            ->where('status', 'simpan')
            ->groupBy('user_id', 'status', 'users.name')
            ->orderBy('user_id')
            ->get();

        // Ambil data total tarik per user
        $tarik = DB::table('simpanans')
            ->join('users', 'simpanans.user_id', 'users.id')

            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status', 'users.name')
            ->where('status', 'tarik')
            ->groupBy('user_id', 'status', 'users.name')
            ->orderBy('user_id')
            ->get();

        // Ambil data total potong per user
        $potong = DB::table('simpanans')
            ->join('users', 'simpanans.user_id', 'users.id')

            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status', 'users.name')
            ->where('status', 'potong')
            ->groupBy('user_id', 'status', 'users.name')
            ->orderBy('user_id')
            ->get();

        // Menghitung saldo akhir per user (tarik + potong - simpan)
        $saldo = [];
        $total_simpan_jumlah = $simpan->sum('sum_jumlah');
        $total_tarik_jumlah = $tarik->sum('sum_jumlah');
        $total_potong_jumlah = $potong->sum('sum_jumlah');

        foreach ($simpan as $itemSimpan) {
            // Temukan data tarik dan potong berdasarkan user_id
            $tarikUser = $tarik->firstWhere('user_id', $itemSimpan->user_id);
            $potongUser = $potong->firstWhere('user_id', $itemSimpan->user_id);

            // Hitung saldo (tarik + potong - simpan)
            $sumTarik = $tarikUser ? $tarikUser->sum_jumlah : 0;
            $sumPotong = $potongUser ? $potongUser->sum_jumlah : 0;

            // Saldo akhir per user
            $saldo[$itemSimpan->user_id] = [
                'user_id' => $itemSimpan->user_id,
                'user_name' => $itemSimpan->name,
                'saldo_akhir' => $itemSimpan->sum_jumlah - ($sumTarik + $sumPotong),
                'status' => 'simpan'
            ];
        }

        // Menghitung total keseluruhan untuk status simpan, tarik, dan potong
        $total_simpan = [
            'count_user' => $simpan->count(),
            'count_jumlah' => $total_simpan_jumlah,
            'status' => 'simpan'
        ];

        $total_tarik = [
            'count_user' => $tarik->count(),
            'count_jumlah' => $total_tarik_jumlah,
            'status' => 'tarik'
        ];

        $total_potong = [
            'count_user' => $potong->count(),
            'count_jumlah' => $total_potong_jumlah,
            'status' => 'potong'
        ];

        // Menghitung total user keseluruhan (count_user_all)
        $all_user_ids = $simpan->pluck('user_id')->merge($tarik->pluck('user_id'))->merge($potong->pluck('user_id'))->unique();
        $count_user_all = $all_user_ids->count();

        // Menghitung count_jumlah_all (simpan - (tarik + potong))
        $count_jumlah_all = $total_simpan_jumlah - ($total_tarik_jumlah + $total_potong_jumlah);

        // Mengembalikan response dengan data dan total_all
        return response()->json([
            'success' => true,
            'message' => 'Data total simpanan, tarik, dan potong per user berhasil diambil',
            'data' => $count_jumlah_all,
        ]);
    }
    public function getTotalPinjaman()
    {
        $pinjam = DB::table('pinjamans')
            ->whereNotIn('pinjamans.status', ['rejected', 'pending'])
            ->where('pinjamans.status_pinjaman', '!=', 'tidak_aktif')
            ->join('angsuran_pinjaman', 'pinjamans.id', '=', 'angsuran_pinjaman.pinjaman_id')
            ->join('users', 'pinjamans.user_id', '=', 'users.id')
            ->select(
                'pinjamans.created_at',
                DB::raw('MAX(pinjamans.user_id) as user_id'),
                DB::raw('MAX(users.name) as user_name'),
                DB::raw('SUM(angsuran_pinjaman.denda) as jumlah_denda'),
                DB::raw('MAX(pinjamans.jumlah) as jumlah_pinjaman'),
                DB::raw('MAX(pinjamans.total_pembayaran) as total_bayar_pinjaman'),
                DB::raw('MAX(pinjamans.tipe_durasi) as tipe_durasi'),
                DB::raw('MAX(pinjamans.durasi) as durasi'),
                DB::raw('MAX(pinjamans.bunga) as bunga'),
                DB::raw('MAX(pinjamans.status) as status'),
                DB::raw('MAX(pinjamans.status_pinjaman) as status_pinjaman')
            )
            ->groupBy('pinjamans.created_at')
            ->get();
        // dd($pinjam);
        // Initialize total variables
        $total_jumlah_pinjaman_all = 0;
        $total_bayar_Pinjaman_all = 0;
        $total_jumlah_denda_all = 0;
        $total_jumlah_keuntungan = 0;
        $user_ids = [];

        // Calculate totals from the retrieved data
        foreach ($pinjam as $value) {
            // Sum up the totals
            $total_jumlah_pinjaman_all += $value->jumlah_pinjaman;
            $total_bayar_Pinjaman_all += $value->total_bayar_pinjaman;
            $total_jumlah_denda_all += $value->jumlah_denda;

            // Collect user_ids for counting unique users
            $user_ids[] = $value->user_id;
        }

        // Calculate total keuntungan
        $total_jumlah_keuntungan = ($total_bayar_Pinjaman_all - $total_jumlah_pinjaman_all) + $total_jumlah_denda_all;

        // Count unique user ids
        $total_user_pinjaman_all = count(array_unique($user_ids));

        // Return the response with totals included
        return response()->json([
            'success' => true,
            'message' => 'Data laporan pinjaman berhasil diambil.',
            'data' => number_format($total_jumlah_pinjaman_all, 2),
        ]);
    }

    // public function getTotalPinjaman()
    // {
    //     return DB::table('pinjamans')
    //         ->where('status', 'approved')
    //         ->where('status_pinjaman', 'aktif')
    //         ->sum('jumlah');
    // }
    // public function getTotalSimpanan()
    // {
    //     return DB::table('simpanans')
    //         ->count();
    // }


    // public function TotalAllChart()
    // {
    //     $response = new StreamedResponse(function () {
    //         // Header SSE

    //         $lastSentHash = null;

    //         while (true) {
    //             try {
    //                 $totalNasabah = $this->getTotalNasabah();
    //                 $totalPinjaman = $this->getTotalPinjaman();
    //                 $totalSimpanan = $this->getTotalSimpanan();

    //                 $currentData = [
    //                     'get_total_nasabah' => $totalNasabah,
    //                     'get_total_pinjaman' => $totalPinjaman,
    //                     'get_total_simpanan' => $totalSimpanan,
    //                 ];

    //                 $currentHash = md5(json_encode($currentData));

    //                 if ($lastSentHash !== $currentHash) {
    //                     echo 'data: ' . json_encode($currentData) . "\n\n";
    //                     $lastSentHash = $currentHash;
    //                 }

    //                 @ob_flush();
    //                 @flush();

    //                 // Jika koneksi terputus dari client
    //                 if (connection_aborted()) break;
    //             } catch (\Exception $e) {
    //                 echo "event: error\n";
    //                 echo 'data: ' . json_encode(['error' => $e->getMessage()]) . "\n\n";
    //                 @ob_flush();
    //                 @flush();
    //                 break;
    //             }

    //             sleep(1); // tunggu 1 detik
    //         }
    //     });

    //     // Set header untuk SSE
    //     $response->headers->set('Content-Type', 'text/event-stream');
    //     $response->headers->set('Cache-Control', 'no-cache');
    //     $response->headers->set('Connection', 'keep-alive');

    //     return $response;
    // }
}
