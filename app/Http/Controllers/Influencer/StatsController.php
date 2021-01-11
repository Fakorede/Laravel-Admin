<?php

namespace App\Http\Controllers\Influencer;

use App\Link;
use App\Order;
use App\User;

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
        $users = User::where('is_influencer', 1)->get();

        $rankings = $users->map(function (User $user) {
            return [
                'name' => $user->full_name,
                'revenue' => $user->revenue,
            ];
        });

        return $rankings->sortByDesc('revenue');
    }
}
