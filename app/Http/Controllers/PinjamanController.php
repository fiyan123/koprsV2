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
                $data = Pinjaman::select('id', 'nama', 'tgl_lahir', 'nip', 'jumlah', 'status', 'status_pinjaman')
                    ->where('user_id', auth()->user()->id)
                    ->get();
            } else {
                $data = Pinjaman::select('id', 'nama', 'tgl_lahir', 'nip', 'jumlah', 'status', 'status_pinjaman')->get();
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex">';
                    $btn .= '<a href="' . route('pinjaman.show', $row->id) . '" class="btn btn-info me-1">Detail</a>';

                    if (auth()->user()->hasRole('anggota') && $row->status == 'approved' && $row->status_pinjaman == 'aktif') {
                        $btn .= '<a href="' . route('pinjaman.bayar', $row->id) . '" class="btn btn-dark me-1">Bayar</a>';
                    }
                    if ($row->status == 'approved' && $row->status_pinjaman == 'tidak_aktif') {
                        $btn .= '<button class="btn btn-success me-1" disabled>Lunas</button>';
                    }

                    if ($row->status == 'approved' && $row->status_pinjaman == 'aktif') {
                        $btn .= '<button class="btn btn-warning me-1" disabled>Belum Lunas</button>';
                    }

                    if ($row->status == 'pending' && $row->status_pinjaman == 'aktif') {
                        $btn .= '<button class="btn btn-secondary me-1" disabled>Proses</button>';
                    }


                    if (auth()->user()->hasRole('admin') && $row->status == 'pending' && $row->status_pinjaman == 'aktif') {
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
                ->rawColumns(['action']) // Tambahkan 'status_pinjaman' di sini agar HTML-nya tidak di-escape
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
            'nip' => 'required',
            'alamat' => 'nullable|string',
            'no_ktp' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'foto_dengan_ktp' => 'required|image|mimes:jpg,jpeg,png|max:5120',
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
            $year = now()->year;

            // Validasi file
            if (
                !$request->hasFile('foto') || !$request->file('foto')->isValid() ||
                !$request->hasFile('foto_ktp') || !$request->file('foto_ktp')->isValid() ||
                !$request->hasFile('foto_dengan_ktp') || !$request->file('foto_dengan_ktp')->isValid()
            ) {
                return redirect()->back()->withInput()->with('toast_error', 'Semua foto harus diunggah dan valid.');
            }

            // Upload file
            $foto = $request->file('foto')->store("foto_user/{$year}", 'public');
            $fotoKtp = $request->file('foto_ktp')->store("foto_ktp/{$year}", 'public');
            $fotoDenganKtp = $request->file('foto_dengan_ktp')->store("foto_dengan_ktp/{$year}", 'public');

            // Simpan pinjaman
            $pinjaman = Pinjaman::create([
                'user_id' => $user->id,
                'nama' => $user->name,
                'tgl_lahir' => $request->tgl_lahir,
                'nip' => $request->nip,
                'email' => $user->email,
                'alamat' => $request->alamat,
                'no_rek' => $noRekening,
                'no_ktp' => $request->no_ktp,
                'no_hp' => $request->no_hp,
                'foto' => $foto,
                'foto_ktp' => $fotoKtp,
                'foto_dengan_ktp' => $fotoDenganKtp,
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
                    'total_denda' => 0,
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

    public function bayar($pinjaman_id)
    {
        // Ambil data pinjaman
        $pinjaman = Pinjaman::findOrFail($pinjaman_id);

        // Ambil semua angsuran pinjaman (diurutkan)
        $semuaAngsuran = DB::table('angsuran_pinjaman')
            ->where('pinjaman_id', $pinjaman_id)
            ->orderBy('angsuran_ke', 'asc')
            ->get();

        // Cari angsuran pertama yang belum dibayar
        $angsuran = $semuaAngsuran->whereNull('tanggal_bayar')->first();

        if (!$angsuran) {
            return redirect()->route('pinjaman.index')->with('error', 'Semua angsuran sudah dibayar!');
        }

        // Cek apakah ini adalah angsuran terakhir
        $angsuranTerakhir = $semuaAngsuran->last()->id === $angsuran->id;

        // Hitung total denda hanya jika angsuran terakhir
        $totalDenda = $angsuranTerakhir ? $semuaAngsuran->sum('denda') : 0;

        // Hitung jumlah dibayar: cicilan + total denda jika angsuran terakhir
        $jumlahDibayar = $pinjaman->cicilan_pembayaran + $totalDenda;
        return view('admin.pinjam.bayar', compact('pinjaman', 'angsuran', 'jumlahDibayar'));
    }

    public function proses_bayar(Request $request, $id)
    {
        // Validasi input bukti transfer wajib diisi
        $request->validate([
            'bukti_transfer' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Cari pinjaman berdasarkan ID
        $pinjaman = Pinjaman::findOrFail($id);

        // Ambil semua angsuran pinjaman untuk cek total dan denda
        $semuaAngsuran = DB::table('angsuran_pinjaman')
            ->where('pinjaman_id', $id)
            ->orderBy('angsuran_ke', 'asc')
            ->get();

        // Cari angsuran pertama yang belum dibayar
        $angsuran = $semuaAngsuran->whereNull('tanggal_bayar')->first();

        if (!$angsuran) {
            return redirect()->route('pinjaman.index')->with('error', 'Semua angsuran sudah dibayar!');
        }

        // Cek apakah ini adalah angsuran terakhir
        $angsuranTerakhir = $semuaAngsuran->last()->id === $angsuran->id;

        // Hitung total denda hanya jika angsuran terakhir
        $totalDenda = $angsuranTerakhir ? $semuaAngsuran->sum('denda') : 0;

        // Hitung jumlah dibayar: cicilan + total denda jika angsuran terakhir
        $jumlahDibayar = $pinjaman->cicilan_pembayaran + $totalDenda;

        // Simpan file bukti transfer
        $folderPath = storage_path('app/public/buktitf');
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $buktiTransfer = $request->file('bukti_transfer');
        $timestamp = now()->format('Y_m_d_H_i_s');
        $fileName = $timestamp . "_" . $pinjaman->id . "_" . $buktiTransfer->getClientOriginalName();
        $buktiTransfer->move($folderPath, $fileName);

        // Update angsuran yang ditemukan
        DB::table('angsuran_pinjaman')
            ->where('id', $angsuran->id)
            ->update([
                'tanggal_bayar' => now(),
                'jumlah_dibayar' => $jumlahDibayar,
                'bukti_transfer' => 'storage/buktitf/' . $fileName,
                'status' => 'lunas'
            ]);

        // Jika angsuran terakhir, ubah status pinjaman menjadi tidak_aktif
        if ($angsuranTerakhir) {
            DB::table('pinjamans')
                ->where('id', $pinjaman->id)
                ->update(['status_pinjaman' => 'tidak_aktif']);
        }

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
            'p.nip',
            'p.no_ktp',
            'p.tgl_lahir',
            'p.no_hp',
            'p.alamat',
            'p.foto',
            'p.foto_ktp',
            'p.foto_dengan_ktp'
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
                                  $totalJumlahDenda = DB::table('angsuran_pinjaman')
                                ->where('pinjaman_id', $id)
                                ->selectRaw('SUM(CAST(total_denda AS DECIMAL)) as total_denda') // Menggunakan CAST untuk konversi tipe data
                                ->value('total_denda'); // Mengambil hasil penjumlahan

    // dd($pinjaman);

    return view('admin.pinjam.show', compact('pinjaman', 'angsuranList', 'sisaAngsuran','totalDenda','totalJumlahDenda'));
}

}
