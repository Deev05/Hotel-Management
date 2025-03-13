<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('Roomtypes', ['namespace' => 'App\Modules\Roomtypes\Controllers'], function ($routes) {
    $routes->add('/', 'Roomtypes::index');
    $routes->add('create', 'Roomtypes::create');
    $routes->add('create/(:any)', 'Roomtypes::create/$1');
    $routes->add('delete/(:any)', 'Roomtypes::delete/$1');
    $routes->add('change_status/(:any)', 'Roomtypes::change_status/$1');
   
    $routes->add('get_Roomtypes', 'Roomtypes::get_Roomtypes');
    $routes->add('add_Roomtypes', 'Roomtypes::add_Roomtypes');
    $routes->add('update_Roomtypes', 'Roomtypes::update_Roomtypes');
});