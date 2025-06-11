<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    //

    // Se le pasa el parametro el modelo de User debido a que la ruta en Web.php, requiere el usuario para recibir ese dato
    
    
    public function store(User $user){
       // para hacer pruebas si pasan las rutas dd($user->username); y para hacer lo que sigue hay que tener las relaciones de la tabla pibote para hacer estas asociaciones $user->followers

       // Relacion de tablas pibote y attach es para la relacion de muchos a muchos de varias tablas o con la misma tabla
       // follower: accedes a la informacion follower() accedes a la definicion del metodo para acceder a otros metodos como en este caso a attach()
       // acceder al Id usuario  y agreha la persona que lo esta siguiendo y sera la persona autenticada
       $user->followers()->attach( auth()->user()->id );

       return back();

    }

    // Funcion de eliminar de dejar de seguir
    public function destroy(User $user){
        // se usa el detach para eliminar el registro de seguir en la BD
        $user->followers()->detach( auth()->user()->id );

        return back();
    }
}
