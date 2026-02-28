<?php

require('core/header.php');
require('core/connection.php');

// Check if the search query is provided as a GET parameter
if (isset($_GET['query'])) {
  $searchQuery = $_GET['query'];

  // Prepare the query to search for products by product name or product ID
  $query = "SELECT * FROM products WHERE name LIKE :searchQuery OR product_id = :searchQuery";
  $stmt = $pdo->prepare($query);
  $stmt->bindValue(':searchQuery', "%$searchQuery%", PDO::PARAM_STR);
  $stmt->execute();
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Display the search results
  if (count($products) > 0) {
    echo "<h2>Search Results:</h2>";
    echo "<ul>";
    foreach ($products as $product) {
      echo "<li>Product ID: " . $product['product_id'] . ", Product Name: " . $product['name'] . " <a href='product.php?id=" . $product['product_id'] . "'>View Product</a></li>";
    }
    echo "</ul>";
  } else {
    echo "<h2>No results found.</h2>";
  }
}
else {
  echo "Invalid request.";
}

require('core/footer.php');
