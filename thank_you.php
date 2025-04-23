<?php
session_start();
require_once 'db_connect.php';

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Thank You - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: #f8f9fa; 
      padding-top: 80px;
    }
    .thank-you-container {
      max-width: 600px;
      margin: 0 auto;
      text-align: center;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .thank-you-container h1 {
      color: #004085;
      margin-bottom: 20px;
    }
    .thank-you-container p {
      font-size: 1.1rem;
      color: #333;
    }
    .btn-home {
      background: #004085;
      color: #fff;
      border: none;
    }
    .btn-home:hover {
      background: #003366;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="container thank-you-container">
    <h1><i class="fas fa-check-circle"></i> Thank You!</h1>
    <p>Your order has been placed successfully.</p>
    <?php if ($order_id): ?>
      <p>Your order ID is <strong><?php echo $order_id; ?></strong>.</p>
    <?php endif; ?>
    <a href="index.php" class="btn btn-home mt-3">
      <i class="fas fa-home"></i> Continue Shopping
    </a>
  </div>

  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
