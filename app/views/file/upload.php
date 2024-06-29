<!-- app/views/upload.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/styles.css">
    <script type="module" src="<?php echo BASE_URL; ?>/js/env.js"></script>
</head>
<body>
     <!-- Incluir el menú -->
     <?php include VIEW_PATH . 'includes/menu.php'; ?>
     
    <h1>Upload File</h1>
    <form id="uploadForm" enctype="multipart/form-data">
        <label for="file">Select file to upload:</label>
        <input type="file" name="file" id="file">
        <br>
        <button type="submit">Upload</button>
    </form>
    <div id="salida"></div>
    <script type="module" src="<?php echo BASE_URL; ?>/js/upload.js"></script>
</body>
</html>
