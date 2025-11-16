<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class Diagnostic
{
    /**
     * Get diagnostic by name with proper SQL injection prevention
     */
    public static function getByName(string $name): ?array
    {
        try {
            $db = Database::getConnection();
            
            // Properly use prepared statements with wildcards in the value, not the query
            $query = "SELECT * FROM diagnostic WHERE name LIKE :name LIMIT 1";
            $statement = $db->prepare($query);
            $statement->execute([':name' => "%{$name}%"]);
            
            $result = $statement->fetch();
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching diagnostic: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all diagnostics
     */
    public static function getAll(): array
    {
        try {
            $db = Database::getConnection();
            $query = "SELECT * FROM diagnostic ORDER BY name";
            $statement = $db->query($query);
            
            return $statement->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching diagnostics: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search diagnostics by keyword
     */
    public static function search(string $keyword): array
    {
        try {
            $db = Database::getConnection();
            $query = "SELECT * FROM diagnostic 
                      WHERE name LIKE :keyword 
                      OR description LIKE :keyword 
                      ORDER BY name";
            
            $statement = $db->prepare($query);
            $statement->execute([':keyword' => "%{$keyword}%"]);
            
            return $statement->fetchAll();
        } catch (PDOException $e) {
            error_log("Error searching diagnostics: " . $e->getMessage());
            return [];
        }
    }
}
