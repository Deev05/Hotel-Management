<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('categories', ['namespace' => 'App\Modules\Categories\Controllers'], function ($routes) {
    $routes->add('/', 'Categories::index');
    $routes->add('create', 'Categories::create');
    $routes->add('create/(:any)', 'Categories::create/$1');
    $routes->add('delete/(:any)', 'Categories::delete/$1');
    $routes->add('change_status/(:any)', 'Categories::change_status/$1');
    $routes->add('get_categories', 'Categories::get_categories');
    $routes->add('add_category', 'Categories::add_category');
    $routes->add('update_category', 'Categories::update_category');
    $routes->add('reorder_list', 'Categories::reorder_list');
});