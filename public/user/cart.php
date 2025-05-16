<?php
session_start();
// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart if product_id is passed
if (isset($_GET['add'])) {
    $productId = intval($_GET['add']);
    $_SESSION['cart'][] = $productId; // Always add, allow duplicates
    header('Location: cart.php');
    exit();
}

// Handle remove from cart
if (isset($_POST['remove_id'])) {
    $removeId = intval($_POST['remove_id']);
    if (($key = array_search($removeId, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
        // Re-index the array to avoid gaps
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header('Location: cart.php');
    exit();
}

require_once __DIR__ . '/../../models/Produit.php';
$produitModel = new Produit();
$cartProducts = [];
$cartQuantities = [];
if (!empty($_SESSION['cart'])) {
    // Count quantities for each product id
    foreach ($_SESSION['cart'] as $pid) {
        if (!isset($cartQuantities[$pid])) {
            $cartQuantities[$pid] = 0;
        }
        $cartQuantities[$pid]++;
    }
    $ids = implode(',', array_map('intval', array_keys($cartQuantities)));
    $stmt = $produitModel->getAllProducts();
    $allProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($allProducts as $product) {
        if (isset($cartQuantities[$product['id']])) {
            $product['quantity'] = $cartQuantities[$product['id']];
            $cartProducts[] = $product;
        }
    }
}

$totalPrice = 0;
foreach ($cartProducts as $product) {
    $totalPrice += $product['prix'] * $product['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/projet_php/public/style.css">
</head>
<body>
    <div class="container mt-4 mb-4">
        <h2 class="mb-4">My Cart</h2>
        <?php if (empty($cartProducts)): ?>
            <div class="alert alert-info">Your cart is empty.</div>
        <?php else: ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($cartProducts as $product): ?>
                    <tr>
                        <td style="width:120px;">
                            <?php if (!empty($product['photo'])): ?>
                                <img src="/projet_php/<?= htmlspecialchars($product['photo']) ?>" alt="<?= htmlspecialchars($product['libelle']) ?>" style="max-width:100px; max-height:100px; object-fit:contain;">
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($product['libelle']) ?></td>
                        <td><?= htmlspecialchars($product['prix']) ?> DT</td>
                        <td><?= htmlspecialchars($product['stock']) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td><span class="badge badge-info" style="font-size:1em; padding:6px 12px;">x<?= $product['quantity'] ?></span></td>
                        <td>
                            <form method="post" action="cart.php" style="display:inline;">
                                <input type="hidden" name="remove_id" value="<?= $product['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-right mt-3">
                <h4>Total Price: <span class="badge badge-success" style="font-size:1.1em; padding:8px 18px;"><?= number_format($totalPrice, 2) ?> DT</span></h4>
            </div>
        <?php endif; ?>
        <a href="user_product.php" class="btn btn-secondary mt-3">Continue Shopping</a>
    </div>
</body>
</html>
