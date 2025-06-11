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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            // Creacion de ambas relaciones de muchos a muchos donde hay muchos usuarios pueden tener multiples post, esto se denomina como "tabla pivote"
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Estos Id seran la relacion del ID del usuario y si comenta algun post diferente al de el, se elimna
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // igual este se elimina si el comentario se publico en un POST que se hizo, hacemos un "php artisan migrate:rollback --step=1" y luego "php artisan migrate", se hace para que funcione bien el "constrained y el "cascade"
            $table->string('comentario'); 
            $table->timestamps();
            // Despues creado lo anterior, corremos la migracion con "php artisan migrate"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
