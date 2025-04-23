<?php
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name         = $_POST['name'];
    $description  = $_POST['description'];
    $price        = $_POST['price'];
    $quantity     = $_POST['quantity'];
    $image        = isset($_POST['image']) ? $_POST['image'] : '';
    $category     = $_POST['category'];
    $size         = $_POST['size'];
    $color        = $_POST['color'];
    $availability = $_POST['availability'];

    // Insert with extra fields
    $stmt = $conn->prepare("INSERT INTO shoes (name, description, price, quantity, image, category, size, color, availability) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdisssss", $name, $description, $price, $quantity, $image, $category, $size, $color, $availability);
    if ($stmt->execute()) {
        header("Location: admin_products.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Product - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f8f9fa; }
    .input-group-text { background: #004085; color: #fff; }
    .form-label i { margin-right: 5px; color: #004085; }
  </style>
</head>
<body>
  <?php include 'admin_header.php'; ?>
  <div class="container mt-4">
    <h2>Add Product</h2>
    <form action="admin_add_product.php" method="POST">
      <!-- Name -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-tag"></i> Name:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-tag"></i></span>
           <input type="text" name="name" class="form-control" required>
         </div>
      </div>
      <!-- Description -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-info-circle"></i> Description:</label>
         <textarea name="description" class="form-control" required></textarea>
      </div>
      <!-- Price -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-dollar-sign"></i> Price:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
           <input type="number" name="price" step="0.01" class="form-control" required>
         </div>
      </div>
      <!-- Quantity -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-sort-numeric-up"></i> Quantity:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
           <input type="number" name="quantity" class="form-control" required>
         </div>
      </div>
      <!-- Image URL -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-image"></i> Image URL:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-image"></i></span>
           <input type="text" name="image" class="form-control">
         </div>
      </div>
      <!-- Category Dropdown -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-list"></i> Category:</label>
         <select name="category" class="form-select" required>
           <option value="" disabled selected>Select Category</option>
           <option value="Men">Men</option>
           <option value="Women">Women</option>
           <option value="Kids">Kids</option>
         </select>
      </div>
      <!-- Size Input -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-ruler-combined"></i> Size:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-ruler-combined"></i></span>
           <input type="text" name="size" class="form-control" placeholder="e.g., 39" required>
         </div>
      </div>
      <!-- Color Input -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-palette"></i> Color:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-palette"></i></span>
           <input type="text" name="color" class="form-control" placeholder="e.g., Blue" required>
         </div>
      </div>
      <!-- Availability Dropdown -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-check-circle"></i> Availability:</label>
         <select name="availability" class="form-select" required>
           <option value="" disabled selected>Select Availability</option>
           <option value="In Stock">In Stock</option>
           <option value="Out of Stock">Out of Stock</option>
         </select>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Product
      </button>
    </form>
  </div>
  <?php include 'admin_footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
