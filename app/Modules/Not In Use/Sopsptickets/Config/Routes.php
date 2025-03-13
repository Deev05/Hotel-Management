<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('sopsptickets', ['namespace' => 'App\Modules\Sopsptickets\Controllers'], function ($routes) {
    $routes->add('/', 'Sopsptickets::index');
    $routes->add('get_data', 'Sopsptickets::get_data');
    $routes->add('send_notification', 'Sopsptickets::send_notification');
    $routes->add('send_message', 'Sopsptickets::send_message');
    $routes->add('single/(:any)', 'Sopsptickets::single/$1');
    $routes->add('get_conversation/(:any)', 'Sopsptickets::get_conversation/$1');
    $routes->add('change_ticket_status', 'Sopsptickets::change_ticket_status');
   

});
