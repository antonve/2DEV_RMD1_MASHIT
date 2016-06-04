<?php

// LastFMService.php - handles communication with last.fm
// By Anton Van Eechaute

namespace Ongaku\LastFMBundle\Services;

use Devine\ApiBundle\Model\ApiCache;
use Devine\ApiBundle\Repository\ApiRepository;

class LastFMService extends \Devine\Framework\Service
{

    public function isUsernameValid($username)
    {
        $data = $this->fetch(array('method' => 'user.getInfo', 'user' => $username));

        if (isset($data['error']) && $data['error'] == 6) {
            return false; // user doesn't exist on last.fm
        }

        return true;
    }

    public function search($query)
    {
        return $this->fetch(array('method' => 'artist.search', 'artist' => $query));
    }

    public function getEvent($id)
    {
        return $this->fetch(array('method' => 'event.getInfo', 'event' => $id));
    }

    public function getArtist($artist)
    {
        return $this->fetch(array('method' => 'artist.getInfo', 'artist' => $artist));
    }

    public function getEvents($artist)
    {
        return $this->fetch(array('method' => 'artist.getEvents', 'artist' => $artist));
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
            $row = new ApiCache($this->config['api_cache_prefix'] . $key, $data);
            $rep->saveRow($row);
        }

        if ('json' === $this->config['format']) {
            $data = json_decode($data, true);
        }

        return ($data);
    }
}
