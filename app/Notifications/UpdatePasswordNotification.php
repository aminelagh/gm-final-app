<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UpdatePasswordNotification extends Notification
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
                  ->subject('Modification du mot de passe d\'un utilisateur')
                  ->line('Bienvenue dans GolfMaroc-APP votre application de gestion des points de vente du groupe GolfMaroc .')
                  ->line('Nous vous informons que le mot de passe de l\'un des utilisateurs de l\'appllication a été modifié ')
                  ->action('Vous pouvez acceder a votre application ici ', url('http://golfmaroc-001-site1.itempurl.com/public/home'))
                  ->line('Merci d\'avoir utilisé notre application' );
  }


  public function toArray($notifiable)
  {
      return [

      ];
  }
}
