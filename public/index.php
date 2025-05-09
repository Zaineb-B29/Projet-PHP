 <?php require_once __DIR__ . '/../config/database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="white-container">
        <?php
        include_once(__DIR__ . '/../views/templates/header/header.html'); // Ensure this file exists
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
        include_once(__DIR__ . '/../views/templates/footer/footer.html'); // Ensure this file exists
        ?>
    </div>

</body>
</html>