<?php

// Request.php - Very basic object that represents a request
// By Anton Van Eechaute

namespace Devine\Framework;

class Request
{
    /**
     * @var array
     */
    private $server;

    /**
     * @var array  
     */
    private $cookies;

    /**
     * @var array  
     */
    private $get;

    /**
     * @var array  
     */
    private $post;

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $session;

    /**
     * @var string  
     */
    private $root;

    /**
     * Creates new request from the globals
     */
    public function __construct()
    {
        $this->path = array_key_exists('PATH_INFO', $_SERVER) ? $_SERVER['PATH_INFO'] : '/';
        $this->session = $_SESSION;
        $this->server = $_SERVER;
        $this->cookies = $_COOKIE;
        $this->get = $_GET;
        $this->post = $_POST;
        $this->root = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME'];

        return $this;
    }

    function __destruct()
    {
        $_SESSION = $this->session;
    }

    /**
     * Get session value
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $key = 'ongaku_' . $key;
        return array_key_exists($key, $this->session) ? $this->session[$key] : $default;
    }

    /**
     * Set session value
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->session['ongaku_' . $key] = $value;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->server['REMOTE_ADDR'];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string  
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * get the submited POST value if it's set, otherwise return $default
     * @param string $key
     * @return mixed  
     */
    public function getPOST($key, $default = null)
    {
        return array_key_exists($key, $this->post) ? $this->post[$key] : $default;
    }

    /**
     * get the submited GET value if it's set, otherwise return $default
     * @param string $key
     * @return mixed  
     */
    public function getGET($key, $default = null)
    {
        return array_key_exists($key, $this->get) ? $this->get[$key] : $default;
    }

    /**
     * checks if it's a POST request
     * @return boolean  
     */
    public function isPOST()
    {
        return ('POST' === $this->server['REQUEST_METHOD']) ? true : false;
    }

    /**
     * checks if it's a GET request
     * @return boolean  
     */
    public function isGET()
    {
        return ('GET' === $this->server['REQUEST_METHOD']) ? true : false;
    }

    /**
     * @return array  
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Get cookie value
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getCookie($key, $default = null)
    {
        return array_key_exists($key, $this->cookies) ? $this->cookies[$key] : $default;
    }

    /**
     * Returns the full url of the current page
     * @return string  
     */
    public function getFullUrl()
    {
        return $this->root . $this->path;
    }

    /**
     * Returns the http referer
     * @return string  
     */
    public function getReferer()
    {
        return $this->server['HTTP_REFERER'];
    }
}
