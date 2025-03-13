<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('cronjobs', ['namespace' => 'App\Modules\Cron_jobs\Controllers'], function ($routes) {
    $routes->add('/', 'Cron_jobs::index');
    $routes->add('send_new_inquiry_notificaion_service_provider', 'Cron_jobs::send_new_inquiry_notificaion_service_provider');
    $routes->add('check_deadlines', 'Cron_jobs::check_deadlines');

});