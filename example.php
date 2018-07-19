<?php

include('vendor/autoload.php');

// We can choose to specify the cache dir in the constructor.
$cacheClient = new \B3none\Cache\CacheClient('/tmp/B3none/cache');

$cacheId = "b3none";
if ($cacheClient->hasCache($cacheId) && $cacheClient->isFreshEnough($cacheId, 5)) {
    $cache = $cacheClient->getCache($cacheId);
    print_r($cache);
} else {
    $dataToCache = [
        'b3none' => [
            'github' => 'https://github.com/b3none',
            'steam' => 'https://steamcommunity.com/b3none'
        ]
    ];
    $cacheClient->setCache($cacheId, $dataToCache);
}