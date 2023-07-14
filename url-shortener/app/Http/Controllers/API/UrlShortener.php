<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\UrlHandler\UrlHandlerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UrlShortener extends Controller
{
    protected $handler;
    public function __construct(UrlHandlerService $urlHandlerService)
    {
        $this->handler = $urlHandlerService;
    }

    /**
     * @param Request $request
     * @param UrlHandlerService $handler
     * @return JsonResponse
     * @throws ValidationException
     */
    public function encodeUrl(Request $request)
    {
       $this->validate($request, [
           'url' => 'required|url',
       ]);

        try{
           return response()->json(
               $this->handler->encode($request->input('url')),
               Response::HTTP_OK
           );

        }catch(Exception $e){

        }
    }


    public function decodeBySpecificUrl(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url',
        ]);

        try{
            $decodeUrl = $this->handler->decode($request->input('url'));
            return response()->json([
                'original_url' => $decodeUrl['original_url']
            ], Response::HTTP_OK);
        }catch(Exception $e){

        }
    }

    public function decodeBySpecificUrlCode($urlCode)
    {
        try{
            $decodeUrl = $this->handler->decodeByCode($urlCode);
            return response()->json([
                'original_url' => $decodeUrl['original_url']
            ], Response::HTTP_OK);
        }catch(Exception $e){

        }
    }

    public function redirectToUrl(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url',
        ]);

        try{
            $decodeUrl = $this->handler->decode($request->input('url'));
            return redirect()->away($decodeUrl['original_url']);
        }catch(Exception $e){

        }
    }
}
