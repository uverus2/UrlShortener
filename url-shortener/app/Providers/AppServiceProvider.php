<?php

namespace App\Providers;

use App\Services\UrlHandler\HashShortUrlLibrary\HashShortUrlStrategy;
use App\Services\UrlHandler\UrlShortenStrategyContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UrlShortenStrategyContract::class, HashShortUrlStrategy::class);
        //$this->app->bind(UrlShortenStrategyContract::class, Another implementation if it required to be changed);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
