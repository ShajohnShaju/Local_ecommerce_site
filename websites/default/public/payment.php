<?php
require('core/header.php');
require('core/connection.php');

// Check if the customer is logged in
if (!isset($_SESSION['customer_id'])) {
    // Redirect to the login page if not logged in
    header('Location: login.php');
    exit();
}

// Get the customer ID from the session
$customerId = $_SESSION['customer_id'];

// Retrieve customer details from the database
$query = "SELECT * FROM customers WHERE customer_id = :customerId";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
$stmt->execute();
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the customer details are found
if (!$customer) {
    // Redirect to the checkout page if customer details are not found
    header('Location: checkout.php');
    exit();
}

// Process the payment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve payment information from the form
    $cardNumber = $_POST['card_number'];
    $expirationMonth = $_POST['expiration_month'];
    $expirationYear = $_POST['expiration_year'];
    $cvv = $_POST['cvv'];

 
    $orderConfirmationNumber = generateOrderConfirmationNumber();

    // Insert the order details into the orders table
    $insertQuery = "INSERT INTO orders (order_id, customer_id, order_date, total_amount, house_number, street_name, city, country, postcode, mob_number)
                    VALUES (:order_id, :customer_id, :order_date, :total_amount, :house_number, :street_name, :city, :country, :postcode, :mob_number)";
    $insertStmt = $pdo->prepare($insertQuery);
    $insertStmt->bindParam(':order_id', $orderConfirmationNumber, PDO::PARAM_STR);
    $insertStmt->bindParam(':customer_id', $customerId, PDO::PARAM_INT);
    $insertStmt->bindValue(':order_date', date('Y-m-d'), PDO::PARAM_STR);
    $insertStmt->bindValue(':total_amount', 0, PDO::PARAM_INT); // Set the initial value as 0
    $insertStmt->bindParam(':house_number', $customer['house_number'], PDO::PARAM_STR);
    $insertStmt->bindParam(':street_name', $customer['street_name'], PDO::PARAM_STR);
    $insertStmt->bindParam(':city', $customer['city'], PDO::PARAM_STR);
    $insertStmt->bindParam(':country', $customer['country'], PDO::PARAM_STR);
    $insertStmt->bindParam(':postcode', $customer['postcode'], PDO::PARAM_STR);
    $insertStmt->bindParam(':mob_number', $customer['mob_number'], PDO::PARAM_STR);
    $insertStmt->execute();

    // Redirect to the order confirmation page with the order confirmation number
    header('Location: order_confirmation.php?order_id=' . $orderConfirmationNumber);
    exit();
}

// Function to generate a unique order confirmation number
function generateOrderConfirmationNumber()
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length = 10;
    $orderConfirmationNumber = '';

    for ($i = 0; $i < $length; $i++) {
        $orderConfirmationNumber .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $orderConfirmationNumber;
}
?>

<main>
    <h2>Payment Information</h2>
    <link rel="stylesheet" href="core/styles.css">
    <form method="POST" action="checkout.php">
        <label for="card_number">Card Number:</label>
        <input type="text" id="card_number" name="card_number" required>

        <label for="expiration_month">Expiration Month:</label>
        <input type="text" id="expiration_month" name="expiration_month" required>

        <label for="expiration_year">Expiration Year:</label>
        <input type="text" id="expiration_year" name="expiration_year" required>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required>

        <button type="submit">Submit Payment</button>
    </form>
</main>
<?php require('core/footer.php'); ?>