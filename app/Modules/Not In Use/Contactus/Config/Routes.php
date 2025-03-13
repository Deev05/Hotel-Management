<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('contactus', ['namespace' => 'App\Modules\Contactus\Controllers'], function ($routes) {
    $routes->add('/', 'Contactus::index');
    
    $routes->add('get_data', 'Contactus::get_data');
    $routes->add('create', 'Contactus::create');
    $routes->add('service_provider_contact_inquiry', 'Contactus::service_provider_contact_inquiry');
    $routes->add('create/(:any)', 'Contactus::create/$1');
    $routes->add('delete/(:any)', 'Contactus::delete/$1');
    $routes->add('change_status/(:any)', 'Contactus::change_status/$1');
});