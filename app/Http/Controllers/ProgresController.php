<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgresController extends Controller
{
   public function progres_trainer()
{
    $latihan = DB::table('program_latihan')
                ->select('tanggal', 'kalori')
                ->orderBy('tanggal')
                ->get();

    $makan = DB::table('resep_makans')
                ->select('tanggal', 'kalori')
                ->orderBy('tanggal')
                ->get();

    return view('pages.trainer.progres', compact('latihan', 'makan'));
}

public function progres()
{
    $latihan = DB::table('program_latihan')
                ->select('tanggal', 'kalori')
                ->orderBy('tanggal')
                ->get();

    $makan = DB::table('resep_makans')
                ->select('tanggal', 'kalori')
                ->orderBy('tanggal')
                ->get();

    return view('pages.progres', compact('latihan', 'makan'));
}


    
}
