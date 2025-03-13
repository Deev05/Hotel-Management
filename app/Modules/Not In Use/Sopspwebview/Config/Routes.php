<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('sopspwebview', ['namespace' => 'App\Modules\Sopspwebview\Controllers'], function ($routes) {
    
    $routes->add('/', 'Sopspwebview::index');
    $routes->add('coversation/(:num)', 'Sopspwebview::coversation/$1');


    $routes->get('get_conversation/(:num)', 'Sopspwebview::get_conversation/$1');
    $routes->add('send_message', 'Sopspwebview::send_message');

});
