# Running the Athletic PHP Application

## Current Status

Your system needs PHP and Composer installed to run the refactored application.

## Quick Setup Instructions

### Option 1: Install PHP and Composer (Recommended for New System)

```bash
# Install PHP
sudo apt update
sudo apt install php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install dependencies
composer install

# Create .env file
cp .env.example .env
nano .env  # Edit with your database credentials

# Test database connection
php test-connection.php

# Run development server
cd public
php -S localhost:8000
```

Then visit: http://localhost:8000

### Option 2: Run Old Version (No Installation Required)

The old application files are still in place. You can run them directly if you have a web server configured:

**Old Entry Points:**
- `view/homePage.php` - Home page
- `view/aboutUs.php` - About page
- `view/diagnostic.php` - Diagnostic tool
- `controller/index.php` - Main controller

**Requirements for Old Version:**
- Web server (Apache/Nginx) with PHP
- MySQL database
- Update credentials in `model/Database.php` (line 17-19)

### Option 3: Use Docker (No Local Installation)

Create a `docker-compose.yml` file:

```yaml
version: '3.8'
services:
  web:
    image: php:8.2-apache
    ports:
      - "8080:80"
    volumes:
      - .:/var/www/html
    working_dir: /var/www/html
    command: >
      bash -c "
      apt-get update &&
      apt-get install -y git unzip &&
      curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer &&
      composer install &&
      docker-php-ext-install pdo pdo_mysql &&
      apache2-foreground
      "
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html/public
  
  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: athleticdb
      MYSQL_USER: athleticdb
      MYSQL_PASSWORD: password
    ports:
      - "3306:3306"
    volumes:
      - ./database/schema.sql:/docker-entrypoint-initdb.d/schema.sql
```

Then run:
```bash
docker-compose up -d
```

Visit: http://localhost:8080

### Option 4: Use XAMPP/WAMP/MAMP

1. Install XAMPP (https://www.apachefriends.org/)
2. Copy project to `htdocs/athletic`
3. Start Apache and MySQL
4. Visit: http://localhost/athletic/view/homePage.php (old version)
   OR configure virtual host to point to `public/` directory (new version)

## What You Need

### For New Refactored Version:
- ✅ PHP 7.4+ with extensions: pdo, pdo_mysql, mbstring, xml
- ✅ Composer
- ✅ MySQL 5.7+
- ✅ Web server (Apache with mod_rewrite OR Nginx)

### For Old Version:
- ✅ PHP with MySQL support
- ✅ MySQL database
- ✅ Web server

## Installation Commands Summary

```bash
# Ubuntu/Debian
sudo apt update
sudo apt install php8.3-cli php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl apache2 mysql-server
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install project dependencies
composer install

# Setup
cp .env.example .env
# Edit .env with your database credentials

# Test
php test-connection.php

# Run
cd public && php -S localhost:8000
```

## Troubleshooting

### "composer: command not found"
Install Composer: https://getcomposer.org/download/

### "php: command not found"
Install PHP: `sudo apt install php8.3-cli`

### "Database connection failed"
1. Make sure MySQL is running
2. Check credentials in `.env` file
3. Create database: `mysql -u root -p -e "CREATE DATABASE athleticdb"`

### "Class not found"
Run: `composer dump-autoload`

## Current System Status

Based on the checks:
- ❌ PHP: Not installed
- ❌ Composer: Not installed
- ✅ Application files: Present
- ✅ Old version: Can run with web server

## Recommended Next Steps

1. **Install PHP and Composer** (5 minutes)
2. **Run `composer install`** (2 minutes)
3. **Configure `.env`** (2 minutes)
4. **Start development server** (1 minute)

Total setup time: ~10 minutes

## Alternative: Use Existing Web Server

If you already have Apache/Nginx with PHP installed:

1. Point document root to project directory
2. Access via: http://localhost/view/homePage.php
3. Update database credentials in `model/Database.php`

## Need Help?

- Check INSTALLATION.md for detailed instructions
- Review QUICK_REFERENCE.md for commands
- Contact: webmaster@athletictrainer.com
