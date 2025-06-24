<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProgresController extends Controller
{
    // Untuk trainer: bisa pilih trainee dari dropdown
    public function progres_trainer(Request $request)
    {
        $traineeId = $request->get('trainee_id');
        $trainees = User::where('role', 'trainee')->get();

        $latihan = DB::table('program_latihan')
                    ->select('tanggal', 'kalori')
                    ->when($traineeId, fn($query) => $query->where('trainee_id', $traineeId))
                    ->orderBy('tanggal')
                    ->get();

        $makan = DB::table('resep_makans')
                    ->select('tanggal', 'kalori')
                    ->when($traineeId, fn($query) => $query->where('trainee_id', $traineeId))
                    ->orderBy('tanggal')
                    ->get();

        return view('pages.trainer.progres', compact('latihan', 'makan', 'trainees', 'traineeId'));
    }

    // Untuk trainee: hanya lihat datanya sendiri
    public function progres()
    {
        $user = Auth::user();

        $latihan = DB::table('program_latihan')
                    ->select('tanggal', 'kalori')
                    ->where('trainee_id', $user->id)
                    ->orderBy('tanggal')
                    ->get();

        $makan = DB::table('resep_makans')
                    ->select('tanggal', 'kalori')
                    ->where('trainee_id', $user->id)
                    ->orderBy('tanggal')
                    ->get();

        return view('pages.progres', compact('latihan', 'makan'));
    }
}
