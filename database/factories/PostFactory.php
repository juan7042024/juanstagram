<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            //Generacion de datos "FAKE" para hacer pruebas
            'titulo' => $this -> faker->sentence(5), // generamos 5 palabras, con faker
            'descripcion' =>$this -> faker->sentence(20),
            'imagen' =>$this -> faker->uuid() . '.jpg', // se le pone asi para que reconozca el tipo de dato en la BD "Post::factory()->times(200)->create();"
            'user_id' => $this->faker->randomElement([4,6,7,8,9,10,11,12,13]) // ponemos los ID (menos deberian de ser en la BD), para que sean excepcion en la generacion de esos Id sus publicaciones
            // Si te equivocas, revertir 1 cambio de la migracion asi  "php artisan migrate:rollback --step=1"

            // despues ejecutamos "php artisan Tinker" (interactua con la aplicacion hacia la base de datos)
            // en la consola, escribimos $usuario = User::find(5); permite buscar el id si existe o no
            // despues accedemos dentro del CMD de tinker a App\Models\Post::factory(), para verificar como factory esta
            //asociado al POST o asi Post::factory que es lo mismo(aunque este ultimo no lo lee el primero si)
            // para llenar "n" veces de datos hacia la BD, se hace asi "Post::factory()->times(200)->create();", si da error, 
            //corriges, te sales de la consola, vuelves a entrar para evitar errores (Lo recomendable es usar facotry en modo LOCAL y en Desarrollo)
        ];
    }
}
