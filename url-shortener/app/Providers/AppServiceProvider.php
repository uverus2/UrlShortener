<?php

namespace App\Providers;

use App\Services\MemoryStorageMethods\CacheStorageStrategy;
use App\Services\MemoryStorageMethods\StorageStrategyContract;
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

        $this->app->bind(StorageStrategyContract::class, CacheStorageStrategy::class);
//        $this->app->bind(UrlShortenStrategyContract::class, Another storage method implementation);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
