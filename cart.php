<?php
session_start();
require_once 'db_connect.php';

// Retrieve the cart from session (associative array: shoe_id => quantity)
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

// If the cart is empty, set products to an empty array.
if (empty($cart)) {
    $products = array();
} else {
    // Get all product IDs from the cart
    $productIDs = array_keys($cart);
    $ids = implode(',', $productIDs);
    // Retrieve product details from the database
    $sql = "SELECT * FROM shoes WHERE shoe_id IN ($ids)";
    $result = $conn->query($sql);
    $products = array();
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Flag to check if any product is missing available options
$missingOptions = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Your Cart - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { 
      font-family: Arial, sans-serif; 
      /* Updated background image to logo.jpg */
      background: url('logo.jpg') no-repeat center center/cover; 
    }
    .cart-container { 
      padding: 40px 0; 
      background: rgba(255,255,255,0.9); 
      margin-top: 20px; 
      border-radius: 8px; 
    }
    .table img { 
      width: 50px; 
      height: 50px; 
      object-fit: cover; 
      border-radius: 5px; 
    }
    .order-summary-img { 
      width: 120px; 
      height: auto; 
      object-fit: cover; 
      border-radius: 5px; 
    }
    .btn-custom { 
      background: blue; 
      color: white; 
      border: none; 
    }
    .btn-custom:hover { 
      background: red; 
    }
    .form-select { 
      width: 150px; 
    }
  </style>
</head>
<body>
  <!-- Optionally include your header file -->
  <?php // include 'header.php'; ?>
  
  <div class="container cart-container">
    <h2 class="mb-4 text-center"><i class="fas fa-shopping-cart"></i> Your Shopping Cart</h2>
    
    <?php if (empty($cart)): ?>
      <p class="text-center">Your cart is empty.</p>
      <div class="text-center">
        <a href="index.php" class="btn btn-primary">
          <i class="fas fa-shopping-bag"></i> Continue Shopping
        </a>
      </div>
    <?php else: ?>
      <?php
      // Check each product for available sizes and colors
      foreach ($products as $product) {
          // Available sizes: use provided available_sizes or default list
          if (isset($product['available_sizes']) && !empty($product['available_sizes'])) {
              $sizes = array_map('trim', explode(',', $product['available_sizes']));
          } else {
              $sizes = array("35", "36", "37", "38", "39", "40", "41", "42", "43", "44");
          }
          sort($sizes);
          if (count($sizes) == 1 && $sizes[0] == 'N/A') {
              $missingOptions = true;
          }
          
          // Available colors: use provided available_colors or default list
          if (isset($product['available_colors']) && !empty($product['available_colors'])) {
              $colors = array_map('trim', explode(',', $product['available_colors']));
          } else {
              $colors = array("Black", "White", "Blue", "Red", "Green", "Yellow", "Brown", "Gray");
          }
          sort($colors);
          if (count($colors) == 1 && $colors[0] == 'N/A') {
              $missingOptions = true;
          }
      }
      ?>
      <?php if ($missingOptions): ?>
        <div class="alert alert-warning text-center">
          One or more products in your cart do not have your desired size or color options available.
          Please <a href="index.php" class="alert-link">continue shopping</a> to select an alternative.
        </div>
      <?php endif; ?>
      
      <form action="update_cart.php" method="POST">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Product</th>
              <th>Price</th>
              <th>Size</th>
              <th>Color</th>
              <th>Quantity</th>
              <th>Subtotal</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $total = 0;
              foreach ($products as $product):
                  $quantity = isset($cart[$product['shoe_id']]) ? $cart[$product['shoe_id']] : 0;
                  $subtotal = $product['price'] * $quantity;
                  $total += $subtotal;
                  
                  // Prepare available sizes
                  if (isset($product['available_sizes']) && !empty($product['available_sizes'])) {
                      $sizes = array_map('trim', explode(',', $product['available_sizes']));
                  } else {
                      $sizes = array("35", "36", "37", "38", "39", "40", "41", "42", "43", "44");
                  }
                  sort($sizes);
                  
                  // Prepare available colors
                  if (isset($product['available_colors']) && !empty($product['available_colors'])) {
                      $colors = array_map('trim', explode(',', $product['available_colors']));
                  } else {
                      $colors = array("Black", "White", "Blue", "Red", "Green", "Yellow", "Brown", "Gray");
                  }
                  sort($colors);
            ?>
            <tr>
              <td>
                <?php if (!empty($product['image'])): ?>
                  <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="order-summary-img">
                <?php else: ?>
                  <img src="placeholder.jpg" alt="Product Image" class="order-summary-img">
                <?php endif; ?>
                <br><?php echo htmlspecialchars($product['name']); ?>
              </td>
              <td>$<?php echo number_format($product['price'], 2); ?></td>
              <td>
                <select name="sizes[<?php echo $product['shoe_id']; ?>]" class="form-select" required>
                  <option value="" disabled selected>Select Size</option>
                  <?php foreach ($sizes as $s): ?>
                    <option value="<?php echo htmlspecialchars($s); ?>"><?php echo htmlspecialchars($s); ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td>
                <select name="colors[<?php echo $product['shoe_id']; ?>]" class="form-select" required>
                  <option value="" disabled selected>Select Color</option>
                  <?php foreach ($colors as $c): ?>
                    <option value="<?php echo htmlspecialchars($c); ?>"><?php echo htmlspecialchars($c); ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
              <td>
                <input type="number" name="quantities[<?php echo $product['shoe_id']; ?>]" value="<?php echo $quantity; ?>" min="1" class="form-control" style="width:80px;">
              </td>
              <td>$<?php echo number_format($subtotal, 2); ?></td>
              <td>
                <a href="remove_from_cart.php?shoe_id=<?php echo $product['shoe_id']; ?>" class="btn btn-danger btn-sm">
                  <i class="fas fa-trash"></i> Remove
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
            <tr>
              <td colspan="5" class="text-end"><strong>Total:</strong></td>
              <td colspan="2"><strong>$<?php echo number_format($total, 2); ?></strong></td>
            </tr>
          </tbody>
        </table>
        <div class="d-flex justify-content-between">
          <a href="index.php" class="btn btn-primary">
            <i class="fas fa-shopping-bag"></i> Continue Shopping
          </a>
          <div>
            <button type="submit" class="btn btn-secondary">
              <i class="fas fa-sync"></i> Update Cart
            </button>
            <a href="checkout.php" class="btn btn-success">
              <i class="fas fa-credit-card"></i> Checkout
            </a>
          </div>
        </div>
      </form>
    <?php endif; ?>
  </div>
  
  <!-- Optionally include your footer file -->
  <?php // include 'footer.php'; ?>
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
