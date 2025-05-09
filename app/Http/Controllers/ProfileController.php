<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
   
    public function index($id)
    {
        // dd($id);
        $user = User::findOrFail($id);
        return view('profile.index', compact('user'));
    }
   
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
