@extends('layouts.app')

<!--Ponemos por defecto el contenido que se mostrara en la pagina-->
@section('titulo')
    Crea una nueva publicacion
@endsection

@push('styles') <!--En es caso solo carga los estilos de dropzone donde unicamente le demos push a esos estilos (Esos estilos no estaran en las otras paginas)-->
<!--Para darle estilos al dropzone a la subida de archivos-->
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

<!--Aqui el contenido lo que se mostrara-->
@section('contenido')
    <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
        <div class="sm:w-8/12 lg:w-6/12 ">
            <!--Se toma la ruta donde se dirigira la imagen declarado en el "web.php"-->
            <form action="{{route('imagenes.store')}}" method="POST" id="dropzone"       enctype="multipart/form-data" class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center">
                @csrf

            </form>
        </div>

        <div class="md:w-1/2 p-10 bg-white rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{ route('posts.store')}}" method="POST" novalidate> <!--Action es donde esta la ruta de "web.php" y el metodo del formulario-->
                @csrf <!--Uso de cross site request para validar el tipo de dato que es para que no nos hackeen IMPORTANTE PONERLO DENTRO DEL FORMULARIO-->
                <div class="mb-5">
                    <label for="titulo" class="mb-2 block uppercase text-gray-500 font-bold">
                        Titulo
                    </label>
                    <input type="text" 
                            name="titulo" 
                            id="titulo"
                            placeholder="Titulo de la publicacion"                                                     
                            class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror value={{old('titulo')}}"> <!--Dentro del error, tambien se marca el recuadro en rojo para que sea indicativo y el OLD, name para que no borre al reiniciar el formulario-->
                            <!--MOSTRAR VALIDACION EN LARAVEL-->
                    @error('titulo')<!--Aqui se pone la directiva de error para que detecte que es de la validacion del controlador-->
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p> <!--$message, para ver los errores de manera dinamica-->
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="descricpion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Descripcion
                    </label>
                    <textarea 
                            name="descripcion" 
                            id="descripcion"
                            placeholder="Descripcion de la publicacion"                                                     
                            class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror"
                            >
                            {{old('descripcion')}}
                    </textarea>
                            <!--MOSTRAR VALIDACION EN LARAVEL-->
                    @error('descripcion')<!--Aqui se pone la directiva de error para que detecte que es de la validacion del controlador-->
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p> <!--$message, para ver los errores de manera dinamica-->
                    @enderror
                </div>

                <div class="mb-5"><!--Mensaje de error donde se pide una imagen para que suba (Opcional)-->
                    <!--Se pone el nombre que tiene el campo de la migracion Post, en el PostController, registramos el error-->
                    <input type="hidden" name="imagen" value={{old('imagen')}}> <!--el old imagen, para que mantenga la ultima imagen que se subio, si falla que no aparece, nos vamos a app.js-->
                    @error('imagen')<!--Aqui se pone la directiva de error para que detecte que es de la validacion del controlador-->
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p> <!--$message, para ver los errores de manera dinamica-->
                    @enderror
                </div>

                <input type="submit" value="Crear Publicacion" class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer 
                uppercase font-bold w-full p-3 text-white rounded-lg">
            </form>
        </div>
    </div>
@endsection