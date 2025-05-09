<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LaporanPinjamanService
{
    public function generatelaporanPinjaman($tahun = null, $bulan = null)
    {
        $pinjamQuery = DB::table('pinjamans')
            ->whereNotIn('pinjamans.status', ['rejected', 'pending'])
            ->where('pinjamans.status_pinjaman', '!=', 'tidak_aktif')
            ->join('angsuran_pinjaman', 'pinjamans.id', '=', 'angsuran_pinjaman.pinjaman_id')
            ->select(
                'pinjamans.created_at',
                DB::raw('MAX(pinjamans.user_id) as user_id'),
                DB::raw('SUM(angsuran_pinjaman.denda) as jumlah_denda'),
                DB::raw('MAX(pinjamans.jumlah) as jumlah_pinjaman'),
                DB::raw('MAX(pinjamans.total_pembayaran) as total_bayar_pinjaman'),
                DB::raw('MAX(pinjamans.tipe_durasi) as tipe_durasi'),
                DB::raw('MAX(pinjamans.durasi) as durasi'),
                DB::raw('MAX(pinjamans.bunga) as bunga'),
                DB::raw('MAX(pinjamans.status) as status'),
                DB::raw('MAX(pinjamans.status_pinjaman) as status_pinjaman')
            )
            ->groupBy('pinjamans.created_at');

        if ($tahun) {
            $pinjamQuery->whereYear('pinjamans.created_at', $tahun);
        }
        if ($bulan) {
            $pinjamQuery->whereMonth('pinjamans.created_at', $bulan);
        }

        $pinjam = $pinjamQuery->get();

        $total_jumlah_pinjaman_all = 0;
        $total_bayar_Pinjaman_all = 0;
        $total_jumlah_denda_all = 0;
        $user_ids = [];

        foreach ($pinjam as $value) {
            $total_jumlah_pinjaman_all += $value->jumlah_pinjaman;
            $total_bayar_Pinjaman_all += $value->total_bayar_pinjaman;
            $total_jumlah_denda_all += $value->jumlah_denda;
            $user_ids[] = $value->user_id;
        }

        $total_jumlah_keuntungan = ($total_bayar_Pinjaman_all - $total_jumlah_pinjaman_all) + $total_jumlah_denda_all;
        $total_user_pinjaman_all = count(array_unique($user_ids));

        return [
            'data' => $pinjam,
            'total_user_pinjaman_all' => $total_user_pinjaman_all,
            'total_jumlah_pinjaman_all' => number_format($total_jumlah_pinjaman_all, 2),
            'total_bayar_pinjaman_all' => number_format($total_bayar_Pinjaman_all, 2),
            'total_jumlah_denda_all' => number_format($total_jumlah_denda_all, 2),
            'total_jumlah_keuntungan' => number_format($total_jumlah_keuntungan, 2)
        ];
    }
}
