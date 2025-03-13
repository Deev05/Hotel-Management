<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('paylater', ['namespace' => 'App\Modules\Paylater\Controllers'], function ($routes) {
    $routes->add('/', 'Paylater::index');
    $routes->add('change_status/(:any)', 'Paylater::change_status/$1');
    $routes->add('get_paylater_history', 'Paylater::get_paylater_history');
});