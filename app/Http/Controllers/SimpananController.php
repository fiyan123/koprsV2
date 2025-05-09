<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SimpananController extends Controller
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
   // Show all data for Simpanan
public function index(Request $request)
{
    $user_id = Auth::id();
    // dd($user_id);
    if ($request->ajax()) {
        $data = Simpanan::where('user_id', $user_id )->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '
                    <a href="' . route('simpanan.show', $row->id) . '" class="btn btn-sm btn-info">Detail</a>
                ';

                // Cek jika pengguna yang login memiliki role 'anggota', maka tampilkan tombol Edit
                if (auth()->user()->hasRole('anggota') && $row->status != 'potong') {
                    $btn .= '
                        <a href="' . route('simpanan.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                    ';
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('admin.simpanan.index');
}


    // Show the form for creating a new Simpanan
    public function create()
    {
        $hakakses = $this->HakaksesLogin(Auth::id());

        if (!$hakakses) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        } else {

        $user_id = Auth::id();
               $data = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->leftJoin('simpanans as simpan', function ($join) {
                    $join->on('users.id', '=', 'simpan.user_id')
                        ->where('simpan.status', '=', 'simpan');
                })
                ->leftJoin('simpanans as tarik', function ($join) {
                    $join->on('users.id', '=', 'tarik.user_id')
                        ->where('tarik.status', '=', 'tarik');
                })
                ->leftJoin('simpanans as potong', function ($join) {
                    $join->on('users.id', '=', 'potong.user_id')
                        ->where('potong.status', '=', 'potong');
                })
                ->where('users.id', $user_id)
                ->where('roles.id', 3) // Filter hanya role_id = 3 (misalnya: santri)
                ->select(
                    'users.*',
                    DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) as total_simpan'),
                    DB::raw('COALESCE(SUM(DISTINCT tarik.jumlah), 0) as total_tarik'),
                    DB::raw('COALESCE(SUM(DISTINCT potong.jumlah), 0) as total_potong'),
                    DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) - (COALESCE(SUM(DISTINCT tarik.jumlah), 0) + COALESCE(SUM(DISTINCT potong.jumlah), 0)) as saldo_akhir')
                )
                ->groupBy('users.id')
                ->first();
        $sisa_saldo = $data->saldo_akhir;
        return view('admin.simpanan.create', compact('sisa_saldo'));
                }
    }

    public function store(Request $request)
    {
         $hakakses = $this->HakaksesLogin(Auth::id());

        if (!$hakakses) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        } else {
        // Validasi awal
        $rules = [
            'nip' => 'required|string|max:50',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'jumlah' => 'required|numeric|min:1',
            'status' => 'required|in:simpan,tarik',
        ];

        // Validasi tambahan jika status adalah "simpan"
        if ($request->input('status') === 'simpan') {
            $rules['bukti_tf'] = 'required|image|mimes:jpg,jpeg,png|max:5120';
        }

        $validated = $request->validate($rules);

        try {
            $user_id = Auth::id();

            // Cek apakah user adalah anggota
            $user = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('users.id', $user_id)
                ->where('roles.id', 3) // Role anggota
                ->select('users.*')
                ->first();

            if (!$user) {
                return redirect()->back()->withErrors('Akun ini bukan anggota.');
            }

            DB::beginTransaction();

            $status = $validated['status'];
            $buktiTf = null;
            $no_rek = null;

            // Proses simpan bukti_tf jika status = simpan
            if ($status === 'simpan' && $request->hasFile('bukti_tf')) {
                $year = now()->year;
                $buktiTf = $request->file('bukti_tf')->store("bukti_tf/{$year}", 'public');
            }

            // Validasi status = tarik
            if ($status === 'tarik') {
                $no_rek = $request->input('no_rek');
                if (!$no_rek) {
                    return redirect()->back()->withErrors('Nomor Rekening wajib diisi jika status tarik.');
                }
   $data = DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->leftJoin('simpanans as simpan', function ($join) {
            $join->on('users.id', '=', 'simpan.user_id')
                ->where('simpan.status', '=', 'simpan');
        })
        ->leftJoin('simpanans as tarik', function ($join) {
            $join->on('users.id', '=', 'tarik.user_id')
                ->where('tarik.status', '=', 'tarik');
        })
        ->leftJoin('simpanans as potong', function ($join) {
            $join->on('users.id', '=', 'potong.user_id')
                ->where('potong.status', '=', 'potong');
        })
        ->where('users.id', $user_id)
        ->where('roles.id', 3) // Filter hanya role_id = 3 (misalnya: santri)
        ->select(
            'users.*',
            DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) as total_simpan'),
            DB::raw('COALESCE(SUM(DISTINCT tarik.jumlah), 0) as total_tarik'),
            DB::raw('COALESCE(SUM(DISTINCT potong.jumlah), 0) as total_potong'),
            DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) - (COALESCE(SUM(DISTINCT tarik.jumlah), 0) + COALESCE(SUM(DISTINCT potong.jumlah), 0)) as saldo_akhir')
        )
        ->groupBy('users.id')
        ->first();
                $sisa_saldo = $data->saldo_akhir;
                if ($validated['jumlah'] >= $sisa_saldo) {
                    return redirect()->back()->withErrors("Jumlah tarik melebihi saldo maksimal Rp {$sisa_saldo}");
                }
            }

            // Simpan data ke database
            Simpanan::create([
                'user_id' => $user_id,
                'nama' => $user->name,
                'email' => $user->email,
                'tgl_lahir' => $user->tgl_lahir,
                'nip' => $validated['nip'],
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'jumlah' => $validated['jumlah'],
                // 'jenis_simpanan' => 'sukarela',
                'status' => $status,
                'bukti_tf' => $status === 'simpan' ? $buktiTf : null,
                'no_rek' => $status === 'tarik' ? $no_rek : null,

            ]);

            DB::commit();
            return redirect()->route('simpanan.index')->with('success', 'Data simpanan berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors('Gagal menyimpan data: ' . $e->getMessage());
        }
    }
    }





  // Show the form for editing the specified Simpanan
