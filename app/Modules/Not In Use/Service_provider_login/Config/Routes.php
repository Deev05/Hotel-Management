<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('service_provider_login', ['namespace' => 'App\Modules\Service_provider_login\Controllers'], function ($routes) {
    $routes->add('/', 'Service_provider_login::index');
    $routes->add('login_check', 'Service_provider_login::login_check');
    $routes->add('verify_otp', 'Service_provider_login::verify_otp');
    $routes->add('logout', 'Service_provider_login::logout');
});