<?php require_once __DIR__ . '/../config/database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="white-container">
        <?php
        include_once(__DIR__ . '/../views/templates/header/header.html');
        ?>
    </div>

    <div class="middlecontainer">
        <h4><?php echo "Hello"; ?> <?php echo "World!"; ?></h4>
    </div>

    <div class="white-container">
        <?php
        include_once(__DIR__ . '/../views/templates/footer/footer.html');
        ?>
    </div>

</body>
</html>