<?php



if(!isset($routes))

{ 

    $routes = \Config\Services::routes(true);

}



$routes->group('service_provider_api', ['namespace' => 'App\Modules\service_provider_api\Controllers'], function ($routes) {



    $routes->add('user_device_token', 'Service_provider_api::user_device_token');

    $routes->add('login', 'Service_provider_api::login');
    $routes->add('register', 'Service_provider_api::register');
    $routes->add('verify_otp', 'Service_provider_api::verify_otp');

    $routes->add('get_profile_details', 'Service_provider_api::get_profile_details');
    $routes->add('update_profile', 'Service_provider_api::update_profile');

    $routes->add('store_info', 'Service_provider_api::store_info');
    
    $routes->add('get_homepage_data', 'Service_provider_api::get_homepage_data');
    $routes->add('get_packages', 'Service_provider_api::get_packages');


    $routes->add('contact', 'Service_provider_api::contact');

    $routes->add('test_notification', 'Service_provider_api::test_notification');
    $routes->add('get_service_provider_notifications', 'Service_provider_api::get_service_provider_notifications');
    $routes->add('clear_notifications', 'Service_provider_api::clear_notifications');
    

    
    $routes->add('sop_service_step_one', 'Service_provider_api::sop_service_step_one');
    $routes->add('sop_service_step_one_update', 'Service_provider_api::sop_service_step_one_update');
    $routes->add('sop_application_update_document', 'Service_provider_api::sop_application_update_document');
    $routes->add('get_document_status', 'Service_provider_api::get_document_status');
    $routes->add('get_sop_application_list', 'Service_provider_api::get_sop_application_list');
    $routes->add('confirm_sop_package_details', 'Service_provider_api::confirm_sop_package_details');
    
    
    $routes->add('accept_sop_application', 'Service_provider_api::accept_sop_application');
    $routes->add('reject_sop_application', 'Service_provider_api::reject_sop_application');
    $routes->add('get_service_provider_applications', 'Service_provider_api::get_service_provider_applications');
    $routes->add('get_application_details', 'Service_provider_api::get_application_details');
    $routes->add('sop_application_document', 'Service_provider_api::sop_application_document');
    $routes->add('get_service_provider_payment_history', 'Service_provider_api::get_service_provider_payment_history');
    
    $routes->add('get_family_members', 'Service_provider_api::get_family_members');
    $routes->add('create_ticket', 'Service_provider_api::create_ticket');
    $routes->add('get_tickets', 'Service_provider_api::get_tickets');
    $routes->add('send_note', 'Service_provider_api::send_note');
    $routes->add('get_payment_history', 'Service_provider_api::get_payment_history');





});