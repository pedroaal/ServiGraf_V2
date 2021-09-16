<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddComentario extends Component
{
  public $contactoId;

  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($contactoId)
  {
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
