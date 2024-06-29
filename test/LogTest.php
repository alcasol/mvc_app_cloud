<?php
use PHPUnit\Framework\TestCase;
use Utils\Log;

require_once __DIR__ . '/../config/config.php';

class LogTest extends TestCase {

    public function testLogSaveMessage() {
        try {
            // Simular un mensaje de error
            $errorMessage = "Testing error message.";
            Log::error($errorMessage);

        } catch (Exception $e) {
            // Si hay alguna excepción, la prueba fallará
            $this->fail("Exception thrown: " . $e->getMessage());
        }
    }
}

?>
