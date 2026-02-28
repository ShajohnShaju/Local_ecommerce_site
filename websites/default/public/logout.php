<?php
require('core/header.php');
require('core/connection.php');

session_start();
unset($_SESSION['loggedin']);
echo 'You are logged out.';
echo '<p><a href="login.php">Click here to log back in</a></p>';

require('core/footer.php');
?>
