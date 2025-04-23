<?php
session_start();
require_once 'db_connect.php';

// Fetch shoe collections
$shoes = [];
$result = $conn->query("SELECT * FROM shoes");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $shoes[] = $row;
    }
}

// Fetch recent reviews (limit to 5)
$reviews = [];
$result3 = $conn->query("SELECT r.rating, r.review_text, r.created_at, c.name AS customer_name 
                          FROM reviews r 
                          JOIN customers c ON r.customer_id = c.id 
                          ORDER BY r.created_at DESC LIMIT 5");
if ($result3) {
    while ($row = $result3->fetch_assoc()) {
        $reviews[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: url('logo.jpg') no-repeat center center/cover; 
    }
    /* Other styles for cards, footer, etc. remain unchanged */
    .card-img-top { 
      height: 200px; 
      object-fit: cover; 
    }
    footer { 
      background-color: #004085; 
      color: #fff; 
      padding: 30px 0; 
    }
    footer a { 
      color: #ffc107; 
      text-decoration: none; 
    }
    footer a:hover { 
      text-decoration: underline; 
    }
    .review-box { 
      background: #fff; 
      border-radius: 5px; 
      padding: 15px; 
      margin-bottom: 15px; 
    }
    .star-rating i { 
      color: gold; 
    }
  </style>
</head>
<body>
  <!-- Include the header (which now has a semi-transparent background) -->
  <?php include 'header.php'; ?>
  
  <div class="container mt-5">
    <!-- Welcome Section -->
    <div class="text-center py-5">
      <?php if(isset($_SESSION['customer_name'])): ?>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['customer_name']); ?>!</h1>
        <p class="lead">Discover our exclusive shoe collections for every style and occasion.</p>
      <?php else: ?>
        <h1>Welcome to Jambo Shoes</h1>
        <p class="lead">Discover our exclusive shoe collections for every style and occasion.</p>
      <?php endif; ?>
    </div>
    
    <!-- Shoe Collections Section -->
    <div class="row">
      <?php if(count($shoes) > 0): ?>
        <?php foreach($shoes as $shoe): ?>
          <div class="col-md-4 mb-4">
            <div class="card">
              <?php if(!empty($shoe['image'])): ?>
                <img src="<?php echo htmlspecialchars($shoe['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($shoe['name']); ?>">
              <?php else: ?>
                <img src="airforce.jpg" class="card-img-top" alt="Shoe Image">
              <?php endif; ?>
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($shoe['name']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($shoe['description']); ?></p>
                <p class="card-text"><strong>$<?php echo number_format($shoe['price'], 2); ?></strong></p>
                <p class="card-text">
                  <strong>Size:</strong> <?php echo isset($shoe['size']) ? htmlspecialchars($shoe['size']) : 'N/A'; ?><br>
                  <strong>Color:</strong> <?php echo isset($shoe['color']) ? htmlspecialchars($shoe['color']) : 'N/A'; ?><br>
                  <strong>Availability:</strong> <?php echo isset($shoe['availability']) ? htmlspecialchars($shoe['availability']) : 'N/A'; ?><br>
                  <strong>Category:</strong> <?php echo isset($shoe['category']) ? htmlspecialchars($shoe['category']) : 'N/A'; ?><br>
                  <strong>Quantity:</strong> <?php echo isset($shoe['quantity']) ? $shoe['quantity'] : 'N/A'; ?>
                </p>
                <a href="product_details.php?shoe_id=<?php echo $shoe['shoe_id']; ?>" class="btn btn-primary">
                  <i class="fas fa-eye"></i> View Details
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No shoes available at the moment.</p>
      <?php endif; ?>
    </div>
    
    <!-- Reviews Section -->
    <div class="mt-5">
      <h2 class="mb-4"><i class="fas fa-comments"></i> Customer Reviews</h2>
      <?php if(count($reviews) > 0): ?>
        <?php foreach($reviews as $review): ?>
          <div class="review-box">
            <h5>
              <i class="fas fa-user"></i> <?php echo htmlspecialchars($review['customer_name']); ?>
              <small class="text-muted float-end"><?php echo date("M d, Y", strtotime($review['created_at'])); ?></small>
            </h5>
            <div class="star-rating mb-2">
              <?php for($i = 0; $i < $review['rating']; $i++) echo '<i class="fas fa-star"></i>'; ?>
              <?php for($i = $review['rating']; $i < 5; $i++) echo '<i class="far fa-star"></i>'; ?>
            </div>
            <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="alert alert-info">No reviews yet. Be the first to review our products!</div>
      <?php endif; ?>
    </div>
    
  </div>
  
  <!-- Logout Button at the Footer of the Page -->
  <div class="container text-center my-4">
      <a href="logout.php" class="btn btn-danger">
          <i class="fas fa-sign-out-alt"></i> Logout
      </a>
  </div>
  
  <?php include 'footer.php'; ?>
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
