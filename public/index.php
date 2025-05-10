<?php require_once __DIR__ . '/../config/database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="/projet_php/public/style.css">
</head>
<body>
    <div class="white-container">
        <?php
        include_once(__DIR__ . '/../views/templates/header/header.php');
        ?>
    </div>

    <!-- From Uiverse.io by marcelodolza --> 
    <div class="middlecontainer">
        <!-- Placeholder for future content -->
         <h4>this is the middle part</h4>
    </div>

    <!-- Your content here -->

    <div class="white-container">
        <?php
        include_once(__DIR__ . '/../views/templates/footer/footer.php');
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>