<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //dentro de views/auth/ creamos el "login.blade.php"

    public function index(){
        // Mandamos a mostrar el inicio de sesion
        return view('auth.login');
    }

    public function store(Request $request){

        // HAcer pruebas si mantener o NO la sesion abierta funciona "Null" si NO se marca la opcion, "ON" si se marca la opcion
        //dd($request->remember_token); 
        
        // El uso de "dd('autenticando')", es importante para la comunicacion de los endpoints para avanzar en la creacion de las funciones
        $this->validate($request,[
            'email' => 'required|email', // email es un campo obligatorio y debe ser un email
            'password' => 'required'
        ]);

        // Verificar si las credenciales estan mal ingresadas para mandar un mensaje, se checa en el navegador las cookies
                                                        // Aqui se mantiene si la sesion se mantiene o NO, se mete dentro del arreglo de email y password se pone el $request->remember, para ver si funciona
                                                        // En el navegador en la seccion de cookies, verificas dl inicio de sesion sin marcar la de "mantener sesion", en cookies solo generar los tokens de sesion
                                                        //si lo marcas de mantener la sesion y presionar iniciar sesion, las cookies genera un token y te la da, la BD guarda el token de sesion en "remember Token" y verificara si coincide con el token dado de la sesion abierta 
        if(!auth()->attempt($request->only('email', 'password', $request->remember))){ //manda un true o false si esta mal escrito, tambien en el login.blade.php, se pone una verificacion si el login esta bien d
            return back()->with('mensaje', 'Credenciales Incorrectas');
            //back() : regresa el mensaje con el error 
        }

        // Si el usuario se autentico, lo redirigimos, si copias la url hacia otro navegador, "te mandaria al login"
                                    
        return redirect()->route('posts.index', 
        // (Error lo marca laravel 10 por falta de parametros) y es la ruta de autenticacion del usuario
        ['user' => auth()->user()->username] // Ya pusimos en la ruta del usuario autenticado, {user:username} aunque aqui no se declare el modelo User como si en PostController par ver el name, se pone el ['user' => auth()->user()->username] para evitar errores 
                                            // por la falta de parametros (igual en el registro)
        );
    }
}
