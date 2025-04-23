<?php
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: admin_login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: admin_products.php");
    exit();
}
$id = $_GET['id'];

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM shoes WHERE shoe_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "Product not found";
    exit();
}
$product = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name         = $_POST['name'];
    $description  = $_POST['description'];
    $price        = $_POST['price'];
    $quantity     = $_POST['quantity'];
    $image        = $_POST['image'];
    $size         = $_POST['size'];
    $color        = $_POST['color'];
    $availability = $_POST['availability'];
    $category     = $_POST['category'];

    // Update query with new fields
    $stmt = $conn->prepare("UPDATE shoes SET name = ?, description = ?, price = ?, quantity = ?, image = ?, size = ?, color = ?, availability = ?, category = ? WHERE shoe_id = ?");
    $stmt->bind_param("ssdisssssi", $name, $description, $price, $quantity, $image, $size, $color, $availability, $category, $id);
    
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
  <title>Edit Product - Admin</title>
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
    <h2>Edit Product</h2>
    <form action="admin_edit_product.php?id=<?php echo $id; ?>" method="POST">
      <!-- Name -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-tag"></i> Name:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-tag"></i></span>
           <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
         </div>
      </div>
      <!-- Description -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-info-circle"></i> Description:</label>
         <textarea name="description" class="form-control" required><?php echo htmlspecialchars($product['description']); ?></textarea>
      </div>
      <!-- Price -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-dollar-sign"></i> Price:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
           <input type="number" name="price" step="0.01" class="form-control" value="<?php echo $product['price']; ?>" required>
         </div>
      </div>
      <!-- Quantity -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-sort-numeric-up"></i> Quantity:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
           <input type="number" name="quantity" class="form-control" value="<?php echo $product['quantity']; ?>" required>
         </div>
      </div>
      <!-- Image URL -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-image"></i> Image URL:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-image"></i></span>
           <input type="text" name="image" class="form-control" value="<?php echo htmlspecialchars($product['image']); ?>">
         </div>
      </div>
      <!-- Size -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-ruler-combined"></i> Size:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-ruler-combined"></i></span>
           <input type="text" name="size" class="form-control" value="<?php echo isset($product['size']) ? htmlspecialchars($product['size']) : ''; ?>" required>
         </div>
      </div>
      <!-- Color -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-palette"></i> Color:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-palette"></i></span>
           <input type="text" name="color" class="form-control" value="<?php echo isset($product['color']) ? htmlspecialchars($product['color']) : ''; ?>" required>
         </div>
      </div>
      <!-- Availability -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-check-circle"></i> Availability:</label>
         <select name="availability" class="form-select" required>
           <option value="In Stock" <?php if(isset($product['availability']) && $product['availability'] == "In Stock") echo "selected"; ?>>In Stock</option>
           <option value="Out of Stock" <?php if(isset($product['availability']) && $product['availability'] == "Out of Stock") echo "selected"; ?>>Out of Stock</option>
         </select>
      </div>
      <!-- Category -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-users"></i> Category:</label>
         <select name="category" class="form-select" required>
           <option value="Men" <?php if(isset($product['category']) && $product['category'] == "Men") echo "selected"; ?>>Men</option>
           <option value="Women" <?php if(isset($product['category']) && $product['category'] == "Women") echo "selected"; ?>>Women</option>
           <option value="Kids" <?php if(isset($product['category']) && $product['category'] == "Kids") echo "selected"; ?>>Kids</option>
         </select>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Update Product
      </button>
    </form>
  </div>
  <?php include 'admin_footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
