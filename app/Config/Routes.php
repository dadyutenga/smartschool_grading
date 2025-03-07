<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');

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
