<?php
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class UserControllerTest extends TestCase
{
    protected $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://localhost/mvc_app/public/',
            'http_errors' => false, // Prevent Guzzle from throwing exceptions on 4xx or 5xx responses
        ]);
    }

    public function testRegisterPage()
    {
        $response = $this->client->get('user/register');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Register', (string) $response->getBody());
    }

    public function testLoginPage()
    {
        $response = $this->client->get('user/login');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('Login', (string) $response->getBody());
    }

    public function testCreateUser()
    {
        $response = $this->client->post('user/create', [
            'form_params' => [
                'name' => 'Test User',
                'phone' => '123456789',
                'email' => 'test.user@example.com',
                'username' => 'testuser',
                'password' => 'password',
            ],
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringNotContainsString('Registration failed!', (string) $response->getBody());
    }

    public function testAuthenticateUser()
    {
        $response = $this->client->post('user/authenticate', [
            'form_params' => [
                'username' => 'testuser',
                'password' => 'password',
            ],
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringNotContainsString('Login failed!', (string) $response->getBody());
    }

    public function testProfilePage()
    {
        // Iniciar sesión manualmente para simular el inicio de sesión
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = 'testuser';

        // Hacer una solicitud GET a la página de perfil
        $response = $this->client->get('/mvc_app/public/user/profile');

        // Verificar que la respuesta sea exitosa (código 200)
        $this->assertEquals(200, $response->getStatusCode());

        // Verificar que el contenido de la página contiene "Profile"
        //$this->assertStringContainsString('Profile', (string) $response->getBody());
    }
    
    public function testDeleteUser()
    {
        // Suponiendo que tienes un usuario de prueba creado para esta prueba
        // Aquí deberías crear un usuario en tu base de datos o en la aplicación

        // Simular una solicitud DELETE para eliminar el usuario
        $response = $this->client->request('DELETE', 'user/deleteUser', [
            'json' => [
                'username' => 'testuser', // Usuario a eliminar
                'password' => 'password', // Contraseña del usuario
            ],
        ]);

        // Verificar que la solicitud fue exitosa (código 200)
        $this->assertEquals(200, $response->getStatusCode());

        // Verificar que la respuesta contiene un estado de éxito
        $responseData = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('status', $responseData);
        $this->assertEquals('success', $responseData['status']);
    }
}
?>
