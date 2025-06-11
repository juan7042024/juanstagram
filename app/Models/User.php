<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     * El modelo de User que es un extra de seguridad
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'imagen' //se agrega el nuevo campo de username al modelo
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Si cambias en la migracion para romper la convencion de laravel en "posts" a publicaciones, y de "user_id" a "autor_id" en la relacion
    // hay que pasarle una llave foranea hacia "autor_id", 

    // Creacion de la relacion de 1 a muchos que es has many
    public function posts(){
        // Se asocia el otro modelo Post que es el "Muchos", hacemos pruebas en php artisan tinker para ver la funcion de la relacion
        // buscamos en tinker este usuario id de ejemplo: "$usuario = User::find(7);"
        // VERIFICAR LA RELACION CON PONER "$usuario->posts"
        return $this->hasMany(Post::class); // si los pones en español en la migracion de post, con poner ",'autor_id'" para que identifique la llave fornanea
    }

    // Despues sigue la relacion para que borre el registro del user_id y del post_id
    public function likes(){
        // hasMany porque el usuario puede tener multiples likes es decir puede darle LIKE a varias publicaciones que desee
        // por eso entra en el modelo de Like
        return $this->hasMany(Like::class);
    }

    //Metodo que almacena Los seguidores de un usuario (AQUI NO SIGUE LAS CONVENCIONES DE LARAVEL, HAY QUE DECLARARLAS)
    public function followers(){
        // relacion de (destino) muchos seguidores de 1 usuario(ejemplo los seguidores ID 4,5,6,7,21,23 que siguen al id 20)
        //El metodo followers de la tabla followers pertenecen muchos usuarios y se declaran los campos de la llave foranea de la tabla Pibote esto se hace porque nos salimos de las "convenciones de laravel"
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');// (followers: es la tabla de la migracion que hace referencia)
    }

    // Almacenar los que seguimos
    public function followings(){
        // 
        // esta relacion foranea (destino) obtiene la fuente del id que esta siguiendo al usuario de este perfil
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');// 
    }



    // Comprobar si un usuario sigue a otro
    public function siguiendo(User $user){
        // followers es la funcion donde se sigue al usuario y verifica si ya es seguidor de la persona
        return $this->followers->contains( $user->id); // contains para que itere la coleccion de las tabla pibote de "followers" pasandole el id del usuario que se busca con $user->id
    }


    
}
