<?php

// Bundle.php - represents a module
// By Anton Van Eechaute

namespace Devine\Framework;

/**
 * Represents a bundle
 */
class Bundle
{
    /**
     * @var array
     */
    private $config   = array();

    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * @var array
     */
    private $services = array();


    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return Bundle
     */
    public function load()
    {
        if ($this->config['routes']) {
            $this->routes = include ($this->config['path'] . '/config/routes.php');
        }

        return $this;
    }

    /**
     * @param $module
     * @return bool
     */
    public function isValid($module)
    {
        if (array_key_exists('name', $module)
            && array_key_exists('services', $module)
            && array_key_exists('init', $module)
            && array_key_exists('routes', $module)
            && array_key_exists('smarty', $module)
            && array_key_exists('namespace', $module)) {
            return true;
        }

        return false;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @return bool
     */
    public function hasInit()
    {
        return $this->config['init'];
    }

    /**
     * @return bool
     */
    public function getServices()
    {
        return $this->config['services'];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->config['path'];
    }

    /**
     * @return bool
     */
    public function hasSmarty()
    {
        return $this->config['smarty'];
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->config['namespace'];
    }
}
