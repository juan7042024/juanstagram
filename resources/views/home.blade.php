@extends('layouts.app')  <!--Se llama el contenido que se mostrara del proyecto que es el home desde "app.blade.php"-->

<!--COMPONENTE donde ira el "contenido principal" el donde el usuario ve primero la pagina--->
@section('titulo')
    Pagina principal
@endsection


@section('contenido')<!--Se llama el contenido que se mostrara del proyecto de "register.blade.php"-->

<!--pasa la variable, siempre y cuando el constructor se le pase $posts dentro del controlador del componente-->
<!--Se hace un "php artisan view:clear" para limpiar la cache de la vista-->
    <x-listar-post :posts="$posts"/>


@endsection