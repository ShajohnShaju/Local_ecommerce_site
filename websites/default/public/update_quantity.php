<?php
session_start();

require('core/header.php');
require('core/connection.php');

// Checks if the item index and quantity are provided
if (isset($_POST['item_index']) && isset($_POST['quantity'])) {
    $itemIndex = $_POST['item_index'];
    $quantity = $_POST['quantity'];

    // Update the quantity of the item in the cart
    if (isset($_SESSION['cart'][$itemIndex])) {
        $_SESSION['cart'][$itemIndex]['quantity'] = $quantity;
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Quantity</title>
</head>
<body>
    <h2>Updated Quantity...</h2>
    <a href="basket.php">Go back to the basket</a>
</body>
</html>
<?php require('core/footer.php');
?>