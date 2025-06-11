<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

     // Creacion de la funcion de los likes asi:  "php artisan make:model --migration --controller Like"
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // llaves foraneas para que el like de algun POST, tenga su relacion hacia el ID_usuario y el ID del post
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Que sea constrained para que si borra el propietario el post, igual se borre todo esa publicacion despues de crear estos campos, con php artisan migrate
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
