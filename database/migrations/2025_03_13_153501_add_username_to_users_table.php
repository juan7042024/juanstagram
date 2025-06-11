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
        // Se asocia hacia la tabla de Users donde esta la mayoria de campos
        Schema::table('users', function (Blueprint $table) {
            // aqui para agrega la COLUMNA username y el unique para evitar duplicados al registro de los usuarios, se hace un "php artisan migrate:rollback --step=1" para revertir la ultima migracion despues "php artisan migrate" para añadir los cambios
            // Si quieres eliminar toda la informacion de la BD con "php artisan migrate:refresh"
            $table->string('username')->unique();// Se añade el username, pero hay que actualizar las migraciones, 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Aqui para eliminar en dado caso que se requiera
            $table->dropColumn('username');// Se añade el username, pero hay que actualizar las migraciones, con "dropColumn"
        });
    }
};
