<?php
// ------------------------------------------------------------------------
// tests/ConfigControllerTest.php
// ------------------------------------------------------------------------
// Pruebas para el ConfigController y ErrorHelper
// ------------------------------------------------------------------------

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ConfigControllerTest extends TestCase {

    private $client;

    protected function setUp(): void {
        $this->client = new Client([
            'base_uri' => 'http://localhost', // Ajusta la base URI según tu configuración
            'http_errors' => false, // Para manejar los errores manualmente
        ]);
    }

    public function testEnvEndpointReturnsVariables() {
        $response = $this->client->get('/config/env');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getBody()->getContents());
    }

    public function testEnvEndpointHandlesException() {
        // Provocar un error intencional en ConfigController, por ejemplo, desconectando la base de datos.
        $response = $this->client->get('/config/env');

        $this->assertEquals(500, $response->getStatusCode());

        $responseData = json_decode($response->getBody()->getContents(), true);
        $this->assertArrayHasKey('error', $responseData);
        $this->assertEquals('Internal Server Error', $responseData['error']);
    }
}
?>