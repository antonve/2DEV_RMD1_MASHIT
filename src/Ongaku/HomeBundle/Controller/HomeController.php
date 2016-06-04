<?php

// HomeController.php - General controller
// By Anton Van Eechaute

namespace Ongaku\HomeBundle\Controller;

use Devine\Framework\BaseController;

class HomeController extends BaseController
{
    public function indexAction()
    {
        $this->setTemplate('index');
    }
}
