<?php
require('core/header.php');
require('core/connection.php');

// Check if the user is logged in
$isLoggedIn = false; // Set it to true if the user is logged in

// Initialize variables for form fields
$firstName = '';
$surname = '';
$houseNumber = '';
$streetName = '';
$city = '';
$country = '';
$postcode = '';
$mobileNumber = '';
$email = '';
$username = '';

// Check if the user is logged in and retrieve their details from the database
if ($isLoggedIn) {
    // Retrieve customer details from the database based on their login information
    $customerId = 1; // Replace with the actual customer ID from the logged-in user
    $customerQuery = "SELECT * FROM customers WHERE customer_id = :customerId";
    $customerStmt = $pdo->prepare($customerQuery);
    $customerStmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
    $customerStmt->execute();
    $customer = $customerStmt->fetch(PDO::FETCH_ASSOC);

    // Populate the form fields with the customer details
    $firstName = $customer['first_name'];
    $surname = $customer['surname'];
    $houseNumber = $customer['house_number'];
    $streetName = $customer['street_name'];
    $city = $customer['city'];
    $country = $customer['country'];
    $postcode = $customer['postcode'];
    $mobileNumber = $customer['mob_number'];
    $email = $customer['email'];
    $username = $customer['username'];
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $firstName = $_POST['first_name'];
    $surname = $_POST['surname'];
    $houseNumber = $_POST['house_number'];
    $streetName = $_POST['street_name'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $postcode = $_POST['postcode'];
    $mobileNumber = $_POST['mobile_number'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    // Validate the form data (you can add additional validation as needed)

    // Update or insert customer details into the database
    if ($isLoggedIn) {
        // Update existing customer details
        $updateQuery = "UPDATE customers SET first_name = :firstName, surname = :surname, house_number = :houseNumber, street_name = :streetName, city = :city, country = :country, postcode = :postcode, mob_number = :mobileNumber, username = :username WHERE customer_id = :customerId";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $updateStmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $updateStmt->bindParam(':houseNumber', $houseNumber, PDO::PARAM_STR);
        $updateStmt->bindParam(':streetName', $streetName, PDO::PARAM_STR);
        $updateStmt->bindParam(':city', $city, PDO::PARAM_STR);
        $updateStmt->bindParam(':country', $country, PDO::PARAM_STR);
        $updateStmt->bindParam(':postcode', $postcode, PDO::PARAM_STR);
        $updateStmt->bindParam(':mobileNumber', $mobileNumber, PDO::PARAM_STR);
        $updateStmt->bindParam(':username', $username, PDO::PARAM_STR);
        $updateStmt->bindParam(':customerId', $customerId, PDO::PARAM_INT);
        $updateStmt->execute();
    } else {
        // Insert new customer details
        $insertQuery = "INSERT INTO customer (first_name, surname, house_number, street_name, city, country, postcode, mob_number, email, username) VALUES (:firstName, :surname, :houseNumber, :streetName, :city, :country, :postcode, :mobileNumber, :email, :username)";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $insertStmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $insertStmt->bindParam(':houseNumber', $houseNumber, PDO::PARAM_STR);
        $insertStmt->bindParam(':streetName', $streetName, PDO::PARAM_STR);
        $insertStmt->bindParam(':city', $city, PDO::PARAM_STR);
        $insertStmt->bindParam(':country', $country, PDO::PARAM_STR);
        $insertStmt->bindParam(':postcode', $postcode, PDO::PARAM_STR);
        $insertStmt->bindParam(':mobileNumber', $mobileNumber, PDO::PARAM_STR);
        $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $insertStmt->bindParam(':username', $username, PDO::PARAM_STR);
        $insertStmt->execute();

        // Get the newly generated customer ID
        $customerId = $pdo->lastInsertId();
    }

    // Store the customer ID in a session variable for future use
    $_SESSION['customer_id'] = $customerId;

    // Redirect to the payment page
    header('Location: payment.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
   
</head>
<body>
    <h2>Checkout</h2>
    <form action="" method="POST">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo $firstName; ?>"><br>

        <label for="surname">Surname:</label>
        <input type="text" name="surname" id="surname" value="<?php echo $surname; ?>"><br>

        <label for="house_number">House Number:</label>
        <input type="text" name="house_number" id="house_number" value="<?php echo $houseNumber; ?>"><br>

        <label for="street_name">Street Name:</label>
        <input type="text" name="street_name" id="street_name" value="<?php echo $streetName; ?>"><br>

        <label for="city">City:</label>
        <input type="text" name="city" id="city" value="<?php echo $city; ?>"><br>

        <label for="country">Country:</label>
        <input type="text" name="country" id="country" value="<?php echo $country; ?>"><br>

        <label for="postcode">Postcode:</label>
        <input type="text" name="postcode" id="postcode" value="<?php echo $postcode; ?>"><br>

        <label for="mobile_number">Mobile Number:</label>
        <input type="text" name="mobile_number" id="mobile_number" value="<?php echo $mobileNumber; ?>"><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo $email; ?>"><br>

        <label for="username">Username:</label> <!-- Added username field -->
        <input type="text" name="username" id="username" value="<?php echo $username; ?>"><br>

        <input type="submit" value="Proceed to Payment">
    </form>
    <a href="basket.php">Go back to the basket</a>
</body>
</html>

<?php
require('core/footer.php');
?>