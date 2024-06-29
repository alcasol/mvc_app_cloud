<?php
use PHPUnit\Framework\TestCase, Core\Database, App\Models\User;

require_once __DIR__ . '/../config/config.php'; // Cargar el archivo de configuración

class UserTest extends TestCase
{
    protected static $db;

    public static function setUpBeforeClass(): void
    {
        // Establecer una conexión a la base de datos para las pruebas
        self::$db = Database::getInstance();
    }

    public function testGetUserById()
    {
        $userModel = new User();
        $userId = 2; // Ajusta este valor según tus datos de prueba

        $result = $userModel->getUserById($userId);

        $this->assertNotNull($result, 'No se encontró ningún usuario con el ID proporcionado');
        $this->assertEquals($userId, $result['id'], 'El ID del usuario recuperado no coincide con el esperado');
    }

    public function testGetUserByUsername()
    {
        $userModel = new User();
        $username = 'alcasol'; // Ajusta este valor según tus datos de prueba

        $result = $userModel->getUserByUsername($username);

        $this->assertNotNull($result, 'No se encontró ningún usuario con el nombre de usuario proporcionado');
        $this->assertEquals($username, $result['username'], 'El nombre de usuario recuperado no coincide con el esperado');
    }

    public function testCreateUser()
    {
        $userModel = new User();
        
        // Datos del primer usuario
        $name1 = 'John Doe';
        $phone1 = '123456789';
        $email1 = 'john.doe@example.com';
        $username1 = 'johndoe';
        $password1 = 'password';

        // Crear el primer usuario
        $result1 = $userModel->createUser($name1, $phone1, $email1, $username1, $password1);
        $this->assertTrue($result1, 'Fallo al crear el primer usuario');

        // Intentar crear otro usuario con el mismo correo
        $result2 = $userModel->createUser($name1, $phone1, $email1, $username1, $password1);
        $this->assertFalse($result2, 'Se permitió crear el mismo usuario dos veces');

        // Datos del segundo usuario
        $name2 = 'Jane Doe';
        $phone2 = '987654321';
        $email2 = 'john.doe@example.com';
        $username2 = 'janedoe';
        $password2 = 'password';

        // Crear el segundo usuario
        $result3 = $userModel->createUser($name2, $phone2, $email2, $username2, $password2);
        $this->assertTrue($result3, 'Fallo al crear el segundo usuario');

        // Intentar crear el mismo correo electrónico de nuevo
        $result4 = $userModel->createUser($name2, $phone2, $email2, $username2 . '2', $password2);
        $this->assertFalse($result4, 'Se permitió crear el mismo correo electrónico dos veces');
    }

    public function testLogin()
    {
        $userModel = new User();
        $username = 'johndoe'; // Ajusta este valor según el usuario creado en testCreateUser
        $password = 'password'; // Ajusta este valor según el usuario creado en testCreateUser

        $result = $userModel->login($username, $password);

        $this->assertNotNull($result, 'Fallo al iniciar sesión con las credenciales proporcionadas');
        $this->assertEquals($username, $result['username'], 'El nombre de usuario recuperado después del inicio de sesión no coincide con el esperado');
    }
}
?>
