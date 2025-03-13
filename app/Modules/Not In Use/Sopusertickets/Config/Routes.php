<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('sopusertickets', ['namespace' => 'App\Modules\Sopusertickets\Controllers'], function ($routes) {
    $routes->add('/', 'Sopusertickets::index');
    $routes->add('get_data', 'Sopusertickets::get_data');
    $routes->add('send_notification', 'Sopusertickets::send_notification');
    $routes->add('send_message', 'Sopusertickets::send_message');
    $routes->add('single/(:any)', 'Sopusertickets::single/$1');
    $routes->add('get_conversation/(:any)', 'Sopusertickets::get_conversation/$1');
    $routes->add('change_ticket_status', 'Sopusertickets::change_ticket_status');
   

});
