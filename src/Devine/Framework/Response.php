<?php

// Response.php - Very basic object that represents a response
// By Anton Van Eechaute

namespace Devine\Framework;

class Response
{
    /**
     * @var string
     */
    private $mode = 'html';

    /**
     * @var mixed
     */
    private $content;

    /**
     * @var integer
     */
    private $statusCode;

    /**
     * @var Smarty
     */
    private $smarty;

    /**
     * @var string 
     */
    private $layout;

    /**
     * @var array  
     */
    private $data;

    /**
     * @var array  
     */
    private $slots;

    /**
     * Array taken from symfony HttpFoundation component
     *
     * Status codes translation table.
     *
     * The list of codes is complete according to the
     * {@link http://www.iana.org/assignments/http-status-codes/ Hypertext Transfer Protocol (HTTP) Status Code Registry}
     * (last updated 2012-02-13).
     *
     * Unless otherwise noted, the status code is defined in RFC2616.
     *
     * @var array
     */
    private $statusTexts = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC-reschke-http-status-308-07
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        422 => 'Unprocessable Entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Reserved for WebDAV advanced collections expired proposal',   // RFC2817
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates (Experimental)',                      // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    );

    /**
     * Initializes a new Response with statusCode 200 and html mode
     * @param Smarty $smarty  
     * @param Request $request  
     */
    public function __construct($smarty = null)
    {
        $this->statusCode = 200;
        $this->smarty = $smarty;
        $this->data = array();
        $this->slots = array();
    }

    /**
     * Sends the response to the browser  
     */
    public function send($no_layout = false)
    {
        // send correct header to the browser
        header('HTTP/1.1 ' . $this->statusCode . ' ' . $this->statusTexts[$this->statusCode]);

        // show correct output according to the mode and if smarty is available
        if ('json' === $this->mode) {

            header('Content-type:  application/json');
            echo json_encode($this->content);

        } elseif(null === $this->smarty) {
            echo $this->content;

        } else {
            // assign all variables passed on from the controller
            foreach ($this->data as $key => $val) {
                $this->smarty->assign($key, $val);
            }
            if ($no_layout) {
                $this->smarty->display($this->slots['content'] . '.tpl');
            } else {
                foreach ($this->slots as $key => $slot) {
                    if (isset($slot)) {
                        $this->smarty->assign($key, $this->smarty->fetch($slot . '.tpl'));
                    }
                }
                $this->smarty->display($this->layout);
            }
        }
    }

    /**
     * @param string $mode  
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * @param mixed $content  
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param integer $statusCode  
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param string $template  
     */
    public function setTemplate($template)
    {
        $this->slots['content'] = $template;
    }

    /**
     * @return Smarty  
     */
    public function getSmarty()
    {
        return $this->smarty;
    }

    /**
     * @param string $layout  
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @param array $data  
     */
    public function setData($data)
    {
        $this->data = array_merge($this->data, $data);
    }

    /**
     * @param string $root  
     */
    public function setRoot($root)
    {
        $this->data['root'] = $root;
    }

    /**
     * @param string $rootDir  
     */
    public function setRootDir($rootDir)
    {
        $this->data['rootDir'] = $rootDir;
    }

    /**
     * @param string $dev  
     */
    public function setDevelopmentMode($dev)
    {
        $this->data['dev'] = $dev;
    }

    /**
     * Adds (or replaces if it already exists) a template slot
     * @param string $key
     * @param string $template  
     */
    public function addSlot($key, $template)
    {
        $this->slots[$key] = $template;
    }
}
