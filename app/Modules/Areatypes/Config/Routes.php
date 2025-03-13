<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('Areatypes', ['namespace' => 'App\Modules\Areatypes\Controllers'], function ($routes) {
    $routes->add('/', 'Areatypes::index');
    $routes->add('create', 'Areatypes::create');
    $routes->add('create/(:any)', 'Areatypes::create/$1');
    $routes->add('delete/(:any)', 'Areatypes::delete/$1');
    $routes->add('change_status/(:any)', 'Areatypes::change_status/$1');
   
    $routes->add('get_Areatypes', 'Areatypes::get_Areatypes');
    $routes->add('add_Areatypes', 'Areatypes::add_Areatypes');
    $routes->add('update_Areatypes', 'Areatypes::update_Areatypes');
});