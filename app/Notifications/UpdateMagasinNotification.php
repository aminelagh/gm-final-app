<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdateMagasinNotification extends Notification
{
  use Queueable;



   protected $user;
  public function __construct($user)
  {
        $this->user=$user;
  }



  public function via($notifiable)
  {
      return ['mail'];
  }


  public function toMail($notifiable)
  {
      return (new MailMessage)
                  ->subject('Modification des cordonnées d\'un Magasin ')
                  ->line('Bienvenue dans GolfMaroc-APP votre application de gestion des points de vente du groupe GolfMaroc .')
                  ->line('Nous vous informons qu\'une modification des cordonnées d\'un magasin a eu lieu dans notre application ')
                  ->action('Vous pouvez acceder a votre application ici ', url('http://golfmaroc-001-site1.itempurl.com/public/home'))
                  ->line('Merci d\'avoir utilisé notre application' );
  }


  public function toArray($notifiable)
  {
      return [

      ];
  }
}
