<div>
    <!-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Marie Curie -->
    {{-- <h1>Mostrar Post</h1> --}}

    <!--AQUI TRAEMOS LAS PUBLICACIONES DE LAS PERSONAS QUE SEGUIMOS-->
@if($posts->count())<!--Condicion donde se muestra si hay contenido del post-->
<!--Le damos estilos para acomodar de mejor manera las imagenes aparte de que es responsivo-->
<div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <!--Si ya pasa, se manda por un foreach para mostrar los valores que tenga guardado en los posts-->
    @foreach ($posts as $post)
    <div>
        <!--Como en route esta '/{user:username}/posts/{post}'  $post->$user para entrar al user  donde el post es el ID, se le pasa al href el $post que tiene el ID para que lo muestre en la vista y el usuario que es el que tiene asignado el ID de la publicacion-->
        <a href="{{route('posts.show', ['post'=>$post, 'user'=> $post->user])}}"><!--Aqui se muestra la imagen accediendo al atributo una vez ya consultado junto a "Uploads" donde se encuentra almacenado dichas imagenes en "PostController" al igual que el titulo-->
            <img src="{{asset('uploads') . '/' . $post->imagen}}" alt="Imagen de post {{$post->titulo}}">
        </a>
    </div>
    @endforeach
</div>
<!--Creacion de un div donde dentro le pasamos boton de paginacion al estilo tailwind, siempre y cuando en la consulta, este declarado "->paginate(1)"-->
<div class="my-10">
    <div>{{ $posts->links() }}</div>
</div>
@else
<p class="text-center">no hay post, Sigue a alguien para poder mostrar sus posts</p>
@endif
</div>