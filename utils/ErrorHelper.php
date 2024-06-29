<?php
// ----------------------------------------------------------------------------
// utils/ErrorHelper.php
// ----------------------------------------------------------------------------
// clase dedicada para manejar las respuestas de error.
// ----------------------------------------------------------------------------

namespace Utils;

class ErrorHelper {
    
    /**
     * Envía una respuesta JSON con un estado de error.
     *
     * @param string $message El mensaje de error
     * @param int $statusCode El código de estado HTTP
     */
    public static function sendErrorResponse($message, $statusCode) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode([
            'status' => 'error',
            'statusCode' => $statusCode,
            'message' => $message
        ]);
        exit;
    }

    /**
     * Redirige a una página HTML personalizada que muestra el tipo de error y el número de error.
     *
     * @param string $message El mensaje de error
     * @param int $statusCode El código de estado HTTP
     */
    public static function redirectToErrorPage($message, $statusCode) {
        // Establecer el código de estado HTTP
        http_response_code($statusCode);
        
        // Construir la URL de la página de error utilizando VIEW_PATH
        $errorPageUrl = rtrim(BASE_URL, '/') . VIEW_PATH . 'error.php';
        $errorPageUrl .= '?message=' . urlencode($message) . '&code=' . $statusCode;
        
        // Redirigir a la página de error personalizada
        header('Location: ' . $errorPageUrl);
        exit;
    }
}
?>
