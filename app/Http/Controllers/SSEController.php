<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SSEController extends Controller
{
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
