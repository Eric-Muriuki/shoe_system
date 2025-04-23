<?php
session_start();
require_once 'db_connect.php';

// Ensure a product is specified
if (!isset($_GET['product_id'])) {
    die("No product specified.");
}
$product_id = intval($_GET['product_id']);

// Retrieve product details
$stmtProduct = $conn->prepare("SELECT name, image, description, price FROM shoes WHERE shoe_id = ?");
$stmtProduct->bind_param("i", $product_id);
$stmtProduct->execute();
$productResult = $stmtProduct->get_result();
if ($productResult->num_rows > 0) {
    $product = $productResult->fetch_assoc();
} else {
    die("Invalid product specified.");
}
$stmtProduct->close();

// Calculate average rating and total reviews for the product
$stmtAvg = $conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE product_id = ?");
$stmtAvg->bind_param("i", $product_id);
$stmtAvg->execute();
$avgResult = $stmtAvg->get_result();
if ($avgRow = $avgResult->fetch_assoc()) {
    $avgRating = round($avgRow['avg_rating'], 1);
    $totalReviews = $avgRow['total_reviews'];
} else {
    $avgRating = 0;
    $totalReviews = 0;
}
$stmtAvg->close();

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $rating = intval($_POST['rating']);
    $review_text = trim($_POST['review_text']);
    $customer_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("INSERT INTO reviews (product_id, customer_id, rating, review_text) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $product_id, $customer_id, $rating, $review_text);
    $stmt->execute();
    $stmt->close();
    $success = "Thank you for your review!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product Reviews - <?php echo htmlspecialchars($product['name']); ?></title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    .star-rating i { color: gold; }
    .review-box {
      background: rgba(255,255,255,0.8);
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 15px;
    }
    .product-info {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 30px;
    }
    .product-info img {
      max-width: 100%;
      height: auto;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  
  <div class="container my-5">
    <!-- Product Information Section -->
    <div class="product-info row mb-4">
      <div class="col-md-4">
        <?php if(!empty($product['image'])): ?>
          <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        <?php else: ?>
          <img src="placeholder.jpg" alt="Product Image">
        <?php endif; ?>
      </div>
      <div class="col-md-8">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <p><?php echo htmlspecialchars($product['description']); ?></p>
        <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
        <p>
          <strong>Average Rating:</strong> <?php echo $avgRating; ?> / 5 
          <span class="star-rating">
            <?php for($i = 0; $i < round($avgRating); $i++) echo '<i class="fas fa-star"></i>'; ?>
            <?php for($i = round($avgRating); $i < 5; $i++) echo '<i class="far fa-star"></i>'; ?>
          </span>
          (<?php echo $totalReviews; ?> reviews)
        </p>
      </div>
    </div>
    
    <!-- Review Submission Success Message -->
    <?php if(isset($success)): ?>
      <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    
    <!-- Review Submission Form -->
    <?php if(isset($_SESSION['user_id'])): ?>
    <div class="card mb-4">
      <div class="card-body">
        <h5 class="card-title"><i class="fas fa-pen"></i> Leave a Review</h5>
        <form action="reviews.php?product_id=<?php echo $product_id; ?>" method="POST">
          <div class="mb-3">
            <label for="rating" class="form-label">Rating:</label>
            <select name="rating" id="rating" class="form-select" required>
              <option value="">Select Rating</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="review_text" class="form-label">Your Review:</label>
            <textarea name="review_text" id="review_text" class="form-control" rows="4" placeholder="Write your review here..." required></textarea>
          </div>
          <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Submit Review</button>
        </form>
      </div>
    </div>
    <?php else: ?>
      <div class="alert alert-info">Please <a href="login.php">login</a> to leave a review.</div>
    <?php endif; ?>
    
    <!-- Display Reviews Section -->
    <div class="mb-4">
      <h4><i class="fas fa-comments"></i> What our customers say</h4>
      <?php
      // Retrieve reviews for this product
      $stmt = $conn->prepare("SELECT r.rating, r.review_text, r.created_at, c.name FROM reviews r JOIN customers c ON r.customer_id = c.id WHERE r.product_id = ? ORDER BY r.created_at DESC");
      $stmt->bind_param("i", $product_id);
      $stmt->execute();
      $result = $stmt->get_result();
      if($result->num_rows > 0):
          while($review = $result->fetch_assoc()):
      ?>
      <div class="review-box">
        <h5>
          <i class="fas fa-user"></i> <?php echo htmlspecialchars($review['name']); ?>
          <small class="text-muted float-end"><?php echo date("M d, Y", strtotime($review['created_at'])); ?></small>
        </h5>
        <div class="star-rating mb-2">
          <?php for($i = 0; $i < $review['rating']; $i++) echo '<i class="fas fa-star"></i>'; ?>
          <?php for($i = $review['rating']; $i < 5; $i++) echo '<i class="far fa-star"></i>'; ?>
        </div>
        <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
      </div>
      <?php
          endwhile;
      else:
      ?>
      <div class="alert alert-info">No reviews yet. Be the first to review this product!</div>
      <?php endif; ?>
      <?php $stmt->close(); ?>
    </div>
  </div>
  
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
