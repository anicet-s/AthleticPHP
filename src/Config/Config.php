<?php

namespace App\Config;

class Config
{
    /**
     * Get configuration value
     */
    public static function get(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }

    /**
     * Check if app is in debug mode
     */
    public static function isDebug(): bool
    {
        return filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get app URL
     */
    public static function getAppUrl(): string
    {
        return rtrim($_ENV['APP_URL'] ?? 'http://localhost', '/');
    }
}
