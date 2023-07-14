<?php

namespace App\Services\UrlHandler\HashShortUrlLibrary;

use App\Enums\UrlShortenerEnum;
use App\Services\UrlHandler\UrlShortenStrategyContract;

class HashShortUrlStrategy implements UrlShortenStrategyContract
{
    public function encodeUrl(string $url): array
    {
        $createUniqueCode = $this->generateUniqueCode($url);
        $shorterUrl = UrlShortenerEnum::SHORTER_URL_PREFIX;

        return [
            'original_url' => $url,
            'unique_code' => $createUniqueCode,
            'short_url' => $shorterUrl . $createUniqueCode
        ];
    }

    /**
     * @param $url
     * @return string
     */
    private function generateUniqueCode($url): string
    {
        $hashUrl = md5($url);
        return substr($hashUrl, 0, UrlShortenerEnum::URL_LENGHT_SEQUENCE);
    }

    public function decodeUrl(string $url): array
    {
        $parseUrl = parse_url($url);
        $uniqueCode = ltrim($parseUrl['path'], '/');

        return [
            'unique_code' => $uniqueCode
        ];
    }
}
