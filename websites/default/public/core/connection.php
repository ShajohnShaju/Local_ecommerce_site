<?php
// this is the file that connects to the db
// it will be called into each page to allow for a connection
$server = "mysql";
$username = "student";
$password = "student";
$schema = "jw_jewellers";
$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
try {
    // Create a PDO connection
    $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection error
    die("Connection failed: " . $e->getMessage());
}