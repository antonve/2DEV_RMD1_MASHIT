<?php

// UsersRepository.php -
// By Anton Van Eechaute

namespace Ongaku\HomeBundle\Repository;

use Devine\Framework\SingletonPDO;
use Ongaku\HomeBundle\Model\Event;

class EventRepository
{
    /**
     * @var PDO ¬†
     */
    private $dbh;

    public function __construct()
    {
        $this->dbh = SingletonPDO::getInstance();
    }

    public function getEvent($id)
    {
        $stmt = $this->dbh->prepare("SELECT
                                        events.*, event_artists.artist_name
                                     FROM
                                        events
                                     LEFT JOIN
                                        event_artists ON (events.id = event_artists.event_id)
                                     WHERE
                                        events.id = :id");
        $stmt->execute(array('id' => $id));
        $data = $stmt->fetchAll();

        if ($stmt->rowCount() > 0) {
            $bands = array();
            foreach ($data as $band) {
                $bands[] = $band['artist_name'];
            }
            return new Event($data[0]['id'], $data[0]['name'], $data[0]['date'], $data[0]['date_created'], $data[0]['date_updated'], $data[0]['location'], $bands);
        }

        throw new \Exception('Event with id \'' . $id . '\' wasn\'t found.');
    }

    public function getDetailedUserEvents($user_id)
    {
        $stmt = $this->dbh->prepare("SELECT
                                        events.*
                                     FROM
                                        events
                                     INNER JOIN
                                        user_events ON (events.id = user_events.event_id)
                                     WHERE
                                        user_events.user_id = :id");
        $stmt->execute(array('id' => $user_id));
        $data = $stmt->fetchAll();

        $events = array();

        foreach ($data as $data) {
            $events[] = new Event($data['id'], $data['name'], $data['date'], $data['date_created'], $data['date_updated'], $data['location'], array());
        }

        return $events;
    }

    public function getUserEvents($user_id)
    {
        $stmt = $this->dbh->prepare("SELECT
                                        *
                                     FROM
                                        user_events
                                     WHERE
                                        user_id = :id");
        $stmt->execute(array('id' => $user_id));
        $data = $stmt->fetchAll();

        $eids = array();

        if ($stmt->rowCount() > 0) {
            foreach ($data as $events) {
                $eids[] = $events['event_id'];
            }
        }

        return $eids;
    }

    public function saveEvent(Event $event)
    {
        $stmt = $this->dbh->prepare("INSERT INTO events (id,`name`,date,date_created,date_updated,location)
                                     VALUES (:id,:name,:date, NOW(),NOW(), :location)");

        $data = array('name' => $event->getName(),
            'id' => $event->getId(),
            'date' => $event->getDate(),
            'location' => $event->getLocation());

        $stmt->execute($data);

        if (1 === $stmt->rowCount()) {
            $event->setId($this->dbh->lastInsertId());

            $stmt = $this->dbh->prepare("INSERT INTO event_artists (event_id,artist_name)
                                         VALUES (:event_id, :name)");

            if (is_array($event->getBands())) {
                foreach ($event->getBands() as $band) {
                    $stmt->execute(array('name' => $band,
                        'event_id' => $event->getId()));
                    if (1 !== $stmt->rowCount()) {
                        throw new \Exception('Couldn\'t save Event Artist to database.');
                    }
                }
            }

            return true;
        }

        throw new \Exception('Couldn\'t save Event to database');
    }

    public function addUserEvent($event_id, $user_id)
    {
        $stmt = $this->dbh->prepare("INSERT INTO user_events (event_id,user_id)
                                     VALUES (:eid,:uid)");

        $data = array('eid' => $event_id,
            'uid' => $user_id);

        $stmt->execute($data);

        if (1 === $stmt->rowCount()) {
            return true;
        }

        throw new \Exception('Couldn\'t save User Event to database');
    }

    public function removeUserEvent($event_id, $user_id)
    {
        $stmt = $this->dbh->prepare("DELETE FROM user_events
                                     WHERE (event_id = :eid AND user_id = :uid)");

        $data = array('eid' => $event_id,
            'uid' => $user_id);

        $stmt->execute($data);

        if (1 === $stmt->rowCount()) {
            return true;
        }

        throw new \Exception('Couldn\'t delete User Event to database');
    }

}
