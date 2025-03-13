<?php

if (!isset($routes)) {
    $routes = \Config\Services::routes(true);
}

$routes->group('orders', ['namespace' => 'App\Modules\Orders\Controllers'], function ($routes) {
    $routes->add('/', 'Orders::index');
    $routes->add('order_table', 'Orders::order_table');
    $routes->add('get_order_data', 'Orders::get_order_data');
    $routes->add('change_order_status/(:any)/(:any)', 'Orders::change_order_status/$1/$1');
    $routes->add('change_transaction_status/(:any)', 'Orders::change_transaction_status/$1');
    $routes->add('order_invoice/(:any)', 'Orders::order_invoice/$1');
    $routes->add('tracking_order', 'Orders::tracking_order');
    $routes->add('order_details/(:any)', 'Orders::order_details/$1');
    $routes->add('update_order_summary/(:any)', 'Orders::update_order_summary/$1');
    $routes->add('get_data', 'Orders::get_data');
    $routes->add('download_excel', 'Orders::download_excel');
    $routes->add('get_product', 'Orders::get_product');
    $routes->add('get_product_variation', 'Orders::get_product_variation');
    $routes->add('insert_product', 'Orders::insert_product');
    $routes->add('send_notification', 'Orders::send_notification');
    $routes->add('update_quantity', 'Orders::update_quantity');

    $routes->add('get_item_stock_details/(:any)', 'Orders::get_item_stock_details/$1');
    
    $routes->add('send_invoice_email', 'Orders::send_invoice_email');
    
    $routes->add('app_invoice/(:any)', 'Orders::app_invoice/$1');
    $routes->add('print/(:any)', 'Orders::print/$1');
});
