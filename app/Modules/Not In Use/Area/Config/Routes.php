<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('area', ['namespace' => 'App\Modules\Area\Controllers'], function ($routes) {
    $routes->add('/', 'Area::index');
    $routes->add('create', 'Area::create');
    $routes->add('create/(:any)', 'Area::create/$1');
    $routes->add('delete/(:any)', 'Area::delete/$1');
    $routes->add('change_status/(:any)', 'Area::change_status/$1');
    $routes->add('get_area', 'Area::get_area');
    $routes->add('add_area', 'Area::add_area');
    $routes->add('update_area', 'Area::update_area');
    $routes->add('get_pincodes', 'Area::get_pincodes');
});