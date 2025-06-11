<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Creacion de una migracion que es tabla pibote para que se registren los que siguen y no siguen de los perfiles los usuarios
        Schema::create('followers', function (Blueprint $table) {
            $table->id();                          // Ejemplo de relacion de Muchos a Muchos
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // llave foranea(destino) que registra el ID del que dio seguir y si eliminar tu perfil se elimina el registro de la relacion
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');// llave foranea(destino) que registra que "user_id" sigue a otro "user_id"(este ultimo seria el follower_id) y el constrained de 'users' saca el Id que sigue "user_id"
            $table->timestamps();
        });// Despues EJECUTAMOS LA MIGRACION CON LOS CAMBIOS
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
