<?php
// ------------------------------------------------------------------------
// app/controllers/UserController.php
// ------------------------------------------------------------------------
// Este controlador maneja las solicitudes relacionadas con la página de 
// inicio (/). Cuando se llama al método index(), carga la vista 
// correspondiente (home/index.php).
// ------------------------------------------------------------------------
// 
namespace App\Controllers;
use Core\Controller;

class HomeController extends Controller {
    // index() --> vista 
    public function index() {
        $this->view('home/index');
    }
}

?>
