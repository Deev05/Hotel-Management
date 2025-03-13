<?php



if(!isset($routes))

{ 

    $routes = \Config\Services::routes(true);

}



$routes->group('api', ['namespace' => 'App\Modules\server_api\Controllers'], function ($routes) {



    $routes->add('user_device_token', 'Server_api::user_device_token');

    $routes->add('login', 'Server_api::login');
    $routes->add('register', 'Server_api::register');
    $routes->add('verify_otp', 'Server_api::verify_otp');

    $routes->add('get_profile_details', 'Server_api::get_profile_details');
    $routes->add('update_profile', 'Server_api::update_profile');

    $routes->add('store_info', 'Server_api::store_info');
    
    $routes->add('get_homepage_data', 'Server_api::get_homepage_data');
    $routes->add('get_packages', 'Server_api::get_packages');


    $routes->add('contact', 'Server_api::contact');

    $routes->add('test_notification', 'Server_api::test_notification');
    $routes->add('get_notifications', 'Server_api::get_notifications');
    $routes->add('clear_notifications', 'Server_api::clear_notifications');
    

    
    $routes->add('sop_service_step_one', 'Server_api::sop_service_step_one');
    $routes->add('sop_service_step_one_update', 'Server_api::sop_service_step_one_update');
    $routes->add('sop_application_update_document', 'Server_api::sop_application_update_document');
    $routes->add('get_document_status', 'Server_api::get_document_status');
    $routes->add('get_sop_application_list', 'Server_api::get_sop_application_list');
    $routes->add('confirm_sop_package_details', 'Server_api::confirm_sop_package_details');
    $routes->add('payment_successful', 'Server_api::payment_successful');
    $routes->add('add_family_member', 'Server_api::add_family_member');
    $routes->add('get_family_members', 'Server_api::get_family_members');
    $routes->add('remove_family_member', 'Server_api::remove_family_member');
    $routes->add('get_application_details', 'Server_api::get_application_details');
    
    
    $routes->add('get_applicant_details', 'Server_api::get_applicant_details');
    $routes->add('get_documents', 'Server_api::get_documents');
    $routes->add('update_any_remark', 'Server_api::update_any_remark');
    
    $routes->add('create_ticket', 'Server_api::create_ticket');
    $routes->add('get_tickets', 'Server_api::get_tickets');
    
    $routes->add('send_mail', 'Server_api::send_mail');
    
    
    $routes->add('get_state_city_from_pincode', 'Server_api::get_state_city_from_pincode');
    $routes->add('create_custom_package', 'Server_api::create_custom_package');
    $routes->add('send_modification_message', 'Server_api::send_modification_message');
    $routes->add('complete_by_user', 'Server_api::complete_by_user');
    $routes->add('add_review_rating', 'Server_api::add_review_rating');





});