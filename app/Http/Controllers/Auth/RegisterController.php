<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.registerCustom');
    }

    public function registerAction(Request $request)
    {
        // Custom validasi untuk password kuat
        Validator::extend('strong_password', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[A-Z]/', $value) && // huruf besar
                   preg_match('/[a-z]/', $value) && // huruf kecil
                   preg_match('/[0-9]/', $value) && // angka
                   strlen($value) >= 8;             // minimal 8 karakter
        }, 'Password harus memiliki minimal 8 karakter, huruf besar, huruf kecil, dan angka.');

        // Validasi input
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

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('toast_error', $validator->errors()->first());
        }

        // Pastikan file valid
        foreach (['foto', 'foto_ktp', 'foto_dengan_ktp'] as $field) {
            if (!$request->hasFile($field) || !$request->file($field)->isValid()) {
                return redirect()->back()->withInput()->with('toast_error', ucfirst(str_replace('_', ' ', $field)) . ' harus diunggah dan valid.');
            }
        }

        // Upload file ke folder berdasarkan tahun
        $year = now()->year;
        $foto = $request->file('foto')->store("foto_user/{$year}", 'public');
        $fotoKtp = $request->file('foto_ktp')->store("foto_ktp/{$year}", 'public');
        $fotoDenganKtp = $request->file('foto_dengan_ktp')->store("foto_dengan_ktp/{$year}", 'public');

        // Simpan data user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_verified_at = now(); // langsung verifikasi
        $user->nip = $request->nip;
        $user->alamat = $request->alamat;
        $user->no_ktp = $request->no_ktp;
        $user->tgl_lahir = $request->tgl_lahir;
        $user->no_hp = $request->no_hp;
        $user->foto = $foto;
        $user->foto_ktp = $fotoKtp;
        $user->foto_dengan_ktp = $fotoDenganKtp;
        $user->save();

        // Tambah role_id = 3 ke tabel role_user
        DB::table('role_user')->insert([
            'role_id' => 3, // misalnya role "user"
            'user_id' => $user->id,
            'user_type' => 'App\\Models\\User',
        ]);

        // Login otomatis
        Auth::login($user);

        return redirect(route('dashboard'))->with('toast_success', 'Pendaftaran Berhasil, Selamat Datang! ' . $user->name);
    }

}