public function show($id)
{
    // Cari Simpanan berdasarkan ID
    $simpanan = Simpanan::findOrFail($id);  // Mengambil Simpanan dengan ID yang sesuai
    $simpananList = Simpanan::where('user_id', $simpanan->user_id)->get(); // Ambil semua simpanan milik user yang sama

                $data = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->leftJoin('simpanans as simpan', function ($join) {
                    $join->on('users.id', '=', 'simpan.user_id')
                        ->where('simpan.status', '=', 'simpan');
                })
                ->leftJoin('simpanans as tarik', function ($join) {
                    $join->on('users.id', '=', 'tarik.user_id')
                        ->where('tarik.status', '=', 'tarik');
                })
                ->leftJoin('simpanans as potong', function ($join) {
                    $join->on('users.id', '=', 'potong.user_id')
                        ->where('potong.status', '=', 'potong');
                })
                ->where('users.id', $simpanan->user_id)
                ->where('roles.id', 3) // Filter hanya role_id = 3 (misalnya: santri)
                ->select(
                    'users.*',
                    DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) as total_simpan'),
                    DB::raw('COALESCE(SUM(DISTINCT tarik.jumlah), 0) as total_tarik'),
                    DB::raw('COALESCE(SUM(DISTINCT potong.jumlah), 0) as total_potong'),
                    DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) - (COALESCE(SUM(DISTINCT tarik.jumlah), 0) + COALESCE(SUM(DISTINCT potong.jumlah), 0)) as saldo_akhir')
                )
                ->groupBy('users.id')
                ->first();
                $sisa_saldo = $data->saldo_akhir;
    // Mengirim data Simpanan ke view edit
    return view('admin.simpanan.show',compact('simpanan','simpananList','sisa_saldo'));
}
// Show the form for editing the specified Simpanan
public function edit($id)
{
     $hakakses = $this->HakaksesLogin(Auth::id());

        if (!$hakakses) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        } else {
    // Cari Simpanan berdasarkan ID
    $simpanan = Simpanan::findOrFail($id);  // Mengambil Simpanan dengan ID yang sesuai
    $user_id = $simpanan->user_id;
    // Menghapus desimal pada jumlah jika ada
    // $simpanan->jumlah = intval($simpanan->jumlah);  // Mengubah jumlah menjadi integer
 $data = DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->leftJoin('simpanans as simpan', function ($join) {
            $join->on('users.id', '=', 'simpan.user_id')
                ->where('simpan.status', '=', 'simpan');
        })
        ->leftJoin('simpanans as tarik', function ($join) {
            $join->on('users.id', '=', 'tarik.user_id')
                ->where('tarik.status', '=', 'tarik');
        })
        ->leftJoin('simpanans as potong', function ($join) {
            $join->on('users.id', '=', 'potong.user_id')
                ->where('potong.status', '=', 'potong');
        })
        ->where('users.id', $user_id)
        ->where('roles.id', 3) // Filter hanya role_id = 3 (misalnya: santri)
        ->select(
            'users.*',
            DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) as total_simpan'),
            DB::raw('COALESCE(SUM(DISTINCT tarik.jumlah), 0) as total_tarik'),
            DB::raw('COALESCE(SUM(DISTINCT potong.jumlah), 0) as total_potong'),
            DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) - (COALESCE(SUM(DISTINCT tarik.jumlah), 0) + COALESCE(SUM(DISTINCT potong.jumlah), 0)) as saldo_akhir')
        )
        ->groupBy('users.id')
        ->first();
        $sisa_saldo = $data->saldo_akhir;
    return view('admin.simpanan.edit', compact('simpanan','sisa_saldo'));
        }
}
public function update(Request $request, $id)
{
     $hakakses = $this->HakaksesLogin(Auth::id());

        if (!$hakakses) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses.');
        } else {
    // Gabungkan semua aturan validasi menjadi satu
    $rules = [
        'nip' => 'required|string|max:50',
        'alamat' => 'required|string',
        'no_hp' => 'required|string|max:20',
        'jumlah' => 'required|numeric|min:1',
        'status' => 'required|in:simpan,tarik',
    ];

    // Validasi tambahan untuk 'bukti_tf' jika status = simpan
    if ($request->input('status') === 'simpan') {
        $rules['bukti_tf'] = 'required|image|mimes:jpg,jpeg,png|max:5120';
    }

    // Lakukan validasi
    $validated = $request->validate($rules);

    try {
        $user_id = Auth::id();

        // Pastikan user adalah anggota
        $user = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('users.id', $user_id)
            ->where('roles.id', 3) // role anggota
            ->select('users.*')
            ->first();

        if (!$user) {
            return redirect()->back()->withErrors('Akun ini bukan anggota.');
        }

        DB::beginTransaction();

        // Ambil data simpanan yang akan diupdate
        $simpanan = Simpanan::findOrFail($id);

        // Cek apakah user pemilik simpanan
        if ($simpanan->user_id != $user_id) {
            return redirect()->back()->withErrors('Data simpanan ini tidak milik Anda.');
        }

        $status = $validated['status'];
        $no_rek = null;
        $buktiTf = $simpanan->bukti_tf;

        // Jika status 'simpan', proses upload bukti_tf
        if ($status === 'simpan' && $request->hasFile('bukti_tf')) {
            $year = now()->year;
            $buktiTf = $request->file('bukti_tf')->store("bukti_tf/{$year}", 'public');
        }

        // Jika status 'tarik', validasi no_rek dan cek saldo
        if ($status === 'tarik') {
            $no_rek = $request->input('no_rek');
            if (!$no_rek) {
                return redirect()->back()->withErrors('Nomor Rekening wajib diisi jika status tarik.');
            }

                $data = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id')
                ->leftJoin('simpanans as simpan', function ($join) {
                    $join->on('users.id', '=', 'simpan.user_id')
                        ->where('simpan.status', '=', 'simpan');
                })
                ->leftJoin('simpanans as tarik', function ($join) {
                    $join->on('users.id', '=', 'tarik.user_id')
                        ->where('tarik.status', '=', 'tarik');
                })
                ->leftJoin('simpanans as potong', function ($join) {
                    $join->on('users.id', '=', 'potong.user_id')
                        ->where('potong.status', '=', 'potong');
                })
                ->where('users.id', $user_id)
                ->where('roles.id', 3) // Filter hanya role_id = 3 (misalnya: santri)
                ->select(
                    'users.*',
                    DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) as total_simpan'),
                    DB::raw('COALESCE(SUM(DISTINCT tarik.jumlah), 0) as total_tarik'),
                    DB::raw('COALESCE(SUM(DISTINCT potong.jumlah), 0) as total_potong'),
                    DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) - (COALESCE(SUM(DISTINCT tarik.jumlah), 0) + COALESCE(SUM(DISTINCT potong.jumlah), 0)) as saldo_akhir')
                )
                ->groupBy('users.id')
                ->first();
                $sisa_saldo = $data->saldo_akhir;
            if ($validated['jumlah'] >= $sisa_saldo) {
                return redirect()->back()->withErrors("Jumlah tarik melebihi saldo maksimal Rp {$sisa_saldo}");
            }
        }

        // Update data simpanan
        $simpanan->update([
            'nip' => $validated['nip'],
            'alamat' => $validated['alamat'],
            'no_hp' => $validated['no_hp'],
            'jumlah' => $validated['jumlah'],
            'status' => $status,
            'bukti_tf' => $status === 'simpan' ? $buktiTf : null,
            'no_rek' => $status === 'tarik' ? $no_rek : null,
        ]);

        DB::commit();
        return redirect()->route('simpanan.index')->with('success', 'Data simpanan berhasil diperbarui.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withInput()->withErrors('Gagal memperbarui data: ' . $e->getMessage());
    }
}
}

}
