<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramLatihan extends Model
{
    protected $table = 'program_latihan';

    protected $fillable = [
        'nama',
        'tanggal',
        'jenis_latihan',
        'details',
        'feedback', // Ubah dari 'status' menjadi 'feedback'
        'kalori',   // Tambahan
    ];

    public $timestamps = false; // jika tidak ada kolom created_at & updated_at
}
