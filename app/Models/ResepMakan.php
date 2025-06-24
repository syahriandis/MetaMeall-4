<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepMakan extends Model
{
    protected $fillable = [
    'nama',
    'tanggal',
    'jenismakanan',
    'details',
    'kalori',
    'feedback',
    'trainee_id'
];


}
