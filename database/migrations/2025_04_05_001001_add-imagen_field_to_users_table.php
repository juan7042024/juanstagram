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

        // NO siempre las migraciones sirve para crear tablas completas, si no campos 1 o 2 nuevos para pruebas o para unirlo a otra migracion
        // users es a la tabla donde se le pueden agregar mas campos y no directamente a la migracion de users, esto sirve para hacer pruebas
        Schema::table('users', function (Blueprint $table) {
            // se añade un nuevo campo donde se pone "nullable" porque las imagenes no son obligatorias si quiere o no el usuario
            //php artisan make:migration add-imagen_field_to_users_table (este nombre para que la migracion automaticamente añada "users" y se asocie al modelo)
            $table->string('imagen')->nullable(); // Se hace el php artisan migrate
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('imagen');
        });
    }
};
