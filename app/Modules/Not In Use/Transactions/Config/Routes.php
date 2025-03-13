<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('transactions', ['namespace' => 'App\Modules\Transactions\Controllers'], function ($routes) {
    $routes->add('/', 'Transactions::index');
    
    $routes->add('get_data', 'Transactions::get_data');
    $routes->add('get_payment_summary', 'Transactions::get_payment_summary');
    $routes->add('make_payment', 'Transactions::make_payment');
    $routes->add('create', 'Transactions::create');
    $routes->add('service_provider_contact_inquiry', 'Transactions::service_provider_contact_inquiry');
    $routes->add('create/(:any)', 'Transactions::create/$1');
    $routes->add('delete/(:any)', 'Transactions::delete/$1');
    $routes->add('change_status/(:any)', 'Transactions::change_status/$1');
    
});