<?php
session_start();
require('core/header.php');
require('core/connection.php');


// Check if the product ID is provided as a GET parameter
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    $quantity = 1; 

    // Retrieve the product details from the database
    $query = "SELECT * FROM products WHERE product_id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the product exists
    if ($product) {
        // Add the product to the cart
        $cartItem = [
            'id' => $product['product_id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity
        ];

        // Check if the cart session variable exists, otherwise create it
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product already exists in the cart, update the quantity
        $existingCartItem = null;
        foreach ($_SESSION['cart'] as $key => $item) {
            if ($item['id'] === $cartItem['id']) {
                $existingCartItem = $key;
                break;
            }
        }

        if ($existingCartItem !== null) {
            $_SESSION['cart'][$existingCartItem]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][] = $cartItem;
        }

        echo 'Product added to the cart.';
 } else {
        echo 'Product not found.';
    }
} else {
    echo 'Invalid request.';
} 

require('core/footer.php'); 
?>