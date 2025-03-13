<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('serviceproviderpaymenthistory', ['namespace' => 'App\Modules\Serviceproviderpaymenthistory\Controllers'], function ($routes) {
    $routes->add('/', 'Serviceproviderpaymenthistory::index');
    $routes->add('order_table', 'Serviceproviderpaymenthistory::order_table');
    $routes->add('get_application_details', 'Serviceproviderpaymenthistory::get_application_details');
    $routes->add('order_details/(:any)', 'Serviceproviderpaymenthistory::order_details/$1');
    $routes->add('get_data', 'Serviceproviderpaymenthistory::get_data');
    $routes->add('send_notification', 'Serviceproviderpaymenthistory::send_notification');
    $routes->add('send_notification_to_service_provider', 'Serviceproviderpaymenthistory::send_notification_to_service_provider');

});
