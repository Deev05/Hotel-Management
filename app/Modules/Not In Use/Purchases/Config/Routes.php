<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('purchases', ['namespace' => 'App\Modules\Purchases\Controllers'], function ($routes) {
    $routes->add('/', 'Purchases::index');
    $routes->add('create', 'Purchases::create');
    $routes->add('create/(:any)', 'Purchases::create/$1');
    $routes->add('delete/(:any)', 'Purchases::delete/$1');
    $routes->add('change_purchase_status/(:any)/(:any)', 'Purchases::change_purchase_status/$1/$1');
    $routes->add('change_payment_status/(:any)/(:any)', 'Purchases::change_payment_status/$1/$1');
    $routes->add('get_purchases', 'Purchases::get_purchases');
    $routes->add('add_purchase', 'Purchases::add_purchase');
    $routes->add('update_purchase', 'Purchases::update_purchase');
    $routes->add('get_details_for_update', 'Purchases::get_details_for_update');
    $routes->add('get_details_for_view', 'Purchases::get_details_for_view');
    $routes->add('get_supplier_products', 'Purchases::get_supplier_products');
    $routes->add('get_product_details', 'Purchases::get_product_details');
    $routes->add('get_supplier_info', 'Purchases::get_supplier_info');
    $routes->add('purchase_invoice/(:any)', 'Purchases::purchase_invoice/$1');
    $routes->add('print/(:any)', 'Purchases::print/$1');
    $routes->add('download_excel', 'Purchases::download_excel');

});