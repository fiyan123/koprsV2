<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class LaporanService
{
    public function generateLaporanSimpanan()
    {
        // Ambil data total simpan per user
        $simpan = DB::table('simpanans')
            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status')
            ->where('status', 'simpan')
            ->groupBy('user_id', 'status')
            ->orderBy('user_id')
            ->get();

        // Ambil data total tarik per user
        $tarik = DB::table('simpanans')
            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status')
            ->where('status', 'tarik')
            ->groupBy('user_id', 'status')
            ->orderBy('user_id')
            ->get();

        // Ambil data total potong per user
        $potong = DB::table('simpanans')
            ->select('user_id', DB::raw('SUM(jumlah) as sum_jumlah'), 'status')
            ->where('status', 'potong')
            ->groupBy('user_id', 'status')
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
                'saldo_akhir' => $sumTarik + $sumPotong - $itemSimpan->sum_jumlah,
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
        return [
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
        ];
    }
}
