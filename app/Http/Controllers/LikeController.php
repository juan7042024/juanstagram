<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    //Funcion del boton de Like

    public function store(Request $request, Post $post){
        // Probamos con dd si no haya problema de comunicacion, despues de ello, en el modelo de LIKE, se declara para que funcione

        // Funcion para dar like a un post donde se guarda el id user_id y post_id
        $post->likes()->create([
            // Se manda hacia el modelo de LIKE el id del usuario y el id del post
            'user_id' => $request->user()->id
        ]);

        // Regresa al mismo sitio despues de haber puesto like
        return back();
    }

    // Funcion de eliminar el like
    public function destroy(Request $request, Post $post){
        // Funcion para eliminar el like de un post que es una consulta de BD
        $request->user()->likes()->where('post_id', $post->id)->delete();
        // Nos devuelve al mismo sitio despues de eliminar el like
        return back();
    }


}
