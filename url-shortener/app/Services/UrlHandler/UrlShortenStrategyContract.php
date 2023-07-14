<?php

namespace App\Services\UrlHandler;

interface UrlShortenStrategyContract
{
    public function encodeUrl(string $url): array;

    public function decodeUrl(string $url): array;
}
