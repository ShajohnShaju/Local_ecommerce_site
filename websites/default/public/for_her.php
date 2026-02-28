<?php
require('core/header.php');
require('core/connection.php');

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'recent';
$sortingOptions = [
    'recent' => 'created_at DESC',
    'az' => 'name ASC',
    'za' => 'name DESC',
    'price_up' => 'price ASC',
    'price_down' => 'price DESC'
];
if (!array_key_exists($sort, $sortingOptions)) {
    $sort = 'recent';
}
$productsPerPage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $productsPerPage;

$query = "SELECT * FROM products WHERE category = gender = 'F' ORDER BY {$sortingOptions[$sort]} LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':limit', $productsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalProductsQuery = "SELECT COUNT(*) as total FROM products WHERE category = gender AND gender = 'F'";
$totalProductsResult = $pdo->query($totalProductsQuery);
$totalProducts = $totalProductsResult->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalProducts / $productsPerPage);
?>

<main>
    <h2>For Her</h2>
    <link rel="stylesheet" href="core/styles.css">
    <div class="sorting-options">
        <label for="sort">Sort By:</label>
        <select id="sort" name="sort" onchange="this.options[this.selectedIndex].value && (window.location = 'for_her.php?sort=' + this.options[this.selectedIndex].value)">
            <option value="recent" <?php echo ($sort === 'recent') ? 'selected' : ''; ?>>Recently Added</option>
            <option value="az" <?php echo ($sort === 'az') ? 'selected' : ''; ?>>Name (A-Z)</option>
            <option value="za" <?php echo ($sort === 'za') ? 'selected' : ''; ?>>Name (Z-A)</option>
            <option value="price_up" <?php echo ($sort === 'price_up') ? 'selected' : ''; ?>>Price (Low to High)</option>
            <option value="price_down" <?php echo ($sort === 'price_down') ? 'selected' : ''; ?>>Price (High to Low)</option>
        </select>
    </div>
    <div class="product-list">
        <?php foreach ($products as $product) : ?>
            <div class="product-item">
                <a href="product.php?id=<?php echo $product['product_id']; ?>">
                    <?php if (isset($product['image'])) : ?>
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <?php else : ?>
                        <img src="../pictures/placeholder_image.png" alt="Product Image Coming Soon">
                    <?php endif; ?>
                </a>
                <h3><?php echo $product['name']; ?></h3>
                <p><?php echo $product['price']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="pagination">
        <?php if ($totalPages > 1) : ?>
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <a href="for_her.php?sort=<?php echo $sort; ?>&page=<?php echo $i; ?>" <?php echo ($page === $i) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
            <?php endfor; ?>
        <?php endif; ?>
    </div>
</main>

    </div>
    <div class="pagination">
        <?php if ($totalPages > 1) : ?>
            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                <a href="for_her.php?sort=<?php echo $sort; ?>&page=<?php echo $i; ?>" <?php echo ($page === $i) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
            <?php endfor; ?>
        <?php endif; ?>
    </div>
</main>
<?php require('core/footer.php'); ?>