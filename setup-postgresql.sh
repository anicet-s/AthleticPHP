#!/bin/bash

###############################################################################
# Athletic PHP - PostgreSQL Quick Setup
# Run this to set up the application with your existing PostgreSQL database
###############################################################################

set -e

echo "=========================================="
echo "Athletic PHP - PostgreSQL Setup"
echo "=========================================="
echo ""

# Check if PostgreSQL is running
echo "Checking PostgreSQL status..."
if sudo systemctl is-active --quiet postgresql; then
    echo "✓ PostgreSQL is running"
else
    echo "⚠ PostgreSQL is not running. Starting..."
    sudo systemctl start postgresql
fi

echo ""

# Get database credentials
echo "Please provide your PostgreSQL credentials:"
echo ""
read -p "Database name [athleticdb]: " DB_NAME
DB_NAME=${DB_NAME:-athleticdb}

read -p "Database user [postgres]: " DB_USER
DB_USER=${DB_USER:-postgres}

read -sp "Database password: " DB_PASS
echo ""

read -p "Database host [localhost]: " DB_HOST
DB_HOST=${DB_HOST:-localhost}

read -p "Database port [5432]: " DB_PORT
DB_PORT=${DB_PORT:-5432}

echo ""
echo "Creating database if it doesn't exist..."

# Try to create database
sudo -u postgres psql -c "CREATE DATABASE $DB_NAME;" 2>/dev/null || echo "Database already exists or couldn't create (this is OK if it exists)"

echo ""
echo "Importing schema..."

# Import schema
if [ -f "database/schema-postgresql.sql" ]; then
    sudo -u postgres psql -d "$DB_NAME" -f database/schema-postgresql.sql
    echo "✓ Schema imported successfully"
else
    echo "⚠ Schema file not found. You may need to create tables manually."
fi

echo ""
echo "Creating .env file..."

# Create .env file
cat > .env << EOF
# Database Configuration (PostgreSQL)
DB_HOST=$DB_HOST
DB_PORT=$DB_PORT
DB_NAME=$DB_NAME
DB_USER=$DB_USER
DB_PASS=$DB_PASS

# Application Configuration
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000

# Security
SESSION_LIFETIME=120
EOF

echo "✓ .env file created"

echo ""
echo "Installing Composer dependencies..."

if command -v composer &> /dev/null; then
    composer install
    echo "✓ Dependencies installed"
else
    echo "⚠ Composer not found. Please install Composer first:"
    echo "   curl -sS https://getcomposer.org/installer | php"
    echo "   sudo mv composer.phar /usr/local/bin/composer"
    exit 1
fi

echo ""
echo "Testing database connection..."

if php test-connection.php; then
    echo ""
    echo "=========================================="
    echo "✓ Setup Complete!"
    echo "=========================================="
    echo ""
    echo "Start the development server with:"
    echo "  cd public && php -S localhost:8000"
    echo ""
    echo "Then visit: http://localhost:8000"
else
    echo ""
    echo "⚠ Database connection test failed."
    echo "Please check your credentials in .env file"
    exit 1
fi
