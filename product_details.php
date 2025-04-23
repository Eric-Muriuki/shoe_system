<?php
session_start();
require_once 'db_connect.php';

if (!isset($_GET['shoe_id'])) {
    die("No product specified.");
}

$shoe_id = intval($_GET['shoe_id']);

// Retrieve product details using prepared statements
$stmt = $conn->prepare("SELECT * FROM shoes WHERE shoe_id = ?");
$stmt->bind_param("i", $shoe_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();
$stmt->close();

// Use isset checks to avoid undefined index notices
$quantity     = isset($product['quantity']) ? $product['quantity'] : 'N/A';
$size         = isset($product['size']) ? $product['size'] : 'N/A';
$color        = isset($product['color']) ? $product['color'] : 'N/A';
$availability = isset($product['availability']) ? $product['availability'] : 'N/A';
$category     = isset($product['category']) ? $product['category'] : 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($product['name']); ?> - Product Details</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: url('logo.jpg') no-repeat center center/cover; 
      font-size: 18px; /* Base font size increased */
    }
    h1 {
      font-size: 2.5rem; /* Increased heading size */
    }
    h2 {
      font-size: 2rem;
    }
    p {
      font-size: 1.2rem;
    }
    .product-details { 
      padding: 40px 0; 
    }
    .product-image { 
      max-width: 100%; 
      height: auto; 
      border-radius: 10px; 
    }
    .btn-custom { 
      background: blue; 
      color: white; 
      border: none; 
      font-size: 1.1rem;
      padding: 12px 20px;
    }
    .btn-custom:hover { 
      background: red; 
    }
    .details-box { 
      padding: 20px; 
      background: rgba(255, 255, 255, 0.8); 
      border-radius: 10px; 
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
    }
  </style>
</head>
<body>
  <!-- Optionally include a header file if needed -->
  <?php // include 'header.php'; ?>

  <div class="container product-details">
    <div class="row">
      <div class="col-md-6">
        <?php if (!empty($product['image'])): ?>
          <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image img-fluid">
        <?php else: ?>
          <img src="placeholder.jpg" alt="Shoe Image" class="product-image img-fluid">
        <?php endif; ?>
      </div>
      <div class="details-box col-md-6 ">

        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <p class="lead">$<?php echo number_format($product['price'], 2); ?></p>
        <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
        <p><strong>Size:</strong> <?php echo htmlspecialchars($size); ?></p>
        <p><strong>Color:</strong> <?php echo htmlspecialchars($color); ?></p>
        <p><strong>Availability:</strong> <?php echo htmlspecialchars($availability); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($category); ?></p>
        <p><strong>Quantity:</strong> <?php echo htmlspecialchars($quantity); ?></p>
        <a href="add_to_cart.php?shoe_id=<?php echo $product['shoe_id']; ?>" class="btn btn-custom">
          <i class="fas fa-cart-plus"></i> Add to Cart
        </a>
        <a href="index.php" class="btn btn-outline-secondary ms-2" style="font-size:1.1rem;">
          <i class="fas fa-arrow-left"></i> Continue Shopping
        </a>
      </div>
    </div>
  </div>

  <!-- Optionally include a footer file if needed -->
  <?php // include 'footer.php'; ?>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
