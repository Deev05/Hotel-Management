<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('units', ['namespace' => 'App\Modules\Units\Controllers'], function ($routes) {
    $routes->add('/', 'Units::index');
    $routes->add('create', 'Units::create');
    $routes->add('create/(:any)', 'Units::create/$1');
    $routes->add('delete/(:any)', 'Units::delete/$1');
    $routes->add('change_status/(:any)', 'Units::change_status/$1');
    $routes->add('get_units', 'Units::get_units');
    $routes->add('add_unit', 'Units::add_unit');
    $routes->add('update_unit', 'Units::update_unit');
});