<?php

if(!isset($routes))
{ 
    $routes = \Config\Services::routes(true);
}

$routes->group('Task', ['namespace' => 'App\Modules\Task\Controllers'], function ($routes) {
    $routes->add('/', 'Task::index');
    

    $routes->add('create', 'Task::create');
    $routes->add('create/(:any)', 'Task::create/$1');
    $routes->add('update', 'Task::update');
    $routes->add('update/(:any)', 'Task::update/$1');
    $routes->add('delete', 'Task::delete');
    $routes->add('delete/(:any)', 'Task::delete/$1');
    $routes->add('change_status/(:any)', 'Task::change_status/$1');
   
    $routes->add('get_Task', 'Task::get_Task');
    $routes->add('add_Task', 'Task::add_Task');
    $routes->add('update_Task', 'Task::update_Task');
    $routes->add('update_Task/(:any)', 'Task::update_Task/$1');
    $routes->add('view_sub_task_details', 'Task::view_sub_task_details');
    $routes->add('view_sub_task_details/(:any)', 'Task::view_sub_task_details/$1');
    
});