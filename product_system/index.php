<?php
session_start();
include 'products.php';

// Add to cart
if (isset($_GET['add_to_cart'])) {
    $product_id = $_GET['add_to_cart'];
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = 1;
    } else {
        $_SESSION['cart'][$product_id]++;
    }
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="index.php">Product</a>
        <a href="cart.php">View Cart</a>
    </nav>
    <h1>Our Products</h1>
    <div class="product-container">
        <?php foreach ($products as $id => $product): ?>
            <div class="product">
                <img src="<?= $product['image']; ?>" alt="<?= $product['name']; ?>">
                <h3><?= $product['name']; ?></h3>
                <p>$<?= number_format($product['price'], 2); ?></p>
                <a href="index.php?add_to_cart=<?= $id; ?>" class="btn">Add to Cart</a>
            </div>
            
        <?php endforeach; ?>
    </div>
</body>
</html>
