<?php require('core/header.php'); ?>
<?php require('core/connection.php'); ?>

<?php
// Check if the product ID is provided in the URL
if (!isset($_GET['id'])) {
    // Redirect to the product listing page if the ID is not provided
    header("Location: for_him.php");
    exit();
}

// Get the product ID from the URL
$productID = $_GET['id'];

// Fetch the product details from the database
$query = "SELECT * FROM products WHERE product_id = :productID";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect to the product listing page if the product does not exist
if (!$product) {
    header("Location: for_him.php");
    exit();
}
?>

<main>
<link rel="stylesheet" href="core/styles.css">
    <h2><?php echo $product['name']; ?></h2>
    <div class="product-details">
        <?php if (isset($product['image'])) : ?>
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        <?php else : ?>
            <img src="../pictures/placeholder_image.png" alt="Product Image Coming Soon">
        <?php endif; ?>
        <h3><?php echo $product['name']; ?></h3>
        <p>Price: £<?php echo $product['price']; ?></p>
        <p>Description: <?php echo $product['description']; ?></p>
        <form action="add_to_cart.php" method="get">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <button type="submit">Add to Cart</button>
        </form>
    </div>
</main>
<?php require('core/footer.php'); ?>
