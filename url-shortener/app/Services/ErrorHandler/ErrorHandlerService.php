<?php

namespace App\Services\ErrorHandler;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorHandlerService
{
    /**
     * @param Exception $error
     * @return JsonResponse
     */
    public function handleException(Exception $error): JsonResponse
    {
        $errorMessage = $error->getMessage() ?? Response::$statusTexts['500'];

        $errorCode = $error->getCode();
        $errorStatus = $errorCode && $errorCode < 500 && $errorCode >= 400 ?
            $errorCode :
            Response::HTTP_INTERNAL_SERVER_ERROR;

        return response()->json(['error' => $errorMessage], $errorStatus);
    }
}
