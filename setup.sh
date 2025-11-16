#!/bin/bash

###############################################################################
# Athletic PHP - Quick Setup Script
# 
# This script helps you set up the application quickly
# Usage: ./setup.sh
###############################################################################

set -e

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Athletic PHP - Setup Script${NC}"
echo -e "${GREEN}========================================${NC}\n"

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo -e "${RED}Error: Composer is not installed${NC}"
    echo "Please install Composer from https://getcomposer.org/"
    exit 1
fi

echo -e "${GREEN}✓${NC} Composer found\n"

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo -e "${RED}Error: PHP is not installed${NC}"
    exit 1
fi

PHP_VERSION=$(php -r "echo PHP_VERSION;")
echo -e "${GREEN}✓${NC} PHP $PHP_VERSION found\n"

# Install dependencies
echo -e "${YELLOW}Installing Composer dependencies...${NC}"
composer install
echo -e "${GREEN}✓${NC} Dependencies installed\n"

# Create .env file if it doesn't exist
if [ ! -f ".env" ]; then
    echo -e "${YELLOW}Creating .env file...${NC}"
    cp .env.example .env
    echo -e "${GREEN}✓${NC} .env file created\n"
    
    echo -e "${YELLOW}Please edit .env file with your database credentials:${NC}"
    echo "  - DB_HOST"
    echo "  - DB_NAME"
    echo "  - DB_USER"
    echo "  - DB_PASS"
    echo ""
    
    read -p "Press Enter to open .env in editor (or Ctrl+C to skip)..."
    ${EDITOR:-nano} .env
else
    echo -e "${GREEN}✓${NC} .env file already exists\n"
fi

# Create logs directory
if [ ! -d "logs" ]; then
    echo -e "${YELLOW}Creating logs directory...${NC}"
    mkdir -p logs
    chmod 755 logs
    echo -e "${GREEN}✓${NC} Logs directory created\n"
else
    echo -e "${GREEN}✓${NC} Logs directory exists\n"
fi

# Create cache directory (optional)
if [ ! -d "cache" ]; then
    mkdir -p cache
    chmod 755 cache
    echo -e "${GREEN}✓${NC} Cache directory created\n"
fi

# Test database connection
echo -e "${YELLOW}Testing database connection...${NC}"
if php test-connection.php; then
    echo ""
else
    echo -e "${RED}Database connection failed!${NC}"
    echo "Please check your .env configuration"
    exit 1
fi

# Set permissions
echo -e "${YELLOW}Setting file permissions...${NC}"
find . -type f -exec chmod 644 {} \; 2>/dev/null || true
find . -type d -exec chmod 755 {} \; 2>/dev/null || true
chmod 755 logs 2>/dev/null || true
chmod 600 .env 2>/dev/null || true
chmod +x deploy.sh 2>/dev/null || true
chmod +x setup.sh 2>/dev/null || true
chmod +x test-connection.php 2>/dev/null || true
echo -e "${GREEN}✓${NC} Permissions set\n"

echo -e "${GREEN}========================================${NC}"
echo -e "${GREEN}Setup Complete!${NC}"
echo -e "${GREEN}========================================${NC}\n"

echo -e "${YELLOW}Next Steps:${NC}"
echo "1. Verify your .env configuration"
echo "2. Import database schema: mysql -u user -p database < database/schema.sql"
echo "3. Configure your web server to point to the 'public' directory"
echo "4. Visit your application in a browser"
echo ""
echo -e "${YELLOW}Development Server:${NC}"
echo "  cd public && php -S localhost:8000"
echo ""
echo -e "${YELLOW}Documentation:${NC}"
echo "  - INSTALLATION.md - Complete installation guide"
echo "  - MIGRATION_GUIDE.md - Migration from old version"
echo "  - DEVELOPER_GUIDE.md - Development reference"
echo "  - SECURITY.md - Security improvements"
echo ""
echo -e "${GREEN}Happy coding!${NC}"
