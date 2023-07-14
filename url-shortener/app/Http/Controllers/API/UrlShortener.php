<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class UrlShortener extends Controller
{
    public function encodeUrl(Request $request)
    {
        $validate = $request->validate([
            'url' => 'required|string',
        ]);


        try{


        }catch(Exception $e){

        }
    }

    public function decodeSpecificUrl($urlCode)
    {
        try{

        }catch(Exception $e){

        }
    }

    public function decodeLastCachedUrl()
    {
        try{

        }catch(Exception $e){

        }
    }

    public function redirectToLastUrl($urlCode)
    {
        try{

        }catch(Exception $e){

        }
    }
}
