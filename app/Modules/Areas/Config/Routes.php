<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('Areas', ['namespace' => 'App\Modules\Areas\Controllers'], function ($routes) {
    $routes->add('/', 'Areas::index');
    $routes->add('create', 'Areas::create');
    $routes->add('create/(:any)', 'Areas::create/$1');
    $routes->add('delete/(:any)', 'Areas::delete/$1');
    $routes->add('change_status/(:any)', 'Areas::change_status/$1');
   
    $routes->add('get_areas', 'Areas::get_areas');
    $routes->add('add_areas', 'Areas::add_areas');
    $routes->add('update_areas', 'Areas::update_areas');
});