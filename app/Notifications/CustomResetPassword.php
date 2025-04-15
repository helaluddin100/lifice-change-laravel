<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends Notification
{
    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = config('app.frontend_url') . '/password-reset/' . $this->token . '?email=' . urlencode($this->email);

        return (new MailMessage)
            ->subject('Reset Your BuyTiq Password')
            ->markdown('emails.reset-password', ['url' => $url]);
    }

}
