<!-- calculate.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Calculate</title>
</head>
<body>
    <h1>Calculator for, 
        <?php echo (isset($_SESSION['username']) && $_SESSION['username']) ? $_SESSION['username'] : 'User'; ?>!
    </h1>
    <form id="mathForm">
        <label for="number1">Number 1:</label>
        <input type="number" id="number1" name="number1" required>
        <br>
        <label for="number2">Number 2:</label>
        <input type="number" id="number2" name="number2" required>
        <br>
        <label for="operation">Operation:</label>
        <select id="operation" name="operation" required>
            <option value="add">Addition</option>
            <option value="subtract">Subtraction</option>
            <option value="multiply">Multiplication</option>
            <option value="divide">Division</option>
        </select>
        <br>
        <button type="submit">Calculate</button>
    </form>

    <div id="result"></div>

    <script type="module" src="<?php echo BASE_URL; ?>/js/math.js"></script>
    <a href="<?php echo BASE_URL; ?>/user/logout">Logout</a>
    <a href="<?php echo BASE_URL; ?>/user/profile">Profile</a>
</body>
</html>
