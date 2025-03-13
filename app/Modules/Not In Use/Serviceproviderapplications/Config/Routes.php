<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('serviceproviderapplications', ['namespace' => 'App\Modules\Serviceproviderapplications\Controllers'], function ($routes) {
    $routes->add('/', 'Serviceproviderapplications::index');
    $routes->add('order_table', 'Serviceproviderapplications::order_table');
    $routes->add('get_application_details', 'Serviceproviderapplications::get_application_details');
    $routes->add('order_details/(:any)', 'Serviceproviderapplications::order_details/$1');
    
    $routes->add('get_data', 'Serviceproviderapplications::get_data');
    $routes->add('send_notification', 'Serviceproviderapplications::send_notification');
    $routes->add('send_notification_to_service_provider', 'Serviceproviderapplications::send_notification_to_service_provider');
    $routes->add('upload_sop_document', 'Serviceproviderapplications::upload_sop_document');
    
    $routes->add('conversation/(:any)', 'Serviceproviderapplications::conversation/$1');
    $routes->add('get_conversation/(:any)', 'Serviceproviderapplications::get_conversation/$1');
    $routes->add('send_message', 'Serviceproviderapplications::send_message');
    $routes->add('send_edit_message', 'Serviceproviderapplications::send_edit_message');
    $routes->add('change_application_status', 'Serviceproviderapplications::change_application_status');
});
