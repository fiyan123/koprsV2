<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    public function index()
    {
        return view('layouts.dashboard');
    }

    public function indexKeanggotaan()
    {
        return view('dashboard.keanggotaan');
    }

    public function indexSimpanPinjam()
    {
        return view('dashboard.simpanPinjam');
    }

    public function indexKeunggulan()
    {
        return view('dashboard.keunggulan');
    }

    public function indexEventMedia()
    {
        return view('dashboard.eventMedia');
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
