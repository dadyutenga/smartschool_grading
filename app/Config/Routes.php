<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Change the default route to redirect to login
$routes->get('/', 'Admin::login');

// Auth routes
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/login', 'Admin::login');
$routes->get('admin/logout', 'Admin::logout');

// Dashboard
$routes->get('dashboard', 'Admin::dashboard');

// Results routes
$routes->get('results', 'Results::index');
$routes->post('results/class', 'Results::viewClassResults');
$routes->get('results/student/(:num)/(:num)', 'Results::viewStudentResults/$1/$2');
$routes->post('results/getSections', 'Results::getSections');

// Test route to verify framework is working
$routes->get('test', 'Test::index');
$routes->get('test/users', 'Test::users');

// Default route to handle 404 errors
$routes->set404Override(function() {
    return view('errors/html/error_404');
});
