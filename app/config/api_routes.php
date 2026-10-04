<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$router->post('/api/auth/login', 'ProductApiController::login');
$router->post('/api/auth/refresh', 'ProductApiController::refresh');
$router->post('/api/auth/logout', 'ProductApiController::logout');
$router->options('/api/auth/login', 'ProductApiController::options');
$router->options('/api/auth/refresh', 'ProductApiController::options');
$router->options('/api/auth/logout', 'ProductApiController::options');

$router->get('/api/health', 'ProductApiController::health');
$router->get('/api/products', 'ProductApiController::products');
$router->post('/api/products', 'ProductApiController::create_product');
$router->get('/api/products/{id}', 'ProductApiController::product');
$router->put('/api/products/{id}', 'ProductApiController::update_product');
$router->patch('/api/products/{id}', 'ProductApiController::update_product');
$router->delete('/api/products/{id}', 'ProductApiController::delete_product');
$router->options('/api/products', 'ProductApiController::options');
$router->options('/api/products/{id}', 'ProductApiController::options');
