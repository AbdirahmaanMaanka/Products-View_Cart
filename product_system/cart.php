<?php
session_start();
include 'products.php';

// Remove item from cart
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    unset($_SESSION['cart'][$product_id]);
    header("Location: cart.php");
    exit();
}

// Calculate total and prepare WhatsApp message
$total = 0;
$whatsapp_message = "Order Details:\n";

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $quantity) {
        $product = $products[$id];
        $total += $product['price'] * $quantity;
        $whatsapp_message .= "- " . $product['name'] . " (x" . $quantity . "): $" . number_format($product['price'], 2) . "\n";
    }
    $whatsapp_message .= "Total: $" . number_format($total, 2);
}

// WhatsApp link
$phone_number = '252616346244'; // Replace with your WhatsApp number
$whatsapp_url = "https://wa.me/$phone_number?text=" . urlencode($whatsapp_message);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <style>
        /* Style to mimic your design */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        nav {
            background-color: #333;
            padding: 10px;
            text-align: center;
        }
        nav a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        .cart-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        table th {
            background-color: #f4f4f4;
        }
        .btn {
            display: inline-block;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn.remove {
            background-color: #f44336;
            color: #fff;
        }
        .btn.checkout {
            background-color: #28a745;
            color: #fff;
            text-align: center;
            display: block;
            width: 100%;
        }
        h3 {
            text-align: right;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="index.php">Product</a>
        <a href="cart.php">View Cart</a>
    </nav>

    <h1>Your Cart</h1>

    <div class="cart-container">
        <?php if (!empty($_SESSION['cart'])): ?>
            <table>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Remove</th>
                </tr>
                <?php foreach ($_SESSION['cart'] as $id => $quantity): 
                    $product = $products[$id];
                ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']); ?></td>
                    <td>$<?= number_format($product['price'], 2); ?></td>
                    <td><?= htmlspecialchars($quantity); ?></td>
                    <td>
                        <a href="cart.php?remove=<?= $id; ?>" class="btn remove">Remove</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <h3>Total: $<?= number_format($total, 2); ?></h3>
            <a href="<?= $whatsapp_url; ?>" class="btn checkout" target="_blank">Proceed to Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</body>
</html>
  