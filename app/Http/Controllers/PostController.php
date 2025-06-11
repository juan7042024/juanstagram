<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{

    // Este controlador debe estar seguro para los usuarios
    // Este middleware se ejecutara antes que entre al la funcion "index"
    public function __construct()
    {
        // Restringimos ciertos accesos, solo los usuarios autenticados pueden acceder a esta funciones de la pagina
        $this->middleware('auth')->except(['show', 'index']); // solo los usuarios No autenticados y autenticados pueden ver el Post de un ID de la funcion de "SHOW"
        // Con el fin que puedan comentar los usuarios, tambien ver el perfil
    }


    //Funcion donde se asocia la ruta
    // SE declara el modelo "User" para que mediante la variable "$user" lo use en la Ruta de "Web.php" para que los usuarios tengan su ID en su URL
    public function index(User $user){
        // verificar si el usuario esta autenticado donde la sesion lo muestra en "user"
        //dd(auth()->user());

        // Probamos si muestra el user como ejemplo http://localhost:8000/10 <-(Si este ID este registrado en la BD)
        // En este caso se hace una consulta para mostrar solo en la web el usuario, solo para checar si todo esta funcionando
        //dd($user->username);

        // Ejecuta antes el id que esta autenticado, ya que php es interpretado para luego hacer la consulta con where
        //dd($user->id);

        // Hacemos una consulta estilo LARAVEL para mostrar todos los posts de un usuario
        $posts = Post::where('user_id', $user->id)->latest()->paginate(1);// para paginar los posts si pones 5, 5 iamgenes por seccion
        // con get es para traer los resultados (en attributes se ven los datos de la BD)
        // verificamos si los datos del modelo "User" se muestran de dicha consulta
        //dd($posts);

        // Mandamos a llamar a dashboard
        return view('dashboard',[
            'user'=> $user, // En este arreglo podemos hacer que en el dashboard.blade.php se muestre el nombre del usuario
            'posts' => $posts // ya generado la consulta, hay que traerlo hacia la vista que es aqui para luego manipularse en el blade
        ]);
    }

    // La funcion de Create de la ruta declarada de /posts/create
    public function create(){
        // en el Boton de "crear" de app.blade.php, ponemos la ruta posts.create como esta declarado en el "name" de la ruta
        //dd('Creando post...'); // Para verificar si muestra el mensaje para luego implementar la funcionalidad

        return view ('posts.create'); // se redirige hacia /posts/create.blade.php
    }

    // Validacion de las publicaciones y guardar en la BD, create.blade.php, le pasamos le Request para que funcione y guarde en la BD
    public function store(Request $request){
        //hacemos pruebas con
        // dd('Publicacion creada...');
        // Funcion de validaciones
        $this->validate($request, [
            // en el create.blade.php, modificamos las etiquetas de de estas validaciones para que coincida los input
            'titulo' => 'required|max:255',
            'descripcion'=> 'required',
            'imagen' => 'required'
        ]); // despues de poner el campo imagen para validacion, en "app.js", se configura

        // Aqui se subirian los datos de la publicacion para generar un registro en la BD
        // Post::create([ // Importamos el Post que es el modelo y en el modelo, con el protected filliable, rellenamos estos campos para evitar errores
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id // se le asigna el ID del usuario que creo la publicacion eso cuando se encuentre AUTENTICADO
        // ]);

        // Otra forma de crear registros
        // $post = new Post();// Se crea el Objeto del registro
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;

        //TERCERA FORMA al estilo de LARAVEL de guardar registros con una relacion(esta ya debidamente creado en el modelo) las anteriores igual son validas
        // solo que esta es mas explicita de lo que va hacer en este caso una publicacion de 1 a muchos y a la inversa donde 1 publicacion proviene de 1 usuario
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id // se le asigna el ID del usuario que creo la publicacion eso cuando se encuentre AUTENTICADO
        ]);

        // Retornamos la pantalla al usuario despues de publicar hacia el usuario AUTENTICADO
        return redirect()->route('posts.index', auth()->user()->username);
    }

    //Funcion de la ruta para mostrar el contenido dentro de las imagenes del post
    // Aqui si importa el orden de como declares las variables para mostrar la URl
    public function show(User $user, Post $post){ // Se declara el modelo User por la url que tiene 2 modelos para mostrare el usuario junto al ID de su publicacion como esta ahora -> /{user:username}/posts/{post}
        return view('posts.show',[
            'post' => $post,
            'user'=> $user// Aqui se declara la variable en donde cualquier vista donde tenga relacion, se pueda usar, similar a User
        ]); // ponemos que retorne la vista de posts.show del ->name('posts.show') de la ruta de web.php
    }

    public function destroy(Post $post){
        // Verificando si se elimina o No el post, en "show.blade.php, se hace el boton de eliminar
        // dd('Elimnando ', $post->id);

        // if($post->user_id === auth()->user()->id){// Si el post es del usuario que esta autenticado
        //     dd('Si es la misma persona');
        // }else{
        //     dd('No es la misma persona');
        // }

        
        // 1: Si se pasa esta autorizacion (la validacion del usuario autenticado que borre su propio POST)
        $this->authorize('delete', $post);
        // 2: Eliminamos el post
        $post->delete();

        //3: Eliminar la imagen en conjunto donde se agarra la url completa que registro la BD de la imagen para que la elimine
        $imagen_path = public_path('uploads/' . $post->imagen);
        if(file_exists($imagen_path)){// Condicion de que si existe la imagen, tambien checar que si la publicacion tiene comentarios, tambien hay que programar para borrar esos comentarios de dicha publicacion
            unlink($imagen_path);// con esto eliminaria la imagen aunado al Id de la publicacion
        }

        
            // la retornamos al usuario su perfil
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
