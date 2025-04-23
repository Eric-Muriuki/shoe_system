<?php
session_start();
require_once 'db_connect.php';

// Redirect if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

$cart = $_SESSION['cart'];
$productIDs = array_keys($cart);
$ids = implode(',', $productIDs);
$sql = "SELECT * FROM shoes WHERE shoe_id IN ($ids)";
$result = $conn->query($sql);
$products = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $quantity = $cart[$row['shoe_id']];
    $subtotal = $row['price'] * $quantity;
    $total += $subtotal;
    $row['quantity'] = $quantity;
    $row['subtotal'] = $subtotal;
    $products[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['shipping'] = array(
        'shipping_name'    => $_POST['shipping_name'],
        'shipping_address' => $_POST['shipping_address'],
        'shipping_phone'   => $_POST['shipping_phone']
    );
    $_SESSION['order_total'] = $total;
    header("Location: payment_methods.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fa;
    }
    .container.checkout-container {
      max-width: 960px;
      margin-top: 40px;
    }
    .checkout-card {
      background: #ffffff;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }
    .order-summary-img {
      width: 120px;
      height: auto;
      object-fit: cover;
      border-radius: 5px;
    }
    .shipping-details .input-group-text {
      background: #004085;
      color: #fff;
    }
    .btn-custom {
      background: #004085;
      color: white;
      border: none;
    }
    .btn-custom:hover {
      background: #003366;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="container checkout-container">
    <div class="checkout-card">
      <h2 class="mb-4"><i class="fas fa-shopping-cart"></i> Checkout</h2>
      <div class="row">
        <!-- Order Summary Section -->
        <div class="col-md-7">
          <h4>Order Summary</h4>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($products as $product): ?>
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
                <td><?php echo $product['quantity']; ?></td>
                <td>$<?php echo number_format($product['subtotal'], 2); ?></td>
              </tr>
              <?php endforeach; ?>
              <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td><strong>$<?php echo number_format($total, 2); ?></strong></td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Shipping Details Section -->
        <div class="col-md-5">
          <h4>Shipping Details</h4>
          <form action="checkout.php" method="POST" class="shipping-details">
            <div class="mb-3">
              <label class="form-label"><i class="fas fa-user"></i> Full Name</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="shipping_name" class="form-control" placeholder="Enter your full name" required>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label"><i class="fas fa-map-marker-alt"></i> Address</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                <textarea name="shipping_address" class="form-control" rows="3" placeholder="Enter your address" required></textarea>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label"><i class="fas fa-phone"></i> Phone Number</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                <input type="text" name="shipping_phone" class="form-control" placeholder="Enter your phone number" required>
              </div>
            </div>
            <button type="submit" class="btn btn-success w-100">
              <i class="fas fa-credit-card"></i> Proceed to Payment
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
