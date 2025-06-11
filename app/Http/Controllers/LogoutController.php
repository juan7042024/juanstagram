<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    // Controlador de cerrar Sesion (Recomendable probar) "dd(Cerrando sesion)" dentro de la funcion para saber si se comunica bien para avanzar la implementacion de la accion 
    // app.blade.php, reemplazamos la ruta de cerrar sesion de register -> "logout" dentro de su route asi tiene el "name" la ruta que se declaro en web.php
    public function store(){
        // Si funciona la accion, se comenta el dd y se hace abajo la accion
        //dd('Cerrando sesion...');

        // Esto cierra la sesion
        auth()->logout();
        // Despues redirege hacia la ruta del login
        return redirect()->route('login');
    }
}
