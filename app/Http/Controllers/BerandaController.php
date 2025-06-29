<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function beranda_trainer()
    {
        $trainees = User::where('role', 'trainee')
            ->leftJoin('program_latihan', 'users.id', '=', 'program_latihan.trainee_id')
            ->select('users.id', 'users.name', 'users.email', DB::raw('COUNT(program_latihan.id) as total_latihan'))
            ->groupBy('users.id', 'users.name', 'users.email')
            ->get();

        return view('pages.trainer.beranda', compact('trainees'));
    }

    public function beranda_trainee()
    {
        return view('pages.beranda'); // Sesuaikan jika nanti disimpan di /trainee
    }
}
