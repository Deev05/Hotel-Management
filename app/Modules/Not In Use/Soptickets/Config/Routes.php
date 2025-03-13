<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('soptickets', ['namespace' => 'App\Modules\Soptickets\Controllers'], function ($routes) {
    
    $routes->add('/', 'Soptickets::index');
    $routes->add('ticket/(:num)', 'Soptickets::ticket/$1');


    $routes->get('get_conversation/(:num)', 'Soptickets::get_conversation/$1');
    $routes->add('send_message', 'Soptickets::send_message');

});
