<?php

namespace App\Services\UrlHandler;
use App\Services\MemoryStorageMethods\StorageStrategyContract;

class UrlHandlerService
{
    protected UrlShortenStrategyContract $strategy;
    protected StorageStrategyContract $storage;

    public function __construct(UrlShortenStrategyContract $strategy, StorageStrategyContract $storage)
    {
        $this->strategy = $strategy;
        $this->storage = $storage;
    }

    /**
     * @param string $url
     * @return array
     */
    public function encode(string $url): array
    {
      $encodedUrl = $this->strategy->encodeUrl($url);
      $this->storage->storeData($encodedUrl, $encodedUrl['unique_code']);
      return $encodedUrl;
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function decode(string $url): mixed
    {
        $decodedUrl = $this->strategy->decodeUrl($url);
        return  $this->storage->retrieveData($decodedUrl['unique_code']);
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function decodeByCode(string $code): mixed
    {
        return $this->storage->retrieveData($code);
    }
}
