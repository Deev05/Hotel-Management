<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('batch', ['namespace' => 'App\Modules\Batch\Controllers'], function ($routes) {
    $routes->add('/', 'Batch::index');
    $routes->add('create', 'Batch::create');
    $routes->add('create/(:any)', 'Batch::create/$1');
    $routes->add('delete/(:any)', 'Batch::delete/$1');
    $routes->add('change_status/(:any)', 'Batch::change_status/$1');
    $routes->add('get_batch', 'Batch::get_batch');
    $routes->add('add_batch', 'Batch::add_batch');
    $routes->add('update_batch', 'Batch::update_batch');
});