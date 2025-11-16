# Installation Guide

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer
- Apache with mod_rewrite OR Nginx
- Git (for cloning the repository)

## Quick Start

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/AthleticPHP.git
cd AthleticPHP
```

### 2. Install Dependencies

```bash
composer install
```

If you don't have Composer installed, visit [getcomposer.org](https://getcomposer.org/)

### 3. Configure Environment

```bash
cp .env.example .env
```

Edit `.env` with your settings:

```env
DB_HOST=your_database_host
DB_NAME=athleticdb
DB_USER=your_database_user
DB_PASS=your_database_password

APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

**Security Note:** Never commit `.env` to version control!

### 4. Set Up Database

Create the database and import your schema:

```bash
mysql -u your_user -p
```

```sql
CREATE DATABASE athleticdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE athleticdb;
-- Import your existing tables here
```

### 5. Configure Web Server

#### Apache

Update your VirtualHost configuration:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/AthleticPHP/public
    
    <Directory /var/www/AthleticPHP/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/athletic-error.log
    CustomLog ${APACHE_LOG_DIR}/athletic-access.log combined
</VirtualHost>
```

Enable mod_rewrite:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Nginx

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/AthleticPHP/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 6. Set Permissions

```bash
# Create logs directory
mkdir -p logs
chmod 755 logs

# Set proper ownership (adjust user/group as needed)
sudo chown -R www-data:www-data /var/www/AthleticPHP
sudo chmod -R 755 /var/www/AthleticPHP
```

### 7. Test Installation

Visit your domain in a browser. You should see the home page.

## Development Setup

For local development:

### Using PHP Built-in Server

```bash
cd public
php -S localhost:8000
```

Visit `http://localhost:8000`

### Using Docker (Optional)

Create `docker-compose.yml`:

```yaml
version: '3.8'
services:
  web:
    image: php:7.4-apache
    ports:
      - "8080:80"
    volumes:
      - .:/var/www/html
    environment:
      - APACHE_DOCUMENT_ROOT=/var/www/html/public
  
  db:
    image: mysql:5.7
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: athleticdb
      MYSQL_USER: athleticdb
      MYSQL_PASSWORD: password
    ports:
      - "3306:3306"
```

Run:

```bash
docker-compose up -d
```

## Security Checklist

- [ ] Changed default database credentials
- [ ] Set `APP_DEBUG=false` in production
- [ ] Configured HTTPS (use Let's Encrypt)
- [ ] Set proper file permissions
- [ ] Enabled error logging
- [ ] Configured firewall rules
- [ ] Regular backups scheduled
- [ ] Updated all dependencies

## Troubleshooting

### Composer Install Fails

```bash
# Update Composer
composer self-update

# Clear cache
composer clear-cache

# Try again
composer install
```

### Database Connection Errors

1. Verify credentials in `.env`
2. Check MySQL is running: `sudo systemctl status mysql`
3. Test connection: `mysql -u username -p -h hostname`
4. Check firewall rules

### 500 Internal Server Error

1. Check Apache/Nginx error logs
2. Verify `.htaccess` exists in `public/`
3. Ensure mod_rewrite is enabled (Apache)
4. Check file permissions

### 404 on All Pages

1. Verify document root points to `public/` directory
2. Check `.htaccess` or Nginx config
3. Ensure URL rewriting is working

### Permission Denied Errors

```bash
# Fix ownership
sudo chown -R www-data:www-data /var/www/AthleticPHP

# Fix permissions
sudo chmod -R 755 /var/www/AthleticPHP
sudo chmod -R 775 logs
```

## Production Deployment

### Pre-Deployment Checklist

- [ ] Run `composer install --no-dev --optimize-autoloader`
- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Configure HTTPS with valid SSL certificate
- [ ] Set up automated backups
- [ ] Configure monitoring and alerts
- [ ] Test all functionality
- [ ] Set up log rotation

### Deployment Script Example

```bash
#!/bin/bash

# Pull latest code
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader

# Clear caches if any
# php artisan cache:clear (if using Laravel-style caching)

# Set permissions
chmod -R 755 .
chmod -R 775 logs

# Restart services
sudo systemctl reload apache2
# or
sudo systemctl reload nginx
sudo systemctl reload php7.4-fpm

echo "Deployment complete!"
```

## Support

For issues or questions:
- Check the [Migration Guide](MIGRATION_GUIDE.md)
- Review error logs in `logs/error.log`
- Contact: webmaster@athletictrainer.com

## License

Copyright © 2024 The Athletic Trainer. All rights reserved.
