<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerCreated extends Notification
{
    use Queueable;
    

    public function __construct($link, $msg, $user)
    {
        $this->link = $link;
        $this->msg = $msg;
        $this->user = $user;
    }

    
    public function via($notifiable)
    {
        return ['database'];
    }

    
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    
    public function toArray($notifiable)
    {
        return [
            "data"=>$this->msg,
            "link"=>$this->link,
            "user"=>$this->user,
        ];
    }
}
