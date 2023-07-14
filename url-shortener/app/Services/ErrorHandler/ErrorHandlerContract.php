<?php

namespace App\Services\ErrorHandler;

use Exception;

interface ErrorHandlerContract
{
    public function handleException(Exception $error);
}
