<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('sopcountries', ['namespace' => 'App\Modules\Sopcountries\Controllers'], function ($routes) {
    $routes->add('/', 'Sopcountries::index');
    $routes->add('create', 'Sopcountries::create');
    $routes->add('create/(:any)', 'Sopcountries::create/$1');
    $routes->add('delete/(:any)', 'Sopcountries::delete/$1');
    $routes->add('change_status/(:any)', 'Sopcountries::change_status/$1');
    $routes->add('get_sop_countries', 'Sopcountries::get_sop_countries');
    $routes->add('add_sop_country', 'Sopcountries::add_sop_country');
    $routes->add('update_sop_country', 'Sopcountries::update_sop_country');
});