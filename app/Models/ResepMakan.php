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

    /**
     * Relasi ke model User atau Trainee
     */
    public function trainee()
    {
        return $this->belongsTo(User::class, 'trainee_id'); // Ganti User::class jika kamu pakai model Trainee
    }
}
