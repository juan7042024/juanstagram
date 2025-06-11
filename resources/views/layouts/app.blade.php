<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--Aqui reutiliza codifo del title para la pestaña-->
        <title>Devestagram - @yield('titulo')</title>
        @stack('styles')<!--Darle estilos diferentes que NO TODAS las paginas deben de tener en este caso en create.blade.php, si estilos de dropzone con push('styles')-->
        <Link href={{ asset('css/app.css') }} rel="stylesheet">
        @vite('resources/css/app.css')<!--AL igual los estilos de "tailwind" para que funcione-->
        @vite('resources/js/app.js')<!--Se toma en cuenta para que funcione el DROPZONE-->
    </head>
    <body class="antialiased">
        <header class="p-5 border-b bg-white shadow"> <!--Genera un borde para la navegacion generalmente esto se checa en la documentacion de tailwind-->
            <div class="container mx-auto flex justify-between items-center"> <!--un contenedor donde dentro estan centrado-->
                <a href="{{route('home')}}" class="text-3xl font-black">
                    Juanstagram
                </a>

                <!--verificar si un usuario esta autenticado o no (salda en el dashboard del usuario si se autentico o no)-->
                {{-- @if(auth()->user()){
                    <p>Autenticado</p>
                @else
                    <p>No autenticado</p>
                @endif --}}

                <!--Cualquiera de las 2 formas (if) muestra si el usuario esta autenticado aunque esta es mas moderna y RECOMENDADA para este caso o funcion (en este caso el de cerrar sesion)-->
                @auth
                <nav class="flex gap-2 items-center"> <!--Separa el login y el crear cuenta en vertical y los centra-->
                    <!--Dentro del boton de "crear" ponemos la ruta del "name" de web.php-->
                    <a href="{{route('posts.create')}}" class="flex items-center gap-2 bg-white border p-2 text-gray-600 rounded text-sm uppercase font-bold cursor-pointer"><!--Se crea un boton para crear una publicion siempre y cuando el usuario este autenticado-->
                        <!--Implementacion de iconos de SVG directo de https://heroicons.com/-->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                          </svg>
                          
                        Crear
                    </a>
                    <!--Aqui se pasa dentro del parametro la autenticacion dentro del href donde verifica si estas autenticado para mandarte a tu perfil-->                                 
                    <a class="font-bold text-gray-600 text-sm" href="{{ route('posts.index', auth()->user()->username)}}">
                        Hola <span class="font-normal">{{auth()->user()->username}}
                            </span>
                        </a>
                                                                            <!--Toma el name de la ruta POST, para ser llamado aqui-->
                <form method="POST" action="{{route('logout')}}"><!--Se mete dentro de un formulario el "cerrar sesion para que reduzca los ataques en caso de sesiones no cerradas y con el method 
                    POST que se comunica hacia el endpoint de web.php, se asegura de eso-->
                    @csrf <!--Se pone el csrf para evitar vulnerabilidades que entren a atacar, para eso se hace como formulario el boton para aumentar la velocidad-->                                                        
                    <button  type="submit" class="font-bold uppercase text-gray-600 text-sm">
                        Cerrar sesion
                    </button> <!--Uso de /register para redirigir hacia la cuenta de los usuarios-->
                </nav>
                </form>
                @endauth
                <!--Como el usuario de forma general (como el else) no esta autenticado, se muestra el siguiente mensaje o bloque de codigo
                 en este caso es el registro para los NO autenticados-->
                @guest
                <nav class="flex gap-2 items-center"> <!--Separa el login y el crear cuenta en vertical y los centra-->
                    <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('login')}}">Login</a>

                    
                        <a class="font-bold uppercase text-gray-600 text-sm" href="{{ route('register')}}">Crear cuenta</a> <!--Uso de /register para redirigir hacia la cuenta de los usuarios-->
                                                                            <!--Toma el name de la ruta GET, para ser llamado aqui-->
                    
                </nav>
                @endguest

               
            </div>
        </header>

        <main class="container mx-auto mt-10"> <!--contenedor donde se adapta -->
            <h2 class="font-black text-center text-3xl mb-10">@yield('titulo')</h2> <!-- YIELD('titulo') trae de manera dinamica el titulo dependiendo de la pagina-->
            @yield('contenido')<!--YIELD('contenido') trae de manera dinamica el titulo dependiendo de la pagina mediante las rutas de "web.php"-->
        </main>

        <footer class="mt-10 text-center p-5 text-gray-500 font-bold uppercase">
            Juanstagram - todos los derechos reservados {{now()->year}} <!--Aqui se pone la fecha en el formato de blade-->
        </footer>
    <body>
    </html>