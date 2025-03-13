<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('admin_login', ['namespace' => 'App\Modules\Admin_login\Controllers'], function ($routes) {
    $routes->add('/', 'Admin_login::index');
    $routes->add('login_check', 'Admin_login::login_check');
    $routes->add('logout', 'Admin_login::logout');
});