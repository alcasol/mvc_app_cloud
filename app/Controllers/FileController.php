<?php
namespace App\Controllers;

use Core\Controller;
use Utils\Log;
use Utils\JSONServerResponse; // Asegúrate de importar la clase JSONServerResponse

class FileController extends Controller {

    /**
     * Carga la vista para el formulario de subida de archivos.
     */
    public function upload() {
        $this->view('file/upload');
    }

    /**
     * Maneja la subida de archivos al servidor.
     */
    public function uploadFile() {
        try {
            // Verificar si la solicitud es POST y si se ha subido un archivo
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
                $targetDir = UPLOAD_PATH . '/';
                $targetFile = $targetDir . basename($_FILES['file']['name']);
                $uploadOk = 1;

                // Verificar si el archivo ya existe
                if (file_exists($targetFile)) {
                    $errorMessage = "File already exists.";
                    Log::error($errorMessage);
                    JSONServerResponse::error($errorMessage, 400);
                }

                // Verificar el tamaño del archivo
                if ($_FILES['file']['size'] > 5242880) { // 5 MB
                    $errorMessage = "File is too large.";
                    Log::error($errorMessage);
                    JSONServerResponse::error($errorMessage, 400);
                }

                // Permitir ciertos formatos de archivo (opcional)
                $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
                if (!in_array($fileType, ["jpg", "jpeg", "png", "gif"])) {
                    $errorMessage = "Only JPG, JPEG, PNG & GIF files are allowed.";
                    Log::error($errorMessage);
                    JSONServerResponse::error($errorMessage, 400);
                }

                // Si no hay errores hasta este punto, intentar mover el archivo
                if ($uploadOk == 1) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
                        // Archivo subido correctamente
                        JSONServerResponse::success("The file ". htmlspecialchars(basename($_FILES['file']['name'])) . " has been uploaded.");
                    } else {
                        // Error al mover el archivo
                        $errorMessage = "There was an error uploading your file.";
                        $errorDetails = error_get_last();
                        Log::error($errorMessage, $errorDetails);
                        JSONServerResponse::error($errorMessage, 500);
                    }
                }
            } else {
                // No se subió ningún archivo o método de solicitud incorrecto
                $errorMessage = "No file was uploaded or incorrect request method.";
                Log::error($errorMessage);
                JSONServerResponse::error($errorMessage, 400);
            }
        } catch (\Exception $e) {
            // Capturar cualquier excepción no manejada
            $errorMessage = "An error occurred: " . $e->getMessage();
            $errorDetails = [
                'type' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ];
            Log::error($errorMessage, $errorDetails);
            JSONServerResponse::error("Internal Server Error", 500);
        }
    }
}
?>
