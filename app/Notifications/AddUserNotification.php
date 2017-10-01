<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AddUserNotification extends Notification
{
    use Queueable;


    protected $user1;

    public function __construct($user1)
    {
        $this->user = $user1;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Ajout d\'un nouveau utilisateur')
            ->line('Bienvenue dans GolfMaroc-APP votre application de gestion des points de vente du groupe GolfMaroc .')
            ->line('Nous vous informons qu\'un nouveau utilisateur appartenant au magasin a été ajouté  ')
            ->action('Vous pouvez acceder a votre application ici ', url('https://www.golfmaroc-app.com/'))
            ->line('Merci d\'avoir utilisé notre application');
    }


    public function toArray($notifiable)
    {
        return [

        ];
    }
}
