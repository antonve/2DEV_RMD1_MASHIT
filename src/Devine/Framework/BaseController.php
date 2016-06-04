<?php

// BaseController.php - A set of functions available for every controller
// By Anton Van Eechaute

namespace Devine\Framework;

use Devine\Framework\Request;

class BaseController extends Injectable
{
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
     * Initializes a controller
     * @param Request $request
     * @param Array $parameters
     */
    public function __construct(Request $request, Array $parameters, Response $response)
    {
        $this->request = $request;
        $this->parameters = $parameters;
        $this->response = $response;
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->request;
    }

    /**
     * Add a variable that should be passed on to the template
     * @param type $key
     * @param type $value  
     */
    protected function add($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * @param string $parameter
     * @param mixed $default
     * @return mixed
     */
    protected function get($parameter, $default = null)
    {
        return array_key_exists($parameter, $this->parameters) ? $this->parameters[$parameter] : $default;
    }

    /**
     * Forwards an error 404 page not found
     * @throws PageNotFoundException  
     */
    protected function forward404()
    {
        throw new PageNotFoundException();
    }

    /**
     * Redirect page to the given url
     * @param string $url  
     * @param boolean $prefix
     */
    protected function redirect($url, $prefix = false)
    {
        header ("Location: " . ((false !== $prefix) ? $prefix : $this->request->getRoot()) . $url);
        exit();
    }

    /**
     * Proxy method to set the mode (json or html)
     * @param type $mode  
     */
    public function setMode($mode)
    {
        $this->response->setMode($mode);
    }

    /**
     * Proxy method to set the content
     * @param type $content  
     */
    public function setContent($content)
    {
        $this->response->setContent($content);
    }

    /**
     * Proxy method to set the status code
     * @param type $statusCode  
     */
    public function setStatusCode($statusCode)
    {
        $this->response->setStatusCode($statusCode);
    }

    /**
     * Proxy method to set the template
     * @param string $template  
     */
    public function setTemplate($template)
    {
        $this->response->setTemplate($template);
    }

    /**
     * Proxy method to get the smarty object
     * @return Smarty  
     */
    public function getSmarty()
    {
        return $this->response->getSmarty();
    }

    public function getParameters()
    {
        return $this->parameters;
    }
}
