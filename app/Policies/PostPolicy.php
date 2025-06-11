<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{

    use HandlesAuthorization;
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post)
    {
        // Se hace la condicion donde Si el usuario Autenticado es quien esta por eliminar su publicacion
        return $user->id === $post->user_id;
    }

}
