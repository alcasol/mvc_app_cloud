<?php
// ------------------------------------------------------------------------
// app/controllers/MathController.php
// ------------------------------------------------------------------------
//
// Controlador para manejar las operaciones matemáticas
//

namespace App\Controllers;

use Core\Controller;
use App\Controllers\AuthController;
use Utils\Log;
use Utils\JSONServerResponse;

class MathController extends Controller {
    
    /**
     * ---------------------------------------------------------------------
     * @route GET math/calculate
     * ---------------------------------------------------------------------
     * Carga la vista 'math/calculate', donde el usuario puede realizar 
     * operaciones matemáticas
     */
    public function math() {
        // Obtener el nombre de usuario de la sesión si está iniciada
        $username = AuthController::getUsername();
        
        // Cargar la vista del cálculo y pasar la variable $username
        $this->view('math/calculate', ['username' => $username]);
    }

    /**
     * Método para dividir dos números pasados como parámetros en la URL.
     * @route GET dividir
     */
    public function dividir() {
        // Verificar si el usuario está autenticado
        AuthController::checkAuthentication();

        // Obtener los parámetros a y b de la URL
        $a = isset($_GET['a']) ? (int)$_GET['a'] : 0;
        $b = isset($_GET['b']) ? (int)$_GET['b'] : 1; // Por defecto b es 1 para evitar división por cero

        // Realizar la división y mostrar el resultado
        if ($b != 0) {
            $resultado = $a / $b;
            echo "El resultado de dividir $a entre $b es $resultado.";
        } else {
            echo "Error: División por cero no permitida.";
        }
    }

    /**
     * ---------------------------------------------------------------------
     * @route POST math/calculate
     * ---------------------------------------------------------------------
     * Carga la vista 'math/calculate', que renderiza el formulario de cálculo.
     */
    public function calculate() {
        AuthController::checkAuthentication();
        
        // Obtener el tipo de contenido de la solicitud
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        // Inicializar variables
        $number1 = $number2 = $operation = '';

        if (stripos($contentType, 'application/x-www-form-urlencoded') !== false) {
            // Manejar datos enviados como application/x-www-form-urlencoded
            $number1 = $_POST['number1'] ?? '';
            $number2 = $_POST['number2'] ?? '';
            $operation = $_POST['operation'] ?? '';
        } elseif (stripos($contentType, 'application/json') !== false) {
            // Manejar datos enviados como application/json
            $input = json_decode(file_get_contents('php://input'), true);
            $number1 = $input['number1'] ?? '';
            $number2 = $input['number2'] ?? '';
            $operation = $input['operation'] ?? '';
        } else {
            // Manejar otros tipos de contenido si es necesario
            JSONServerResponse::error('Unsupported Content-Type', 415);
            return;
        }

        // Validar los parámetros recibidos
        if ($number1 === '' || $number2 === '' || $operation === '') {
            // Registro de error si falta algún parámetro
            JSONServerResponse::error('Missing parameters', 400);
            return;
        }

        // Realizar el cálculo según la operación especificada
        $result = null;
        switch ($operation) {
            case 'add':
                $result = $number1 + $number2;
                break;
            case 'subtract':
                $result = $number1 - $number2;
                break;
            case 'multiply':
                $result = $number1 * $number2;
                break;
            case 'divide':
                if ($number2 != 0) {
                    $result = $number1 / $number2;
                } else {
                    JSONServerResponse::error('Cannot divide by zero', 400);
                    return;
                }
                break;
            default:
                JSONServerResponse::error('Invalid operation', 400);
                return;
        }

        // Responder con el resultado del cálculo
        JSONServerResponse::success('Calculation successful', ['result' => $result]);
    }
}

?>
