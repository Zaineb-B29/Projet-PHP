<?php
require_once '../../models/Product.php';
$productModel = new Product();
$products = $productModel->getAll();
include '../templates/header.php';
?>
<h2>Products</h2>
<div class="row">
    <?php foreach ($products as $p): ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5><?= $p['libelle']; ?></h5>
                    <p>Price: <?= $p['prix']; ?> DT</p>
                    <p>Discount: <?= $p['discount']; ?>%</p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php include '../templates/footer.php'; ?>
