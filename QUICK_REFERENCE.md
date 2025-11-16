# Quick Reference Card

## 🚀 Quick Start

```bash
# 1. Install dependencies
composer install

# 2. Configure environment
cp .env.example .env
nano .env  # Edit with your settings

# 3. Test database
php test-connection.php

# 4. Start development server
cd public && php -S localhost:8000
```

## 📁 Key Files

| File | Purpose |
|------|---------|
| `public/index.php` | Application entry point |
| `bootstrap.php` | Application bootstrap |
| `.env` | Environment configuration |
| `src/Router.php` | Routing system |
| `src/Controllers/` | Request handlers |
| `src/Models/` | Database models |
| `view/partials/` | Reusable view components |

## 🔧 Common Commands

```bash
# Install dependencies
composer install

# Update dependencies
composer update

# Test database connection
php test-connection.php

# Run setup
./setup.sh

# Deploy
./deploy.sh production

# Check logs
tail -f logs/error.log

# Clear cache (if implemented)
rm -rf cache/*
```

## 🎯 Adding Features

### Add a Route
```php
// public/index.php
$router->get('/my-page', MyController::class, 'index');
```

### Create a Controller
```php
// src/Controllers/MyController.php
namespace App\Controllers;

class MyController extends BaseController {
    public function index(): void {
        $this->render('myview', ['title' => 'My Page']);
    }
}
```

### Create a Model
```php
// src/Models/MyModel.php
namespace App\Models;

class MyModel {
    public static function getAll(): array {
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM table");
        return $stmt->fetchAll();
    }
}
```

### Create a View
```php
// view/myview.php
<?php require __DIR__ . '/partials/header.php'; ?>
<?php require __DIR__ . '/partials/navigation.php'; ?>

<div class="container">
    <h1><?= htmlspecialchars($title) ?></h1>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
```

## 🔒 Security Checklist

- [ ] `.env` file configured and gitignored
- [ ] `APP_DEBUG=false` in production
- [ ] HTTPS enabled
- [ ] CSRF tokens on all forms
- [ ] Input sanitization active
- [ ] Output escaping used
- [ ] Prepared statements for all queries
- [ ] Error logging enabled
- [ ] Security headers configured

## 🐛 Troubleshooting

| Problem | Solution |
|---------|----------|
| Class not found | `composer dump-autoload` |
| Database error | Check `.env` credentials |
| 404 on all pages | Check `.htaccess` and mod_rewrite |
| Permission denied | `chmod 755 logs` |
| Routes not working | Verify document root is `public/` |

## 📚 Helper Functions

```php
// Get environment variable
$value = env('DB_HOST', 'localhost');

// Generate URL
$url = url('/path');

// Generate asset URL
$css = asset('style/main.css');

// CSRF token
$token = csrf_token();
$field = csrf_field();
```

## 🎨 BaseController Methods

```php
// Render view
$this->render('view', ['key' => 'value']);

// Redirect
$this->redirect('/path');

// Get input
$value = $this->input('field', 'default');

// Validate CSRF
$valid = $this->validateCsrfToken();

// JSON response
$this->json(['status' => 'ok']);

// Error pages
$this->error404();
$this->error500('Message');
```

## 💾 Database Queries

```php
// SELECT
$query = "SELECT * FROM table WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->execute([':id' => $id]);
$result = $stmt->fetch();

// INSERT
$query = "INSERT INTO table (name) VALUES (:name)";
$stmt = $db->prepare($query);
$stmt->execute([':name' => $name]);

// UPDATE
$query = "UPDATE table SET name = :name WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->execute([':name' => $name, ':id' => $id]);

// DELETE
$query = "DELETE FROM table WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->execute([':id' => $id]);
```

## 🔐 Security Best Practices

```php
// ✅ DO: Use prepared statements
$stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute([':id' => $id]);

// ❌ DON'T: Concatenate SQL
$query = "SELECT * FROM users WHERE id = $id";

// ✅ DO: Escape output
<?= htmlspecialchars($userInput) ?>

// ❌ DON'T: Raw output
<?= $userInput ?>

// ✅ DO: Validate CSRF
if (!$this->validateCsrfToken()) {
    $this->error403();
}

// ✅ DO: Sanitize input
$name = $this->input('name', '', FILTER_SANITIZE_SPECIAL_CHARS);
```

## 📖 Documentation

| Document | Description |
|----------|-------------|
| `README.md` | Project overview |
| `INSTALLATION.md` | Installation guide |
| `MIGRATION_GUIDE.md` | Migration instructions |
| `DEVELOPER_GUIDE.md` | Development reference |
| `SECURITY.md` | Security improvements |
| `CHANGELOG.md` | Version history |
| `REFACTORING_SUMMARY.md` | Refactoring overview |

## 🌐 URLs

### Old Structure
- `/view/homePage.php`
- `/view/aboutUs.php`
- `/controller/index.php?action=search`

### New Structure
- `/` or `/home`
- `/about`
- `/injuries/search`
- `/diagnostic`

## 🔄 Deployment

```bash
# Quick deployment
./deploy.sh production

# Manual deployment
git pull
composer install --no-dev --optimize-autoloader
chmod -R 755 .
chmod 775 logs
sudo systemctl reload apache2
```

## 📞 Support

- **Email**: webmaster@athletictrainer.com
- **Logs**: `logs/error.log`
- **Test**: `php test-connection.php`

## ⚡ Performance Tips

- Use `composer install --optimize-autoloader` in production
- Enable opcache in PHP
- Use database indexes
- Enable gzip compression
- Configure browser caching
- Consider implementing Redis/Memcached

---

**Version**: 2.0.0  
**Last Updated**: 2024
