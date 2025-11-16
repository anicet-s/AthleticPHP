<?php

require_once __DIR__ . '/../bootstrap.php';

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\InjuryController;
use App\Controllers\DiagnosticController;

// Create router instance
$router = new Router();

// Define routes
$router->get('/', HomeController::class, 'index');
$router->get('/home', HomeController::class, 'index');
$router->get('/about', HomeController::class, 'about');

$router->get('/injuries', InjuryController::class, 'index');
$router->any('/injuries/search', InjuryController::class, 'search');

$router->get('/diagnostic', DiagnosticController::class, 'index');
$router->any('/diagnostic/result', DiagnosticController::class, 'getByBodyPart');

// Dispatch the request
$router->dispatch();
