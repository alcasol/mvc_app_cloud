<?php
// ----------------------------------------------------------------------------
// core/Controller.php
// ----------------------------------------------------------------------------
// Proporciona funcionalidad para cargar modelos y vistas.
// Útil para la lógica de control y la interacción entre modelos y vistas en el
// patrón MVC.
// ------------------------------------------------------------------------
//
namespace Core;

class Controller {

    /**
     * Carga un modelo específico utilizando su nombre.
     *
     * @param string $model Nombre del modelo a cargar
     * @return object Instancia del modelo solicitado
     * @throws \Exception Si la clase del modelo no existe
     */
    public function model($model) {
        // Crear el nombre completo de la clase utilizando el namespace
        $modelClass = "App\\Models\\$model";

        // Verificar si la clase existe antes de intentar crear una instancia
        if (class_exists($modelClass)) {
            return new $modelClass();
        } else {
            throw new \Exception("Model class '$modelClass' not found. 2");
        }
    }

    /**
     * Carga una vista específica y pasa datos a la vista para su renderizado.
     *
     * @param string $view Nombre del archivo de vista a cargar
     * @param array $data Datos opcionales para pasar a la vista
     * @return void
     * @throws \Exception Si el archivo de vista no existe
     */
    public function view($view, $data = []) {
        // Construir la ruta completa de la vista
        $viewFile = APP_PATH . "views/$view.php";

        // Verificar si el archivo de vista existe
        if (file_exists($viewFile)) {
            // Extraer las variables de datos para la vista
            extract($data);

            // Incluir la vista
            require_once $viewFile;
        } else {
            throw new \Exception("View file '$viewFile' not found.");
        }
    }

}
?>
