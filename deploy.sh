#!/bin/bash

###############################################################################
# Athletic PHP Deployment Script
# 
# This script automates the deployment process for the Athletic PHP application
# Usage: ./deploy.sh [environment]
# Example: ./deploy.sh production
###############################################################################

set -e  # Exit on error

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
ENVIRONMENT=${1:-production}
APP_DIR=$(pwd)
BACKUP_DIR="$APP_DIR/backups"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Athletic PHP Deployment Script${NC}"
echo -e "${GREEN}Environment: $ENVIRONMENT${NC}"
echo -e "${GREEN}========================================${NC}"

# Function to print status messages
print_status() {
    echo -e "${GREEN}[✓]${NC} $1"
}

print_error() {
    echo -e "${RED}[✗]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[!]${NC} $1"
}

# Check if .env file exists
if [ ! -f "$APP_DIR/.env" ]; then
    print_error ".env file not found!"
    echo "Please create .env file from .env.example"
    exit 1
fi

print_status ".env file found"

# Create backup directory if it doesn't exist
if [ ! -d "$BACKUP_DIR" ]; then
    mkdir -p "$BACKUP_DIR"
    print_status "Created backup directory"
fi

# Backup current deployment
print_status "Creating backup..."
BACKUP_FILE="$BACKUP_DIR/backup_$TIMESTAMP.tar.gz"
tar -czf "$BACKUP_FILE" \
    --exclude='vendor' \
    --exclude='node_modules' \
    --exclude='backups' \
    --exclude='.git' \
    . 2>/dev/null || true
print_status "Backup created: $BACKUP_FILE"

# Pull latest code (if using git)
if [ -d ".git" ]; then
    print_status "Pulling latest code from git..."
    git pull origin main || git pull origin master
    print_status "Code updated"
else
    print_warning "Not a git repository, skipping git pull"
fi

# Install/Update Composer dependencies
print_status "Installing Composer dependencies..."
if [ "$ENVIRONMENT" == "production" ]; then
    composer install --no-dev --optimize-autoloader --no-interaction
else
    composer install --optimize-autoloader --no-interaction
fi
print_status "Composer dependencies installed"

# Create logs directory if it doesn't exist
if [ ! -d "$APP_DIR/logs" ]; then
    mkdir -p "$APP_DIR/logs"
    print_status "Created logs directory"
fi

# Set proper permissions
print_status "Setting file permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 775 logs
chmod 600 .env
print_status "Permissions set"

# Clear any application caches (if you implement caching)
if [ -d "$APP_DIR/cache" ]; then
    print_status "Clearing cache..."
    rm -rf "$APP_DIR/cache/*"
    print_status "Cache cleared"
fi

# Verify critical files exist
print_status "Verifying installation..."
CRITICAL_FILES=(
    "public/index.php"
    "bootstrap.php"
    "composer.json"
    ".env"
    "src/Router.php"
    "src/Config/Database.php"
)

for file in "${CRITICAL_FILES[@]}"; do
    if [ ! -f "$APP_DIR/$file" ]; then
        print_error "Critical file missing: $file"
        exit 1
    fi
done
print_status "All critical files present"

# Test database connection
print_status "Testing database connection..."
php -r "
require 'bootstrap.php';
try {
    \$db = App\Config\Database::getConnection();
    echo 'Database connection successful';
    exit(0);
} catch (Exception \$e) {
    echo 'Database connection failed: ' . \$e->getMessage();
    exit(1);
}
" && print_status "Database connection successful" || {
    print_error "Database connection failed"
    exit 1
}

# Restart web server (uncomment the one you use)
print_status "Restarting web server..."

# Apache
if command -v apache2ctl &> /dev/null; then
    sudo systemctl reload apache2 2>/dev/null || sudo service apache2 reload 2>/dev/null || true
    print_status "Apache reloaded"
fi

# Nginx + PHP-FPM
if command -v nginx &> /dev/null; then
    sudo systemctl reload nginx 2>/dev/null || sudo service nginx reload 2>/dev/null || true
    sudo systemctl reload php7.4-fpm 2>/dev/null || sudo service php7.4-fpm reload 2>/dev/null || true
    print_status "Nginx and PHP-FPM reloaded"
fi

# Clean up old backups (keep last 10)
print_status "Cleaning up old backups..."
cd "$BACKUP_DIR"
ls -t backup_*.tar.gz 2>/dev/null | tail -n +11 | xargs -r rm
cd "$APP_DIR"
print_status "Old backups cleaned"

# Display deployment summary
echo ""
echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Deployment Complete!${NC}"
echo -e "${GREEN}========================================${NC}"
echo -e "Environment: ${YELLOW}$ENVIRONMENT${NC}"
echo -e "Timestamp: ${YELLOW}$TIMESTAMP${NC}"
echo -e "Backup: ${YELLOW}$BACKUP_FILE${NC}"
echo ""
echo -e "${YELLOW}Post-Deployment Checklist:${NC}"
echo "  [ ] Test homepage"
echo "  [ ] Test search functionality"
echo "  [ ] Test diagnostic tool"
echo "  [ ] Check error logs"
echo "  [ ] Verify database connectivity"
echo ""
echo -e "${GREEN}Deployment successful!${NC}"

exit 0
