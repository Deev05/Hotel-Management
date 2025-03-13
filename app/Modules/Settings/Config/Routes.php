<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('settings', ['namespace' => 'App\Modules\Settings\Controllers'], function ($routes) {
    $routes->add('/', 'Settings::index');
    $routes->add('create', 'Settings::create');
    $routes->add('create/(:any)', 'Settings::create/$1');
    $routes->add('delete/(:any)', 'Settings::delete/$1');
    $routes->add('change_status/(:any)', 'Settings::change_status/$1');
    
    $routes->add('get_details', 'Settings::get_details');
    $routes->add('update_payment_method_status', 'Settings::update_payment_method_status');
    $routes->add('app_settings', 'Settings::app_settings');
    $routes->add('social_media_links', 'Settings::social_media_links');
    $routes->add('change_api', 'Settings::change_api');
    $routes->add('change_admin', 'Settings::change_admin');
    $routes->add('layout_settings', 'Settings::layout_settings');
    $routes->add('change_theme_view', 'Settings::change_theme_view');
    $routes->add('change_logo_backround', 'Settings::change_logo_backround');
    $routes->add('change_sidebar_backround', 'Settings::change_sidebar_backround');
    $routes->add('change_navbar_backround', 'Settings::change_navbar_backround');
});