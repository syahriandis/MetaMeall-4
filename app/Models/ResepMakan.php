<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepMakan extends Model
{
    protected $table = 'resep_makan'; // Ganti ke nama tabel yang benar

    protected $fillable = [
        'nama',
        'tanggal',
        'jenismakanan',
        'details',
        'kalori',
        'status',
    ];

    public $timestamps = false; // jika tidak ada kolom created_at & updated_at
}
