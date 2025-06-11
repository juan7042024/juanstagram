<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    //

    // Esto evita que otro usuario Autenticado No edite otro perfil 
    //al menos que sea el del usuario su propio perfil
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Funcion para poder editar el perfil si el usuario autenticado esta en su perfil
    public function index(){
         // Se verifica si funciona la ruta 
        // dd('aqui el perfil');

        return view('perfil.index');
    }

    // Funcion para poder editar el perfil si el usuario autenticado esta en su perfil
    public function store(Request $request){
        // checamos si funciona la ruta dd('Guardando cambio');

        //MODIFICAR EL REQUEST (mostrar otro error y no el que da laravel cuando intente registrar 2 usuarios iguales)
      $request->request->add([
        // Evitar que muestre la consulta de error SQL si no que muestre el alert
        'username'=> Str::slug ($request->username)
      ]);


        $this->validate($request, [
                        // Validacion que si son mas de 3 parametros, se mete en un arreglo,   reglas de validacion donde el usuario NO puede poder ese tipo de nombres en su Username
                                    // validacion del usuario donde si oprime el boton de guardar, No hace el cambio y te retorna algo(en este caso te devuelve para que cambies el nombre)
            'username' => ['required', 
            'unique:users,username,' . auth()->user()->id, // hay que tener cuidado con tener espacios en "user:username ," debe ir junto la coma, ya que es susceptible a errores
            'min:3',
            'max:30', 
            'not_in:twitter, editar-perfil',  // puedes poner otros como estos 'in:CLIENTE, PROVEEDOR, VENDEDOR' que son palabras reservadas para que no metas eso de perfil al sistema
            ]

        ]);

        // $this->validate($request, [
        //     'username' => [
        //         'required', 
        //         'unique:users,username,' . auth()->user()->id,
        //         'min:3',
        //         'max:30',
        //         'not_in:twitter,editar-perfil', // Usamos 'not_in' para evitar ciertos valores
        //         'in:CLIENTE,PROVEEDOR,VENDEDOR' // Asegúrate de que los valores en 'in' sean los correctos
        //     ]
        // ]);

        // Validacion para verificar si el usuario cambio o no de imagen de lo que haya recibido el request
        if($request->imagen){// condicion de que si cambio IMAGEN, hace el cambio
            $imagen = $request->file('imagen'); // recibe archivo y se pone en 'file

        // Esto generara un Id unico para cada una de las imagenes porque cada directorio del servidor NO
        // Podemos tener dos imagenes con el mismo ID pero SI con el mismo Nombre
        $nombreImagen = Str::uuid() . "." . $imagen->extension(); // esto solo guarda la ruta de la imagen en la base de datos, mas no dentro de la base de datos para no sobrecargarla

        // make: nos permite crear una imagen de intervention Image y le vamos a pasar imagen
        // que estamos subiendo
        $imagenServidor = Image::make($imagen);
        $imagenServidor->fit(1000, 1000); // la cantidad de pixeles que podra tomar de la imagen que suba el usuario

        // Dentro de Public, se crea la carpeta "uploads", con eso en la consola, deberia de geneerar el id  de la imagen, nos vamos a uploads,
        // deberia de estar ahi la imagen subida
        $imagenPath = public_path('perfiles') . '/' . $nombreImagen; // Creamos la ruta donde se va guardar la imagen
        $imagenServidor->save($imagenPath); // Lo que se tiene en memoria, se va a guardar junto a esa ruta

        }else{
            dd('No imagen');
        }
        // Si no hay cambio en la imagen, sigue en la siguiente linea

        // guardar cambios

        // Esto buscara el ID usuario si es el usuario quien modifica su informacion
        $usuario = User::find(auth()->user()->id);

        // Esto capta los datos del usuario
        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null; // ternario donde $nombre imagen es del if de arriba, de lo contrario, no pasa nada de datos

        // Aqui se guarda en la base de datos
        $usuario->save();

        // Redireccionamos al usuario y con el seguro del nuevo nombre de usuario ya actualizado
        return redirect()->route('posts.index', $usuario->username);
    }
}
