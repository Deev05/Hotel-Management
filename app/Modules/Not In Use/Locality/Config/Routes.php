<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('locality', ['namespace' => 'App\Modules\Locality\Controllers'], function ($routes) {
    $routes->add('/', 'Locality::index');
    $routes->add('create', 'Locality::create');
    $routes->add('create/(:any)', 'Locality::create/$1');
    $routes->add('delete/(:any)', 'Locality::delete/$1');
    $routes->add('change_status/(:any)', 'Locality::change_status/$1');
    $routes->add('get_locality', 'Locality::get_locality');
    $routes->add('add_locality', 'Locality::add_locality');
    $routes->add('update_locality', 'Locality::update_locality');
    $routes->add('get_pincodes', 'Locality::get_pincodes');
    $routes->add('get_area', 'Locality::get_area');
});