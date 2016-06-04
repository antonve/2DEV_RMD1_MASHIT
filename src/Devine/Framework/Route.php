<?php

// Route.php - Object that represents a route
// By Anton Van Eechaute

namespace Devine\Framework;

class Route
{
    /**
     * @var String
     */
    private $route;

    /**
     * @var String
     */
    private $name;

    /**
     * @var String
     */
    private $controller;

    /**
     * Route initializer
     * @param string $name
     * @param string $route
     * @param string $controller
     */
    public function __construct($name, $route, $controller)
    {
        $this->name = $name;
        $this->route = $route;
        $this->controller = $controller;
    }
    
    /**
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function getController()
    {
        return $this->controller;
    }
}
