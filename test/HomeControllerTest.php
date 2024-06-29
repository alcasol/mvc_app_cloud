<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class HomeControllerTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost/mvc_app/public/',
            'http_errors' => false,
        ]);
    }

    public function testHomePage()
    {
        $response = $this->client->get('home/index');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Home', (string) $response->getBody());
    }
}
?>
