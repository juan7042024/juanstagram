@extends('layouts.app')

@section('titulo')
<!--qui declarado el $post en la funcion Show donde se enlaza con el modelo, ya se podria llamar en cualquier vista de .blade-->
<!--En este caso se muestra el titulo-->
{{$post->titulo}}
@endsection

@section('contenido')
<div class="container mx-auto md:flex">

    <!--Mostrar la imagen asociado al ID-->
    <div class="md:w-1/2">
        <img src="{{asset('uploads'). '/'. $post->imagen}}" alt="imagen del post {{$post->titulo}}">

        <!--Seccion de la creacion del boton LIKES-->
        <div class="p-3 flex item-center gap-4">
            @auth

            <!--Aqui se pone un componente de livewire-->
            


            <!--Entra al modelo Post y se busca el ID del post para poder hacer el like-->
            @if($post->checkLike(auth()->user()))
            <!--Muestra ya el like que le dio, se le pone un destroy para que sea propenso a eliminar su like el usuario-->
            <form method="POST" action="{{route('posts.likes.destroy', $post)}}">
                @method('DELETE')
                @csrf <!--DE LEY SE PONE DENTRO DEL FORMULARIO POR SEGURIDAD-->
                <div class="my-4">
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                          </svg>   
                    </button>
                </div>
                </form>
            @else
            <!--De lo contrario, se le da el formulario al usuario AUTENTICADO para que de like-->
                <form method="POST" action="{{route('posts.likes.store', $post)}}">
                @csrf <!--DE LEY SE PONE DENTRO DEL FORMULARIO POR SEGURIDAD-->
                <div class="my-4">
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                          </svg>   
                    </button>
                </div>
                </form>
            @endif
            
            @endauth
            <!--Cuenta los likes que se tenga guardado en la tabla like gracias al Post-->
            <p class="font-bold">  
                <span class="font-normal">{{ $post->likes->count()}} Likes</span></p>
        </div>
    </div>

    <!--Seccion de mostrar quien fue el autor de la imagen-->
    <div class="md:w-1/2"><!--Directiva para mostrar el autor quien publico dicha imagen esto debido a la relacion-->
                        <!-- De binding donde un post pertenece a 1 usuario(autor)-->
        <p class="font-bold">{{ $post->user->username}}</p>

        <!--Seccion de mostrar el registro de la publicacion, ya que es un campo de la migracion de POST-->
        <p class="text-sm text-gray-500">
            {{ $post->created_at->diffForHumans() }}<!---DiffForHumans, solo dice cuantos dias se publico eso, disfraza la fecha real y solo pone los dia, horas minutos y segundos-->
        </p>
        <!--Mostramos la descripcion de la publicacion-->
        <p class="mt-5">
            {{ $post->descripcion}}
        </p>
    </div>

    @auth <!--Con esto aseguramos que los otros usuarios que compartan la URL, no puedan eliminar si no estan auntenticados-->
    <!--entra el metodo de posts.destroy pasandole de parametro el $post y no de pone method="DELETE" pero si el method="POST"ya que No existe", eso se hace con una funcion-->
    <form method="POST" action="{{route('posts.destroy', $post)}}">
        <!--method SPOOFING puede ser PUT, PATCH y DELETE en este caso-->
        @method('DELETE') <!--Aunque es post para el formulario por que enviamos algo, pasa por la directiva de DELETE-->
        @csrf
        <!--Valida si el post es del usuario autenticado-->
        @if($post->user_id === auth()->user()->id) <!--Condicion para que si el usuario se autentico es su propia publicacion para que le salga el boton de "elimnar publicacion, de lo contrario, no le sale si esta en otra cuenta-->

        <input type="submit" value="Eliminar publicacion" class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor pointer">
        @endif
    </form>
        
    @endauth
    
@auth <!--Para comentar, aparece para usuarios AUTENTICADOS-->
        
    <div class="md:w-1/2 p-5 mb-5">
        <div class="shadow bg-white">
            <p class="text-xl font-bold text-center mb-4">Agrega un Nuevo Comentario</p>

            <!--detecta la sesion Del return  de la funcion de store de ComentarioController de with donde se pone el mensaje, mostrara si envio algo el usaurio d-->
            @if(session('mensaje'))
                <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                    {{session('mensaje')}}
                </div>
            @endif
            <!--Se pone la nueva ruta de comentarios store donde se necesita el $post y el $user ya que la ruta asi la definimos en web.php con metodo POST, para despues hacer la funcion del comentario -->
            <form action="{{route('comentarios.store', ['post'=>$post, 'user'=> $user])}}" method="POST"><!--Comentarios.store, hacemos la funcion en comentario Controller--->
                @csrf <!--SIEMPRE PONER Dentro de los form, para evitar ataques de seguridad-->
                <div class="mb-5">
                    <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">
                        Añade un comentario
                    </label>
                    <textarea 
                            name="comentario" 
                            id="comentario"
                            placeholder="Agrega un comentario"                                                     
                            class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                            >
                    </textarea>
                            <!--MOSTRAR VALIDACION EN LARAVEL-->
                    @error('comentario')<!--Aqui se pone la directiva de error para que detecte que es de la validacion del controlador-->
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p> <!--$message, para ver los errores de manera dinamica-->
                    @enderror
                </div>
                <input type="submit" value="Comentar" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer 
                uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
@endauth

      <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
        @if ($post->comentarios->count()) <!--condicion donde checa Si hay comentarios, muestra los comentarios-->
            @foreach ($post->comentarios as $comentario) <!--foreach para recorrer los comentarios una vez ya cumplida la condicion-->
                <div class="p-5 border-gray-300 border-b">
                    <!--Para mostrar los comentarios, hay que hacer una relacion de la tabla usuarios hacia la tabla de comentarios.php donde se hace la relacion (belongsto)-->
                    <!--Añadimos el link del perfil en base al "name donde este esa ruta en "web.php"-->
                    <a href="{{ route('posts.index', $comentario->user)}}" class="font-bold">
                        {{$comentario->user->username}}
                    </a>
                    <p>{{$comentario->comentario}}</p>
                    <p class="text-sm text-gray-500">{{$comentario->created_at->diffForHumans()}}</p>
                </div>
            @endforeach
        @else
           <p class="p-10 text-center">No hay comentarios Aun</p>
        @endif
      </div>

        </div>
    </div>


</div>

@endsection