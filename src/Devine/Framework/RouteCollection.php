<?php

// RouteCollection.php - Object that has a collection of various routes
// By Anton Van Eechaute

namespace Devine\Framework;
// TODO: Refactor so it extends from a normal collection
class RouteCollection
{
    /**
     * @var Array
     */
    private $routes;

    /**
     * Initializer
     */
    public function __construct()
    {
        $this->routes = array();
    }

    /**
     * Merge two collections into one
     * @param RouteCollection $collection
     */
    public function addCollection(RouteCollection $collection)
    {
        $this->routes = array_merge($this->routes, $collection->getRoutes());
    }

    /**
     * Add route to the collection
     * @param Route $route
     */
    public function addRoute(Route $route)
    {
        $this->routes[$route->getName()] = $route;
    }

    /**
     * @return Array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Get Route by name
     * @param string $routeName
     * @return boolean
     */
    public function getRouteByName($routeName)
    {
        foreach($this->routes as $route) {
            if ($route->getName() === $routeName) {
                return $route;
            }
        }

        return false;
    }

    /**
     * Check if the collection is empty
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->routes);
    }
}
