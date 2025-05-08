<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PinjamanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pinjaman::all();

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
        // Validasi request
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'tipe_durasi' => 'required|in:harian,bulanan,tahunan',
            'durasi' => 'required|integer|min:1',
            'no_rekening' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Ambil input
            $jumlah = $validated['jumlah'];
            $tipe = $validated['tipe_durasi'];
            $durasi = $validated['durasi'];
            $noRekening = $validated['no_rekening'];

            // Hitung bunga berdasarkan tipe
            $bungaPersen = match ($tipe) {
                'harian' => 1,
                'bulanan' => 4,
                'tahunan' => 8,
            };

            $totalBunga = ($bungaPersen / 100) * $jumlah * $durasi;
            $totalPembayaran = $jumlah + $totalBunga;
            $cicilanPerPembayaran = $totalPembayaran / $durasi;

            // Ambil data user dengan role anggota (id = 3)
            $user_id = Auth::id();
            $user = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('users.id', $user_id)
                ->where('roles.id', 3) // Role Anggota
                ->select('users.*')
                ->first();

            if (!$user) {
                return redirect()->back()->withErrors('Akun ini bukan anggota.');
            }

            // Simpan data ke DB
            Pinjaman::create([
                'user_id' => $user->id,
                'nama' => $user->name,
                'tgl_lahir' => $user->tgl_lahir,
                'nip' => $user->nip,
                'email' => $user->email,
                'alamat' => $user->alamat,
                'no_rek' => $noRekening,
                'jumlah' => number_format($jumlah, 2, '.', ''),
                'tipe_durasi' => $tipe,
                'durasi' => $durasi,
                'bunga' => $bungaPersen,
                'total_bunga' => number_format($totalBunga, 2, '.', ''),
                'total_pembayaran' => number_format($totalPembayaran, 2, '.', ''),
                'cicilan_pembayaran' => number_format($cicilanPerPembayaran, 2, '.', ''),
                'status' => 'pending',
                'status_pinjaman' => 'aktif'
            ]);

            DB::commit();

            return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal menyimpan data pinjaman: ' . $e->getMessage());
        }
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
