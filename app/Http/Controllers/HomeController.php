<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Creacion que llama a la vista que va mostrar primero hacia el usuario

    // Esto es para que las personas que no tienen cuenta, puedan ver las publicaciones de los usuarios
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Invoque es un metodo que se manda a llamar automaticamente como un constructor
    public function __invoke(){
        // Obtener a quienes seguimos y "pluck" es para traer ciertos campos filtramos los datos que queremos usar
        $ids = auth()->user()->followings->pluck('id')->toArray();// Convierte en  modo array los datos 

        // Filtrar el Post
        // Con el where es para filtrar un valor y el whereIn es para filtrar en un arreglo y el "latest" para mostrar lo mas reciente
        $posts=Post::whereIn('user_id', $ids)->latest()->paginate(20); // filtramos el "user_id" y se guarda en "$ids" y el get() para traer los resultados o paginate(20)

        //dd($posts);

        return view('home',[
            // Pasamos el valor hacia la vista
            'posts'=> $posts
        ]);
    }
}
