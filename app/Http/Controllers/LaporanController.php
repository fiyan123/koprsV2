<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\LaporanService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\LaporanPinjamanService;

class LaporanController extends Controller
{

      public function HakaksesLogin($user_id)
        {
            $user = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('users.id', $user_id)
                ->where('roles.id', 3) // role_id 3 = anggota
                ->select('users.id')
                ->first();

            return $user ? true : false;
        }
    public function index()
    {
        $hakakses = $this->HakaksesLogin(Auth::id());

        if ($hakakses) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        } else {

            return view('admin.laporan.index');
        }
    }

    public function getDataAjax(Request $request, LaporanService $laporanService)
    {
         $hakakses = $this->HakaksesLogin(Auth::id());

        if ($hakakses) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        } else {
        $tahun = $request->query('tahun') ?? now()->year;
        $bulan = $request->query('bulan') ?? now()->month;

        $laporan = $laporanService->generateLaporanSimpanan($tahun, $bulan);

        return response()->json([
            'jumlah_simpanan' => $laporan['total_all']['count_jumlah_simpan'],
            'jumlah_anggota' => $laporan['total_all']['count_user_simpan']
        ]);
    }
    }

    public function getDataPinjaman(Request $request, LaporanPinjamanService $laporanPinjamanService)
    {
         $hakakses = $this->HakaksesLogin(Auth::id());

        if ($hakakses) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        } else {
        $tahun = $request->query('tahun') ?? now()->year;
        $bulan = $request->query('bulan') ?? now()->month;

        $laporan = $laporanPinjamanService->generatelaporanPinjaman($tahun, $bulan);
        return response()->json([
            'total_user_pinjaman_all' => $laporan['total_user_pinjaman_all'],
            'total_jumlah_pinjaman_all' => $laporan['total_jumlah_pinjaman_all'],
        ]);
    }
    }

    public function laporan_simpanan(Request $request, LaporanService $laporanService)
    {
         $hakakses = $this->HakaksesLogin(Auth::id());

        if ($hakakses) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        } else {
        $tahun = $request->query('tahun') ?? now()->year;
        $bulan = $request->query('bulan') ?? now()->month;

        $laporan = $laporanService->generateLaporanSimpanan($tahun, $bulan);

        $pdf = Pdf::loadView('pdf.export_simpanan', [
            'data' => $laporan['data'],
            'total_all' => $laporan['total_all'],
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
        return $pdf->download('Laporan-Simpanan.pdf');
    }
    }

    public function laporan_pinjaman(Request $request, LaporanPinjamanService $laporanPinjamanService)
    {
         $hakakses = $this->HakaksesLogin(Auth::id());

        if ($hakakses) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        } else {
        $tahun = $request->query('tahun') ?? now()->year;
        $bulan = $request->query('bulan') ?? now()->month;

        $laporan = $laporanPinjamanService->generatelaporanPinjaman($tahun, $bulan);
        $pdf = PDF::loadView('pdf.export_pinjaman', [
            'laporan' => $laporan,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
        return $pdf->download('Laporan-Pinjaman.pdf');
    }
    }

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
