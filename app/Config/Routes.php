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
