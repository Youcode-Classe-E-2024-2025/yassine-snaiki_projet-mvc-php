<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?Database $instance = null; 
    private ?PDO $db = null; 

    private static string $host = 'localhost';
    private static string $dbname = 'prj_mvc';
    private static string $user = 'postgres';
    private static string $pass = '0000';

    private function __construct() {}

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        if ($this->db === null) {
            try {
       
                $dsn = "pgsql:host=" . self::$host . ";dbname=" . self::$dbname . ";port=8885";
                $this->db = new PDO($dsn, self::$user, self::$pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);

                
                $this->initializeDatabase();
            } catch (PDOException $e) {
                error_log("Database Connection Error: " . $e->getMessage());
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return $this->db;
    }

   
    private function initializeDatabase()
    {
        try {
            
            $tempDb = new PDO("pgsql:host=" . self::$host . ";dbname=postgres;port=8885", self::$user, self::$pass);
            $tempDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            
            $dbExists = $tempDb->query("SELECT 1 FROM pg_database WHERE datname = '" . self::$dbname . "'")->fetch();

            if (!$dbExists) {
                $tempDb->exec("CREATE DATABASE " . self::$dbname);

                $sql = file_get_contents('database/database.sql');
                $tempDb->exec($sql);
            }

            $tempDb = null;
        } catch (PDOException $e) {
            error_log("Database Initialization Error: " . $e->getMessage());
            die("Database initialization failed: " . $e->getMessage());
        }
    }
}
