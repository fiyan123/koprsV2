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
        // Ambil data pinjaman, sesuaikan query berdasarkan role
        if (auth()->user()->hasRole('anggota')) {
            // Jika login sebagai anggota, tampilkan hanya pinjaman yang terkait dengan user_id anggota
            $data = Pinjaman::select('id', 'nama', 'tgl_lahir', 'nip', 'jumlah', 'status')
                ->where('user_id', auth()->user()->id) // Menyaring berdasarkan user yang login
                ->get();
        } else {
            // Untuk role selain anggota, ambil semua data pinjaman
            $data = Pinjaman::select('id', 'nama', 'tgl_lahir', 'nip', 'jumlah', 'status')->get();
            // dd($data);
        }

        // Mengembalikan data dalam format DataTables
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<div class="d-flex">';

                $btn .= '<a href="' . route('pinjaman.show', $row->id) . '" class="btn btn-info me-1">Detail</a>';

                // Jika status pinjaman sudah disetujui dan login sebagai anggota, tampilkan tombol Bayar
                if (auth()->user()->hasRole('anggota') && $row->status == 'approved') {
                    $btn .= '<a href="' . route('pinjaman.bayar', $row->id) . '" class="btn btn-dark me-1">Bayar</a>';
                }

                // Jika login sebagai selain anggota, tampilkan tombol Approve dan Reject
                if (auth()->user()->hasRole('admin') && $row->status == 'pending') {
                    $btn .= '
                    <form action="' . route('pinjaman.approve', $row->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('POST') . '
                        <button type="submit" class="btn btn-success me-1">Approve</button>
                    </form>';

                    $btn .= '
                    <form action="' . route('pinjaman.reject', $row->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        ' . method_field('POST') . '
                        <button type="submit" class="btn btn-danger me-1">Reject</button>
                    </form>';

                }

                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action']) // Penting agar HTML tidak di-escape
            ->make(true);
    }

    return view('admin.pinjam.index');
}
public function approve($id)
{
    $pinjaman = Pinjaman::findOrFail($id);

    $pinjaman->status = 'approved';
    $pinjaman->save();

    return redirect()->route('pinjaman.index')->with('success', 'Pinjaman berhasil disetujui.');
}

