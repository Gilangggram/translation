<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\OrderItem;
use App\Models\Stall;
use App\Observers\MenuObserver;
use App\Observers\OrderItemObserver;
use App\Observers\StallObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        OrderItem::observe(OrderItemObserver::class);
        Menu::observe(MenuObserver::class);
        Stall::observe(StallObserver::class);
    }
}
