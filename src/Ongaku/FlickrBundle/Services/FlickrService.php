<?php

// LastFMService.php - handles communication with last.fm
// By Anton Van Eechaute

namespace Ongaku\FlickrBundle\Services;

use Devine\ApiBundle\Model\ApiCache;
use Devine\ApiBundle\Repository\ApiRepository;

class FlickrService extends \Devine\Framework\Service
{
    public function buildUrl($img)
    {
        if (is_array($img)
            && array_key_exists('farm', $img)
            && array_key_exists('server', $img)
            && array_key_exists('id', $img)
            && array_key_exists('secret', $img)) {
            return 'http://farm' . $img['farm'] . '.staticflickr.com/' . $img['server'] . '/' . $img['id'] . '_' . $img['secret'] . '.jpg';
        }

        throw new \Exception('Invalid Flickr image data.');
    }

    public function getFilename($img)
    {
        if (is_array($img)
            && array_key_exists('id', $img)
            && array_key_exists('secret', $img)) {
            return $img['id'] . '_' . $img['secret'] . '.jpg';
        }

        throw new \Exception('Invalid Flickr image data.');
    }

    public function search($query)
    {
        return $this->fetch(array('method' => 'flickr.photos.search', 'tags' => $query));
    }

    private function fetch(array $params)
    {
        $rep = new ApiRepository();
        $key = http_build_query($params);

        try {
            // try to get the result from the cache
            $row = $rep->getRow($this->config['api_cache_prefix'] . $key);
            $data = $row->getData();
        }
        catch(\Exception $e) {
            // build url
            $params['api_key'] = $this->config['api_key'];
            $params['format'] = $this->config['format'];
            $url = $this->config['url'] . http_build_query($params);

            // retrieve data
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            curl_close($ch);

            // cache results
            $row = new ApiCache($this->config['api_cache_prefix'] . $key, substr($data, 14, strlen($data)-15));
            $rep->saveRow($row);
            $data = $row->getData();
        }

        if ('json' === $this->config['format']) {
            $data = json_decode($data, true);
        }

        return ($data);
    }
}
