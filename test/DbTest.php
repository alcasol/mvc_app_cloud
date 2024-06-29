<?php

use PHPUnit\Framework\TestCase, Core\Database;

class DbTest extends TestCase {

    protected static $db;

    public function testDatabaseConnection() {
        
        try {

            $db = Database::getInstance();
            
            // Ejemplo de consulta para verificar la conexión
            $statement = $db->query('SELECT 1');
            $this->assertNotFalse($statement, 'Connected to the database successfully!');
            
        } catch (Exception $e) {
            $this->fail('Failed to connect to the database: ' . $e->getMessage());
        }
    }
}
?>
