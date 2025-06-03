<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;


use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(){
        return view('pages.auth.login');
    }
    public function daftar(){
        return view('pages.auth.daftar');
    }

    public function registerProcess(Request $request)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
        'age' => 'required|integer',
        'gender' => 'required|string',
        'weight' => 'required|numeric',
        'height' => 'required|numeric',
    ]);

    // Simpan user ke database
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'age' => $request->age,
        'gender' => $request->gender,
        'weight' => $request->weight,
        'height' => $request->height,
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),
        'role' => 'trainee',
    ]);

    return redirect()->route('beranda')->with('success', 'Registrasi berhasil!');
}

public function loginProcess(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('beranda')->with('success', 'Login berhasil!');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
}


public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'Berhasil logout.');

    
}
}
