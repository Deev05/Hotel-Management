<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('products', ['namespace' => 'App\Modules\Products\Controllers'], function ($routes) {
    $routes->add('/', 'Products::index');
    $routes->add('create', 'Products::create');
    $routes->add('create/(:any)', 'Products::create/$1');
    $routes->add('edit_product/(:any)', 'Products::edit_product/$1');
    $routes->add('get_stock_logs/(:any)', 'Products::get_stock_logs/$1');
    $routes->add('stock_logs/(:any)', 'Products::stock_logs/$1');
    $routes->add('delete/(:any)', 'Products::delete/$1');
    $routes->add('delete_product_option/(:any)', 'Products::delete_product_option/$1');
    $routes->add('change_status/(:any)', 'Products::change_status/$1');
    $routes->add('change_product_option_status/(:any)', 'Products::change_product_option_status/$1');
    $routes->add('get_products', 'Products::get_products');

    $routes->add('add_product', 'Products::add_product');
    $routes->add('duplicate_product', 'Products::duplicate_product');
    $routes->add('update_product', 'Products::update_product');
    $routes->add('update_price', 'Products::update_price');
    $routes->add('get_details_for_update', 'Products::get_details_for_update');
    $routes->add('get_units_for_product_option', 'Products::get_units_for_product_option');
    $routes->add('get_details_for_view', 'Products::get_details_for_view');
    $routes->add('get_product_price', 'Products::get_product_price');
    $routes->add('get_product_details_for_copy', 'Products::get_product_details_for_copy');
    $routes->add('add_product_option', 'Products::add_product_option');
    $routes->add('import_products', 'Products::import_products');
    $routes->add('upload_product_images', 'Products::upload_product_images');
});