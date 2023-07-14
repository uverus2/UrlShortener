<?php

namespace App\UtilityTraits;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

trait GeneralTrait
{
    public function verifyUrlIsFound($decodedUrl)
    {
        if(empty($decodedUrl)){
            throw new RuntimeException('We could not find a URL to decode', Response::HTTP_NOT_FOUND);
        }
    }
}
