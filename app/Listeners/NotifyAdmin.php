<?php

namespace App\Listeners;

use App\Events\OrderCompleted;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class NotifyAdmin
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCompleted $event)
    {
        Mail::send('emails.admin.admin', ['order' => $event->order], function (Message $message) {
            $message->to('admin@admin.com');
            $message->subject('A new Order has been completed!');
        });
    }
}
