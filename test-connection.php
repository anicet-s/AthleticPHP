#!/usr/bin/env php
<?php
/**
 * Database Connection Test Script
 * 
 * Run this script to verify your database configuration
 * Usage: php test-connection.php
 */

require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "========================================\n";
echo "Database Connection Test\n";
echo "========================================\n\n";

// Display configuration (without password)
echo "Configuration:\n";
echo "  Host: " . ($_ENV['DB_HOST'] ?? 'not set') . "\n";
echo "  Database: " . ($_ENV['DB_NAME'] ?? 'not set') . "\n";
echo "  User: " . ($_ENV['DB_USER'] ?? 'not set') . "\n";
echo "  Password: " . (isset($_ENV['DB_PASS']) ? '***' : 'not set') . "\n\n";

// Test connection
echo "Testing connection...\n";

try {
    $db = App\Config\Database::getConnection();
    echo "✓ Connection successful!\n\n";
    
    // Test query
    echo "Testing query...\n";
    $stmt = $db->query("SELECT DATABASE() as db_name, VERSION() as version");
    $result = $stmt->fetch();
    
    echo "✓ Query successful!\n";
    echo "  Database: " . $result['db_name'] . "\n";
    echo "  MySQL Version: " . $result['version'] . "\n\n";
    
    // Check tables
    echo "Checking tables...\n";
    $stmt = $db->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    if (empty($tables)) {
        echo "⚠ No tables found. You may need to import your schema.\n";
    } else {
        echo "✓ Found " . count($tables) . " tables:\n";
        foreach ($tables as $table) {
            echo "  - $table\n";
        }
    }
    
    echo "\n";
    
    // Check for required tables
    $requiredTables = ['injury', 'diagnostic'];
    $missingTables = array_diff($requiredTables, $tables);
    
    if (!empty($missingTables)) {
        echo "⚠ Missing required tables:\n";
        foreach ($missingTables as $table) {
            echo "  - $table\n";
        }
        echo "\nPlease import database/schema.sql\n";
    } else {
        echo "✓ All required tables present\n";
        
        // Count records
        echo "\nRecord counts:\n";
        foreach ($requiredTables as $table) {
            $stmt = $db->query("SELECT COUNT(*) as count FROM $table");
            $count = $stmt->fetch()['count'];
            echo "  $table: $count records\n";
        }
    }
    
    echo "\n========================================\n";
    echo "✓ All tests passed!\n";
    echo "========================================\n";
    
    exit(0);
    
} catch (Exception $e) {
    echo "✗ Connection failed!\n";
    echo "Error: " . $e->getMessage() . "\n\n";
    
    echo "Troubleshooting:\n";
    echo "1. Check your .env file exists and has correct values\n";
    echo "2. Verify MySQL is running\n";
    echo "3. Test connection manually: mysql -u user -p -h host\n";
    echo "4. Check firewall rules\n";
    echo "5. Verify database user has proper permissions\n";
    
    exit(1);
}
