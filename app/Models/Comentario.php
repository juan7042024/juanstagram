<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    // Declaracion del modelo(tablaa) que se usara en la parte de comentarios 
    protected $fillable = [
        'user_id',
        'post_id',
        'comentario'
    ];


    // Relacion donde este comentario (Belongs To ) pertenece a un usuario
    // es decir que cada comentario tiene 1 usuario origen quien lo hizo en la plantilla de "show.blade.php" puedes escribir esto $comentario->user->username
    public function user(){
        return $this->belongsTo(User::class);
    }
}
