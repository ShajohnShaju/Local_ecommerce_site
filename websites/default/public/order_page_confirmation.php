<?php
require('core/header.php');
require('core/connection.php');

// Retrieve the customer ID from the session variable
$customerId = $_SESSION['customer_id'];

// Generate a unique order ID (example: timestamp + customer ID)
$orderID = time() . $customerId;

// Retrieve customer details from the database
$query = "SELECT * FROM customers WHERE customer_id = :customer_id";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':customer_id', $customerId, PDO::PARAM_INT);
$stmt->execute();
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

// Insert the order into the orders table
$insertQuery = "INSERT INTO orders (order_id, customer_id, order_date, total_amount, house_number, street_name, city, country, postcode, mob_number)
                VALUES (:order_id, :customer_id, NOW(), :total_amount, :house_number, :street_name, :city, :country, :postcode, :mob_number)";
$insertStmt = $pdo->prepare($insertQuery);
$insertStmt->bindValue(':order_id', $orderID, PDO::PARAM_STR);
$insertStmt->bindValue(':customer_id', $customerId, PDO::PARAM_INT);
$insertStmt->bindValue(':total_amount', $_SESSION['total_amount'], PDO::PARAM_INT); // Assuming you have stored the total amount in a session variable
$insertStmt->bindValue(':house_number', $_SESSION['house_number'], PDO::PARAM_STR); // Assuming you have stored the address details in session variables
$insertStmt->bindValue(':street_name', $_SESSION['street_name'], PDO::PARAM_STR);
$insertStmt->bindValue(':city', $_SESSION['city'], PDO::PARAM_STR);
$insertStmt->bindValue(':country', $_SESSION['country'], PDO::PARAM_STR);
$insertStmt->bindValue(':postcode', $_SESSION['postcode'], PDO::PARAM_STR);
$insertStmt->bindValue(':mob_number', $_SESSION['mob_number'], PDO::PARAM_STR);
$insertStmt->execute();

// Display the order confirmation
?>

<main>
    <h2>Order Confirmation</h2>
    <p>Thank you for your order! Your order has been placed successfully.</p>
    <p>Order Number: <?php echo $orderID; ?></p>
    <h3>Order Details:</h3>
    <p>Total Amount: £<?php echo $_SESSION['total_amount']; ?></p> 
    <p>Customer Details:</p>
    <ul>
        <li>First Name: <?php echo $customer['first_name']; ?></li>
        <li>Surname: <?php echo $customer['surname']; ?></li>
        <li>House Number: <?php echo $_SESSION['house_number']; ?></li> 
        <li>Street Name: <?php echo $_SESSION['street_name']; ?></li>
        <li>City: <?php echo $_SESSION['city']; ?></li>
        <li>Country: <?php echo $_SESSION['country']; ?></li>
        <li>Postcode: <?php echo $_SESSION['postcode']; ?></li>
        <li>Mobile Number: <?php echo $_SESSION['mob_number']; ?></li>
    </ul>
</main>

<?php require ('core/footer.php'); ?>