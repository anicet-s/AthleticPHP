# Fix "localhost refused to connect" Error

## Problem Identified

You're getting two issues:
1. **"localhost refused to connect"** - The PHP development server isn't running
2. **"could not find driver"** - The PostgreSQL PHP extension is not installed

## Solution

### Step 1: Install PostgreSQL PHP Extension

```bash
sudo apt update
sudo apt install php8.3-pgsql
```

Or if that doesn't work:
```bash
sudo apt install php-pgsql
```

Verify installation:
```bash
php -m | grep pgsql
```

You should see:
```
pdo_pgsql
pgsql
```

### Step 2: Test Database Connection

```bash
php test-connection.php
```

Expected output:
```
========================================
Database Connection Test
========================================
...
✓ Connection successful!
```

### Step 3: Start the Development Server

```bash
cd public
php -S localhost:8000
```

You should see:
```
[Sun Nov 16 13:40:00 2024] PHP 8.3.6 Development Server (http://localhost:8000) started
```

### Step 4: Open in Browser

Visit: **http://localhost:8000**

---

## Alternative: Use MySQL Instead

If you prefer to use MySQL (which you already have installed), I can switch the application back to MySQL. Just let me know!

To use MySQL:
1. The `pdo_mysql` extension is already installed
2. I would update the database configuration back to MySQL
3. You'd need to import the MySQL schema

---

## Quick Fix Commands

```bash
# Install PostgreSQL extension
sudo apt install php8.3-pgsql

# Test connection
php test-connection.php

# Start server
cd public && php -S localhost:8000
```

---

## Why This Happened

1. PHP is installed ✅
2. Composer dependencies are installed ✅
3. .env file is configured ✅
4. BUT: PostgreSQL PHP extension is missing ❌

The error "could not find driver" means PHP can't connect to PostgreSQL because the `pdo_pgsql` extension isn't loaded.

---

## Check Current PHP Extensions

```bash
php -m
```

Look for:
- ✅ PDO (you have this)
- ✅ pdo_mysql (you have this)
- ❌ pdo_pgsql (you need this)
- ❌ pgsql (you need this)

---

## After Installing Extension

Once you install `php-pgsql`, you need to:

1. **Test database connection**:
   ```bash
   php test-connection.php
   ```

2. **Create database if needed**:
   ```bash
   sudo -u postgres createdb athleticdb
   sudo -u postgres psql -d athleticdb -f database/schema-postgresql.sql
   ```

3. **Start the server**:
   ```bash
   cd public
   php -S localhost:8000
   ```

4. **Keep the terminal open** - The server runs in the foreground

5. **Open browser** to http://localhost:8000

---

## Troubleshooting

### "Package not found"
Try:
```bash
sudo apt install php-pgsql
```

### "Database does not exist"
Create it:
```bash
sudo -u postgres createdb athleticdb
sudo -u postgres psql -d athleticdb -f database/schema-postgresql.sql
```

### "Connection refused" after starting server
- Make sure you're in the `public` directory
- Check the terminal output for the correct port
- Try a different port: `php -S localhost:8080`

### Server stops when I close terminal
This is normal. The development server runs in the foreground. To run in background:
```bash
cd public
nohup php -S localhost:8000 > ../logs/server.log 2>&1 &
```

To stop background server:
```bash
pkill -f "php -S localhost:8000"
```

---

## Need to Switch to MySQL?

If PostgreSQL is causing issues and you want to use MySQL instead, let me know and I'll:
1. Update the database configuration back to MySQL
2. Provide the MySQL schema
3. Update the .env file

You already have `pdo_mysql` installed, so MySQL would work immediately.
