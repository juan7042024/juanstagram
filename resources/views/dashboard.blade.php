@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username}}
@endsection



@section('contenido')

    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="sm:w-8/12 lg:w-6/12 px-5">
                <!--Ponemos la ruta donde se mostrara la imagen, mas la imagen que subio de perfil el usuario con condicional de que si el usuario no tiene imagen, se pone un SVG de un perfil de usuario por defecto-->
                <img src="{{ $user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/user.svg') }}" alt="Imagen usuario">
            </div>
            <div class="md:w-8/12 lg:w-6/12 px-5 md:flex md:flex-col items-center md:justify-center py-10 md:py-10 md:items-start">
                <div class="flex items-center gap-4">
                    <!--Declarando en el $user el modelo PostController donde directo el modelo User, mosrara el nombre del usuario aqui-->
                    <p class="text-gray-700 text-2xl ">{{$user->username}} <!--Aqui se muestra el usuario autenticado--></p>

                    <!--BOTON DE EDITAR PERFIL-->
                    <!--Seccion de editar perfil y Verificar si el usuario esta autenticado-->
                    @auth
                        <!--Verificar si ese usuario autenticado es el que va editar su perfil-->
                        @if($user->id === auth()->user()->id)
                        <!--Se pasa la ruta donde ira para actualizar sus datos -->
                            <a href="{{ route('perfil.index')}}" class="text-gray-500 hover:text-gray-600 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>                              
                            </a>
                        @endif
                    @endauth
                </div>
                
                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->followers->count()}}<!--Le indicamos con una consulta la cantidad de seguidores que tiene con "count"-->
                    <span class="font-normal">@choice('seguidor|seguidores', $user->followers->count())</span><!--Directiva de choice para que en base al count, determine que oracion agregar-->
                </p>

                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->followings->count()}}<!--Le indicamos con una consulta la cantidad de seguidores que tiene con "count"-->
                    <span class="font-normal">Siguiendo</span>
                </p>

                <p class="text-gray-800 text-sm mb-3 font-bold">
                    {{ $user->posts->count() }}
                    <span class="font-normal">Posts</span>
                </p>

            @auth<!--Ponemos que solo usuarios autenticados Pueden seguir el perfil-->
                    <!--Boton de seguir un perfil   aparte se pone el name de la ruta declarada en "web.php" y el $user que es el "USER" que estamos visitando--> 
            @if($user->id !== auth()->user()->id)<!--Condicion de que si el usuario ID es diferente al usuario autenticado, para que no muestre el boton de seguir al mismo usuario-->
                <!--$user es la persona que estamos visitando su perfil desde nuestro perfil y auth()->user() (acceder a la instancia con () ) es la persona que lo esta visitando (nuestro perfil)-->
                @if (!$user->siguiendo(auth()->user())) <!--Condicion donde el usuario verifica si es el usuario que le dio "seguir" esta autenticada-->
                
            
                    <!--(SI da error de que no encuentra la ruta aunque realmete este bien, con "php artisan route:cache", deberia de resolverse)-->
                <form action="{{ route('users.follow', $user)}}" method="POST">
                    @csrf
                    <input type="submit" class="bg-blue-600 text-white uppercase rounded-lg px-3 text-xs cursor-pointer" value="Seguir">
                </form>

                @else

                <!--Boton de Dejar de seguir un perfil-->
                <form form action="{{ route('users.unfollow', $user)}}" method="POST">
                    @csrf
                    @method('DELETE')<!--Se mete un  metodo de Spoffing para que el metodo sea detectado, tambien este el de PUT y PATCH-->
                    <input type="submit" class="bg-red-600 text-white uppercase rounded-lg px-3 text-xs cursor-pointer" value="Dejar de Seguir">
                </form>
                @endif
            @endif 
            @endauth
                
            </div>
        </div>
    </div>

    <!--Seccion DE MOSTRAR LAS PUBLICACIONES DIRECTO DE PostController en el dashboard del usuario-->
    <section class="container mx-auto mt-10">
        <div class="text-4xl text-center">
            <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>
            <!--Verificacion si pasa la consulta para mostrar los posts-->
            {{-- {{dd($posts)}} --}}

            <x-listar-post :posts="$posts"/>
    </section>
@endsection
