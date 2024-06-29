<?php
// ------------------------------------------------------------------------
// app/controllers/ConfigController.php
// ------------------------------------------------------------------------
// Controlador para manejar las variables de entorno y su entrega al frontend.
// ------------------------------------------------------------------------

namespace App\Controllers;

use Core\Controller;
use Utils\Log; // Asegúrate de incluir la clase Log
use Utils\ErrorHelper; // Incluye ErrorHelper

class ConfigController extends Controller {
    public function env() {
        try {
            // Sólo devolver las variables necesarias para el frontend
            $envVariables = [
                'BASE_URL' => $_ENV['BASE_URL'] ?? '',
                'IP_PUERTO' => $_ENV['IP_PUERTO'] ?? '',
            ];

            header('Content-Type: application/json');
            echo json_encode($envVariables);
        } catch (\Exception $e) {
            // Capturar y registrar cualquier error
            Log::error('Error retrieving environment variables', ['exception' => $e->getMessage()]);
            // Responder con un mensaje de error genérico
            ErrorHelper::sendErrorResponse('Internal Server Error', 500);
        }
    }
}
?>
