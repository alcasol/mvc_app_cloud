<?php
// ------------------------------------------------------------------------
// app/controllers/UserController.php
// ------------------------------------------------------------------------
// Este controlador encapsula la lógica relacionada con la gestión de
// usuarios, siguiendo el patrón MVC para separar claramente la lógica de
// presentación (vistas) de la lógica de negocio (controladores y modelos).
// ------------------------------------------------------------------------

namespace App\Controllers;

use Core\Controller;
use Utils\Log;
use Utils\JSONServerResponse;

class UserController extends Controller {

    /**
     * ---------------------------------------------------------------------
     * @route GET user/register
     * ---------------------------------------------------------------------
     * Carga la vista 'user/register', que renderiza el formulario de registro
     * para los usuarios.
     */
    public function register() {
        // Generar el token CSRF
        $csrfToken = AuthController::generateCSRFToken();
        
        // Pasar el token CSRF a la vista
        $this->view('user/register', ['csrfToken' => $csrfToken]);
    }

    /**
     * ---------------------------------------------------------------------
     * @route POST user/create
     * ---------------------------------------------------------------------
     * Utiliza el modelo User para crear un nuevo usuario en la base de datos
     * usando los datos recibidos del formulario.
     */
    public function create() {
        // Verificar el token CSRF
        if (!AuthController::verifyCSRFToken($_POST['csrf_token'] ?? '')) {
            JSONServerResponse::error('Invalid CSRF token', 400);
            return;
        }

        // Obtener el tipo de contenido de la solicitud
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        // Inicializar variables
        $name = $phone = $email = $username = $password = '';

        if (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
            // Manejar datos enviados como application/x-www-form-urlencoded
            $name = $_POST['name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
        } elseif (stripos($contentType, 'application/json') !== false) {
            // Manejar datos enviados como application/json
            $input = json_decode(file_get_contents('php://input'), true);
            $name = $input['name'] ?? '';
            $phone = $input['phone'] ?? '';
            $email = $input['email'] ?? '';
            $username = $input['username'] ?? '';
            $password = $input['password'] ?? '';
        } else {
            Log::error('Unsupported Content-Type: ' . $contentType);
            JSONServerResponse::error('Unsupported Content-Type', 415);
            return;
        }

        // Validar los datos del formulario
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        if (empty($username) || empty($password) || !$email) {
            // Manejo de errores, por ejemplo:
            Log::error('Invalid registration data');
            JSONServerResponse::error('Invalid registration data', 400);
            return;
        }

        // Crear el usuario usando el modelo User
        $user = $this->model('User');
        $result = $user->createUser($name, $phone, $email, $username, $password);

        if ($result) {
            Log::info('User created successfully: ' . $username);
            JSONServerResponse::success('User created successfully', [], 201);
        } else {
            Log::error('User creation failed for username: ' . $username);
            JSONServerResponse::error('Registration failed!', 500);
        }
    }

    /**
     * ---------------------------------------------------------------------
     * @route GET user/profile
     * ---------------------------------------------------------------------
     * Verifica si el usuario está autenticado iniciando sesión (session_start())
     * Si el usuario está autenticado, obtiene el nombre de usuario de las variables
     * de sesión y carga la vista del perfil (user/profile) pasando el nombre de
     * usuario como datos para mostrar en la vista.
     */
    public function profile() {
        // Obtener el nombre de usuario de la sesión si está iniciada
        $username = AuthController::getUsername();

        // Cargar la vista del perfil y pasar la variable $username
        $this->view('user/profile', ['username' => $username]);
    }

    /**
     * ---------------------------------------------------------------------
     * @route GET user/delete
     * ---------------------------------------------------------------------
     * Renderiza la vista para eliminar un usuario.
     *
     * Esta función simplemente carga la vista correspondiente al formulario
     * de eliminación de usuario.
     *
     * @return void
     */
    public function delete() {
        $this->view('user/delete');
    }

    /**
     * ---------------------------------------------------------------------
     * @route DELETE user/delete
     * ---------------------------------------------------------------------
     * Elimina un usuario de la base de datos utilizando el modelo User.
     *
     * @param string $_POST['username'] Nombre de usuario
     * @param string $_POST['password'] Contraseña del usuario
     *
     * @return void
     */
    public function deleteUser() {
        // Obtener los datos del usuario y contraseña del cuerpo de la solicitud
        $data = json_decode(file_get_contents('php://input'), true);
        $username = htmlspecialchars($data['username']);
        $password = htmlspecialchars($data['password']);
    
        // Validar los datos
        if (empty($username) || empty($password)) {
            Log::error('Invalid username or password provided for deletion');
            JSONServerResponse::error('Invalid username or password provided for deletion', 400);
            return;
        }
    
        // Llamar al modelo para eliminar el usuario
        $user = $this->model('User');
        $result = $user->delete($username, $password);
    
        if ($result) {
            Log::info('User deleted successfully: ' . $username);
            JSONServerResponse::success('User deleted successfully');
        } else {
            Log::error('User deletion failed for username: ' . $username);
            JSONServerResponse::error('User deletion failed!', 500);
        }
    }

}
?>
