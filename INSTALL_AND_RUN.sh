#!/bin/bash

###############################################################################
# Athletic PHP - Installation and Run Script
# Run this script to install dependencies and start the application
###############################################################################

set -e

echo "=========================================="
echo "Athletic PHP - Installation Script"
echo "=========================================="
echo ""

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo "This script needs sudo privileges."
    echo "Please run: sudo bash INSTALL_AND_RUN.sh"
    echo ""
    echo "Or run these commands manually:"
    echo ""
    echo "# 1. Install PHP"
    echo "sudo apt update"
    echo "sudo apt install -y php8.3-cli php8.3-pgsql php8.3-mbstring php8.3-xml php8.3-curl"
    echo ""
    echo "# 2. Install Composer"
    echo "curl -sS https://getcomposer.org/installer | php"
    echo "sudo mv composer.phar /usr/local/bin/composer"
    echo ""
    echo "# 3. Install project dependencies"
    echo "composer install"
    echo ""
    echo "# 4. Setup environment"
    echo "cp .env.example .env"
    echo "nano .env  # Edit with your database credentials"
    echo ""
    echo "# 5. Run the application"
    echo "cd public && php -S localhost:8000"
    exit 1
fi

echo "Step 1: Updating package list..."
apt update

echo ""
echo "Step 2: Installing PHP and extensions..."
apt install -y php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl

echo ""
echo "Step 3: Checking PHP installation..."
php --version

echo ""
echo "Step 4: Installing Composer..."
cd /tmp
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

echo ""
echo "Step 5: Verifying Composer installation..."
composer --version

echo ""
echo "Step 6: Installing project dependencies..."
cd "$OLDPWD"
sudo -u $SUDO_USER composer install

echo ""
echo "Step 7: Setting up environment file..."
if [ ! -f .env ]; then
    sudo -u $SUDO_USER cp .env.example .env
    echo "✓ .env file created"
    echo ""
    echo "⚠️  IMPORTANT: Edit .env file with your database credentials!"
    echo "   Run: nano .env"
else
    echo "✓ .env file already exists"
fi

echo ""
echo "=========================================="
echo "Installation Complete!"
echo "=========================================="
echo ""
echo "Next steps:"
echo "1. Edit .env file with your database credentials:"
echo "   nano .env"
echo ""
echo "2. Test database connection:"
echo "   php test-connection.php"
echo ""
echo "3. Start the development server:"
echo "   cd public && php -S localhost:8000"
echo ""
echo "4. Open your browser to:"
echo "   http://localhost:8000"
echo ""
