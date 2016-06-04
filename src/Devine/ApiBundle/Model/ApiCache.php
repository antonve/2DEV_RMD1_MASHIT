<?php

// ApiCache.php -
// By Anton Van Eechaute

namespace Devine\ApiBundle\Model;

class ApiCache
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var null
     */
    private $created;

    /**
     * @param $key
     * @param $data
     * @param null $created
     */
    function __construct($key, $data, $created = null)
    {
        $this->key = $key;
        $this->data = $data;
        $this->created = $created;
    }

    /**
     * @param $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return null
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }


}
