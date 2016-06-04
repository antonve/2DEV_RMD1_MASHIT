<?php

// LastFMService.php - handles communication with last.fm
// By Anton Van Eechaute

namespace Ongaku\YoutubeBundle\Services;

use Devine\ApiBundle\Model\ApiCache;
use Devine\ApiBundle\Repository\ApiRepository;

class YoutubeService extends \Devine\Framework\Service
{
    public function search($query)
    {
        return $this->fetch('videos?', array('orderby' => 'relevance', 'q' => $query, 'max-results' => 1));
    }

    private function fetch($prefix, array $params)
    {
        $rep = new ApiRepository();
        $key = $prefix . http_build_query($params);

        try {
            // try to get the result from the cache
            $row = $rep->getRow($this->config['api_cache_prefix'] . $key);
            $data = $row->getData();
        }
        catch(\Exception $e) {
            // build url
            $params['v'] = 2;
            $params['alt'] = $this->config['format'];
            $url = $this->config['url'] . $prefix . http_build_query($params);

            // retrieve data
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $data = curl_exec($ch);
            curl_close($ch);

            // cache results
            $row = new ApiCache($this->config['api_cache_prefix'] . $key, $data);
            $rep->saveRow($row);
        }

        if ('json' === $this->config['format']) {
            $data = json_decode($data, true);
        }

        return ($data);
    }
}
