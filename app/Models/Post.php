<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Si quieres crear en conjunto el modelo, la migracion, facotrys y el controller asi
// "php artisan make:model --migration --controller --factory Post"
// factory es para hacer pruebas hacia la base de datos
class Post extends Model
{
    use HasFactory;
// Se declara estos campos del modelos post para que se use en el desarrollo del sistema 
// al enviar datos hacia la BD
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    // Relacion inversa donde 1 Post puede tener a 1 usuario (belongsTo)
    public function user(){
        // Relacion "inversa" donde 1 Post pertenece a 1 un usuario
        // en tinker: $post=Post::find(1)
        return $this->belongsTo(User::class)->select(['name', 'username']); // el select es mas para seleccionar los campos que quiere que muestre y no todos
        // Esto sirve para no cargar tanta informacion en la consulta
    }

    // relacion 1 post a muchos comentarios
    // Relacion de 1 post de muchos comentarios que tendra los comentarios en base del ID de los usuarios
    public function comentarios(){
        return $this->hasMany(Comentario::class);
    }

    // relacion de que 1 post puede tener muchos Likes (has many)
    public function likes(){
        return $this->hasMany(Like::class);
    }

    // Verificar si el usuario solo dio un Like
    public function checklike(User $user){
        // se posiciona en la tabla de likes en la col "user_id" si contiene ese usuario ese post
        return $this->Likes->contains('user_id', $user->id);
    }
}
