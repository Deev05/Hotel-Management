<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('bottominfo', ['namespace' => 'App\Modules\Bottominfo\Controllers'], function ($routes) {
    $routes->add('/', 'Bottominfo::index');
    $routes->add('create', 'Bottominfo::create');
    $routes->add('create/(:any)', 'Bottominfo::create/$1');
    $routes->add('delete/(:any)', 'Bottominfo::delete/$1');
    $routes->add('change_status/(:any)', 'Bottominfo::change_status/$1');
    $routes->add('get_bottominfo', 'Bottominfo::get_bottominfo');
    $routes->add('add_bottominfo', 'Bottominfo::add_bottominfo');
    $routes->add('update_bottominfo', 'Bottominfo::update_bottominfo');
});