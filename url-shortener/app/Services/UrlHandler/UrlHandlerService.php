<?php

namespace App\Services\UrlHandler;
use Illuminate\Support\Facades\Cache;

class UrlHandlerService
{
    protected UrlShortenStrategyContract $strategy;

    public function __construct(UrlShortenStrategyContract $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @param $encodedUrl
     * @return void
     */
    private function storeUrlInCache($encodedUrl): void
    {
        Cache::put($encodedUrl['unique_code'], $encodedUrl);
    }

    private function retrieveFromCache($code)
    {
        return Cache::get($code);
    }

    /**
     * @param string $url
     * @return array
     */
    public function encode(string $url): array
    {
      $encodedUrl = $this->strategy->encodeUrl($url);
      $this->storeUrlInCache($encodedUrl);

      return $encodedUrl;
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function decode(string $url): mixed
    {
        $decodeUrl = $this->strategy->decodeUrl($url);
        return $this->retrieveFromCache($decodeUrl['unique_code']);
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function decodeByCode(string $code): mixed
    {
        return $this->retrieveFromCache($code);
    }
}
