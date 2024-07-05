<?php

use App\Controllers\UserController;
use Application\Routing\Router;
use Dotenv\Dotenv;

// Load the environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '../../');
$dotenv->load();

// Define the routes
Router::get('/user', [UserController::class, 'index']);
Router::post('/user', [UserController::class, 'create']);

// Handle the request
$response = Router::handle();
echo $response;
