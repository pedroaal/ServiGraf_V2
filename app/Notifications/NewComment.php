<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Ventas\Comentario;

class NewComment extends Notification implements ShouldQueue
{
  use Queueable;

  protected $comentario;

  /**
   * Create a new notification instance.
   *
   * @return void
   */
  public function __construct(Comentario $comentario)
  {
    $this->comentario = $comentario;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function via($notifiable)
  {
    return ['database'];
  }

  /**
   * Get the array representation of the notification.
   *
   * @param  mixed  $notifiable
   * @return array
   */
  public function toArray($notifiable)
  {
    return [
      'icon' => 'fas fa-address-book',
      'from' => $this->comentario->creador->usuario,
      'to' => $this->comentario->contacto->full_name,
      'mssg' => $this->comentario->comentario,
      'route' => route('contacto.show', $this->comentario->contacto->id)
    ];
  }
}
