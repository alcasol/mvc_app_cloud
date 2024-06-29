<?php
// ------------------------------------------------------------------------
// /controllers/AuthController.php
// ------------------------------------------------------------------------
// Esta clase se encarga de manejar todas las operaciones relacionadas con
// la autenticación de usuarios.
// ------------------------------------------------------------------------
namespace App\Controllers;

use Core\Controller;
use Utils\Log;
use Utils\JSONServerResponse;

class AuthController extends Controller {

    /**
     * ---------------------------------------------------------------------
     * @route GET user/login
     * ---------------------------------------------------------------------
     * Carga la vista 'user/login', que renderiza el formulario de inicio de
     * sesión.
     */
    public function login() {
        // Generar el token CSRF
        $csrfToken = self::generateCSRFToken();
        
        // Pasar el token CSRF a la vista
        $this->view('user/login', ['csrfToken' => $csrfToken]);
    }

    /**
     * ---------------------------------------------------------------------
     * @route POST user/authenticate
     * ---------------------------------------------------------------------
     * Verifica las credenciales de inicio de sesión recibidas desde el
     * formulario a partir de ($_POST['username'] y $_POST['password'])
     * utilizando el modelo User.
     * Si las credenciales son válidas, inicia una sesión (session_start()),
     * establece variables de sesión y redirige al usuario al perfil
     * (user/profile). Si no, devuelve un mensaje de error JSON.
     */
    public function authenticate() {
        // Verificar el token CSRF
        if (!self::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            JSONServerResponse::error('Invalid CSRF token', 400);
            return;
        }

        try {
            // Recuperar los datos del formulario
            $username = $_POST['username'];
            $password = $_POST['password'];
        
            // Verificar las credenciales
            $user = $this->model('User');
            $userData = $user->login($username, $password);
        
            if ($userData && password_verify($password, $userData['password'])) {
                // Iniciar sesión
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
        
                // Redirigir al perfil del usuario
                header('Location: ' . BASE_URL . '/user/profile');
                exit;
            } else {
                // Si las credenciales no son válidas, devolver un mensaje de error en JSON
                JSONServerResponse::error('Login failed!', 401);
            }
        } catch (\Exception $e) {
            // Capturar y registrar cualquier excepción
            Log::error('Authentication error: ' . $e->getMessage());
            JSONServerResponse::error('Authentication error', 500);
        }
    }    

    /**
     * ---------------------------------------------------------------------
     * @route GET user/logout
     * ---------------------------------------------------------------------
     * Cierra la sesión destruyendo todas las variables de sesión ($_SESSION)
     * y redirige al usuario al formulario de inicio de sesión (user/login).
     */
    public function logout() {
        try {
            // Iniciar sesión si aún no está iniciada
            session_start();
    
            // Destruir todas las variables de sesión
            $_SESSION = array();
    
            // Destruir la sesión
            session_destroy();
    
            // Redirigir al formulario de login
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        } catch (\Exception $e) {
            // Capturar y registrar cualquier excepción
            Log::error('Logout error: ' . $e->getMessage());
            JSONServerResponse::error('Logout error', 500);
        }
    }

    /**
     * ---------------------------------------------------------------------
     * @route GET user/checkAuthentication
     * ---------------------------------------------------------------------
     * Verifica si el usuario está autenticado comprobando la variable de
     * sesión $_SESSION['loggedin']. Si no está autenticado, devuelve un
     * mensaje de error JSON y redirige al usuario al formulario de inicio
     * de sesión (user/login).
     */
    public static function checkAuthentication() {
        try {
            // Iniciar sesión
            session_start();
    
            // Verificar si el usuario está autenticado
            if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
                Log::error('Authentication check failed', ['session' => $_SESSION]); 
                JSONServerResponse::error('Unauthorized', 401); 
            }
        } catch (\Exception $e) {
            // Capturar y registrar cualquier excepción
            Log::error('Authentication check error: ' . $e->getMessage());
            JSONServerResponse::error('Authentication check error', 500);
        }
    }

    /**
     * ---------------------------------------------------------------------
     * Verifica si la sesión está iniciada. Si no, redirige al formulario de
     * inicio de sesión (user/login).
     */
    public static function checkSession() {
        // Iniciar sesión si aún no está iniciada
        session_start();

        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
            // Si no está autenticado, redirigir al formulario de login
            header('Location: ' . BASE_URL . '/user/login');
            exit;
        }
    }

    /**
     * Obtiene el nombre de usuario de la sesión.
     *
     * @return string|null
     */
    public static function getUsername() {
        //session_start();
        self::checkSession();
        return $_SESSION['username'] ?? null;
    }

    /**
     * Genera un token CSRF y lo almacena en la sesión.
     *
     * @return string
     */
    public static function generateCSRFToken() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    /**
     * Verifica si el token CSRF es válido.
     *
     * @param string $token
     * @return bool
     */
    public static function verifyCSRFToken($token) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
?>
