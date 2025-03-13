<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('usermaster', ['namespace' => 'App\Modules\Usermaster\Controllers'], function ($routes) {
    $routes->add('/', 'Usermaster::index');
    $routes->add('single_details/(:any)', 'Usermaster::single_details/$1');
    $routes->add('change_status/(:any)', 'Usermaster::change_status/$1');
    $routes->add('get_user_applications/(:any)', 'Usermaster::get_user_applications/$1');
    $routes->add('get_usermaster', 'Usermaster::get_usermaster');

    
});