<?php
session_start();
require_once 'db_connect.php';

// Define allowed categories and set default if none is provided or if an invalid one is supplied
$allowedCategories = array("Men", "Women", "Kids");
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';
if (!in_array($selectedCategory, $allowedCategories)) {
    $selectedCategory = 'Men';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Categories - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: #f8f9fa; 
    }
    .card-img-top { 
      height: 200px; 
      object-fit: cover; 
    }
    .bg-white {
      background-color: #ffffff !important;
    }
    .shadow-sm {
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

  </style>
</head>
<body>
  <!-- Include header.php which contains your navigation bar -->
  <?php include 'header.php'; ?>
  
  <div class="container mt-5">
    <!-- Category Navigation Pills -->
    <nav class="mb-4">
      <ul class="nav nav-pills justify-content-center">
        <?php foreach ($allowedCategories as $cat): ?>
          <li class="nav-item">
            <a class="nav-link <?php if ($selectedCategory == $cat) echo 'active'; ?>" href="categories.php?category=<?php echo urlencode($cat); ?>">
              <?php 
                // Display an icon based on the category
                if ($cat == "Men") {
                    echo '<i class="fas fa-male"></i> ';
                } elseif ($cat == "Women") {
                    echo '<i class="fas fa-female"></i> ';
                } else {
                    echo '<i class="fas fa-child"></i> ';
                }
              ?>
              <?php echo htmlspecialchars($cat); ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    
    <!-- Heading -->
    <h2 class="mb-4 p-3 text-white bg-primary rounded shadow-sm">
  <i class="fas fa-shoe-prints"></i> <?php echo htmlspecialchars($selectedCategory); ?> Shoes
</h2>


    
    <!-- Display Shoes -->
    <div class="row">
      <?php
      // Prepare and execute the query to fetch shoes for the selected category
      $stmt = $conn->prepare("SELECT * FROM shoes WHERE category = ? AND quantity > 0 ORDER BY name ASC");
      $stmt->bind_param("s", $selectedCategory);
      $stmt->execute();
      $shoeResult = $stmt->get_result();

      if ($shoeResult && $shoeResult->num_rows > 0) {
          while ($shoe = $shoeResult->fetch_assoc()) {
              echo '<div class="col-md-4 mb-4">';
              echo '  <div class="p-3 bg-white rounded shadow-sm h-100">';
              echo '    <div class="card border-0">';
              if (!empty($shoe['image'])) {
                  echo '      <img src="' . htmlspecialchars($shoe['image']) . '" class="card-img-top" alt="' . htmlspecialchars($shoe['name']) . '">';
              } else {
                  echo '      <img src="placeholder.jpg" class="card-img-top" alt="Shoe Image">';
              }
              echo '      <div class="card-body">';
              echo '        <h5 class="card-title">' . htmlspecialchars($shoe['name']) . '</h5>';
              echo '        <p class="card-text">' . htmlspecialchars($shoe['description']) . '</p>';
              echo '        <p class="card-text"><strong>$' . number_format($shoe['price'], 2) . '</strong></p>';
              echo '        <p class="card-text">In Quantity: ' . $shoe['quantity'] . '</p>';
              echo '        <p class="card-text">Available Colors: ' . htmlspecialchars($shoe['colors']) . '</p>';
              echo '        <a href="product_details.php?shoe_id=' . $shoe['shoe_id'] . '" class="btn btn-primary"><i class="fas fa-eye"></i> View Details</a> ';
              echo '        <a href="add_to_cart.php?shoe_id=' . $shoe['shoe_id'] . '" class="btn btn-success"><i class="fas fa-cart-plus"></i> Add to Cart</a>';
              echo '      </div>';
              echo '    </div>';
              echo '  </div>';
              echo '</div>';
          }
      } else {
          echo "<p class='text-center'>No shoes available in this category at the moment.</p>";
      }
      ?>
    </div>
    
    <!-- Continue Shopping Button -->
    <div class="text-center mt-4">
      <a href="index.php" class="btn btn-outline-primary"><i class="fas fa-shopping-bag"></i> Continue Shopping</a>
    </div>
  </div>
  
  <!-- Include footer.php -->
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
