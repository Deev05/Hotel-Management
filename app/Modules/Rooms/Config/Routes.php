<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('Rooms', ['namespace' => 'App\Modules\Rooms\Controllers'], function ($routes) {
    $routes->add('/', 'Rooms::index');
    $routes->add('create', 'Rooms::create');
    $routes->add('create/(:any)', 'Rooms::create/$1');
    $routes->add('delete/(:any)', 'Rooms::delete/$1');
    $routes->add('change_status/(:any)', 'Rooms::change_status/$1');
   
    $routes->add('get_rooms', 'Rooms::get_rooms');
    $routes->add('add_rooms', 'Rooms::add_rooms');
    $routes->add('update_rooms', 'Rooms::update_rooms');
});