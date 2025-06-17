<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    public $timestamps = false;
    public $primaryKey = 'trainee_id';
    public $incrementing = false;

    protected $fillable = [
        'trainee_id', 'weight', 'height'
    ];
}
