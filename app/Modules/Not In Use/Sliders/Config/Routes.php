<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('sliders', ['namespace' => 'App\Modules\Sliders\Controllers'], function ($routes) {
    $routes->add('/', 'Sliders::index');
    $routes->add('create', 'Sliders::create');
    $routes->add('create/(:any)', 'Sliders::create/$1');
    $routes->add('delete/(:any)', 'Sliders::delete/$1');
    $routes->add('change_status/(:any)', 'Sliders::change_status/$1');
    $routes->add('get_sliders', 'Sliders::get_sliders');
    $routes->add('add_slider', 'Sliders::add_slider');
    $routes->add('update_slider', 'Sliders::update_slider');
});