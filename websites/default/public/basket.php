<?php
session_start();

require('core/header.php');
require('core/connection.php');



// Function to calculate the total value of the basket
// Function to calculate the total basket value
function calculateBasketTotal() {
    $total = 0;
  
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
      foreach ($_SESSION['cart'] as $item) {
        $price = floatval($item['price']);
        $quantity = intval($item['quantity']);
        $subtotal = $price * $quantity;
        $total += $subtotal;
      }
    }
  
    return $total;
  }

?>

<main>
  <h2>Basket</h2>
  <div class="basket-container">
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
      <?php foreach ($_SESSION['cart'] as $key => $item) : ?>
        <div class="basket-item">
          <img src="../pictures/W1.png" alt="For Him">
          <h3><?php echo $item['name']; ?></h3>
          <p>Price: £<?php echo $item['price']; ?></p>
          <p>Quantity: 
            <form action="update_quantity.php" method="post">
              <input type="hidden" name="item_index" value="<?php echo $key; ?>">
              <input type="number" name="quantity" min="1" value="<?php echo $item['quantity']; ?>">
              <button type="submit">Update</button>
            </form>
          </p>
        </div>
      <?php endforeach; ?>
      <div class="basket-total">
        <?php
        $total = calculateBasketTotal();
        echo 'Total: £' . number_format($total, 2);
        ?>
      </div>
      <div class="basket-actions">
        <a href="checkout.php" class="btn btn-primary">Checkout</a>
      </div>
    <?php else : ?>
      <p>Your basket is empty.</p>
    <?php endif; ?>
  </div>
</main>

<?php require('core/footer.php'); ?>