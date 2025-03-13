<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('serviceproviderhome', ['namespace' => 'App\Modules\Serviceproviderhome\Controllers'], function ($routes) {
    $routes->add('/', 'Serviceproviderhome::index');
     $routes->add('get_admin_notifications', 'Serviceproviderhome::get_admin_notifications');
     $routes->add('get_service_provider_inquiries', 'Serviceproviderhome::get_service_provider_inquiries');
     $routes->add('update_service_provider_token', 'Serviceproviderhome::update_service_provider_token');
     $routes->add('accept_sop_application', 'Serviceproviderhome::accept_sop_application');
     $routes->add('reject_sop_application', 'Serviceproviderhome::reject_sop_application');
     $routes->add('profile', 'Serviceproviderhome::profile');
     $routes->add('update_profile', 'Serviceproviderhome::update_profile');

});