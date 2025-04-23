<?php
session_start();
require_once 'db_connect.php';

// Ensure customer is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ensure an order_id is provided via GET
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "Order ID missing!";
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch order details for the logged-in customer
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND customer_id = ?");
$stmt->bind_param("ii", $order_id, $_SESSION['user_id']);
$stmt->execute();
$orderResult = $stmt->get_result();

if ($orderResult->num_rows === 0) {
    echo "Order not found or you do not have permission to view this order.";
    exit();
}

$order = $orderResult->fetch_assoc();

// Fetch order items joined with shoe details
$stmtItems = $conn->prepare("SELECT oi.*, s.name, s.price, s.image, s.description 
                             FROM order_items oi 
                             JOIN shoes s ON oi.shoe_id = s.shoe_id 
                             WHERE oi.order_id = ?");
$stmtItems->bind_param("i", $order_id);
$stmtItems->execute();
$itemsResult = $stmtItems->get_result();
$items = [];
while ($row = $itemsResult->fetch_assoc()) {
    $items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order Details - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: #f8f9fa; 
    }
    .order-details { 
      margin-top: 50px; 
      margin-bottom: 50px; 
    }
    .order-summary { 
      background: #fff; 
      padding: 20px; 
      border-radius: 15px; 
      box-shadow: 0 0 15px rgba(0,0,0,0.1); 
      margin-bottom: 30px;
    }
    .order-summary h4 { 
      margin-bottom: 20px; 
    }
    .table img { 
      width: 50px; 
      height: auto; 
    }
    .product-description {
      max-width: 300px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="container order-details">
    <h2 class="mb-4"><i class="fas fa-receipt"></i> Order Details</h2>
    <div class="order-summary">
      <h4>Order #<?php echo htmlspecialchars($order['order_id']); ?></h4>
      <p><strong>Date:</strong> <?php echo date("M d, Y", strtotime($order['order_date'])); ?></p>
      <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
      <p><strong>Total:</strong> $<?php echo number_format($order['total'], 2); ?></p>
    </div>

    <h5>Items Purchased</h5>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Product</th>
          <th>Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
          <td>
            <?php if (!empty($item['image'])): ?>
              <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
            <?php else: ?>
              <img src="placeholder.jpg" alt="Shoe Image">
            <?php endif; ?>
          </td>
          <td><?php echo htmlspecialchars($item['name']); ?></td>
          <td class="product-description" title="<?php echo htmlspecialchars($item['description']); ?>">
            <?php echo htmlspecialchars($item['description']); ?>
          </td>
          <td>$<?php echo number_format($item['price'], 2); ?></td>
          <td><?php echo $item['quantity']; ?></td>
          <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <?php include 'footer.php'; ?>
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
