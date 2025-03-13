<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('tax', ['namespace' => 'App\Modules\Tax\Controllers'], function ($routes) {
    $routes->add('/', 'Tax::index');
    $routes->add('create', 'Tax::create');
    $routes->add('create/(:any)', 'Tax::create/$1');
    $routes->add('delete/(:any)', 'Tax::delete/$1');
    $routes->add('change_status/(:any)', 'Tax::change_status/$1');
    $routes->add('get_tax', 'Tax::get_tax');
    $routes->add('add_tax', 'Tax::add_tax');
    $routes->add('update_tax', 'Tax::update_tax');
});