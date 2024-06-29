<!-- profile.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
    <h1>Welcome to your profile, 
        <?php echo (isset($_SESSION['username']) && $_SESSION['username']) ? $_SESSION['username'] : 'User'; ?>!
    </h1>
    <a href="<?php echo BASE_URL; ?>/user/logout">Logout</a>
    <a href="<?php echo BASE_URL; ?>/math">calculadora</a>
</body>
</html>
