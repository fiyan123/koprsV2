<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SaldoController extends Controller
{
    public function index(Request $request)
    {
        $data = Saldo::get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jumlah_saldo', function ($row) {
                    // Format the jumlah_saldo as Rupiah
                    return 'Rp ' . number_format($row->jumlah_saldo, 0, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex">
                            <a href="' . route('saldo.edit', $row->id) . '" class="btn btn-dark mr-1">Edit</a>
                            <form action="' . route('saldo.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin ingin hapus?\')">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.saldo.index', compact('data'));
    }


    public function create()
    {
        return view('admin.saldo.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jumlah_saldo' => 'required|numeric|min:1',  // Validasi angka positif
            'description' => 'nullable|string|max:255'
        ]);

        // Menghapus titik (thousand separator) pada jumlah saldo
        $jumlah = str_replace('.', '', $request->jumlah_saldo);

        // Menyimpan saldo baru
        Saldo::create([
            'jumlah_saldo' => $jumlah,  // Disimpan dalam format integer
            'type_saldo' => 'saldo_koperasi',  // Tipe saldo koperasi
            'status_saldo' => 'pemasukan',    // Menandakan saldo pemasukan
            'description' => $request->description,  // Deskripsi tambahan
        ]);

        // Redirect ke halaman saldo.index dengan pesan sukses
        return redirect()->route('saldo.index')->with('success', 'Saldo berhasil ditambahkan.');
    }
    public function edit($id)
    {
        // Ambil data saldo berdasarkan ID
        $saldo = Saldo::findOrFail($id);

        // Tampilkan halaman edit dengan data saldo
        return view('admin.saldo.edit', compact('saldo'));
    }

    public function update(Request $request, $id)
    {
        // Remove dots from the jumlah_saldo input
        $request->merge([
            'jumlah_saldo' => str_replace('.', '', $request->jumlah_saldo), // Remove dots for validation
        ]);

        // Validate the input
        $request->validate([
            'jumlah_saldo' => 'required|integer',  // Validate as integer
            'description' => 'nullable|string',
        ]);

        // Find the saldo by ID
        $saldo = Saldo::findOrFail($id);

        // Update the saldo record
        $saldo->update([
            'jumlah_saldo' => $request->jumlah_saldo,  // Store as an integer
            'description' => $request->description,
        ]);

        // Redirect with success message
        return redirect()->route('saldo.index')->with('success', 'Saldo berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $saldo = Saldo::findOrFail($id);
        $saldo->delete();

        return redirect()->route('saldo.index')->with('success', 'Saldo berhasil dihapus.');
    }
}
