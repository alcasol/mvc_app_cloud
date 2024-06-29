<?php
// ------------------------------------------------------------------------
// config/routes.php
// ------------------------------------------------------------------------
// Define las rutas junto con los controladores y métodos que debe manejar 
// cada ruta
// ------------------------------------------------------------------------
return [
    '' => ['handler' => 'HomeController@index', 'method' => 'GET'],
    'user/register' => ['handler' => 'UserController@register', 'method' => 'GET'],
    'user/create' => ['handler' => 'UserController@create', 'method' => 'POST'],
    'user/profile' => ['handler' => 'UserController@profile', 'method' => 'GET'],
    'user/login' => ['handler' => 'AuthController@login', 'method' => 'GET'],
    'user/authenticate' => ['handler' => 'AuthController@authenticate', 'method' => 'POST'],
    'user/logout' => ['handler' => 'AuthController@logout', 'method' => 'GET'],
    'dividir' => ['handler' => 'MathController@dividir', 'method' => 'GET'],
    'user/delete' => ['handler' => 'UserController@delete', 'method' => 'GET'],
    'user/deleteUser' => ['handler' => 'UserController@deleteUser', 'method' => 'DELETE'],
    'file/upload' => ['handler' => 'FileController@upload', 'method' => 'GET'],
    'file/uploadFile' => ['handler' => 'FileController@uploadFile', 'method' => 'POST'],
    'env' => ['handler' => 'ConfigController@env', 'method' => 'GET'],
    'math' => ['handler' => 'MathController@math', 'method' => 'GET'],
    'math/calculate' => ['handler' => 'MathController@calculate', 'method' => 'POST'],
];
?>
