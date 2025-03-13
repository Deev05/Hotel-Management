<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('manage_page', ['namespace' => 'App\Modules\Manage_page\Controllers'], function ($routes) {
    $routes->add('/', 'Manage_page::index');
    $routes->add('create', 'Manage_page::create');
    $routes->add('create/(:any)', 'Manage_page::create/$1');
    $routes->add('delete/(:any)', 'Manage_page::delete/$1');
    $routes->add('change_status/(:any)', 'Manage_page::change_status/$1');
});