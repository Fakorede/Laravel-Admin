<?php

namespace App\Providers;

use App\Events\AdminAdded;
use App\Events\OrderCompleted;
use App\Events\ProductUpdated;
use App\Listeners\NotifyAddedAdmin;
use App\Listeners\NotifyAdmin;
use App\Listeners\NotifyInfluencer;
use App\Listeners\ProductCacheFlush;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCompleted::class => [
            NotifyAdmin::class,
            NotifyInfluencer::class,
        ],
        AdminAdded::class => [
            NotifyAddedAdmin::class,
        ],
        ProductUpdated::class => [
            ProductCacheFlush::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
