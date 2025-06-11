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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');// añadimos el campo titulo
            $table->text('descripcion');//añadimos el campo descripcion
            $table->string('imagen');// añadimos el campo imagen
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // llave FORANEA del user Id con sus publicaciones donde 1 usuario puede tener muchas publicaciones para ello el "cascade"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
