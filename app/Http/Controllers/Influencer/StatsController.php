<?php

namespace App\Http\Controllers\Influencer;

use App\Link;
use App\Order;
use App\User;
use Illuminate\Support\Facades\Redis;

class StatsController
{
    public function index()
    {
        $user = request()->user();
        $links = Link::where('user_id', $user->id)->get();

        return $links->map(function (Link $link) {
            $orders = Order::where('code', $link->code)
                ->where('complete', 1)
                ->get();

            return [
                'code' => $link->code,
                'count' => $orders->count(),
                'revenue' => $orders->sum(function (Order $order) {
                    return $order->influencer_total;
                }),
            ];
        });
    }

    public function rankings()
    {
        // retreive sorted set in desc order
        return Redis::zrevrange('rankings', 0, -1, 'WITHSCORES');
    }
}
