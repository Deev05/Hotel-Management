<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('news', ['namespace' => 'App\Modules\News\Controllers'], function ($routes) {
    $routes->add('/', 'News::index');
    $routes->add('create', 'News::create');
    $routes->add('create/(:any)', 'News::create/$1');
    $routes->add('delete/(:any)', 'News::delete/$1');
    $routes->add('change_status/(:any)', 'News::change_status/$1');
    $routes->add('get_news', 'News::get_news');
    $routes->add('add_news', 'News::add_news');
    $routes->add('update_news', 'News::update_news');
});