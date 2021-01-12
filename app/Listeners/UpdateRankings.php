<?php

namespace App\Listeners;

use App\Events\OrderCompleted;
use App\User;
use Illuminate\Support\Facades\Redis;

class UpdateRankings
{
    public function handle(OrderCompleted $event)
    {
        $order = $event->order;

        $revenue = $order->influencer_total;

        $user = User::find($order->user_id);

        Redis::zincrby('rankings', $revenue, $user->full_name);
    }
}
