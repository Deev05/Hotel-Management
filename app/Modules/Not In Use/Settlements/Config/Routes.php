<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('settlements', ['namespace' => 'App\Modules\Settlements\Controllers'], function ($routes) {
    $routes->add('/', 'Settlements::index');
    $routes->add('get_application_details', 'Settlements::get_application_details');
    $routes->add('get_data', 'Settlements::get_data');
    $routes->add('send_notification', 'Settlements::send_notification');
    $routes->add('make_payment_to_service_provider', 'Settlements::make_payment_to_service_provider');
    $routes->add('change_application_status', 'Settlements::change_application_status');
    $routes->add('change_status/(:any)', 'Settlements::change_status/$1');
    $routes->add('change_payment_status/(:any)', 'Settlements::change_payment_status/$1');
    $routes->add('change_edit_mode/(:any)', 'Settlements::change_edit_mode/$1');

});
