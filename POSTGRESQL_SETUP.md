# PostgreSQL Setup Guide

The application has been configured to use PostgreSQL instead of MySQL.

## Quick Setup

### Step 1: Install PHP with PostgreSQL Support

```bash
sudo apt update
sudo apt install -y php8.3-cli php8.3-pgsql php8.3-mbstring php8.3-xml php8.3-curl
```

Or if PHP 8.3 is not available:
```bash
sudo apt install -y php-cli php-pgsql php-mbstring php-xml php-curl
```

### Step 2: Verify PostgreSQL is Running

```bash
sudo systemctl status postgresql
```

If not running:
```bash
sudo systemctl start postgresql
```

### Step 3: Create Database and User

```bash
# Switch to postgres user
sudo -u postgres psql
```

In PostgreSQL prompt:
```sql
-- Create database
CREATE DATABASE athleticdb WITH ENCODING 'UTF8';

-- Create user (if needed)
CREATE USER athleticdb WITH PASSWORD 'your_secure_password';

-- Grant privileges
GRANT ALL PRIVILEGES ON DATABASE athleticdb TO athleticdb;

-- Connect to database
\c athleticdb

-- Grant schema privileges
GRANT ALL ON SCHEMA public TO athleticdb;

-- Exit
\q
```

### Step 4: Import Schema

```bash
psql -U postgres -d athleticdb -f database/schema-postgresql.sql
```

Or if you created a specific user:
```bash
psql -U athleticdb -d athleticdb -f database/schema-postgresql.sql
```

### Step 5: Configure Environment

```bash
cp .env.example .env
nano .env
```

Update with your PostgreSQL credentials:
```env
DB_HOST=localhost
DB_PORT=5432
DB_NAME=athleticdb
DB_USER=postgres
DB_PASS=your_password

APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### Step 6: Install Composer Dependencies

```bash
composer install
```

### Step 7: Test Database Connection

```bash
php test-connection.php
```

### Step 8: Start Development Server

```bash
cd public
php -S localhost:8000
```

Visit: **http://localhost:8000**

---

## Using Your Existing PostgreSQL Database

If you already have PostgreSQL running locally, you just need to:

1. **Create the database:**
   ```bash
   sudo -u postgres createdb athleticdb
   ```

2. **Import the schema:**
   ```bash
   sudo -u postgres psql -d athleticdb -f database/schema-postgresql.sql
   ```

3. **Configure .env:**
   ```bash
   cp .env.example .env
   nano .env
   ```
   
   Set your credentials:
   ```
   DB_HOST=localhost
   DB_PORT=5432
   DB_NAME=athleticdb
   DB_USER=postgres
   DB_PASS=your_postgres_password
   ```

4. **Install and run:**
   ```bash
   composer install
   php test-connection.php
   cd public && php -S localhost:8000
   ```

---

## PostgreSQL Connection Details

The application now uses:
- **Driver**: PostgreSQL (pgsql)
- **Default Port**: 5432
- **DSN Format**: `pgsql:host=localhost;port=5432;dbname=athleticdb`
- **Character Encoding**: UTF8

---

## Differences from MySQL

### Auto-increment
- MySQL: `AUTO_INCREMENT`
- PostgreSQL: `SERIAL` or `BIGSERIAL`

### String Concatenation
- MySQL: `CONCAT()`
- PostgreSQL: `||` operator or `CONCAT()`

### Date Functions
- MySQL: `NOW()`
- PostgreSQL: `CURRENT_TIMESTAMP` or `NOW()`

### LIMIT/OFFSET
Both databases support the same syntax.

### Case Sensitivity
PostgreSQL is case-sensitive for table/column names unless quoted.

---

## Troubleshooting

### "could not connect to server"
```bash
sudo systemctl start postgresql
sudo systemctl enable postgresql
```

### "FATAL: Peer authentication failed"
Edit `/etc/postgresql/*/main/pg_hba.conf`:
```
# Change this line:
local   all             all                                     peer

# To this:
local   all             all                                     md5
```

Then restart:
```bash
sudo systemctl restart postgresql
```

### "permission denied for schema public"
```sql
sudo -u postgres psql -d athleticdb
GRANT ALL ON SCHEMA public TO athleticdb;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO athleticdb;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO athleticdb;
```

### "extension pgsql not found"
```bash
sudo apt install php-pgsql
# or
sudo apt install php8.3-pgsql
```

### Check PostgreSQL version
```bash
psql --version
```

### List databases
```bash
sudo -u postgres psql -l
```

### Connect to database
```bash
sudo -u postgres psql -d athleticdb
```

---

## Quick Commands Reference

```bash
# Create database
sudo -u postgres createdb athleticdb

# Drop database
sudo -u postgres dropdb athleticdb

# Import SQL file
sudo -u postgres psql -d athleticdb -f schema.sql

# Backup database
sudo -u postgres pg_dump athleticdb > backup.sql

# Restore database
sudo -u postgres psql -d athleticdb < backup.sql

# List all databases
sudo -u postgres psql -l

# Connect to database
sudo -u postgres psql -d athleticdb

# List tables in database
sudo -u postgres psql -d athleticdb -c "\dt"

# Show table structure
sudo -u postgres psql -d athleticdb -c "\d injury"
```

---

## Complete Installation (One Command)

```bash
# Install PHP with PostgreSQL, create database, import schema, and run
sudo apt update && \
sudo apt install -y php8.3-cli php8.3-pgsql php8.3-mbstring php8.3-xml php8.3-curl && \
curl -sS https://getcomposer.org/installer | php && \
sudo mv composer.phar /usr/local/bin/composer && \
sudo -u postgres createdb athleticdb && \
sudo -u postgres psql -d athleticdb -f database/schema-postgresql.sql && \
composer install && \
cp .env.example .env && \
echo "Edit .env file now with: nano .env" && \
echo "Then run: cd public && php -S localhost:8000"
```

---

## Production Considerations

1. **Use connection pooling** (PgBouncer)
2. **Enable SSL** for database connections
3. **Regular backups** with pg_dump
4. **Monitor performance** with pg_stat_statements
5. **Optimize queries** with EXPLAIN ANALYZE
6. **Set up replication** for high availability

---

## Need Help?

- PostgreSQL Documentation: https://www.postgresql.org/docs/
- PHP PDO PostgreSQL: https://www.php.net/manual/en/ref.pdo-pgsql.php
- Contact: webmaster@athletictrainer.com
