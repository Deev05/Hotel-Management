<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('pincode', ['namespace' => 'App\Modules\Pincode\Controllers'], function ($routes) {
    $routes->add('/', 'Pincode::index');
    $routes->add('create', 'Pincode::create');
    $routes->add('create/(:any)', 'Pincode::create/$1');
    $routes->add('delete/(:any)', 'Pincode::delete/$1');
    $routes->add('change_status/(:any)', 'Pincode::change_status/$1');
    $routes->add('get_pincode', 'Pincode::get_pincode');
    $routes->add('add_pincode', 'Pincode::add_pincode');
    $routes->add('update_pincode', 'Pincode::update_pincode');
});