<?php

namespace B3none\Cache;

class CacheClient
{
    /**
     * @var string
     */
    protected $cacheDir = "/tmp/B3none/cache";

    public function __construct($cacheDir = null)
    {
        if ($cacheDir !== null) {
            $this->cacheDir = $cacheDir;
        }

        $this->setupCacheDirectory();
    }

    protected function setupCacheDirectory()
    {
        $directoriesToCreate = explode($this->cacheDir, "/");

        $directoryToCheck = "";

        foreach ($directoriesToCreate as $directory) {
            if (!is_dir($directoryToCheck .= "/{$directory}")) {
                mkdir($directoryToCheck);
            }
        }
    }

    /**
     * @param string $id
     * @param array $cacheValue
     */
    public function setCache(string $id, array $cacheValue) : void
    {
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir);
        }

        $cacheFile = $this->cacheDir . "/$id.json";
        if (file_exists($cacheFile)) {
            unlink($cacheFile);
        }

        $cacheValue['last-modified'] = time();

        $file = fopen($cacheFile, "w");
        fwrite($file, json_encode($cacheValue, JSON_PRETTY_PRINT));
        fclose($file);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function hasCache(string $id) : bool
    {
        $cacheFile = $this->cacheDir . "/$id.json";
        return file_exists($cacheFile);
    }

    /**
     * @param string $id
     * @param int $minutes
     * @return bool
     */
    public function isFreshEnough(string $id, int $minutes = 30) : bool
    {
        $cachedData = $this->getCache($id);

        if (!$cachedData) {
            return false;
        }

        $difference = $cachedData['last-modified'] - time();
        $difference = ($difference / 1000) / 60;

        return round($difference <= $minutes);
    }

    /**
     * @param string $id
     * @return array
     */
    public function getCache(string $id) : array
    {
        $cacheFile = $this->cacheDir . "/$id.json";
        return json_decode(file_get_contents($cacheFile), true);
    }
}