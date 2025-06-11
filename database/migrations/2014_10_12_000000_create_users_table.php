<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * para ver mas migraciones, con php artisan make:migration --help
     * 
     * CREAR el USERNAME con "php artisan make:migration add_username_to_users_table",
     * crean 2 metodos el UP: donde se ejecuta cuando haces la migracion. DOWN eliminas y añades el "username" tanto en el UP como en el DOWN
     * ejecutamos php artisan migrate para ver los cambios, en los gestores de BD, se ve que los cambios en la tabla "users", genera el "username"
     */
    public function up(): void
    {
        // La tabla de users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
