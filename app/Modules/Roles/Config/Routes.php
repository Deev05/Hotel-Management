<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('roles', ['namespace' => 'App\Modules\Roles\Controllers'], function ($routes) {
    $routes->add('/', 'Roles::index');
    $routes->add('create', 'Roles::create');
    $routes->add('create/(:any)', 'Roles::create/$1');
    $routes->add('delete/(:any)', 'Roles::delete/$1');
    $routes->add('change_status/(:any)', 'Roles::change_status/$1');
    $routes->add('get_roles', 'Roles::get_roles');
    $routes->add('add_role', 'Roles::add_role');
    $routes->add('update_role', 'Roles::update_role');
    $routes->add('get_details_for_update', 'Roles::get_details_for_update');
});