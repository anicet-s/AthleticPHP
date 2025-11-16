# Developer Guide

Quick reference for working with the refactored Athletic PHP application.

## Project Structure

```
AthleticPHP/
├── public/              # Web root (point your server here)
│   ├── index.php       # Application entry point
│   └── .htaccess       # Apache rewrite rules
├── src/                # Application source code
│   ├── Config/         # Configuration classes
│   ├── Controllers/    # Request handlers
│   ├── Models/         # Database models
│   └── Router.php      # Routing system
├── view/               # View templates
│   ├── partials/       # Reusable view components
│   └── errors/         # Error pages
├── model/              # Legacy models (deprecated)
├── controller/         # Legacy controller (deprecated)
├── js/                 # JavaScript files
├── style/              # CSS files
├── images/             # Image assets
├── logs/               # Application logs
├── vendor/             # Composer dependencies
├── bootstrap.php       # Application bootstrap
├── composer.json       # PHP dependencies
└── .env                # Environment configuration (not in git)
```

## Common Tasks

### Adding a New Route

Edit `public/index.php`:

```php
// GET route
$router->get('/my-page', MyController::class, 'index');

// POST route
$router->post('/my-action', MyController::class, 'handleAction');

// Any method (GET or POST)
$router->any('/flexible', MyController::class, 'flexible');
```

### Creating a New Controller

Create `src/Controllers/MyController.php`:

```php
<?php

namespace App\Controllers;

class MyController extends BaseController
{
    public function index(): void
    {
        // Get input
        $search = $this->input('search', '');
        
        // Get data from model
        $data = MyModel::getData($search);
        
        // Render view
        $this->render('myview', [
            'title' => 'My Page',
            'data' => $data
        ]);
    }
    
    public function handleAction(): void
    {
        // Validate CSRF token for POST requests
        if (!$this->validateCsrfToken()) {
            $this->error403();
            return;
        }
        
        // Process form
        $name = $this->input('name', '', FILTER_SANITIZE_SPECIAL_CHARS);
        
        // Save to database
        MyModel::save($name);
        
        // Redirect
        $this->redirect('/success');
    }
}
```

### Creating a New Model

Create `src/Models/MyModel.php`:

```php
<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class MyModel
{
    public static function getData(string $search): array
    {
        try {
            $db = Database::getConnection();
            
            $query = "SELECT * FROM my_table WHERE name LIKE :search";
            $stmt = $db->prepare($query);
            $stmt->execute([':search' => "%{$search}%"]);
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error in MyModel::getData: " . $e->getMessage());
            return [];
        }
    }
    
    public static function save(string $name): bool
    {
        try {
            $db = Database::getConnection();
            
            $query = "INSERT INTO my_table (name, created_at) VALUES (:name, NOW())";
            $stmt = $db->prepare($query);
            
            return $stmt->execute([':name' => $name]);
        } catch (PDOException $e) {
            error_log("Error in MyModel::save: " . $e->getMessage());
            return false;
        }
    }
}
```

### Creating a New View

Create `view/myview.php`:

```php
<?php require __DIR__ . '/partials/header.php'; ?>

<?php require __DIR__ . '/partials/navigation.php'; ?>

<div class="container">
    <h1><?= htmlspecialchars($title) ?></h1>
    
    <?php if (!empty($data)): ?>
        <ul>
            <?php foreach ($data as $item): ?>
                <li><?= htmlspecialchars($item['name']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No data found.</p>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/partials/footer.php'; ?>
```

### Working with Forms

```php
<!-- In view -->
<form method="POST" action="<?= url('/my-action') ?>">
    <?= csrf_field() ?>
    
    <input type="text" name="name" required>
    <button type="submit">Submit</button>
</form>

<!-- In controller -->
public function handleForm(): void
{
    // Validate CSRF
    if (!$this->validateCsrfToken()) {
        $this->error403();
        return;
    }
    
    // Get and validate input
    $name = $this->input('name', '', FILTER_SANITIZE_SPECIAL_CHARS);
    
    if (empty($name)) {
        $this->render('form', [
            'error' => 'Name is required'
        ]);
        return;
    }
    
    // Process...
}
```

## BaseController Methods

Available methods in all controllers:

```php
// Render a view
$this->render('viewname', ['key' => 'value']);

// Redirect
$this->redirect('/path');

// Get input (sanitized)
$value = $this->input('fieldname', 'default', FILTER_SANITIZE_SPECIAL_CHARS);

// CSRF protection
$token = $this->generateCsrfToken();
$valid = $this->validateCsrfToken();

// JSON response
$this->json(['status' => 'success'], 200);

// Error pages
$this->error404();
$this->error500('Custom message');
```

## Helper Functions

Available globally:

```php
// Get environment variable
$value = env('DB_HOST', 'localhost');

// Generate URL
$url = url('/path');

// Generate asset URL
$css = asset('style/main.css');

// CSRF token
$token = csrf_token();
$field = csrf_field(); // Returns hidden input
```

## Database Queries

### SELECT

