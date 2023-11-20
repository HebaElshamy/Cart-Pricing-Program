<?php

namespace App\Providers;

use App\Services\CartService;
use App\Services\TotalService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(CartService::class, function ($app) {
            $totalService = $app->make(TotalService::class);
            return new CartService($totalService);
        });

        $this->app->singleton(TotalService::class, function ($app) {
            return new TotalService();
        });
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
