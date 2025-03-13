<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('sopemployment', ['namespace' => 'App\Modules\Sopemployment\Controllers'], function ($routes) {
    $routes->add('/', 'Sopemployment::index');
    $routes->add('create', 'Sopemployment::create');
    $routes->add('create/(:any)', 'Sopemployment::create/$1');
    $routes->add('delete/(:any)', 'Sopemployment::delete/$1');
    $routes->add('change_status/(:any)', 'Sopemployment::change_status/$1');
    $routes->add('get_sop_employment', 'Sopemployment::get_sop_employment');
    $routes->add('add_sop_employment', 'Sopemployment::add_sop_employment');
    $routes->add('update_sop_employment', 'Sopemployment::update_sop_employment');
});