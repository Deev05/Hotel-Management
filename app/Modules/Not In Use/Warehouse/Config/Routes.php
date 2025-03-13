<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('warehouse', ['namespace' => 'App\Modules\Warehouse\Controllers'], function ($routes) {
    $routes->add('/', 'Warehouse::index');
    $routes->add('create', 'Warehouse::create');
    $routes->add('create/(:any)', 'Warehouse::create/$1');
    $routes->add('delete/(:any)', 'Warehouse::delete/$1');
    $routes->add('change_status/(:any)', 'Warehouse::change_status/$1');
    $routes->add('get_warehouse', 'Warehouse::get_warehouse');
    $routes->add('add_warehouse', 'Warehouse::add_warehouse');
    $routes->add('update_warehouse', 'Warehouse::update_warehouse');
});