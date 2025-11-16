#!/bin/bash

###############################################################################
# Athletic PHP - Development Server Starter
# This script starts the PHP development server with proper routing
###############################################################################

echo "=========================================="
echo "Athletic PHP - Starting Development Server"
echo "=========================================="
echo ""

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "❌ Error: PHP is not installed"
    exit 1
fi

echo "✓ PHP found: $(php -v | head -n 1)"
echo ""

# Check if vendor directory exists
if [ ! -d "vendor" ]; then
    echo "⚠️  Warning: Composer dependencies not installed"
    echo "   Run: composer install"
    echo ""
fi

# Check if .env exists
if [ ! -f ".env" ]; then
    echo "⚠️  Warning: .env file not found"
    echo "   Run: cp .env.example .env"
    echo ""
fi

# Set port (default 8000)
PORT=${1:-8000}

echo "Starting server on http://localhost:$PORT"
echo ""
echo "📝 Note: Keep this terminal open while using the application"
echo "🛑 Press Ctrl+C to stop the server"
echo ""
echo "=========================================="
echo ""

# Start the server with router script
cd public
php -S localhost:$PORT router.php
