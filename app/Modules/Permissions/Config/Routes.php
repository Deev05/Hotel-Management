<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('permissions', ['namespace' => 'App\Modules\Permissions\Controllers'], function ($routes) {
    $routes->add('/', 'Permissions::index');
    $routes->add('create', 'Permissions::create');
    $routes->add('create/(:any)', 'Permissions::create/$1');
    $routes->add('delete/(:any)', 'Permissions::delete/$1');
    $routes->add('change_status/(:any)', 'Permissions::change_status/$1');
    $routes->add('get_permissions', 'Permissions::get_permissions');
    $routes->add('add_permission', 'Permissions::add_permission');
    $routes->add('update_permission', 'Permissions::update_permission');
});