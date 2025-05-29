<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
service('auth')->routes($routes);

$routes->get('/', 'Home::index');
$routes->get('app', 'DashboardController::index');

$routes->group('products', ['filter' => 'session'], function ($routes) { // 'session' es el filtro de auth de Shield
    $routes->get('/', 'ProductController::index');
    $routes->get('new', 'ProductController::new');
    $routes->post('create', 'ProductController::create');
    $routes->get('edit/(:num)', 'ProductController::edit/$1');
    $routes->post('update/(:num)', 'ProductController::update/$1'); // CodeIgniter maneja _method="PUT" si envías ese campo, o puedes usar $routes->put()
    $routes->get('delete/(:num)', 'ProductController::delete/$1'); // Para MVP. Mejor usar POST o DELETE con un form.
    // $routes->post('delete/(:num)', 'ProductController::delete/$1'); // Si usas un form para el delete
});

$routes->group('purchases', ['filter' => 'session'], function ($routes) {
    $routes->get('/', 'PurchaseController::index');
    $routes->get('new', 'PurchaseController::new');
    $routes->post('create', 'PurchaseController::create');
    $routes->get('show/(:num)', 'PurchaseController::show/$1');
});

$routes->group('customers', ['filter' => 'session'], function ($routes) { // 'session' es el filtro de auth de Shield
    $routes->get('/', 'CustomerController::index', ['as' => 'customer_list']);
    $routes->get('new', 'CustomerController::new', ['as' => 'customer_new']);
    $routes->post('create', 'CustomerController::create', ['as' => 'customer_create']);
    $routes->get('edit/(:num)', 'CustomerController::edit/$1', ['as' => 'customer_edit']);
    $routes->post('update/(:num)', 'CustomerController::update/$1', ['as' => 'customer_update']);
    $routes->get('delete/(:num)', 'CustomerController::delete/$1', ['as' => 'customer_delete']); // Para MVP GET con confirmación JS
    // Considera $routes->post('delete/(:num)', 'CustomerController::delete/$1'); para producción
});
