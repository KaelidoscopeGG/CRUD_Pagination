<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/about', 'About::index');
$routes->get('/services', 'Services::index');
$routes->match(['get', 'post'], '/contact', 'Contact::index');
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::create');


// Login routes
$routes->get('/login', 'Login::login');
$routes->post('/login', 'Login::login');

// Dashboard routes
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard/account/(:num)', 'Dashboard::viewAccount/$1');

// CRUD routes!
$routes->get('/dashboard/create', 'Dashboard::create');
$routes->post('/dashboard', 'Dashboard::store');

$routes->get('/dashboard/account/(:num)/edit', 'Dashboard::edit/$1');
$routes->post('/dashboard/account/(:num)/update', 'Dashboard::update/$1');

$routes->post('/dashboard/account/(:num)/delete', 'Dashboard::delete/$1');

// Logout route
$routes->post('/logout', 'Login::logout');