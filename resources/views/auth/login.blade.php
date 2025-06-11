<!--Copiamos casi lo de register solo dejamos el username y el password-->

@extends('layouts.app') <!--Donde se declara el app.blade.php donde estan yield, donde abajo ponemos el contenido y se pone el contenido deseado-->


@section('titulo')
    Inicia Sesion en juanstagram
@endsection

@section('contenido')  <!--Contenido en este caso de  los formularios-->
<!--cuando se llena un formulario se usa un metodo POST. GET cuando obtienes informacion de un servidor-->

<!--md:gap-10 md:items-center para ajustar la imagen-->
<div class="md:flex md:justify-center md:gap-10 md:items-center 6/12 p-5"> <!--Se ajusta dentro del formulario de abajo que en este es de 4/12 que se va un poco hacia a derecha-->
    <!--4/12 hace centrar el formulario de los inputs-->
    {{-- <div class="md:w-6/12"> <!--en bootstrap, tienen grillas de 1 al 12, aqui tiene de 1/6 1/12, es decir la proporcion que usaras en la pantalla-->
        <img src="{{ asset('img/registrar.jpg')}}" alt="imagen registro usuario">
    </div> --}}
    <!--4/12 hace centrar el formulario de los inputs-->
    <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl"> <!--shadow es la sombra p-6 es el padding de 6, rounded-lg es el borde redondeado y el bg-white es el color que tendra-->
                                                <!--novalidate para quitar validacion del tipo email y checar validaciones del servidor-->
        <form method="POST" action="{{route('login')}}" novalidate> <!--Action es donde esta la ruta de "web.php" y el metodo del formulario-->
            @csrf <!--Uso de cross site request para validar el tipo de dato que es para que no nos hackeen IMPORTANTE PONERLO DENTRO DEL FORMULARIO-->
            
            @if(session('mensaje'))  <!---Condicional para mandar un mensaje al usuario si ingresa mal sus credenciales de inicio de sesion-->
                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">
                    {{session('mensaje')}} <!--Manda a llamar el mensaje dentro del LoginController-->
                </p>
            @endif
            <div class="mb-5">
                <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                    Email
                </label>
                <input type="email" 
                        name="email" 
                        id="email"
                        placeholder="Tu email de registro"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror" 
                        value="{{old('email')}}">
                @error('email')<!--Aqui se pone la directiva de error para que detecte que es de la validacion del controlador-->
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p> <!--$message, para ver los errores de manera dinamica-->
                @enderror
            </div>

            <div class="mb-5">
                <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                    Password
                </label>
                <input type="password" 
                        name="password" 
                        id="password"
                        placeholder="Tu Contrasena de registro"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror">
                @error('password')<!--Aqui se pone la directiva de error para que detecte que es de la validacion del controlador-->
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p> <!--$message, para ver los errores de manera dinamica-->
                @enderror
            </div>

            <div class="mb-5"> <!--Boton donde se verifica si mantendra o NO la sesion abierta-->
                <input type="checkbox" name="remember" id=""><label for="" class=" text-gray-500 text-sm">Mantener mi sesion abierta</label> 
            </div>

            <!--Boton de enviar los datos-->
            <input type="submit" value="Iniciar sesion" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer 
            uppercase font-bold w-full p-3 text-white rounded-lg">
        </form>
    </div>
</div>
@endsection