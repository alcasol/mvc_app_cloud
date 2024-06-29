<!-- app/views/user/delete.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
    <script type="module" src="<?php echo BASE_URL; ?>/js/delete.js"></script>
</head>
<body>
     <!-- Incluir el menú -->
     <?php include VIEW_PATH . 'includes/menu.php'; ?>
     
    <h1>Delete User</h1>
    <form id="deleteUserForm">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button id="btnDeleteUser">Delete User</button>
    </form>
    <div id="salida"></div>
</body>
</html>
