@extends('layouts.app')

<!--Verificamos si los datos se muestran en la vista-->
@section('titulo')

    Editar Perfil: {{ auth()->user()->username}}
@endsection

@section('contenido')

<div class="md:flex md:justify-center">
    <div class="md:w-1/2 bg-white shadow p-6">
        <!--Formulario donde se actualizan los datos, enctype es para que soporte el poder subir imagenes-->
                        <!--SI Da error y no reconoce la ruta, solo pon -php artisan:route cache-->
        <form method="POST" action= "{{route('perfil.store') }}" enctype="multipart/form-data" class="mt-10 md:mt:0">
            @csrf <!--Uso de cross site request para validar el tipo de dato que es para que no nos hackeen IMPORTANTE PONERLO DENTRO DEL FORMULARIO-->
            <div class="mb-5">
                <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                    Username
                </label>
                <input type="text" 
                        name="username" 
                        id="username"
                        placeholder="Tu Nombre de usuario"                                                     
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror" 
                        value="{{ auth()->user()->username }}"> <!--Mostramos el contenido del formulario que almaceno el Usuario-->
                        <!--MOSTRAR VALIDACION EN LARAVEL-->
                @error('username')<!--Aqui se pone la directiva de error para que detecte que es de la validacion del controlador-->
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p> <!--$message, para ver los errores de manera dinamica-->
                @enderror
            </div>

            <div class="mb-5">
                <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">
                    Imagen Perfil
                </label>
                <input type="file" 
                        name="iamgen" 
                        id="imagen"                                                     
                        class="border p-3 w-full rounded-lg"
                        value=""
                        accept=".jpg, .jpeg .png"> <!--Selecionar los archivos que vamos a subir y solo imagenes-->
                        <!--Mostramos el contenido del formulario que almaceno el Usuario-->
            </div>

            <input type="submit" value="Guardar cambios" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"/>
        </form>
    </div>
</div>

@endsection