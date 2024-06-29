<?php
// ----------------------------------------------------------------------------
// core/Router.php
// ----------------------------------------------------------------------------
// Esta clase facilita el enrutamiento de solicitudes HTTP a controladores y
// métodos específicos dentro de una aplicación PHP, siguiendo un patrón básico
// de enrutamiento.
// ----------------------------------------------------------------------------

namespace Core;

class Router {

    protected $routes = [];

    /**
     * Registra una ruta GET con su handler correspondiente.
     *
     * @param string $route La ruta URL a la que se va a acceder
     * @param string $handler El controlador y método a ejecutar cuando se acceda a la ruta
     * @return void
     */
    public function get($route, $handler) {
        $this->routes['GET'][$route] = $handler;
    }

    /**
     * Registra una ruta POST con su handler correspondiente.
     *
     * @param string $route La ruta URL a la que se va a acceder
     * @param string $handler El controlador y método a ejecutar cuando se acceda a la ruta
     * @return void
     */
    public function post($route, $handler) {
        $this->routes['POST'][$route] = $handler;
    }

    /**
     * Registra una ruta PUT con su handler correspondiente.
     *
     * @param string $route La ruta URL a la que se va a acceder
     * @param string $handler El controlador y método a ejecutar cuando se acceda a la ruta
     * @return void
     */
    public function put($route, $handler) {
        $this->routes['PUT'][$route] = $handler;
    }

    /**
     * Registra una ruta DELETE con su handler correspondiente.
     *
     * @param string $route La ruta URL a la que se va a acceder
     * @param string $handler El controlador y método a ejecutar cuando se acceda a la ruta
     * @return void
     */
    public function delete($route, $handler) {
        $this->routes['DELETE'][$route] = $handler;
    }

    /**
     * Maneja una solicitud HTTP en base a la URL y el método HTTP especificados.
     * Incluye dinámicamente el archivo del controlador, crea una instancia del
     * controlador y llama al método correspondiente.
     *
     * @param string $url La URL solicitada
     * @param string $method El método HTTP de la solicitud (GET, POST, PUT, DELETE, OPTIONS, etc.)
     * @return void
     */
    public function handle($url, $method) {
        // ---------------------------------------------------------
        // RAIOLANETWORKS
        // Configuración de CORS
        // ---------------------------------------------------------
        /*
        header("Access-Control-Allow-Origin: https://rafibrasuite.com");
        header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        // Manejo de la solicitud preflight
        if ($method == 'OPTIONS') {
            http_response_code(200);
            exit();
        }
        */

        $handler = $this->routes[$method][$url] ?? false;

        if (!$handler) {
            // Manejar error 404
            http_response_code(404);
            echo "404 - Not Found";
            return;
        }

        // Separar el controlador y el método
        list($controller, $method) = explode('@', $handler);

        // Incluir el archivo del controlador si aún no está incluido
        $controllerFile = "../app/controllers/{$controller}.php";
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        } else {
            // Manejar error de controlador no encontrado
            http_response_code(500);
            echo "Error: Controller {$controller} not found";
            return;
        }

        // Construir el nombre completo de la clase controlador
        $controllerClass = "App\\Controllers\\{$controller}";

        // Crear una instancia del controlador
        $controllerInstance = new $controllerClass();

        // Llamar al método del controlador y pasar los parámetros necesarios
        $controllerInstance->{$method}();
    }
}
?>
