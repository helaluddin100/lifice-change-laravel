<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;

class OrderConfirmationMail extends Mailable implements ShouldQueue  // ৩. ইন্টারফেস ইমপ্লিমেন্ট করুন
{
    use Queueable, SerializesModels;  // ৪. Queueable ট্রেইট ইউজ করুন

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Congratulations! New Order Received')
            ->view('emails.order_confirmation');
    }
}
