<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UrlShortenerRequest;
use App\Services\ErrorHandler\ErrorHandlerService;
use App\Services\UrlHandler\UrlHandlerService;
use App\UtilityTraits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class UrlShortener extends Controller
{
    use GeneralTrait;

    protected UrlHandlerService $handler;
    protected ErrorHandlerService $errorHandler;

    public function __construct(UrlHandlerService $urlHandlerService, ErrorHandlerService $errorHandler)
    {
        $this->handler = $urlHandlerService;
        $this->errorHandler = $errorHandler;
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
           return $this->errorHandler->handleException($e);
        }
    }

    /**
     * @param UrlShortenerRequest $request
     * @return JsonResponse
     */
    public function decodeBySpecificUrl(UrlShortenerRequest $request): JsonResponse
    {
        try{
            $decodedUrl = $this->handler->decode($request->input('url'));
            $this->verifyUrlIsFound($decodedUrl);

            return response()->json([
                'original_url' => $decodedUrl['original_url']
            ], Response::HTTP_OK);
        }catch(Exception $e){
           return $this->errorHandler->handleException($e);
        }
    }

    /**
     * @param $urlCode
     * @return JsonResponse
     */
    public function decodeBySpecificUrlCode($urlCode): JsonResponse
    {
        try{
            $decodedUrl = $this->handler->decodeByCode($urlCode);
            $this->verifyUrlIsFound($decodedUrl);

            return response()->json([
                'original_url' => $decodedUrl['original_url']
            ], Response::HTTP_OK);
        }catch(Exception $e){
            return $this->errorHandler->handleException($e);
        }
    }

    /**
     * @param UrlShortenerRequest $request
     * @return RedirectResponse|JsonResponse
     */
    public function redirectToUrl(UrlShortenerRequest $request): JsonResponse|RedirectResponse
    {
        try{
            $decodedUrl = $this->handler->decode($request->input('url'));
            $this->verifyUrlIsFound($decodedUrl);

            return redirect()->away($decodedUrl['original_url']);
        }catch(Exception $e){
            return $this->errorHandler->handleException($e);
        }
    }
}
