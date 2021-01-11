<?php

namespace App\Listeners;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class NotifyAddedAdmin
{
    public function handle($event)
    {
        $user = $event->user;

        Mail::send('emails.admin.admin-added', [], function (Message $message) use ($user) {
            $message->to($user->email);
            $message->subject('You have been added to the Admin App');
        });
    }
}
