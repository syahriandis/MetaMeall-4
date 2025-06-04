<?php
// app/Models/Notifikasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'title',
        'message',
        'is_read',
    ];
}
