<?php

namespace App\Listeners;

use App\Events\OrderCompleted;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class NotifyInfluencer
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCompleted $event)
    {
        $order = $event->order;

        Mail::send('emails.influencer.influencer', ['order' => $order], function (Message $message) use ($order) {
            $message->to($order->influencer_email);
            $message->subject('A new Order has been completed!');
        });
    }
}
