<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PinjamanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pinjaman::with('user')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '
                        <div class="d-flex">
                            <a href="' . route('pinjaman.edit', $row->id) . '" class="btn btn-dark me-1">Edit</a>
                            <form action="' . route('pinjaman.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin ingin hapus?\')">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.pinjam.index');
    }

    public function create()
    {
        $users = User::all();
        return view('admin.pinjam.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nip' => 'required|string|max:20',
            'jumlah' => 'required|numeric',
            'durasi' => 'required|integer',
            'bunga' => 'required|numeric',
            'no_rek' => 'required|string',
        ]);

        $angsuran = ($request->jumlah + ($request->jumlah * $request->bunga / 100)) / $request->durasi;
        $total_bayar = $angsuran * $request->durasi;

        Pinjaman::create([
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'nip' => $request->nip,
            'jumlah' => $request->jumlah,
            'durasi' => $request->durasi,
            'bunga' => $request->bunga,
            'angsuran_per_bulan' => $angsuran,
            'total_bayar' => $total_bayar,
            'no_rek' => $request->no_rek,
            'status' => 'pending',
        ]);

        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil ditambahkan.');
    }

    public function edit(Pinjaman $pinjaman)
    {
        $users = User::all();
        return view('admin.pinjam.edit', compact('pinjaman', 'users'));
    }

    public function update(Request $request, Pinjaman $pinjaman)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nip' => 'required|string|max:20',
            'jumlah' => 'required|numeric',
            'durasi' => 'required|integer',
            'bunga' => 'required|numeric',
            'no_rek' => 'required|string',
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $angsuran = ($request->jumlah + ($request->jumlah * $request->bunga / 100)) / $request->durasi;
        $total_bayar = $angsuran * $request->durasi;

        $pinjaman->update([
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'nip' => $request->nip,
            'jumlah' => $request->jumlah,
            'durasi' => $request->durasi,
            'bunga' => $request->bunga,
            'angsuran_per_bulan' => $angsuran,
            'total_bayar' => $total_bayar,
            'no_rek' => $request->no_rek,
            'status' => $request->status,
        ]);

        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil diperbarui.');
    }

    public function destroy(Pinjaman $pinjaman)
    {
        $pinjaman->delete();
        return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil dihapus.');
    }
}
