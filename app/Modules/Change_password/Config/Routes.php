<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('change_password', ['namespace' => 'App\Modules\Change_password\Controllers'], function ($routes) {
    $routes->add('/', 'Change_password::index');
    $routes->add('create', 'Change_password::create');
    $routes->add('create/(:any)', 'Change_password::create/$1');
    $routes->add('delete/(:any)', 'Change_password::delete/$1');
    $routes->add('change_status/(:any)', 'Change_password::change_status/$1');
});