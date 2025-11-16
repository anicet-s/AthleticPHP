<?php

// Start session with secure settings
if (session_status() === PHP_SESSION_NONE) {
    $isProduction = ($_ENV['APP_ENV'] ?? 'production') === 'production';
    
    session_start([
        'cookie_lifetime' => (int)($_ENV['SESSION_LIFETIME'] ?? 120) * 60,
        'cookie_httponly' => true,
        'cookie_secure' => $isProduction, // Only on HTTPS in production
        'cookie_samesite' => 'Strict',
        'use_strict_mode' => true,
        'use_only_cookies' => true,
    ]);
}

// Load Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Set error reporting based on environment
if ($_ENV['APP_DEBUG'] === 'true') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', __DIR__ . '/logs/error.log');
}

// Set timezone
date_default_timezone_set('America/Chicago');

// Helper functions
if (!function_exists('env')) {
    function env(string $key, $default = null) {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string {
        return rtrim(env('APP_URL', ''), '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string {
        return rtrim(env('APP_URL', ''), '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string {
        return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
    }
}