```php
// Fetch all
$query = "SELECT * FROM table WHERE status = :status";
$stmt = $db->prepare($query);
$stmt->execute([':status' => 'active']);
$results = $stmt->fetchAll();

// Fetch one
$query = "SELECT * FROM table WHERE id = :id LIMIT 1";
$stmt = $db->prepare($query);
$stmt->execute([':id' => $id]);
$result = $stmt->fetch();
```

### INSERT

```php
$query = "INSERT INTO table (name, email) VALUES (:name, :email)";
$stmt = $db->prepare($query);
$success = $stmt->execute([
    ':name' => $name,
    ':email' => $email
]);

// Get last insert ID
$lastId = $db->lastInsertId();
```

### UPDATE

```php
$query = "UPDATE table SET name = :name WHERE id = :id";
$stmt = $db->prepare($query);
$success = $stmt->execute([
    ':name' => $name,
    ':id' => $id
]);

// Get affected rows
$affected = $stmt->rowCount();
```

### DELETE

```php
$query = "DELETE FROM table WHERE id = :id";
$stmt = $db->prepare($query);
$success = $stmt->execute([':id' => $id]);
```

## Security Best Practices

### Always Use Prepared Statements

```php
// ❌ NEVER do this
$query = "SELECT * FROM users WHERE name = '$name'";

// ✅ Always do this
$query = "SELECT * FROM users WHERE name = :name";
$stmt->execute([':name' => $name]);
```

### Escape Output

```php
// ❌ NEVER do this
<h1><?= $title ?></h1>

// ✅ Always do this
<h1><?= htmlspecialchars($title) ?></h1>
```

### Validate CSRF for POST

```php
public function handlePost(): void
{
    if (!$this->validateCsrfToken()) {
        $this->error403();
        return;
    }
    // Process...
}
```

### Sanitize Input

```php
// Text input
$name = $this->input('name', '', FILTER_SANITIZE_SPECIAL_CHARS);

// Email
$email = $this->input('email', '', FILTER_SANITIZE_EMAIL);

// Integer
$id = $this->input('id', 0, FILTER_SANITIZE_NUMBER_INT);

// URL
$url = $this->input('url', '', FILTER_SANITIZE_URL);
```

## Debugging

### Enable Debug Mode

In `.env`:
```
APP_DEBUG=true
```

### Check Logs

```bash
tail -f logs/error.log
```

### Database Query Debugging

```php
try {
    $stmt = $db->prepare($query);
    $stmt->execute($params);
    
    // Debug: Print query
    error_log("Query: " . $query);
    error_log("Params: " . print_r($params, true));
    
} catch (PDOException $e) {
    error_log("Error: " . $e->getMessage());
}
```

## Testing

### Manual Testing Checklist

- [ ] Test all forms with valid data
- [ ] Test all forms with invalid data
- [ ] Test SQL injection attempts
- [ ] Test XSS attempts
- [ ] Test CSRF protection
- [ ] Test error pages (404, 500)
- [ ] Test on mobile devices
- [ ] Test with JavaScript disabled

### Common Test Cases

```php
// SQL Injection test
$malicious = "'; DROP TABLE users; --";
$result = MyModel::search($malicious);
// Should return empty array, not error

// XSS test
$malicious = "<script>alert('XSS')</script>";
// Should be escaped in output: &lt;script&gt;...
```

## Performance Tips

### Database

```php
// Use LIMIT for large result sets
$query = "SELECT * FROM table LIMIT 100";

// Use indexes on frequently queried columns
// CREATE INDEX idx_name ON table(name);

// Close connection when done (automatic with PDO)
Database::closeConnection();
```

### Caching

Consider adding caching for frequently accessed data:

```php
// Simple file-based cache example
$cacheFile = __DIR__ . '/cache/data.json';
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 3600)) {
    $data = json_decode(file_get_contents($cacheFile), true);
} else {
    $data = MyModel::getExpensiveData();
    file_put_contents($cacheFile, json_encode($data));
}
```

## Deployment

### Pre-Deployment Checklist

```bash
# 1. Update dependencies
composer install --no-dev --optimize-autoloader

# 2. Set production environment
# In .env:
APP_ENV=production
APP_DEBUG=false

# 3. Clear any caches
rm -rf cache/*

# 4. Set permissions
chmod -R 755 .
chmod -R 775 logs

# 5. Test
# Visit all pages and test functionality
```

## Common Issues

### "Class not found"
```bash
composer dump-autoload
```

### "Permission denied" on logs
```bash
chmod 775 logs
chown www-data:www-data logs
```

### Routes not working
- Check `.htaccess` exists in `public/`
- Verify mod_rewrite is enabled
- Check document root points to `public/`

### Database connection fails
- Verify `.env` credentials
- Check MySQL is running
- Test connection: `mysql -u user -p -h host`

## Resources

- [PHP Manual](https://www.php.net/manual/en/)
- [PDO Documentation](https://www.php.net/manual/en/book.pdo.php)
- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)
- [Composer Documentation](https://getcomposer.org/doc/)

## Getting Help

- Check error logs: `logs/error.log`
- Review [SECURITY.md](SECURITY.md) for security issues
- Contact: webmaster@athletictrainer.com
