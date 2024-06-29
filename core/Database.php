<?php
// ----------------------------------------------------------------------------
// core/Controller.php
// ----------------------------------------------------------------------------
// 
// ------------------------------------------------------------------------
// 
namespace Core;
use PDO, PDOException;

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $config = require __DIR__ . '/../config/database.php';
        $host = $config['host'];
        $user = $config['username'];
        $password = $config['password'];
        $dbname = $config['dbname'];

        try {
            $this->pdo = new PDO("mysql:host={$host};dbname={$dbname}", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Capturar y lanzar la excepción para manejarla en un contexto superior
            throw new PDOException("Database connection error: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
?>
