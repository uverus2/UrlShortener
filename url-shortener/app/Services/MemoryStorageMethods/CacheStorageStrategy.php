<?php

namespace App\Services\MemoryStorageMethods;

use Illuminate\Support\Facades\Cache;

class CacheStorageStrategy implements StorageStrategyContract
{
    /**
     * @param array $data
     * @param string $keyName
     * @return void
     */
    public function storeData(array $data, string $keyName): void
    {
        Cache::put($keyName, $data);
    }

    /**
     * @param string $key
     * @return array|mixed
     */
    public function retrieveData(string $key): mixed
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        return [];
    }
}
