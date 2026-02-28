<?php
require('core/header.php');
require('core/connection.php');

if (isset($_SESSION['loggedin'])) {
    header("Location: home.php"); // Redirect to the home page if already logged in
    exit;
}

if (isset($_POST['submit'])) {
    $stmt = $pdo->prepare('SELECT * FROM customer WHERE email = :email');
    $values = [
        'email' => $_POST['email'],
    ];
    $stmt->execute($values);
    $customer = $stmt->fetch();

    if ($customer && password_verify($_POST['customerPassword'], $customer['customerPassword'])) {
        session_start();
        $_SESSION['loggedin'] = $customer['customerId'];
        header("Location: home.php"); // Redirect to the home page or any other desired page
        exit;
    } else {
        $loginError = 'User not found or invalid password';
    }
}
?>
<main>
    <h2>Login</h2>
    <link rel="stylesheet" href="core/styles.css">
    <?php if (isset($loginError)) : ?>
        <p><?php echo $loginError; ?></p>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label>Email:</label>
        <input type="text" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="userPassword" required><br>
        <input type="submit" name="submit" value="Log in">
    </form>
</main>
<?php require('core/footer.php'); ?>