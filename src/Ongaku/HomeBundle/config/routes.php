<?php

// routes.php - Routes configuration for the User module
// By Anton Van Eechaute

use Devine\Framework\RouteCollection;
use Devine\Framework\Route;

$routes = new RouteCollection();
$routes->addRoute(new Route('home', '/', 'Ongaku\HomeBundle\Controller\AppController::indexAction'));
$routes->addRoute(new Route('search', '/search', 'Ongaku\HomeBundle\Controller\AppController::searchAction'));
$routes->addRoute(new Route('searchResult', '/search/$query', 'Ongaku\HomeBundle\Controller\AppController::searchResultAction'));
$routes->addRoute(new Route('artist', '/artist/$name', 'Ongaku\HomeBundle\Controller\AppController::artistAction'));
$routes->addRoute(new Route('artistImage', '/artist/image/$name', 'Ongaku\HomeBundle\Controller\AppController::imageAction'));
$routes->addRoute(new Route('artistDetatil', '/artist/$name/full', 'Ongaku\HomeBundle\Controller\AppController::artistFullAction'));
$routes->addRoute(new Route('addEvent', '/concert/add/%id/$name', 'Ongaku\HomeBundle\Controller\AppController::addEventAction'));
$routes->addRoute(new Route('removeEvent', '/concert/remove/%id/$name', 'Ongaku\HomeBundle\Controller\AppController::removeEventAction'));
$routes->addRoute(new Route('event', '/concert/%id/$name', 'Ongaku\HomeBundle\Controller\AppController::eventAction'));
$routes->addRoute(new Route('events', '/concerts', 'Ongaku\HomeBundle\Controller\AppController::eventsAction'));

return $routes;
