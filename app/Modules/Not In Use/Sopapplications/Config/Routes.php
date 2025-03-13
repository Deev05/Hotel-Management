<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('sopapplications', ['namespace' => 'App\Modules\Sopapplications\Controllers'], function ($routes) {
    $routes->add('/', 'Sopapplications::index');
    $routes->add('order_table', 'Sopapplications::order_table');
    $routes->add('get_application_details', 'Sopapplications::get_application_details');
    $routes->add('order_details/(:any)', 'Sopapplications::order_details/$1');
    $routes->add('get_data', 'Sopapplications::get_data');
    $routes->add('send_edit_message', 'Sopapplications::send_edit_message');
    $routes->add('send_notification', 'Sopapplications::send_notification');
    $routes->add('send_notification_to_service_provider', 'Sopapplications::send_notification_to_service_provider');
    $routes->add('change_application_status', 'Sopapplications::change_application_status');
    $routes->add('change_status/(:any)', 'Sopapplications::change_status/$1');
    $routes->add('change_payment_status/(:any)', 'Sopapplications::change_payment_status/$1');
    $routes->add('change_edit_mode/(:any)', 'Sopapplications::change_edit_mode/$1');
    $routes->add('conversation/(:any)', 'Sopapplications::conversation/$1');
    $routes->add('get_conversation/(:any)', 'Sopapplications::get_conversation/$1');

});
