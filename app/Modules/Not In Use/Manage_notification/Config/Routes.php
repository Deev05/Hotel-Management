<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('manage_notification', ['namespace' => 'App\Modules\Manage_notification\Controllers'], function ($routes) {
    $routes->add('/', 'Manage_notification::index');
    $routes->add('send_notification_all', 'Manage_notification::send_notification_all');
    $routes->add('send_notification', 'Manage_notification::send_notification');
    $routes->add('for_single', 'Manage_notification::for_single');
    $routes->add('notification_image_upload', 'Manage_notification::notification_image_upload');
    $routes->add('notification_image_delete/(:any)', 'Manage_notification::notification_image_delete/$1');
});