<?php

use App\Http\Controllers\API\UrlShortenerController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'url'], static function (){
    Route::post('/encode', [UrlShortenerController::class, 'encodeUrl']);

    Route::group(['prefix' => 'decode'], static function(){
        Route::get('/code/{urlCode}', [UrlShortenerController::class, 'decodeBySpecificUrlCode']);

        Route::post('/', [UrlShortenerController::class, 'decodeBySpecificUrl']);
        Route::post('redirect', [UrlShortenerController::class, 'redirectToUrl']);
    });
});
