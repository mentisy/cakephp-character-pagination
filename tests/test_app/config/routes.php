<?php
/**
 * Routes configuration.
 *
 * @var \Cake\Routing\RouteBuilder $routes
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {
    $builder->fallBacks();
});
