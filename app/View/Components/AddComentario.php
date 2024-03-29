<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

use App\Models\Usuarios\Usuario;

class AddComentario extends Component
{
  public $usuarios;
  public $contactoId;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($contactoId)
  {
    $this->usuarios = Usuario::where('empresa_id', Auth::user()->empresa_id)->get();
    $this->contactoId = $contactoId;
  }

  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|\Closure|string
   */
  public function render()
  {
    return view('components.add-comentario');
  }
}
