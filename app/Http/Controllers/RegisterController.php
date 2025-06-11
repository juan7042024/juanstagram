<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/*

Controllers en laravel, sirve para tener un codigo mejor organizado, ademas de una mejor separacion mayor en la funcionalidad de las aplicaciones y sitios web, laravel tiene convension a la hora de nombrar los metodos
de los controllers como ResourceControllers, esto ayuda a tener todo mejor organizado

ejemplo 

Verbo http         URI                  Accion      Ruta
GET             /clientes               index       clientes.index  (index es la url principal)

POST            /clientes               store       clientes.store

Delete          /clientes/{id_cliente}  destroy     clientes.destroy   

*/


// Se hereda de controller.php
class RegisterController extends Controller
{
    //esta funcion redirecciona hacia la pagina de register en web.php se pone asi -> 
    public function index() {
        return view('auth.register'); // creamos un folder "auth" en resources/views/auth/register.blade.php donde va acceder
    }

    // ejemplo de que creamos otra funcion de autenticacion, nos vamos hacia web.php, donde vamos a declarar dicha ruta de la aplicacion, 
    public function autenticar(){

    }

    public function store(Request $request){ // Se le pasa request que es la solicitud que espera el servidor donde el usuario hara un  POST para que el servidor reciba 
    // day dump (dd) hace detener la ejecucion total de larave, ya no ejecuta las siguientes lineas de esta funcion
      //  dd($request); // $request, muestra toda la informacion a detalle de la solicitud que se uso esto sirve para debugear y ver que envias hacia el servidor

      //dd($request->get('name')); // aqui se ve en especifico lo que se envia hacia el servidor esto funciona si tengo declarado o no en el formulario en name


      //MODIFICAR EL REQUEST (mostrar otro error y no el que da laravel cuando intente registrar 2 usuarios iguales)
      $request->request->add([
        // Evitar que muestre la consulta de error SQL si no que muestre el alert
        'username'=> Str::slug ($request->username)
      ]);


      // VALIDACION EN LARAVEL

      $this->validate($request,[
        // El 5 es la cantidad de caracteres que puede ingresar minimo (min: o max:)
        'name' => 'required|max:30', // Se declara el name del formulario que es obligatorio meter datos aqui 
        'username' => 'required|unique:users|min:3|max:20', // el unique para NO existan 2 personas con username identicos y "users"-> es la tabla de la base de datos
        'email' => 'required|email|unique:users|max:60', // email es un campo obligatorio y debe ser un email
        'password' => 'required|confirmed|min:8', // password es un campo obligatorio y debe ser confirmado
      ]);

      // Se copia y pega los errores dentro de los input para referencias en caso que fallen en algo dentro del proyecto de laravel

      //dd('Creando Usuario');

      // Creacion del modelo para ser usado en el controlador en la carpeta de "models"
      // si no se importa, con click derecho, seleccionar "import class" para que se importe en las librerias el modelo que se va usar
      // Asi es como se guardarian los datos hacia la base de datos, ya que un "User:create = INSERT INTO"
      User::create([
        'name' => $request->name,
        'username' => $request->username, // se importa el str de use Illuminate\Support\Str; donde "slug", le pone guines a usuarios con separaciones
        'email' => $request->email,
        'password' =>Hash::make($request->password) // se usa Hash para encriptar
      ]);

      //Hashear passwords se importa la clase de Hash -> use Illuminate\Support\Facades\Hash;


      // AUTENTICAR UN USUARIO (se checa en attributes) donde se ven los datos de registro,
      // la contrasena hasheada, y lo que metimos durante el registro si checar la sesion en otro navegador, saldria como NULL para evitar accesos que no sea autenticado

      // auth()->attempt([
      //   'email' => $request->email,
      //   'password'=> $request->password
      // ]);

      // OTRA FORMA DE  AUTENTICAR UN USUARIO (funciona igual que la anterior)
      auth()->attempt($request->only('email', 'password'));

      // Redireccionar despues de registrarse a la ruta que se desee, en este caso a la ruta de login (posts.index) es el name de la ruta 
      return redirect()->route('posts.index', [
        // (Error lo marca laravel 10 por falta de parametros) y es la ruta de autenticacion del usuario
        'user' => auth()->user()->username // Aqui se pone la ruta de autenticacion para que coincida con el del usuario que se le proporcione
      ]);
    }
}
