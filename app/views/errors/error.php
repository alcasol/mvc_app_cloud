<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            padding: 20px;
        }
        .error-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #f44336;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Error <?php echo htmlspecialchars($_GET['code']); ?></h1>
        <p><?php echo htmlspecialchars($_GET['message']); ?></p>
    </div>
</body>
</html>
