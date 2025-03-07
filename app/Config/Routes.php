<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Default route to handle 404 errors
$routes->set404Override(function() {
    return view('errors/html/error_404');
}); 