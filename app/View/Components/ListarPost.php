<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListarPost extends Component
{
    public $posts;// Se declara para pasarle la variable dentro de $posts hacia el contructor para que dentro del 

    // Hacer conocer al constructor el valor $posts para poder pasar la informacion hacia la vista
    public function __construct($posts)
    {
        // aqui se declara para luego poder pasar la informacion a la vista de dashboard.blade.php
        $this->posts = $posts;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.listar-post');
    }
}
