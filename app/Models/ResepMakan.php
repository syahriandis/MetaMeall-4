<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepMakan extends Model
{
    protected $fillable = [
    'nama',
    'tanggal',
    'jenis_makanan', // sudah snake_case
    'details',
    'kalori',
    'feedback',
];

}
