<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AnggotaController extends Controller
{
   public function index(Request $request)
{
    if ($request->ajax()) {
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
        ->where('roles.id', 3) // Filter hanya role_id = 3 (misalnya: santri)
        ->select(
            'users.*',
            DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) as total_simpan'),
            DB::raw('COALESCE(SUM(DISTINCT tarik.jumlah), 0) as total_tarik'),
            DB::raw('COALESCE(SUM(DISTINCT potong.jumlah), 0) as total_potong'),
            DB::raw('COALESCE(SUM(DISTINCT simpan.jumlah), 0) - (COALESCE(SUM(DISTINCT tarik.jumlah), 0) + COALESCE(SUM(DISTINCT potong.jumlah), 0)) as saldo_akhir')
        )
        ->groupBy('users.id')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<a href="' . route('anggota.show', $row->id) . '" class="btn btn-sm btn-info">Detail</a> ';

                if (auth()->user()->hasRole('admin')) {
                    $btn .= '<a href="' . route('anggota.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                }

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('admin.anggota.index');
}


    public function create()
    {
        return view('admin.anggota.create');
    }


    public function store(Request $request)
    {
        Validator::extend('strong_password', function ($attribute, $value) {
            return preg_match('/[A-Z]/', $value) &&
                   preg_match('/[a-z]/', $value) &&
                   preg_match('/[0-9]/', $value) &&
                   strlen($value) >= 8;
        }, 'Password harus memiliki minimal 8 karakter, huruf besar, huruf kecil, dan angka.');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', 'strong_password'],
            'nip' => 'nullable|unique:users,nip',
            'alamat' => 'nullable|string',
            'no_ktp' => 'nullable|string|max:50|unique:users,no_ktp',
            'tgl_lahir' => 'nullable|date',
            'no_hp' => 'nullable|string|max:20|unique:users,no_hp',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'foto_dengan_ktp' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('toast_error', $validator->errors()->first());
        }

        try {
            DB::beginTransaction();

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

            // Simpan ke database
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->email_verified_at = now();
            $user->nip = $request->nip;
            $user->alamat = $request->alamat;
            $user->no_ktp = $request->no_ktp;
            $user->tgl_lahir = $request->tgl_lahir;
            $user->no_hp = $request->no_hp;
            $user->foto = $foto;
            $user->foto_ktp = $fotoKtp;
            $user->foto_dengan_ktp = $fotoDenganKtp;
            $user->save();

            // Insert ke tabel pivot
            DB::table('role_user')->insert([
                'role_id' => 3,
                'user_id' => $user->id,
                'user_type' => 'App\\Models\\User',

            ]);

            DB::commit();

            return redirect()->route('anggota.index')->with('toast_success', 'Data anggota berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file jika sudah diupload
            if (isset($foto)) Storage::disk('public')->delete($foto);
            if (isset($fotoKtp)) Storage::disk('public')->delete($fotoKtp);
            if (isset($fotoDenganKtp)) Storage::disk('public')->delete($fotoDenganKtp);

            return redirect()->back()->withInput()->with('toast_error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.anggota.edit', compact('user'));
    }

    public function show($id)
    {
        // $user = User::findOrFail($id);
          $user = DB::table('users')
          ->where('users.id',$id)
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
        return view('admin.anggota.show', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'tgl_lahir' => 'required|date',
            'nip' => 'required',
            'alamat' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'tgl_lahir' => $request->tgl_lahir,
            'nip' => $request->nip,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }

}
