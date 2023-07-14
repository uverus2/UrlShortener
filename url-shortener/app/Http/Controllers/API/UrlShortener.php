<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UrlShortenerRequest;
use App\Services\UrlHandler\UrlHandlerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class UrlShortener extends Controller
{
    protected $handler;
    public function __construct(UrlHandlerService $urlHandlerService)
    {
        $this->handler = $urlHandlerService;
    }

    /**
     * @param UrlShortenerRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function encodeUrl(UrlShortenerRequest $request): JsonResponse
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

    /**
     * @param UrlShortenerRequest $request
     * @return JsonResponse|void
     */
    public function decodeBySpecificUrl(UrlShortenerRequest $request)
    {
        try{
            $decodeUrl = $this->handler->decode($request->input('url'));
            return response()->json([
                'original_url' => $decodeUrl['original_url']
            ], Response::HTTP_OK);
        }catch(Exception $e){

        }
    }

    /**
     * @param $urlCode
     * @return JsonResponse|void
     */
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

    /**
     * @param UrlShortenerRequest $request
     * @return RedirectResponse|void
     */
    public function redirectToUrl(UrlShortenerRequest $request)
    {
        try{
            $decodeUrl = $this->handler->decode($request->input('url'));
            return redirect()->away($decodeUrl['original_url']);
        }catch(Exception $e){

        }
    }
}
