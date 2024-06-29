<?php
// ----------------------------------------------------------------------------
// utils/JSONServerResponse.php
// ----------------------------------------------------------------------------
// Respuestas del servidor al cliente con mensajes JSON
// ----------------------------------------------------------------------------
//
namespace Utils;

class JSONServerResponse {
    
    /**
     * Envía una respuesta JSON con estado de éxito.
     *
     * @param string $message El mensaje de éxito
     * @param array $data Los datos adicionales a enviar
     * @param int $statusCode El código de estado HTTP (por defecto 200)
     */
    public static function success($message, $data = [], $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode([
            'status' => 'success',
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data
        ]);
        exit;
    }

    /**
     * Envía una respuesta JSON con estado de error.
     *
     * @param string $message El mensaje de error
     * @param int $statusCode El código de estado HTTP
     */
    public static function error($message, $statusCode) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode([
            'status' => 'error',
            'statusCode' => $statusCode,
            'message' => $message
        ]);
        exit;
    }
}
?>
