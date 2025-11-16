# ✅ Correct URLs for the Application

## Important: Use Routes, Not Direct File Access

The application now uses a routing system. You should access pages through routes, not direct file paths.

## Correct URLs

### ✅ Use These URLs:

| Page | Correct URL | Description |
|------|-------------|-------------|
| Home | `http://localhost:8080/` | Home page |
| Home | `http://localhost:8080/home` | Home page (alternative) |
| About | `http://localhost:8080/about` | About page |
| Diagnostic | `http://localhost:8080/diagnostic` | Diagnostic tool |
| Injuries | `http://localhost:8080/injuries` | All injuries |
| Search | `http://localhost:8080/injuries/search` | Search results |

### ❌ Don't Use These URLs:

| Wrong URL | Why It's Wrong |
|-----------|----------------|
| `/view/homePage.php` | Bypasses routing system |
| `/view/diagnostic.php` | Returns 404 |
| `/view/aboutUs.php` | Bypasses routing system |
| `/view/injuries.php` | Bypasses routing system |
| `/controller/index.php` | Old system |

## Why Use Routes?

### Benefits of Routing System:

1. **Clean URLs** - `/diagnostic` instead of `/view/diagnostic.php`
2. **Security** - Views are protected from direct access
3. **Flexibility** - Easy to change URLs without changing files
4. **Consistency** - All requests go through the same entry point
5. **Middleware** - Can add authentication, logging, etc.

## How It Works

```
Request: http://localhost:8080/diagnostic
    ↓
public/index.php (entry point)
    ↓
Router matches route
    ↓
DiagnosticController::index()
    ↓
Renders view/diagnostic.php
    ↓
Response sent to browser
```

## URL Structure

### Pattern:
```
http://localhost:8080/{route}
```

### Examples:
```
http://localhost:8080/                    → HomeController::index()
http://localhost:8080/about               → HomeController::about()
http://localhost:8080/diagnostic          → DiagnosticController::index()
http://localhost:8080/injuries            → InjuryController::index()
http://localhost:8080/injuries/search     → InjuryController::search()
```

## Navigation Links

All navigation links in the application use the correct routes:

```php
<a href="<?= url('/') ?>">Home</a>
<a href="<?= url('/about') ?>">About</a>
<a href="<?= url('/diagnostic') ?>">Diagnostic</a>
```

These generate:
```html
<a href="http://localhost:8080/">Home</a>
<a href="http://localhost:8080/about">About</a>
<a href="http://localhost:8080/diagnostic">Diagnostic</a>
```

## If You See 404 Errors

### Check Your URL:

❌ **Wrong:**
```
http://localhost:8080/view/diagnostic.php
```

✅ **Correct:**
```
http://localhost:8080/diagnostic
```

### Common Mistakes:

1. **Including `/view/` in URL**
   - Wrong: `/view/diagnostic.php`
   - Right: `/diagnostic`

2. **Including `.php` extension**
   - Wrong: `/diagnostic.php`
   - Right: `/diagnostic`

3. **Using old controller path**
   - Wrong: `/controller/index.php?action=search`
   - Right: `/injuries/search`

## Bookmarks

If you have bookmarks to old URLs, update them:

### Old Bookmarks → New Bookmarks:

```
/view/homePage.php        → /
/view/aboutUs.php         → /about
/view/Diagnostic.php      → /diagnostic
/view/diagnostic.php      → /diagnostic
/view/injuries.php        → /injuries
/controller/index.php     → /
```

## For Developers

### Adding New Routes:

Edit `public/index.php`:

```php
// Add a new route
$router->get('/my-page', MyController::class, 'index');
```

### Route Types:

```php
$router->get('/path', Controller::class, 'method');    // GET only
$router->post('/path', Controller::class, 'method');   // POST only
$router->any('/path', Controller::class, 'method');    // GET or POST
```

## Testing Routes

### Test if a route works:

```bash
curl http://localhost:8080/diagnostic
```

Should return the diagnostic page HTML.

### Test if old URL is blocked:

```bash
curl http://localhost:8080/view/diagnostic.php
```

Should return 404 (this is correct behavior).

## Production Deployment

### Apache Configuration:

The `.htaccess` file in `public/` handles routing:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [L]
```

### Nginx Configuration:

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

## Summary

✅ **Always use routes**: `/diagnostic`, `/about`, etc.  
❌ **Never use direct file access**: `/view/diagnostic.php`  
✅ **Clean URLs**: No `.php` extensions  
✅ **Consistent**: All pages use the same pattern  

## Quick Reference

```
Home:       http://localhost:8080/
About:      http://localhost:8080/about
Diagnostic: http://localhost:8080/diagnostic
Injuries:   http://localhost:8080/injuries
Search:     http://localhost:8080/injuries/search
```

---

**Remember**: Use routes, not file paths! 🚀
