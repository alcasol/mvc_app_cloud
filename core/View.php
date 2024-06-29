<?php
// ----------------------------------------------------------------------------
// core/View.php
// ----------------------------------------------------------------------------
// Útil para la presentación de datos al usuario final.
// Ofrece un método estático para renderizar vistas. Simplifica el proceso de 
// cargar y mostrar vistas, permitiendo la pasarela de datos a las mismas.
// ----------------------------------------------------------------------------
// 
namespace Core;

class View {
    /**
     * Renderiza una vista específica y pasa datos a la vista para su renderizado.
     *
     * @param string $view Nombre del archivo de vista a cargar
     * @param array $data Datos opcionales para pasar a la vista
     * @return void
     */
    public static function render($view, $data = []) {
        extract($data);
        require_once "../app/views/$view.php";
    }
}
?>
