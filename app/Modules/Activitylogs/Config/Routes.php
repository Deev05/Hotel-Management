<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('activitylogs', ['namespace' => 'App\Modules\Activitylogs\Controllers'], function ($routes) {
    $routes->add('/', 'Activitylogs::index');
    $routes->add('single_details/(:any)', 'Activitylogs::single_details/$1');
    $routes->add('change_status/(:any)', 'Activitylogs::change_status/$1');
    $routes->add('get_activity_logs', 'Activitylogs::get_activity_logs');

    
});