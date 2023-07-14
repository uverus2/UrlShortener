<?php

use App\Http\Controllers\API\UrlShortener;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'url'], static function (){
    Route::post('/encode', [UrlShortener::class, 'encodeUrl']);

    Route::group(['prefix' => 'decode'], static function(){
        Route::get('/code/{urlCode}', [UrlShortener::class, 'decodeBySpecificUrlCode']);

        Route::post('/', [UrlShortener::class, 'decodeBySpecificUrl']);
        Route::post('redirect', [UrlShortener::class, 'redirectToUrl']);
    });
});
