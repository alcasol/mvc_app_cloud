<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class MathControllerTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost/mvc_app/',
            'http_errors' => false, // Prevent Guzzle from throwing exceptions on 4xx or 5xx responses
        ]);
    }

    /**
     * Prueba la división de dos números.
     */
    public function testDividir()
    {
        $response = $this->client->get('dividir?a=4&b=2');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('El resultado de dividir 4 entre 2 es 2.', (string) $response->getBody());
    }

    /**
     * Prueba la división por cero.
     */
    public function testDividirPorCero()
    {
        $response = $this->client->get('dividir?a=4&b=0');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Error: División por cero no permitida.', (string) $response->getBody());
    }
}

