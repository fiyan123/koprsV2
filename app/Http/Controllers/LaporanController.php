<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use App\Models\Simpanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function index()
    {
        return view('admin.laporan.index');
    }


    public function laporan_simpanan(Request $request)
    {
        $tahun = $request->query('tahun');
        $bulan = $request->query('bulan');

        // dd($tahun, $bulan);
        $data = Simpanan::get();

        $pdf = Pdf::loadView('pdf.export_simpanan', ['data' => $data]);
        return $pdf->download('Laporan-Simpanan.pdf');
    }


    public function laporan_pinjaman(Request $request)
    {
        $tahun = $request->query('tahun');
        $bulan = $request->query('bulan');

        // dd($tahun, $bulan);
        $data = Pinjaman::get();

        $pdf = Pdf::loadView('pdf.export_pinjaman', ['data' => $data]);
        return $pdf->download('Laporan-Pinjaman.pdf');
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
