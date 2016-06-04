<?php

// UrlMatcher.php - Tries to match a Request in a RouteCollection
// By Anton Van Eechaute

namespace Devine\Framework;

use Devine\Framework\Request;
use Devine\Framework\RouteCollection;
use Devine\Framework\Route;

class UrlMatcher
{
    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * @var Request
     */
    private $request;

    /**
     * Initializes an UrlMatcher which can try to match a Request object against a RouteCollection
     * @param RouteCollection $routes
     * @param Request $request
     */
    public function __construct(RouteCollection $routes, Request $request)
    {
        $this->routes = $routes;
        $this->request = $request;
    }

    public function match()
    {
        $requestPath = $this->request->getPath();

        foreach($this->routes->getRoutes() as $route) {
            if (true === $this->matchPath($requestPath, $route->getRoute())) {
                return $route;
            }
        }

        throw new PageNotFoundException();
    }

    private function matchPath($path, $route)
    {
        // turn path and route into an array of segments
        $routeSegments = explode('/', trim($route, '/'));
        $pathSegments = explode('/', trim($path, '/'));
        $count = count($routeSegments);

        // compare if length of both are the same, if different there is no need to check any further
        if ($count === count($pathSegments)) {
            // loop all segments and compare them, returns true if they all match
            foreach($routeSegments as $key=>$segment) {
                $char = substr($segment, 0, 1);

                // check if segment is valid
                if (($char === '$' && strlen($pathSegments[$key]) > 0) // check if it's a string variable and at least 1 character long
                        || ('%' === $char && is_numeric($pathSegments[$key])) // check if it's a numeric variable
                        || $segment === $pathSegments[$key]){

                    if ($key === $count - 1) {
                        return true;
                    } else {
                        continue;
                    }
                }

                break;
            }
        }

        return false;
    }
}
