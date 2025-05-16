<?php require_once __DIR__ . '/../../config/database.php'; ?>
<?php
    require_once __DIR__ . '/../../models/Produit.php';
    $produitModel = new Produit();
    $stmt = $produitModel->getAllProducts();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

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

    <div class="container mt-4 mb-4">
        <h2 class="mb-4">Our Products</h2>
        <?php if (empty($products)): ?>
            <div class="alert alert-warning">No products found.</div>
        <?php else: ?>
        <table class="table table-bordered table-striped">
            <tbody>
            <?php
            $count = 0;
            foreach ($products as $product):
                if ($count % 3 == 0) echo '<tr>';
            ?>
                <td style="vertical-align:top; text-align:center; width:33%;">
                    <div class="card h-100">
                        <?php if (!empty($product['photo'])): ?>
                            <?php
                            // Normalize the photo path to avoid double slashes and ensure correct path
                            $photoFile = ltrim($product['photo'], '/\\');
                            $photoPath = '/projet_php/' . $photoFile;
                            ?>
                            <img src="<?= htmlspecialchars($photoPath) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['libelle']) ?>" style="max-height:180px; width:100%; object-fit:contain;">
                        <?php else: ?>
                            <div style="height:180px; display:flex; align-items:center; justify-content:center; background:#f8f9fa; color:#aaa;">No Image</div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['libelle']) ?></h5>
                            <p class="card-text">Price: <?= htmlspecialchars($product['prix']) ?> DT</p>
                            <p class="card-text">Description: <?= htmlspecialchars($product['description']) ?></p>
                            <a href="#" class="btn btn-primary mt-2" onclick="event.preventDefault(); fetch('cart.php?add=<?= $product['id'] ?>').then(() => location.reload());">Add to Cart</a>
                        </div>
                    </div>
                </td>
            <?php
                $count++;
                if ($count % 3 == 0) echo '</tr>';
            endforeach;
            if ($count % 3 != 0) {
                for ($i = 0; $i < 3 - ($count % 3); $i++) {
                    echo '<td></td>';
                }
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

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