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
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed'],
            'nip' => 'nullable|unique:users,nip',
            'alamat' => 'nullable|string',
            'noktp' => 'nullable|string|max:50',
            'tgl_lahir' => 'nullable|date',
            'no_hp' => 'nullable|string|max:20',
            // 'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('toast_error', $validator->errors()->first());
        }

        // Upload foto jika ada
        // $fotoPath = null;
        // if ($request->hasFile('foto')) {
        //     $fotoPath = $request->file('foto')->store('foto_user', 'public');
        // }

        // Simpan user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->email_verified_at = now();
        $user->nip = $request->nip;
        $user->alamat = $request->alamat;
        $user->noktp = $request->noktp;
        $user->tgl_lahir = $request->tgl_lahir;
        $user->no_hp = $request->no_hp;
        // $user->foto = $fotoPath;
        $user->save();
        Auth::login($user);
        return redirect(route('dashboard'))->with('toast_success', 'Pendaftaran Berhasil, Selamat Datang! ' . Auth::user()->name);

    }
}
