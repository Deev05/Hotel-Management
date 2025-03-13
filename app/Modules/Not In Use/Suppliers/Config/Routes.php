<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('suppliers', ['namespace' => 'App\Modules\Suppliers\Controllers'], function ($routes) {
    $routes->add('/', 'Suppliers::index');
    $routes->add('create', 'Suppliers::create');
    $routes->add('create/(:any)', 'Suppliers::create/$1');
    $routes->add('delete/(:any)', 'Suppliers::delete/$1');
    $routes->add('change_status/(:any)', 'Suppliers::change_status/$1');
    $routes->add('get_suppliers', 'Suppliers::get_suppliers');
    $routes->add('add_supplier', 'Suppliers::add_supplier');
    $routes->add('update_supplier', 'Suppliers::update_supplier');
});