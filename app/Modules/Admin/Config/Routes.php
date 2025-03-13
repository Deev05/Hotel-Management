<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('admin', ['namespace' => 'App\Modules\Admin\Controllers'], function ($routes) {
    $routes->add('/', 'Admin::index');
     $routes->add('get_admin_notifications', 'Admin::get_admin_notifications');
     $routes->add('update_admin_token', 'Admin::update_admin_token');
    $routes->add('final_call','Admin::final_call');
    $routes->add('final_call/(:any)/(:any)', 'Admin::final_call/$1/$1');
    $routes->add('final_call/(:any)', 'Admin::final_call/$1');
    $routes->add('start_time','Admin::start_time');
    $routes->add('start_time/(:any)/(:any)', 'Admin::start_time/$1/$1');
    $routes->add('start_time/(:any)', 'Admin::start_time/$1');
});