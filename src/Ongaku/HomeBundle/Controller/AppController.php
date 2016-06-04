<?php

// AppController.php - General controller
// By Anton Van Eechaute

namespace Ongaku\HomeBundle\Controller;

use Devine\Framework\BaseController;
use Ongaku\HomeBundle\Repository\ArtistRepository;
use Ongaku\HomeBundle\Repository\EventRepository;
use Ongaku\HomeBundle\Model\Artist;
use Ongaku\HomeBundle\Model\Event;

class AppController extends BaseController
{
    private $artist, $images, $events, $video;

    public function indexAction()
    {
        $this->setTemplate('index');
    }

    public function searchAction()
    {
        $request = $this->getRequest();

        if ($request->isPOST()) {
            $query = $request->getPOST('search_query');
            $this->redirect('/search/' . $query);
        } else {
            $this->setTemplate('index');
        }
    }

    public function searchResultAction()
    {
        // get results
        $lfm = $this->sget('lastfm');
        $results = $lfm->search($this->get('query'));
        //trace($results->results->artistmatches->artist);

        // pass to template
        $this->add("results", $results['results']['artistmatches']['artist']);
        $this->setTemplate('search_results');
    }

    public function artistAction()
    {
        $this->getArtistData();
        $user = $this->getRequest()->get('user');

        // assign if user has added this event
        if ($user) {
            $rep = new EventRepository();
            $user_events = $rep->getUserEvents($user->getId());
            if (array_key_exists('event', $this->events['events'])) {
                for ($i = 0; $i < count($this->events['events']['event']); $i++) {
                    if (in_array($this->events['events']['event'][$i]['id'], $user_events)) {
                        $this->events['events']['event'][$i]['added'] = true;
                    } else {
                        $this->events['events']['event'][$i]['added'] = false;
                    }
                }
            }
        }

        // pass to template
        $this->add("artist", $this->artist);
        $this->add("images", $this->images);
        $this->add("events", $this->events);
        $this->add("video", $this->video);
        $this->setTemplate('artist');
    }

    public function artistFullAction()
    {
        $this->getArtistData();

        // pass to template
        $this->add("artist", $this->artist);
        $this->setTemplate('artist_full');
    }

    public function imageAction()
    {
        if (!file_exists(PROJECT_DIR . 'app/cache/img_cache/' . md5($this->get('name')))) {
            $this->forward404();
        }

        header('Content-type: image/jpeg');

        echo file_get_contents(PROJECT_DIR . 'app/cache/img_cache/' . md5($this->get('name')));

        exit();
    }

    public function eventAction()
    {
        $event = $this->getRequestEvent();
        $user = $this->getRequest()->get('user');

        // assign if user has added this event
        if ($user) {
            $rep = new EventRepository();
            $user_events = $rep->getUserEvents($user->getId());
            if (in_array($event->getId(), $user_events)) {
                $event->setAdded(true);
            }
        }

        // pass to template
        $this->add("event", $event);
        $this->setTemplate('event');
    }

    public function addEventAction()
    {
        $rep = new EventRepository();
        $request = $this->getRequest();

        if (!$request->get('user')) {
            $this->forward404();
        }

        $event = $this->getRequestEvent();

        if ($rep->addUserEvent($event->getId(), $request->get('user')->getId())) {
            $this->redirect($request->getReferer(), '');
        }

        $this->forward404();
    }

    public function removeEventAction()
    {
        $rep = new EventRepository();
        $request = $this->getRequest();

        if (!$request->get('user')) {
            $this->forward404();
        }

        $event = $this->getRequestEvent();

        if ($rep->removeUserEvent($event->getId(), $request->get('user')->getId())) {
            if (AJAX) {
                $this->setContent(json_encode(array('true')));
                $this->setMode('json');
            } else {
                $this->redirect($request->getReferer(), '');
            }
        } else {
            $this->forward404();
        }
    }

    public function eventsAction()
    {
        // get results
        $rep = new EventRepository();
        $request = $this->getRequest();

        if (!$request->get('user')) {
            $this->forward404();
        }

        if (!$request->get('user')) {
            $this->forward404();
        }

        $events = $rep->getDetailedUserEvents($request->get('user')->getId());

        // pass to template
        $this->add("events", $events);
        $this->setTemplate('events');
    }

    private function getArtistData()
    {
        // get results
        $rep = new ArtistRepository();
        $lfm = $this->sget('lastfm');
        $yt = $this->sget('youtube');

        // watch live
        $this->video = $yt->search($this->get('name') . '+live');
        if (array_key_exists('entry', $this->video['feed'])) {
            $split = explode(':',$this->video['feed']['entry'][0]['id']['$t']);
            $this->video = $split[count($split) - 1];
        } else {
            $this->video = null;
        }

        // events
        $this->events = $lfm->getEvents($this->get('name'));

        try {
            $this->artist = $rep->getArtist($this->get('name'));
            $this->images = $rep->getImagesByArtist($this->artist->getId());
        } catch(\Exception $e) {
            // artist
            $results = $lfm->getArtist($this->get('name'));

            if (array_key_exists('error', $results)) {
                $this->forward404();
            }

            $this->artist = new Artist(
                0,
                $results['artist']['name'],
                array_key_exists('summary', $results['artist']['bio']) ? $results['artist']['bio']['summary'] : null,
                array_key_exists('content', $results['artist']['bio']) ? $results['artist']['bio']['content'] : null,
                $results['artist']['stats']['listeners'],
                array_key_exists('yearformed', $results['artist']['bio']) ? $results['artist']['bio']['yearformed'] : null,
                array_key_exists('placeformed', $results['artist']['bio']) ? $results['artist']['bio']['placeformed'] : null
            );

            $this->artist = $rep->saveArtist($this->artist);

            // images
            $flkr = $this->sget('flickr');
            $images = $flkr->search($this->get('name'));
            $this->images = array();

            if (count($images['photos']['photo']) > 0) {
                $this->images = $this->cacheImages($images);
            }
            $rep->saveArtistImages($this->images, $this->artist->getId());
        }
    }

    private function cacheImages($images)
    {
        $flkr = $this->sget('flickr');
        $cache = $this->sget('cache');
        $files = array();

        for ($i = 0; $i < 4; $i++) {
            $url = $flkr->buildUrl($images['photos']['photo'][$i]);
            $filename = $flkr->getFilename($images['photos']['photo'][$i]);
            $files[] = array('filename' => $filename);
            $cache->cacheImage($url, md5($filename), PROJECT_DIR . 'app/cache/img_cache/');
        }

        return $files;
    }

    private function getRequestEvent()
    {
        // get results
        $rep = new EventRepository();
        $lfm = $this->sget('lastfm');
        $request = $this->getRequest();

        try {
            $event = $rep->getEvent($this->get('id'));
        } catch (\Exception $e) {

            $event = $lfm->getEvent($this->get('id'));
            $d = \DateTime::createFromFormat('D, d M Y G:i:s', $event['event']['startDate'])->format('Y-m-d H:i:s');

            $event = new Event(
                $event['event']['id'],
                $event['event']['title'],
                $d,
                null,
                null,
                $event['event']['venue']['name'] . ' ' . $event['event']['venue']['location']['city'] . ', ' . $event['event']['venue']['location']['country'],
                $event['event']['artists']['artist']
            );

            $rep->saveEvent($event);
        }

        return $event;
    }
}
