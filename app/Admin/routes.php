<?php

use Illuminate\Routing\Router;

// Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('auth/users', AdminsController::class, ['middleware' => 'admin.permission:allow,administrator']);
    $router->resource('users', UsersController::class);
    $router->resource('task_orders', TaskOrdersController::class, ['only' => ['index', 'show']]);
    $router->resource('tasks', TasksController::class, ['only' => ['index', 'show']]);
    $router->post('tasks/{task}/!action/trace_state', 'TasksController@traceState');
});
