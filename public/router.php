<?php
/**
 * Router script for PHP built-in web server
 * This handles URL rewriting since .htaccess doesn't work with php -S
 */

// Get the requested URI
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static files directly
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false; // Serve the requested resource as-is
}

// Otherwise, route through index.php
require __DIR__ . '/index.php';
