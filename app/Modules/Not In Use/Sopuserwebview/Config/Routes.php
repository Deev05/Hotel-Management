<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('sopuserwebview', ['namespace' => 'App\Modules\Sopuserwebview\Controllers'], function ($routes) {
    
    $routes->add('/', 'Sopuserwebview::index');
    $routes->add('coversation/(:num)', 'Sopuserwebview::coversation/$1');


    $routes->get('get_conversation/(:num)', 'Sopuserwebview::get_conversation/$1');
    $routes->add('send_message', 'Sopuserwebview::send_message');

});
