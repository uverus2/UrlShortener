<?php

namespace App\Services\MemoryStorageMethods;

interface StorageStrategyContract
{
    public function storeData(array $data, string $keyName): void;
    public function retrieveData(string $key): mixed;
}
