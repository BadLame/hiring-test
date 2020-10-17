<?php

namespace App\Providers;

use App\Http\Controllers\BasketController;
use App\Models\Basket\ItemsBasket;
use App\Models\Basket\SessionBasket;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(BasketController::class)
            ->needs(ItemsBasket::class)
            ->give(function() { return new SessionBasket(); });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
