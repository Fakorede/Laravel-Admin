<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function orderItems()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function getAdminTotalAttribute()
    {
        return $this->orderItems->sum(function (OrderItem $item) {
            return $item->admin_revenue;
        });
    }

    public function getInfluencerTotalAttribute()
    {
        return $this->orderItems->sum(function (OrderItem $item) {
            return $item->influencer_revenue;
        });
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
