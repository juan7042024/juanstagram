<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    // en base a la url de la ruta que declaramos en web.php, que es '/{user:username}/posts/{post}'
    // se declara dentro del "Store" para hacer funcionar la seccion de los comentarios tal caul esta primero el user y despues el post, asi debemos hacer el orden
    public function store(Request $request, User $user, Post $post){
        // hacemos pruebas con comentario con dd('dd') al presionar enviar, debe salir el mensaje
        //dd('comentario');


        //Validar la caja de comentarios
        $this->validate($request, [
            'comentario' => 'required|max:255',
        ]);

        //Almacenar el resultado (si lo guardas, no dejara debido a que hay que declarar en sus modelo el user_id, post_id, comentario)
        Comentario::create([
            'user_id' => auth()->user()->id, // Se declara para que solo los usuarios autenticados pueden comentar mediante su ID
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);

        // Imprimir un mensaje el With se imprime si esta en SESION en "show.blade.php "
        return back()->with('mensaje', 'Comentario agregado con exito');
    }
}
