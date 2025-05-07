<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SimpananController extends Controller
{
    // Show all data for Simpanan
    public function index(Request $request)
    {
        $data = Simpanan::with('user')->get();  // Eager load the user relationship

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex">
                                <a href="' . route('simpanan.edit', [$row->id]) . '" class="btn btn-dark mr-1">Edit</a>
                                <form action="' . route('simpanan.destroy', [$row->id]) . '" method="POST" onsubmit="return confirm(\'Yakin ingin hapus?\')">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.simpanan.index', compact('data'));
    }

    // Show the form for creating a new Simpanan
    public function create()
    {
        $users = User::all();  // Fetch all users
        return view('admin.simpanan.create', compact('users'));
    }

    // Store a newly created Simpanan
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nip' => 'required|string|max:20|unique:simpanans',
            'no_hp' => 'required|string|max:20',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela,berjangka',
            'jumlah' => 'required|numeric',
            'bukti_tf' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $simpanan = new Simpanan();
        $simpanan->user_id = $request->user_id;
        $simpanan->nama = $request->nama;
        $simpanan->alamat = $request->alamat;
        $simpanan->nip = $request->nip;
        $simpanan->no_hp = $request->no_hp;
        $simpanan->jenis_simpanan = $request->jenis_simpanan;
        $simpanan->jumlah = $request->jumlah;
        if ($request->hasFile('bukti_tf')) {
            $simpanan->bukti_tf = $request->file('bukti_tf')->store('uploads');
        }
        $simpanan->save();

        return redirect()->route('simpanan.index')->with('success', 'Simpanan berhasil ditambahkan!');
    }

    // Show the form for editing the specified Simpanan
    public function edit(Simpanan $simpanan)
    {
        $users = User::all();  // Fetch all users
        return view('admin.simpanan.edit', compact('simpanan', 'users'));
    }

    // Update the specified Simpanan
    public function update(Request $request, Simpanan $simpanan)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nip' => 'required|string|max:20|unique:simpanans,nip,' . $simpanan->id,
            'no_hp' => 'required|string|max:20',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela,berjangka',
            'jumlah' => 'required|numeric',
            'bukti_tf' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $simpanan->user_id = $request->user_id;
        $simpanan->nama = $request->nama;
        $simpanan->alamat = $request->alamat;
        $simpanan->nip = $request->nip;
        $simpanan->no_hp = $request->no_hp;
        $simpanan->jenis_simpanan = $request->jenis_simpanan;
        $simpanan->jumlah = $request->jumlah;
        if ($request->hasFile('bukti_tf')) {
            $simpanan->bukti_tf = $request->file('bukti_tf')->store('uploads');
        }
        $simpanan->save();

        return redirect()->route('simpanan.index')->with('success', 'Simpanan berhasil diperbarui!');
    }

    // Remove the specified Simpanan from storage
    public function destroy(Simpanan $simpanan)
    {
        $simpanan->delete();
        return redirect()->route('simpanan.index')->with('success', 'Simpanan berhasil dihapus!');
    }
}
