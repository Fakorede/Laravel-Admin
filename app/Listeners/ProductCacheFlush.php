<?php

namespace App\Listeners;

class ProductCacheFlush
{
    public function handle($event)
    {
        \Cache::forget('products');
    }
}
