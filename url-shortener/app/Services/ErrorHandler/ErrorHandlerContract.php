<?php

namespace App\Services\ErrorHandler;

use Exception;
use Illuminate\Http\JsonResponse;

interface ErrorHandlerContract
{
    public function handleException(Exception $error): JsonResponse;
}
