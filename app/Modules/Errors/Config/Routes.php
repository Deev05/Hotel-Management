<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('errors', ['namespace' => 'App\Modules\Errors\Controllers'], function ($routes) {
    $routes->add('/', 'Errors::index');
    $routes->add('denied', 'Errors::denied');

}); 