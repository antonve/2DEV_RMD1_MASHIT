<?php

// Event.php
// By Anton Van Eechaute

namespace Ongaku\HomeBundle\Model;

class Event
{
    private $id;

    private $name;

    private $date;

    private $date_created;

    private $date_updated;

    private $location;

    private $bands;

    private $added = false;

    function __construct($id, $name, $date, $date_created, $date_updated, $location, $bands)
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->date_created = $date_created;
        $this->date_updated = $date_updated;
        $this->location = $location;
        $this->bands = $bands;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }

    public function getDateCreated()
    {
        return $this->date_created;
    }

    public function setDateUpdated($date_updated)
    {
        $this->date_updated = $date_updated;
    }

    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setBands($bands)
    {
        $this->bands = $bands;
    }

    public function getBands()
    {
        return $this->bands;
    }

    public function setAdded($added)
    {
        $this->added = $added;
    }

    public function getAdded()
    {
        return $this->added;
    }
}
