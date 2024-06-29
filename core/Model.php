<?php
// ----------------------------------------------------------------------------
// core/Model.php
// ----------------------------------------------------------------------------
// Necesario para realizar operaciones de base de datos y lógica de negocio.
// Sirve como una clase base para todos los modelos. Contiene la lógica 
// relacionada con la interacción con la base de datos (en este caso, inicializa
// la conexión a la base de datos).
// ----------------------------------------------------------------------------
// 
namespace Core;

class Model {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }
}
?>
