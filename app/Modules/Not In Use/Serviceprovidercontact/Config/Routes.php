<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('serviceprovidercontact', ['namespace' => 'App\Modules\Serviceprovidercontact\Controllers'], function ($routes) {
    $routes->add('/', 'Serviceprovidercontact::index');
    $routes->add('create', 'Serviceprovidercontact::create');
    $routes->add('create/(:any)', 'Serviceprovidercontact::create/$1');
    $routes->add('delete/(:any)', 'Serviceprovidercontact::delete/$1');
    $routes->add('change_status/(:any)', 'Serviceprovidercontact::change_status/$1');
});