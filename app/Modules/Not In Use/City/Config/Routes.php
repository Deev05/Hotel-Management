<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('city', ['namespace' => 'App\Modules\City\Controllers'], function ($routes) {
    $routes->add('/', 'City::index');
    $routes->add('create', 'City::create');
    $routes->add('create/(:any)', 'City::create/$1');
    $routes->add('delete/(:any)', 'City::delete/$1');
    $routes->add('change_status/(:any)', 'City::change_status/$1');
    $routes->add('get_city', 'City::get_city');
    $routes->add('add_city', 'City::add_city');
    $routes->add('update_city', 'City::update_city');
});