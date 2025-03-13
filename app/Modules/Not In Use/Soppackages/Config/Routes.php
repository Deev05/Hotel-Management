<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('soppackages', ['namespace' => 'App\Modules\Soppackages\Controllers'], function ($routes) {
    $routes->add('/', 'Soppackages::index');
    $routes->add('create', 'Soppackages::create');
    $routes->add('create/(:any)', 'Soppackages::create/$1');
    $routes->add('delete/(:any)', 'Soppackages::delete/$1');
    $routes->add('change_status/(:any)', 'Soppackages::change_status/$1');
    $routes->add('change_product_option_status/(:any)', 'Soppackages::change_product_option_status/$1');
    $routes->add('get_packages', 'Soppackages::get_packages');
    $routes->add('get_sop_countries', 'Soppackages::get_sop_countries');
    $routes->add('add_package', 'Soppackages::add_package');
    $routes->add('update_package', 'Soppackages::update_package');
    
    
    $routes->add('get_details_for_update', 'Products::get_details_for_update');
    $routes->add('get_details_for_view', 'Products::get_details_for_view');
    
});