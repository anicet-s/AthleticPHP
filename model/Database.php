<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 *
 * @author Anicet
 */
class Database {
    public static function getDB(){
        // DEPRECATED: Use src/Config/Database.php instead
        // This file is kept for backward compatibility with old views
        
        // PostgreSQL connection
        $host = 'localhost';
        $port = '5432';
        $dbname = 'athleticdb';
        $username = 'postgres';  // Update with your PostgreSQL username
        $password = 'your_password';  // Update with your PostgreSQL password
        
        $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
        
        try {
            $db = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            return $db;
        } 
        catch (PDOException $e) {
            $error_message = $e->getMessage();
            include('../view/database_error.php');
            exit();
        }
    }
}
