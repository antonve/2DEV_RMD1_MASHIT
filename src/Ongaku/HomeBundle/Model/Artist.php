<?php

// Artist.php
// By Anton Van Eechaute

namespace Ongaku\HomeBundle\Model;

class Artist
{
    private $id;

    private $name;

    private $summary;

    private $bio;

    private $listeners;

    private $yearformed;

    private $placeformed;

    function __construct($id, $name, $summary, $bio, $listeners, $yearformed, $placeformed)
    {
        $this->id = $id;
        $this->name = $name;
        $this->summary = $summary;
        $this->bio = $bio;
        $this->listeners = $listeners;
        $this->yearformed = $yearformed;
        $this->placeformed = $placeformed;
    }

    public function setBio($bio)
    {
        $this->bio = $bio;
    }

    public function getBio()
    {
        return $this->bio;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setListeners($listeners)
    {
        $this->listeners = $listeners;
    }

    public function getListeners()
    {
        return $this->listeners;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPlaceformed($placeformed)
    {
        $this->placeformed = $placeformed;
    }

    public function getPlaceformed()
    {
        return $this->placeformed;
    }

    public function setSummary($summary)
    {
        $this->summary = $summary;
    }

    public function getSummary()
    {
        return $this->summary;
    }

    public function setYearformed($yearformed)
    {
        $this->yearformed = $yearformed;
    }

    public function getYearformed()
    {
        return $this->yearformed;
    }
}
