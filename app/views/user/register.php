<!-- register.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <!-- Incluir el menú -->
    <?php include VIEW_PATH . 'includes/menu.php'; ?>
     
    <p>Si se utiliza un formulario HTML tradicional, sin recoger el resultado mediante 
        JavaScript, el navegador envía automáticamente una solicitud HTTP (generalmente
        POST o GET, dependiendo del método especificado en el formulario) a la URL 
        especificada en el atributo action del formulario. Luego, el navegador carga
        la página de destino con la respuesta del servidor. En este caso, no se requiere
        JavaScript y el flujo es completamente manejado por el navegador y el servidor.
    </p>
    <h1>Register Tradicional</h1>
    <form method="post" action="<?php echo BASE_URL; ?>/user/create">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Register</button>
    </form>

    <h1>Register (Submit)</h1>
    <form id="registerForm" method="post" action="<?php echo BASE_URL; ?>/user/create">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
        <label for="submit-name">Name:</label>
        <input type="text" id="submit-name" name="name" required>
        <br>
        <label for="submit-phone">Phone:</label>
        <input type="text" id="submit-phone" name="phone" required>
        <br>
        <label for="submit-email">Email:</label>
        <input type="email" id="submit-email" name="email" required>
        <br>
        <label for="submit-username">Username:</label>
        <input type="text" id="submit-username" name="username" required>
        <br>
        <label for="submit-password">Password:</label>
        <input type="password" id="submit-password" name="password" required>
        <br>
        <button type="submit">Register</button>
    </form>

    <div id="responseMessage"></div>

    <script type="module" src="<?php echo BASE_URL; ?>/js/register.js"></script>

</body>
</html>
