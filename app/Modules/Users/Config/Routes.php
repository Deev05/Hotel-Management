<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('users', ['namespace' => 'App\Modules\Users\Controllers'], function ($routes) {
    $routes->add('/', 'Users::index');
    $routes->add('create', 'Users::create');
    $routes->add('create/(:any)', 'Users::create/$1');
    $routes->add('delete/(:any)', 'Users::delete/$1');
    $routes->add('change_status/(:any)', 'Users::change_status/$1');
    $routes->add('get_users', 'Users::get_users');
    $routes->add('add_user', 'Users::add_user');
    $routes->add('update_user', 'Users::update_user');
});