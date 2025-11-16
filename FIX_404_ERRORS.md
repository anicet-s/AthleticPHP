# Fix 404 Not Found Errors

## Problem

All links are returning "404 Not Found" because the PHP built-in server doesn't process `.htaccess` files for URL rewriting.

## Solution

Use the new startup script that includes a router for the built-in server.

### Quick Fix

```bash
# Make the script executable
chmod +x start-server.sh

# Start the server
./start-server.sh
```

Or manually:

```bash
cd public
php -S localhost:8000 router.php
```

**Important**: Use `router.php` instead of just starting the server!

## Why This Happens

The PHP built-in development server (`php -S`) doesn't support `.htaccess` files. The `.htaccess` file contains URL rewriting rules that route all requests through `index.php`.

**Without router.php:**
- Request to `/home` → 404 (no physical file)
- Request to `/about` → 404 (no physical file)

**With router.php:**
- Request to `/home` → Routed through `index.php` → Works! ✅
- Request to `/about` → Routed through `index.php` → Works! ✅

## Available Routes

Once you start the server correctly, these routes will work:

- **/** or **/home** - Home page
- **/about** - About page
- **/diagnostic** - Diagnostic tool
- **/injuries** - All injuries
- **/injuries/search** - Search injuries (POST)

## Step-by-Step Fix

### 1. Stop Any Running Server

Press `Ctrl+C` in the terminal where the server is running.

### 2. Start Server with Router

```bash
./start-server.sh
```

Or:

```bash
cd public
php -S localhost:8000 router.php
```

### 3. Test in Browser

Visit: **http://localhost:8000**

You should see the home page!

### 4. Test Links

Click on the navigation links - they should all work now.

## Alternative: Use Apache/Nginx

If you want to use a proper web server instead of the built-in server:

### Apache

```bash
# Install Apache
sudo apt install apache2

# Enable mod_rewrite
sudo a2enmod rewrite

# Create virtual host
sudo nano /etc/apache2/sites-available/athletic.conf
```

Add:
```apache
<VirtualHost *:80>
    ServerName athletic.local
    DocumentRoot /path/to/AthleticPHP/public
    
    <Directory /path/to/AthleticPHP/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Enable and restart:
```bash
sudo a2ensite athletic.conf
sudo systemctl restart apache2
```

Add to `/etc/hosts`:
```
127.0.0.1 athletic.local
```

Visit: **http://athletic.local**

### Nginx

```bash
# Install Nginx
sudo apt install nginx php-fpm

# Create config
sudo nano /etc/nginx/sites-available/athletic
```

Add:
```nginx
server {
    listen 80;
    server_name athletic.local;
    root /path/to/AthleticPHP/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

Enable and restart:
```bash
sudo ln -s /etc/nginx/sites-available/athletic /etc/nginx/sites-enabled/
sudo systemctl restart nginx
sudo systemctl restart php8.3-fpm
```

## Troubleshooting

### Still getting 404s after using router.php

Check that you're starting from the `public` directory:
```bash
pwd  # Should show: /path/to/AthleticPHP/public
php -S localhost:8000 router.php
```

### CSS/JS not loading

Make sure paths in views use absolute paths starting with `/`:
- ✅ `/style/athletic.css`
- ❌ `../style/athletic.css`

### "Address already in use"

Another process is using port 8000. Try a different port:
```bash
./start-server.sh 8080
```

Or:
```bash
cd public
php -S localhost:8080 router.php
```

### Routes work but pages are blank

Check the error log:
```bash
tail -f ../logs/error.log
```

Or enable debug mode in `.env`:
```
APP_DEBUG=true
```

## Quick Reference

### Start Server (Correct Way)
```bash
./start-server.sh
```

### Start Server (Manual)
```bash
cd public
php -S localhost:8000 router.php
```

### Stop Server
Press `Ctrl+C` in the terminal

### Check if Server is Running
```bash
curl http://localhost:8000
```

### View Server Logs
The built-in server outputs to the terminal where it's running.

## Summary

**Problem**: 404 errors on all links  
**Cause**: PHP built-in server doesn't use `.htaccess`  
**Solution**: Use `router.php` when starting the server  
**Command**: `cd public && php -S localhost:8000 router.php`  
**Or**: `./start-server.sh`

---

**Status**: ✅ Fixed  
**Files Created**: 
- `public/router.php` - Router for built-in server
- `start-server.sh` - Easy startup script
- `view/homePage.php` - Updated with correct paths