public function reject($id)
{
    $pinjaman = Pinjaman::findOrFail($id);
    $pinjaman->status = 'rejected';
    $pinjaman->save();

    return redirect()->route('pinjaman.index')->with('error', 'Pinjaman ditolak.');
}


    public function create()
    {
        $users = User::all();
        return view('admin.pinjam.create', compact('users'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'tipe_durasi' => 'required|in:harian,bulanan,tahunan',
            'durasi' => 'required|integer|min:1',
            'no_rekening' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $jumlah = $validated['jumlah'];
            $tipe = $validated['tipe_durasi'];
            $durasi = $validated['durasi'];
            $noRekening = $validated['no_rekening'];

            $bungaPersen = match ($tipe) {
                'harian' => 1,
                'bulanan' => 4,
                'tahunan' => 8,
            };

            $totalBunga = ($bungaPersen / 100) * $jumlah * $durasi;
            $totalPembayaran = $jumlah + $totalBunga;
            $cicilanPerPembayaran = $totalPembayaran / $durasi;

            // Ambil user anggota
            $user_id = Auth::id();
            $user = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('users.id', $user_id)
                ->where('roles.id', 3) // Anggota
                ->select('users.*')
                ->first();

            if (!$user) {
                return redirect()->back()->withErrors('Akun ini bukan anggota.');
            }

            // Simpan pinjaman
            $pinjaman = Pinjaman::create([
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

            // Simpan angsuran
            $startDate = now();
            for ($i = 1; $i <= $durasi; $i++) {
                $jatuhTempo = match ($tipe) {
                    'harian' => $startDate->copy()->addDays($i),
                    'bulanan' => $startDate->copy()->addMonths($i),
                    'tahunan' => $startDate->copy()->addYears($i),
                };
                DB::table('angsuran_pinjaman')->insert([

                    'pinjaman_id' => $pinjaman->id,
                    'user_id' => $user->id,
                    'angsuran_ke' => $i,
                    'jatuh_tempo' => $jatuhTempo,
                    'jumlah_dibayar' => null,
                    'tanggal_bayar' => null,
                    'denda' => 0,
                    'status' => 'belum_lunas'
                ]);


            }

            DB::commit();
            return redirect()->route('pinjaman.index')->with('success', 'Data pinjaman dan angsuran berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Gagal menyimpan data: ' . $e->getMessage());
        }
    }




    public function edit(Pinjaman $pinjaman)
    {
        $users = User::all();
        return view('admin.pinjam.edit', compact('pinjaman', 'users'));
    }
    public function bayar($pinjaman_id)
{
    // Ambil data pinjaman berdasarkan pinjaman_id
    $pinjaman = Pinjaman::findOrFail($pinjaman_id);

    // Ambil data angsuran berdasarkan angsuran_ke
    $angsuran = DB::table('angsuran_pinjaman')
        ->where('pinjaman_id', $pinjaman_id)
        ->first();


    // Cek apakah angsuran sudah dibayar atau belum
    if ($angsuran->status == 'lunas') {
        return redirect()->route('pinjaman.index')->with('error', 'Angsuran ini sudah dibayar.');
    }

    // Tampilkan form pembayaran
    return view('admin.pinjam.bayar', compact('pinjaman', 'angsuran'));
}
public function proses_bayar(Request $request, $id)
{
    // Validasi input bukti transfer wajib diisi
    $request->validate([
        'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Cari pinjaman berdasarkan ID
    $pinjaman = Pinjaman::findOrFail($id);

    // Cari angsuran pertama yang belum dibayar untuk pinjaman ini
    $angsuran = DB::table('angsuran_pinjaman')
        ->where('pinjaman_id', $id)
        ->whereNull('tanggal_bayar')
        ->whereNull('jumlah_dibayar')
        ->whereNull('bukti_transfer')
        ->orderBy('angsuran_ke', 'asc')
        ->first();

    if (!$angsuran) {
        return redirect()->route('pinjaman.index')->with('error', 'Semua angsuran sudah dibayar!');
    }

    // Path folder penyimpanan bukti transfer
    $folderPath = storage_path('app/public/buktitf');

    // Jika folder belum ada, buat folder
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }

    // Ambil file bukti transfer
    $buktiTransfer = $request->file('bukti_transfer');

    // Format nama file
    $timestamp = now()->format('Y_m_d_H_i_s');
    $fileName = $timestamp . "_" . $pinjaman->id . "_" . $buktiTransfer->getClientOriginalName();

    // Pindahkan file ke folder penyimpanan
    $buktiTransfer->move($folderPath, $fileName);

    // Update angsuran yang ditemukan
    DB::table('angsuran_pinjaman')
        ->where('id', $angsuran->id)
        ->update([
            'tanggal_bayar' => now(),
            'jumlah_dibayar' => $pinjaman->cicilan_pembayaran,
            'bukti_transfer' => 'storage/buktitf/' . $fileName,
            'status' => 'lunas'
        ]);

    return redirect()->route('pinjaman.index')->with('success', 'Pembayaran angsuran berhasil!');
}
public function show($id)
{
    // Ambil data pinjaman beserta user (tanpa duplikasi kolom)
    $pinjaman = DB::table('pinjamans as p')
        ->join('users as u', 'u.id', '=', 'p.user_id')
        ->select(
            'p.id as pinjaman_id',
            'p.nama as nama_pinjaman',
            'p.jumlah',
            'p.durasi',
            'p.tipe_durasi',
            'p.bunga',
            'p.total_bunga',
            'p.total_pembayaran',
            'p.cicilan_pembayaran',
            'p.status',
            'p.status_pinjaman',
            'u.name as user_name',
            'u.email as user_email',
            'u.nip',
            'u.no_ktp',
            'u.tgl_lahir',
            'u.no_hp',
            'u.alamat',
            'u.foto',
            'u.foto_ktp',
            'u.foto_dengan_ktp'
        )
        ->where('p.id', $id)
        ->first();

    // Ambil daftar angsuran terkait
    $angsuranList = DB::table('angsuran_pinjaman')
        ->where('pinjaman_id', $id)
        ->orderBy('angsuran_ke')
        ->get();

    // Hitung sisa angsuran (yang belum dibayar)
    $sisaAngsuran = $angsuranList->whereNull('bukti_transfer')
                                  ->whereNull('tanggal_bayar')
                                  ->whereNull('jumlah_dibayar')
                                  ->count();
                                  $totalDenda = DB::table('angsuran_pinjaman')
                                  ->where('pinjaman_id', $id)
                                  ->sum('denda');
    // dd($pinjaman);

    return view('admin.pinjam.show', compact('pinjaman', 'angsuranList', 'sisaAngsuran','totalDenda'));
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
