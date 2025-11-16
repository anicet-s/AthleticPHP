# Migration Guide

This guide will help you migrate from the old structure to the new refactored application.

## What's Changed

### Security Improvements
- ✅ Fixed SQL injection vulnerabilities with proper prepared statements
- ✅ Moved database credentials to environment variables
- ✅ Added CSRF protection for forms
- ✅ Changed external resources from HTTP to HTTPS
- ✅ Added input validation and sanitization

### Architecture Improvements
- ✅ Implemented proper MVC pattern
- ✅ Added routing system
- ✅ Created reusable view components
- ✅ Added Composer autoloading
- ✅ Proper error handling and logging

### Code Quality
- ✅ Refactored JavaScript to modern ES6+ standards
- ✅ Removed code duplication
- ✅ Added proper namespacing
- ✅ Improved code organization

## Migration Steps

### 1. Install Dependencies

```bash
composer install
```

### 2. Configure Environment

Copy the example environment file and configure it:

```bash
cp .env.example .env
```

Edit `.env` and add your database credentials:

```
DB_HOST=mysql3.gear.host
DB_NAME=athleticdb
DB_USER=athleticdb
DB_PASS=your_actual_password_here
APP_DEBUG=false
```

**IMPORTANT:** Never commit the `.env` file to version control!

### 3. Update Web Server Configuration

#### Apache

Point your document root to the `public/` directory. The `.htaccess` file is already configured.

Example Apache VirtualHost:

```apache
<VirtualHost *:80>
    ServerName athletictrainer.local
    DocumentRoot /path/to/AthleticPHP/public
    
    <Directory /path/to/AthleticPHP/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Nginx

```nginx
server {
    listen 80;
    server_name athletictrainer.local;
    root /path/to/AthleticPHP/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 4. Create Logs Directory

```bash
mkdir -p logs
chmod 755 logs
```

### 5. Test the Application

Visit your application URL. The new routing system will handle all requests.

## New URL Structure

### Old URLs → New URLs

- `view/homePage.php` → `/` or `/home`
- `view/aboutUs.php` → `/about`
- `view/diagnostic.php` → `/diagnostic`
- `view/injuries.php` → `/injuries/search?action=keyword`
- `controller/index.php?action=search` → `/injuries/search` (POST)

## Backward Compatibility

The old files are still in place. You can:

1. **Option A: Full Migration** - Update all links to use new URLs and remove old files
2. **Option B: Gradual Migration** - Keep both systems running and migrate page by page
3. **Option C: Hybrid** - Use new backend with old views (requires minor view updates)

## Using the New System

### Controllers

Controllers are in `src/Controllers/` and extend `BaseController`:

```php
namespace App\Controllers;

class MyController extends BaseController
{
    public function index(): void
    {
        $this->render('myview', [
            'title' => 'My Page',
            'data' => $someData
        ]);
    }
}
```

### Models

Models are in `src/Models/` and use the new Database class:

```php
namespace App\Models;

use App\Config\Database;

class MyModel
{
    public static function getAll(): array
    {
        $db = Database::getConnection();
        $query = "SELECT * FROM my_table";
        return $db->query($query)->fetchAll();
    }
}
```

### Views

Views can use the new helper functions:

```php
<?php require __DIR__ . '/partials/header.php'; ?>
<?php require __DIR__ . '/partials/navigation.php'; ?>

<div class="container">
    <h1><?= htmlspecialchars($title) ?></h1>
    <!-- Your content -->
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
```

### Adding CSRF Protection to Forms

```php
<form method="POST" action="/some-action">
    <?= csrf_field() ?>
    <!-- form fields -->
</form>
```

Validate in controller:

```php
if (!$this->validateCsrfToken()) {
    $this->error403();
    return;
}
```

## Troubleshooting

### "Class not found" errors
Run `composer dump-autoload`

### Database connection errors
Check your `.env` file configuration

### 404 errors on all pages
Ensure `.htaccess` is working (Apache) or Nginx config is correct

### Permission errors
Ensure `logs/` directory is writable: `chmod 755 logs`

## Next Steps

1. Update all internal links to use new URL structure
2. Test all functionality thoroughly
3. Remove old files once migration is complete
4. Set up proper logging and monitoring
5. Consider adding unit tests

## Rollback Plan

If you need to rollback:

1. Point document root back to project root (not `public/`)
2. Use old `controller/index.php` as entry point
3. Keep `.env` file for future migration attempts
