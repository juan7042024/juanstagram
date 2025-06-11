<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController; // aqui se ve que se importo el controlador
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
GET es el mas simple, cuando visitas un sitio web por default es un get, y el metodo
solo se utiliza para RECUPERAR datos del servidor PERO NUNCA ENVIAR

POST se utiliza cuando "mandas" datos al servidor; esto incluye informacion que llenas de un formulario
o buscador.

PUT es utilizado para actualizar datos en el servidor, pero si no existe crea uno nuevo; 
PUT es un reemplazo total de un registro

PATCH es utilizado para actulizar parcialmente un elemento o recurso

DELETE se usa para eliminar un recurso o elemento, 
 */

 // OJO AL CAMBIAR EL ORDEN DE LAS RUTAS COMO EL DE "editar-perfil" esta encima /{user:username} para entrar al perfil del usuario,
 // ejecutar "php artisan route:cache"

 // Esto se le conoce como Routing (es preferible usar controladores) y gracias al __invoque del HomeController, se puede mandar a llamar asi 
Route::get('/', HomeController::class)->name('home');

// Rutas DONDE NAVEGARA LA APLICACION WEB 
//GET cuando visitas el sitio lo que muestra el servidor   name que existe dentro de la clase que forma parte de la URL /register puede ponerle /nose, tomara en cuenta el "name->()" SIEMPRE cuando la rutas del mismo GET y el post tengan la misma ruta
Route::get('/register', [RegisterController::class, 'index'])->name('register'); // declaramos el controlador, se le pasa por una clase la funcion llamada "index" que tiene el RegisterController.php

// POST: Cuando un usuario llena un formulario para luego ser enviado hacia el servidor
Route::post('/register', [RegisterController::class, 'store']); // se pone la funcion "store" para ser llamada, lo que hara es el envio de datos de lo que tenga el formulario hacia el servidor, se hace con una funcion en el controlador

//Route::get('/autenticar', [RegisterController::class, 'autenticar']); // otra funcion que tiene algo que proviene del controlador "RegisterController"

// RUTA DEL LOGIN LO QUE MOSTRARA LA PAGINA
Route::get('/login', [LoginController::class, 'index'])->name('login');
// RuTA DEL LOGIN DONDE SE ENVIARAN LOS DATOS la funcion del controlador "store" donde se almacenara la informacion
Route::post('/login', [LoginController::class, 'store']);

// Ruta para el cierre de sesion con la funcion store dentro del controlador LogoutController con un name igual a la ruta "logout" de tipo post de lo que muestra hacia el usuario
Route::post('/logout',[LogoutController::class, 'store'])->name('logout');

// Metodos para editar el perfil directo hacia el controlador donde se muestra lo que se va editar
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
// ruta donde se envian esos cambios hacia el controlador y la Base de datos
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');



// Se crea la ruta donde se ira a hacer las publicaciones donde se mostrara el contenido hacia el usuario
// Se dirige hacia el PostContriller donde llama a la funcion de "create" y se renombra en la URL "posts.create"
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');// asi en el name, se crea en views/posts/create.blade.php para que coincida es lo mas recomendable

// Creacion de la ruta de publicaciones donde la funcion se llama store del controlador y renombrado a posts.store
Route::post('/post',[PostController::class, 'store'])->name('posts.store');

// La peticion es de tipo GET, se llama a la funcion show del controlador PostController y se renombra a posts.show y la funcion se llama "SHOW" en base a la documentacion de laravel
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');// los nombres de las rutas es muy util

// Ruta para el perfil del usuario donde en PostController, hacemos la funcion de "destroy"
Route::delete('/posts/{post}', [PostController:: class, 'destroy'])->name('posts.destroy');

// Ruta donde se enviaran los likes cuando se envien
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
// Ruta donde se enviaran los dislikes cuando se envien
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');



// Creacion de la ruta tipo POST donde se enviaran las imagenes hacia el servidor
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

// Esta de ultimo que si alguna URL de las de arriba no se reconocen, caiga hacia el username su index
// Redirecciona despues del registro de usuario
//{user:username} es para que en la URl, muestre hacia el nombre usuario la URl donde se mandaran los datos de la aplicacion, poniendo en vez en la URL /muro se pone /{nombre_usuario} <-  del usuario
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');

// ruta POST de la accion de que siguen los usuario al oprimir el boton
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
// ruta DELETE para eliminar alguna accion(en este caso algun registro)
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

