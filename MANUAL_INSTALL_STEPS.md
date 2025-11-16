# Manual Installation Steps

Since I can't enter your sudo password, please run these commands in your terminal:

## Step 1: Install PHP

```bash
sudo apt update
sudo apt install -y php8.3-cli php8.3-pgsql php8.3-mbstring php8.3-xml php8.3-curl
```

Verify installation:
```bash
php --version
```

## Step 2: Install Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

Verify installation:
```bash
composer --version
```

## Step 3: Install Project Dependencies

```bash
composer install
```

This will install the required PHP packages (phpdotenv, etc.)

## Step 4: Configure Environment

```bash
cp .env.example .env
nano .env
```

Edit the `.env` file with your database credentials:
```
DB_HOST=localhost
DB_NAME=athleticdb
DB_USER=your_username
DB_PASS=your_password

APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000
```

## Step 5: Test Database Connection (Optional)

```bash
php test-connection.php
```

## Step 6: Start Development Server

```bash
cd public
php -S localhost:8000
```

## Step 7: Open in Browser

Visit: **http://localhost:8000**

---

## Alternative: Use the Install Script

I've created an automated script. Run it with:

```bash
sudo bash INSTALL_AND_RUN.sh
```

This will do all the steps automatically.

---

## Troubleshooting

### If PHP 8.3 is not available:

Try PHP 8.2 instead:
```bash
sudo apt install -y php8.2-cli php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl
```

Or use the generic php package:
```bash
sudo apt install -y php-cli php-mysql php-mbstring php-xml php-curl
```

### If Composer install fails:

Download manually:
```bash
wget https://getcomposer.org/download/latest-stable/composer.phar
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

### If you don't have a database yet:

Install MySQL:
```bash
sudo apt install postgresql postgresql-contrib
sudo mysql_secure_installation
```

Create database:
```bash
sudo mysql -u root -p
```

Then in MySQL:
```sql
CREATE DATABASE athleticdb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'athleticdb'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON athleticdb.* TO 'athleticdb'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Import schema:
```bash
mysql -u athleticdb -p athleticdb < database/schema.sql
```

---

## Quick Start (Copy & Paste)

```bash
# Install everything
sudo apt update && \
sudo apt install -y php8.3-cli php8.3-pgsql php8.3-mbstring php8.3-xml php8.3-curl && \
curl -sS https://getcomposer.org/installer | php && \
sudo mv composer.phar /usr/local/bin/composer && \
composer install && \
cp .env.example .env

# Edit .env file
nano .env

# Start server
cd public && php -S localhost:8000
```

Then open: http://localhost:8000
