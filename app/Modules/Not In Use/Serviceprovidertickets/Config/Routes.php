<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('serviceprovidertickets', ['namespace' => 'App\Modules\Serviceprovidertickets\Controllers'], function ($routes) {
    $routes->add('/', 'Serviceprovidertickets::index');
    $routes->add('get_data', 'Serviceprovidertickets::get_data');
    $routes->add('send_notification', 'Serviceprovidertickets::send_notification');
    $routes->add('send_message', 'Serviceprovidertickets::send_message');
    $routes->add('single/(:any)', 'Serviceprovidertickets::single/$1');
    $routes->add('get_conversation/(:any)', 'Serviceprovidertickets::get_conversation/$1');
    $routes->add('change_ticket_status', 'Serviceprovidertickets::change_ticket_status');
   

});
