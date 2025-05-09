<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboardMenu.home');
    }

    public function getRekapKeuangan(Request $request)
    {
        $tahun = $request->input('tahun'); // Contoh: 2025
        $bulan = $request->input('bulan'); // Contoh: 5 atau '05'
        // $tahun = $request->input('tahun'); // Contoh: 2025
        // $bulan = $request->input('bulan'); // Contoh: 5 atau '05'

        // 1. Total nasabah (role_id = 3), dengan filter tanggal pendaftaran (created_at)
        $usersQuery = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.id', 3);

        if ($tahun) {
            $usersQuery->whereYear('users.created_at', $tahun);
        }

        if ($bulan) {
            $usersQuery->whereMonth('users.created_at', $bulan);
        }

        $count_nasabah_all = $usersQuery->count();

        // 2. Data simpanan
        $simpananQuery = DB::table('simpanans');

        if ($tahun) {
            $simpananQuery->whereYear('simpanans.created_at', $tahun);
        }

        if ($bulan) {
            $simpananQuery->whereMonth('simpanans.created_at', $bulan);
        }

        $total_simpan_jumlah = (clone $simpananQuery)->where('status', 'simpan')->sum('jumlah');
        $total_tarik_jumlah = (clone $simpananQuery)->where('status', 'tarik')->sum('jumlah');
        $total_potong_jumlah = (clone $simpananQuery)->where('status', 'potong')->sum('jumlah');

        $count_jumlah_all = $total_simpan_jumlah - ($total_tarik_jumlah + $total_potong_jumlah);

        // 3. Data pinjaman
        $pinjamanQuery = DB::table('pinjamans')
            ->whereNotIn('pinjamans.status', ['rejected', 'pending'])
            ->where('pinjamans.status_pinjaman', '!=', 'tidak_aktif')
            ->join('angsuran_pinjaman', 'pinjamans.id', '=', 'angsuran_pinjaman.pinjaman_id')
            ->join('users', 'pinjamans.user_id', '=', 'users.id');

        if ($tahun) {
            $pinjamanQuery->whereYear('pinjamans.created_at', $tahun);
        }

        if ($bulan) {
            $pinjamanQuery->whereMonth('pinjamans.created_at', $bulan);
        }

        $pinjam = $pinjamanQuery
            ->select(
                DB::raw('MAX(pinjamans.jumlah) as jumlah_pinjaman'),
                'pinjamans.created_at'
            )
            ->groupBy('pinjamans.created_at')
            ->get();

        $total_jumlah_pinjaman_all = $pinjam->sum('jumlah_pinjaman');

        // 4. Return response gabungan
        return response()->json([
            'success' => true,
            'message' => 'Rekap data keuangan berhasil diambil.',
            'count_nasabah_all' => $count_nasabah_all,
            'count_jumlah_all' => number_format($count_jumlah_all, 2),
            'total_jumlah_pinjaman_all' => number_format($total_jumlah_pinjaman_all, 2),
        ]);
    }

    public function getTotalPinjamanHome(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');

        $pinjamanQuery = DB::table('pinjamans')
            ->whereNotIn('pinjamans.status', ['rejected', 'pending'])
            ->where('pinjamans.status_pinjaman', '!=', 'tidak_aktif')
            ->join('angsuran_pinjaman', 'pinjamans.id', '=', 'angsuran_pinjaman.pinjaman_id')
            ->join('users', 'pinjamans.user_id', '=', 'users.id');

        // Filter berdasarkan tahun dan bulan
        if ($tahun) {
            $pinjamanQuery->whereYear('pinjamans.created_at', $tahun);
        }

        if ($bulan) {
            $pinjamanQuery->whereMonth('pinjamans.created_at', $bulan);
        }

        $pinjam = $pinjamanQuery
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

        // Initialize total variables
        $total_jumlah_pinjaman_all = 0;
        $total_bayar_Pinjaman_all = 0;
        $total_jumlah_denda_all = 0;
        $total_jumlah_keuntungan = 0;
        $user_ids = [];

        // Calculate totals
        foreach ($pinjam as $value) {
            $total_jumlah_pinjaman_all += $value->jumlah_pinjaman;
            $total_bayar_Pinjaman_all += $value->total_bayar_pinjaman;
            $total_jumlah_denda_all += $value->jumlah_denda;
            $user_ids[] = $value->user_id;
        }

        $total_jumlah_keuntungan = ($total_bayar_Pinjaman_all - $total_jumlah_pinjaman_all) + $total_jumlah_denda_all;
        $total_user_pinjaman_all = count(array_unique($user_ids));

        // Return response
        return response()->json([
            'success' => true,
            'message' => 'Data laporan pinjaman berhasil diambil.',
            'data' => number_format($total_jumlah_pinjaman_all, 2),
            'total_denda' => number_format($total_jumlah_denda_all, 2),
            'total_bayar' => number_format($total_bayar_Pinjaman_all, 2),
            'total_keuntungan' => number_format($total_jumlah_keuntungan, 2),
            'total_user_pinjaman' => $total_user_pinjaman_all
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
