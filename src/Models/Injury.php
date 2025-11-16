<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class Injury
{
    /**
     * Get injuries by name with proper SQL injection prevention
     */
    public static function getByName(string $name): array
    {
        try {
            $db = Database::getConnection();
            
            // Properly use prepared statements with wildcards in the value
            $query = "SELECT * FROM injury WHERE name LIKE :name ORDER BY name";
            $statement = $db->prepare($query);
            $statement->execute([':name' => "%{$name}%"]);
            
            return $statement->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching injuries: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get injury by ID
     */
    public static function getById(int $id): ?array
    {
        try {
            $db = Database::getConnection();
            $query = "SELECT * FROM injury WHERE id = :id LIMIT 1";
            $statement = $db->prepare($query);
            $statement->execute([':id' => $id]);
            
            $result = $statement->fetch();
            return $result ?: null;
        } catch (PDOException $e) {
            error_log("Error fetching injury: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all injuries
     */
    public static function getAll(): array
    {
        try {
            $db = Database::getConnection();
            $query = "SELECT * FROM injury ORDER BY name";
            $statement = $db->query($query);
            
            return $statement->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching injuries: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Search injuries by keyword
     */
    public static function search(string $keyword): array
    {
        try {
            $db = Database::getConnection();
            $query = "SELECT * FROM injury 
                      WHERE name LIKE :keyword 
                      OR description LIKE :keyword 
                      OR treatment LIKE :keyword 
                      ORDER BY name";
            
            $statement = $db->prepare($query);
            $statement->execute([':keyword' => "%{$keyword}%"]);
            
            return $statement->fetchAll();
        } catch (PDOException $e) {
            error_log("Error searching injuries: " . $e->getMessage());
            return [];
        }
    }
}
