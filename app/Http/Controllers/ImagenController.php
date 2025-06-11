<?php

namespace App\Http\Controllers;
// Verifica si el paquete se instalo tanto Intervention y Str
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;



class ImagenController extends Controller
{
    // se crea asi el archivo "php artisan make:controller ImagenController"

    // Se crea una ruta para acceder a esta funcion de lo que va hacer
    public function store(Request $request){

        // Solucionado el errores de Image solo poniendo esta linea en el cmd -> 1 "composer require intervention/image:^2.7" -> despues en "app.php",
        //poner dentro de "providers"->   Intervention\Image\ImageServiceProvider::class,
        //dentro de aliasses -> "Intervention\Image\ImageServiceProvider::class,"


        $imagen = $request ->file('file'); // recibe archivo y se pone en 'file

        // Esto generara un Id unico para cada una de las imagenes porque cada directorio del servidor NO
        // Podemos tener dos imagenes con el mismo ID pero SI con el mismo Nombre
        $nombreImagen = Str::uuid().".".$imagen->extension(); // esto solo guarda la ruta de la imagen en la base de datos, mas no dentro de la base de datos para no sobrecargarla

        // make: nos permite crear una imagen de intervention Image y le vamos a pasar imagen
        // que estamos subiendo
        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000, 1000); // la cantidad de pixeles que podra tomar de la imagen que suba el usuario

        // Dentro de Public, se crea la carpeta "uploads", con eso en la consola, deberia de geneerar el id  de la imagen, nos vamos a uploads,
        // deberia de estar ahi la imagen subida
        $imagenPath = public_path('uploads'). '/'. $nombreImagen; // Creamos la ruta donde se va guardar la imagen
        $imagenServidor->save($imagenPath); // Lo que se tiene en memoria, se va a guardar junto a esa ruta


        return response()->json(['imagen'=>$nombreImagen]); // Retornamos la imagen para ver que este todo bien en la consola debe generar "imagen "id de la imagen"
        //checamos subiendo la imagen si genera un token al subirlo en fetch/XHR -> response debe salir {"imagen":"jpg"}
        // OJO, XHR es una peticion

        // Solucionado el errores de Image solo poniendo esta linea en el cmd -> 1 "composer require intervention/image:^2.7" -> despues en "app.php",
        //poner dentro de "providers"->   Intervention\Image\ImageServiceProvider::class,
        //dentro de aliasses -> "Intervention\Image\ImageServiceProvider::class,"
        // try {
        //     $imagen = $request->file('file');
    
        //     $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
        //     $imagenServidor = Image::make($imagen);
        //     $imagenServidor->fit(1000, 1000);
    
        //     $uploadPath = public_path('uploads');
        //     if (!file_exists($uploadPath)) {
        //         mkdir($uploadPath, 0755, true);
        //     }
    
        //     $imagenPath = $uploadPath . '/' . $nombreImagen;
        //     $imagenServidor->save($imagenPath);
    
        //     return response()->json(['imagen' => $nombreImagen]);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }
    }
}
