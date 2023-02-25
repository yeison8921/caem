<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ForgotPasswordNotification extends Notification
{
    use Queueable;

    protected $name;
    protected $new_password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $new_password)
    {
        $this->name = $name;
        $this->new_password = $new_password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Restablecimiento de contraseña')
            ->greeting('Hola ' . $this->name . '!')
            ->line('Has solicitado un restablecimiento de contraseña.')
            ->line('Tu nueva contraseña es: ' . $this->new_password)
            ->action('Acceder al sistema', url('/'))
            ->salutation(new HtmlString('Saludos, <br> Equipo Carbon Test!'));
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
            //
        ];
    }
}
