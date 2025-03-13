<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('serviceproviders', ['namespace' => 'App\Modules\Serviceproviders\Controllers'], function ($routes) {
    $routes->add('/', 'Serviceproviders::index');
    $routes->add('create', 'Serviceproviders::create');
    $routes->add('create/(:any)', 'Serviceproviders::create/$1');
    $routes->add('delete/(:any)', 'Serviceproviders::delete/$1');
    $routes->add('change_status/(:any)', 'Serviceproviders::change_status/$1');
    $routes->add('get_service_providers', 'Serviceproviders::get_service_providers');
    $routes->add('get_service_provider_payment_history', 'Serviceproviders::get_service_provider_payment_history');
    $routes->add('add_service_provider', 'Serviceproviders::add_service_provider');
    $routes->add('update_service_provider', 'Serviceproviders::update_service_provider');
    $routes->add('service_provider_payments', 'Serviceproviders::service_provider_payments');
       $routes->add('get_city_state', 'Serviceproviders::get_city_state');

});