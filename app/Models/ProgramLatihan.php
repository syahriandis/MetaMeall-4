<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramLatihan extends Model
{
    protected $table = 'program_latihan';

   protected $fillable = [
    'trainee_id',
    'nama',
    'tanggal',
    'jenis_latihan',
    'details',
    'feedback',
    'kalori'
];


    public $timestamps = false; // jika tidak ada kolom created_at & updated_at
}
