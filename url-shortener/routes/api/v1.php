<?php

use App\Http\Controllers\API\UrlShortener;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'url'], static function (){
    Route::post('/encode', [UrlShortener::class, 'encodeUrl']);

    Route::group(['prefix' => 'decode'], static function(){
        Route::get('/{urlCode}', [UrlShortener::class, 'decodeSpecificUrl']);
        Route::get('last', [UrlShortener::class, 'decodeLastCachedUrl']);
        Route::get('redirect/{urlCode}', [UrlShortener::class, 'redirectToLastUrl']);
    });
});
