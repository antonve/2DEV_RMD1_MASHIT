<?php

// Collection.php - Object that manages a collection
// By Anton Van Eechaute

namespace Devine\Framework;

class Collection
{
    /**
     * @var Array
     */
    private $collection;

    /**
     * Initializer
     */
    public function __construct()
    {
        $this->collection = array();
    }

    /**
     * Merge two collections into one
     * @param Collection $collection
     */
    public function addCollection(Collection $collection)
    {
        $this->collection = array_merge($this->collection, $collection->getCollection());
    }

    /**
     * Merge two collections into one
     * @param Collection $collection
     */
    public function addArray($array)
    {
        $this->collection = array_merge($this->collection, $array);
    }

    /**
     * Add item to the collection
     * @param mixed $route
     */
    public function addItem($key, $val)
    {
        $this->collection[$key] = $val;
    }

    /**
     * @return Array
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Check if the collection is empty
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->collection);
    }
}
