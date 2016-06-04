<?php

// CacheService.php - handles communication with last.fm
// By Anton Van Eechaute

namespace Devine\ApiBundle\Services;

class CacheService extends \Devine\Framework\Service
{

    /**
     * @param $url
     * @param $filename
     * @param $location
     * @return boolean whether or not the caching was successful
     */
    public function cacheImage($url, $filename, $location)
    {
        $img = file_get_contents($url);

        $f = @fopen($location . $filename, 'w');

        fwrite($f, $img);
        fclose($f);

        return $f;
    }
}
