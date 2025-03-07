<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Change the default route to redirect to login
$routes->get('/', 'Auth::login');

// Auth routes
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

// Dashboard
$routes->get('dashboard', 'Dashboard::index');

// Results routes
$routes->get('results', 'Results::index');
$routes->post('results/class', 'Results::viewClassResults');
$routes->get('results/student/(:num)/(:num)', 'Results::viewStudentResults/$1/$2');
$routes->post('results/getSections', 'Results::getSections');

// Test route to verify framework is working
$routes->get('test', function() {
    return 'CodeIgniter is working!';
});

// Default route to handle 404 errors
$routes->set404Override(function() {
    return view('errors/html/error_404');
});
