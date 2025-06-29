<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|max:255',
            'age'    => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
        ]);

        $user = Auth::user();

        // Langsung update ke tabel users
        $user->update([
            'name'   => $request->input('name'),
            'email'  => $request->input('email'),
            'age'    => $request->input('age'),
            'weight' => $request->input('weight'),
            'height' => $request->input('height'),
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
