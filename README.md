# PHP Cache
A super simple PHP caching layer.

# Installation
`composer require b3none/php-cache`

# Example
The following is an extract from the [example.php](https://github.com/b3none/php-cache/blob/master/example.php)

```php
$cacheClient = new \B3none\Cache\CacheClient();

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
```
