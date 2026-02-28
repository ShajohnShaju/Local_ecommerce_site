<!DOCTYPE html>
<html>
<head>
    <title>JW Jewellers</title>
    <link rel="stylesheet" href="core/styles.css">
</head>
<body>
    <header>
        <div class="basket">
            <a href="basket.php">
                <img src="basket-icon.png" alt="Basket Icon">
                <?php
                // Check if the cart session variable exists
                if (isset($_SESSION['cart'])) {
                    $cartCount = count($_SESSION['cart']);
                    echo "<span class='basket-count'>$cartCount</span>";
                }
                ?>
                <span class="basket-text">Basket</span>
            </a>
        </div>

        <h1>JW Jewellers</h1>
        <form action="search.php" method="GET" class="search-form">
    <input type="text" name="query" placeholder="Search...">
    <input type="submit" value="Search">
</form>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="category.php">Category</a></li>
                <li><a href="for_him.php">For Him</a></li>
                <li><a href="for_her.php">For Her</a></li>
                <li><a href="jewellery.php">Jewellery</a></li>
                <li><a href="watches.php">Watches</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        
    </main>
</body>
</html>