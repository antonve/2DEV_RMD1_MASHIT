<?php

// routes.php - Routes configuration for the User module
// By Anton Van Eechaute

use Devine\Framework\RouteCollection;
use Devine\Framework\Route;

$routes = new RouteCollection();
$routes->addRoute(new Route('login', '/user/login', 'Devine\UserBundle\Controller\UserController::loginAction'));
$routes->addRoute(new Route('register', '/user/register', 'Devine\UserBundle\Controller\UserController::registerAction'));
$routes->addRoute(new Route('logout', '/user/logout', 'Devine\UserBundle\Controller\UserController::logoutAction'));
//$routes->addRoute(new Route('profile', '/user/profile', 'Devine\UserBundle\Controller\UserController::profileAction'));
$routes->addRoute(new Route('reset', '/user/reset', 'Devine\UserBundle\Controller\UserController::resetAction'));

return $routes;