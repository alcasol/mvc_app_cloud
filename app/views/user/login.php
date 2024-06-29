<!-- login.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <!-- Incluir el menú -->
    <?php include VIEW_PATH . 'includes/menu.php'; ?>
    
    <h1>Login</h1>
    <form method="post" action="<?php echo BASE_URL; ?>/user/authenticate">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
