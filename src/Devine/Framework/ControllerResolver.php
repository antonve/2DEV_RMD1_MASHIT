<?php

// ControllerResolver.php - Extracts parameters from URL & executes controller
// By Anton Van Eechaute

namespace Devine\Framework;

class ControllerResolver
{
    /**
     * @var Route
     */
    private $route;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var Response
     */
    private $response;

    /**
     * Initializes a ControllerResolver, it can extract parameters from URL and execute the linked controller
     * @param Route $route
     * @param Request $request
     */
    public function __construct(Route $route, Request &$request, \Smarty $smarty)
    {
        $this->route = $route;
        $this->request = $request;
        $this->response = new Response($smarty);
    }

    /**
     * Executes the linked controller
     * @return Smarty  
     */
    public function resolve($services)
    {
        $this->buildParameters();
        //print_r($this->parameters);

        $controllerInfo = explode('::', $this->route->getController());

        $controller = new $controllerInfo[0]($this->request, $this->parameters, $this->response);
        $controller->register($services);
        $controller->$controllerInfo[1]();
        $this->response->setData($controller->getParameters());

        return $this->response;
    }

    /**
     * Extracts the parameters from the path and adds them to $this->parameters array
     * @return boolean
     * @throws \Exception  
     */
    private function buildParameters()
    {
        $this->parameters = array();

        // turn path and route into an array of segments
        $routeSegments = explode('/', trim($this->route->getRoute(), '/'));
        $pathSegments = explode('/', trim($this->request->getPath(), '/'));
        $count = count($routeSegments);

        // compare if length of both are the same, if different then the pairing is incorrect
        if ($count !== count($pathSegments)) {
            Throw new \Exception('Route and Request don\'t match');
        }
        // loop all segments and compare them, assign the variables
        foreach($routeSegments as $key=>$segment) {
            $char = substr($segment, 0, 1);

            // check if segment is valid
            if (($char === '$' && strlen($pathSegments[$key]) > 0) // check if it's a string variable and at least 1 character long
                || ('%' === $char && is_numeric($pathSegments[$key])) // check if it's a numeric variable
                || $segment === $pathSegments[$key]){

                if ($segment !== $pathSegments[$key]) {
                    $this->parameters[substr($segment, 1, strlen($segment))] = $pathSegments[$key];
                }

                if ($key === $count - 1) {
                    return true;
                } else {
                    continue;
                }
            }

            Throw new \Exception('Route and Request don\'t match');
        }
    }

}
