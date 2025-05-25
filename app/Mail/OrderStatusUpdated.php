<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;   // এই ইন্টারফেস ইমপোর্ট আছে
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderStatusUpdated extends Mailable implements ShouldQueue  // এখানে implements ShouldQueue যোগ করুন
{
    use Queueable, SerializesModels;

    public $order;
    public $shop; // শপ ডেটা পাবলিক ভ্যারিয়েবল

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->shop = $order->shop;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Your Order Status Has Been Updated',
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.order_status_updated',
            with: [
                'order' => $this->order,
                'shop' => $this->shop,
            ],
        );
    }

    public function attachments()
    {
        return [];
    }
}
