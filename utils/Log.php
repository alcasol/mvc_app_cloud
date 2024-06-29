<?php
// ----------------------------------------------------------------------------
// utils/Log.php
// ----------------------------------------------------------------------------
// Centraliza la funcionalidad de registro de errores y otros mensajes de la 
// aplicación
// ----------------------------------------------------------------------------

namespace Utils;

class Log {
    private static $logFile;

    /**
     * Inicializa la clase Log con la ruta del archivo de log.
     *
     * @return void
     */
    public static function init() {
        // Ajusta la ruta según la ubicación real de tu archivo de registro
        self::$logFile = LOG_PATH . 'error_log';
    }

    /**
     * Registra un mensaje de error en el archivo de log.
     *
     * @param string $message Mensaje de error a registrar.
     * @param array $details Detalles adicionales del error (opcional).
     * @return void
     * @throws \Exception Si la ruta del archivo de log no está configurada.
     */
    public static function error($message, $details = []) {
        self::writeLog("ERROR", $message, $details);
    }

    /**
     * Registra un mensaje informativo en el archivo de log.
     *
     * @param string $message Mensaje informativo a registrar.
     * @param array $details Detalles adicionales (opcional).
     * @return void
     * @throws \Exception Si la ruta del archivo de log no está configurada.
     */
    public static function info($message, $details = []) {
        self::writeLog("INFO", $message, $details);
    }

    /**
     * Registra un mensaje de debug en el archivo de log.
     *
     * @param string $message Mensaje de debug a registrar.
     * @param array $details Detalles adicionales (opcional).
     * @return void
     * @throws \Exception Si la ruta del archivo de log no está configurada.
     */
    public static function debug($message, $details = []) {
        self::writeLog("DEBUG", $message, $details);
    }

    /**
     * Método privado para escribir en el archivo de log.
     *
     * @param string $level Nivel del mensaje (ERROR, INFO, DEBUG).
     * @param string $message Mensaje a registrar.
     * @param array $details Detalles adicionales (opcional).
     * @return void
     * @throws \Exception Si la ruta del archivo de log no está configurada.
     */
    private static function writeLog($level, $message, $details = []) {
        if (empty(self::$logFile)) {
            throw new \Exception("Log file path is not set.");
        }

        // Obtener la IP del cliente
        $clientIp = $_SERVER['REMOTE_ADDR'];

        // Agregar detalles del error si están presentes
        $errorDetails = !empty($details) ? " Details: " . json_encode($details) : "";

        // Crear el mensaje de log
        $logMessage = date('Y-m-d H:i:s') . " [$level] - $message | IP: $clientIp$errorDetails" . PHP_EOL;

        // Escribir el mensaje de log en el archivo
        error_log($logMessage, 3, self::$logFile);
    }
}

// Inicializar la clase Log al cargar el archivo
Log::init();
?>
