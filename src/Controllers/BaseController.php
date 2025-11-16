<?php

namespace App\Controllers;

class BaseController
{
    /**
     * Render a view with data
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        
        $viewPath = __DIR__ . '/../../view/' . $view . '.php';
        
        if (!file_exists($viewPath)) {
            $this->error404();
            return;
        }
        
        require $viewPath;
    }

    /**
     * Redirect to a URL
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Get sanitized input
     */
    protected function input(string $key, $default = null, int $filter = FILTER_SANITIZE_SPECIAL_CHARS)
    {
        $value = $_POST[$key] ?? $_GET[$key] ?? $default;
        
        if ($value === null) {
            return $default;
        }
        
        return filter_var($value, $filter);
    }

    /**
     * Validate CSRF token
     */
    protected function validateCsrfToken(): bool
    {
        $token = $_POST['csrf_token'] ?? '';
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        
        return hash_equals($sessionToken, $token);
    }

    /**
     * Generate CSRF token
     */
    protected function generateCsrfToken(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }

    /**
     * Return JSON response
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Show 404 error
     */
    protected function error404(): void
    {
        http_response_code(404);
        $this->render('errors/404', ['title' => '404 - Page Not Found']);
        exit;
    }

    /**
     * Show 500 error
     */
    protected function error500(string $message = 'Internal Server Error'): void
    {
        http_response_code(500);
        $this->render('errors/500', [
            'title' => '500 - Server Error',
            'message' => $message
        ]);
        exit;
    }
}
