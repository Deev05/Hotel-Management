<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('about', ['namespace' => 'App\Modules\Pages\Controllers'], function ($routes) {
    $routes->add('/', 'Pages::about');
});

$routes->group('terms_condition', ['namespace' => 'App\Modules\Pages\Controllers'], function ($routes) {
    $routes->add('/', 'Pages::terms_condition');
});

$routes->group('privacy_policy', ['namespace' => 'App\Modules\Pages\Controllers'], function ($routes) {
    $routes->add('/', 'Pages::privacy_policy');
});

$routes->group('return_policy', ['namespace' => 'App\Modules\Pages\Controllers'], function ($routes) {
    $routes->add('/', 'Pages::return_policy');
});

$routes->group('contact', ['namespace' => 'App\Modules\Pages\Controllers'], function ($routes) {
    $routes->add('/', 'Pages::contact');
    $routes->add('create', 'Pages::create');
});