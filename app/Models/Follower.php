<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    // Declaramos los campos de la tabla Pibote de "Follower"
    protected $fillable = [
        'user_id',
        'follower_id'
    ];
}
