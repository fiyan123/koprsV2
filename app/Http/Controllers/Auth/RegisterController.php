<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
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
        Validator::extend('strong_password', function ($attribute, $value, $parameters, $validator) {
            $uppercase = preg_match('/[A-Z]/', $value);
            $lowercase = preg_match('/[a-z]/', $value);
            $number    = preg_match('/[0-9]/', $value);
            return $uppercase && $lowercase && $number && strlen($value) >= 8;
        }, 'Password harus memiliki minimal 8 karakter, huruf besar, huruf kecil, dan angka.');

        // Validasi form
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed'],
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

        // Validasi dan upload file jika ada
        $year = now()->year;

        // Cek apakah file foto, foto_ktp, atau foto_dengan_ktp ada, jika tidak validasi gagal
        if (!$request->hasFile('foto') || !$request->file('foto')->isValid()) {
            return redirect()->back()->withInput()->with('toast_error', 'Foto harus diunggah dan valid.');
        }

        if (!$request->hasFile('foto_ktp') || !$request->file('foto_ktp')->isValid()) {
            return redirect()->back()->withInput()->with('toast_error', 'Foto KTP harus diunggah dan valid.');
        }

        if (!$request->hasFile('foto_dengan_ktp') || !$request->file('foto_dengan_ktp')->isValid()) {
            return redirect()->back()->withInput()->with('toast_error', 'Foto dengan KTP harus diunggah dan valid.');
        }

        // Upload file dan simpan di storage/public
        $foto = $request->file('foto')->store("foto_user/{$year}", 'public');
        $fotoKtp = $request->file('foto_ktp')->store("foto_ktp/{$year}", 'public');
        $fotoDenganKtp = $request->file('foto_dengan_ktp')->store("foto_dengan_ktp/{$year}", 'public');

        // Simpan data user
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
        Auth::login($user);
        return redirect(route('dashboard'))->with('toast_success', 'Pendaftaran Berhasil, Selamat Datang! ' . Auth::user()->name);
    }
}
