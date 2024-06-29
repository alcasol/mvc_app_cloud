<!-- index.php -->
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/styles.css">
    <title>Home</title>
</head>
<body>
    <h1>
        <img src="<?php echo BASE_URL; ?>/img/mundo.jpeg" alt="Logo" width="50" height="50">
        ¡Hola, Mundo!
    </h1>

    <!-- Incluir el menú -->
    <?php include VIEW_PATH . 'includes/menu.php'; ?>
    
    <div class="content">
        <!-- Contenido de la página de inicio -->
        <h1>Bienvenido a la página de inicio</h1>
        <p>Este es el contenido de la página de inicio.</p>
    </div>
    
    <a href="<?php echo BASE_URL; ?>/user/login">Login</a>
    <a href="<?php echo BASE_URL; ?>/user/register">Register</a>
    <a href="<?php echo BASE_URL; ?>/user/delete">Delete</a>
    <a href="<?php echo BASE_URL; ?>/file/upload">Upload</a>
</body>
</html>
