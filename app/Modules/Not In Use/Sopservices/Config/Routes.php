<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('sopservices', ['namespace' => 'App\Modules\Sopservices\Controllers'], function ($routes) {
    $routes->add('/', 'Sopservices::index');
    $routes->add('create', 'Sopservices::create');
    $routes->add('create/(:any)', 'Sopservices::create/$1');
    $routes->add('delete/(:any)', 'Sopservices::delete/$1');
    $routes->add('change_status/(:any)', 'Sopservices::change_status/$1');
    $routes->add('get_sop_services', 'Sopservices::get_sop_services');
    $routes->add('add_sop_service', 'Sopservices::add_sop_service');
    $routes->add('update_sop_service', 'Sopservices::update_sop_service');
    $routes->add('reorder_list', 'Sopservices::reorder_list');
});