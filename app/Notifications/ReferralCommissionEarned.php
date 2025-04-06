<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReferralCommissionEarned extends Notification
{
    use Queueable;

    protected $referredUser;
    protected $commission;

    public function __construct($referredUser, $commission)
    {
        $this->referredUser = $referredUser;
        $this->commission = $commission;
    }

    public function via($notifiable)
    {
        return ['mail']; // Or ['mail', 'database'] if you use in-app notifications
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('You earned a commission!')
            ->greeting('Hi ' . $notifiable->name . '!')
            ->line("You have received a commission of ৳" . number_format($this->commission, 2) . " from referral: {$this->referredUser}.")
            ->line('Thank you for referring new users to our platform!');
    }
}
