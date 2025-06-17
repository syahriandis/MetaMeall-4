<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Trainee;
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
            'role' => 'required|in:trainer,trainee'

            

        ]);

        // Simpan user ke database
        Log::debug('ROLE YANG DISIMPAN:', ['role' => $request->role]);
    
        $user = User::create([
            
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'gender' => $request->gender,
            'role' => $request->role, 
        ]);

        if($request->role === 'trainee'){
            Trainee::create([
                'trainee_id' => $user->id,
                'weight' => $request->weight,
                'height' => $request->height,
            ]);
        }

        $user->profile()->create([
            'nama' => '',
            'email' => '',
            'umur' => '',
            'berat' => '',
            'tinggi' => '',
        ]);

        logger('ROLE INPUT:', ['role' => $request->role]);
        Auth::login($user);
        
        session()->put('role', $user->role);
        $request->session()->regenerate();

        return redirect()->route('login')->with('success', 'Registrasi berhasil!');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            session()->put('role', $user->role);
            $request->session()->regenerate();


            if ($user->role === 'trainer') {
                return redirect()->route('beranda-trainer')->with('success', 'Login berhasil sebagai trainer!');
            }

            return redirect()->route('beranda')->with('success', 'Login berhasil sebagai trainee!');
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

