<?php require_once __DIR__ . '/../../config/database.php'; ?>

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
        include_once(__DIR__ . '/../../views/templates/header/header.php');
        ?>
    </div>

    <!-- start --> 
    <div class="main-container">
        <div class="left-container">
            <img src="../../assets/user_bg.jpg" alt="User Background">
        </div>
        <div class="right-container">
            <div class="quote-text" style="margin-left: 50px; margin-top: -150px;">
                Elegance is the only beauty that never fades.<br><br>
                Jewelry is eternal — it never goes out of style and remains timeless.
            </div>
            <a href="/projet_php/public/user/user_product.php" class="btn_sign" style="margin-left: 40px; margin-top: 20px; display: inline-block;">View Shop</a>
        </div>
    </div>
    <!-- end -->
    
    <div class="white-container">
        <?php
        include_once(__DIR__ . '/../../views/templates/footer/footer.php');
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>