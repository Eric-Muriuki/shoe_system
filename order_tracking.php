<?php
// order_tracking.php
session_start();
require_once 'db_connect.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$customerId = $_SESSION['user_id'];
$searchOrderId = "";
$whereClause = "WHERE customer_id = ?";
$params = [$customerId];
$paramTypes = "i";

// If a search is submitted, filter by order_id
if (isset($_GET['order_id']) && !empty(trim($_GET['order_id']))) {
    $searchOrderId = trim($_GET['order_id']);
    $whereClause .= " AND order_id = ?";
    $params[] = $searchOrderId;
    $paramTypes .= "i";
}

// Prepare statement for fetching orders of the logged in customer
$sql = "SELECT order_id, order_date, total, status FROM orders " . $whereClause . " ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param($paramTypes, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order Tracking - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f8f9fa; }
    .navbar-custom { background-color: #004085; }
    .search-form .input-group-text { background-color: #004085; color: #fff; }
    .status-pending { color: #ffc107; }
    .status-completed { color: #28a745; }
    .status-cancelled { color: #dc3545; }
    .bg-primary.text-white { background-color: #004085 !important; }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="p-3 mb-4 bg-primary text-white rounded shadow-sm">
  <h2 class="mb-0"><i class="fas fa-truck"></i> Order Tracking</h2>
</div>

    
    <!-- Search Form -->
    <form class="row g-3 search-form mb-4" method="GET" action="order_tracking.php">
      <div class="col-md-8">
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
          <input type="number" class="form-control" name="order_id" placeholder="Enter Order ID" value="<?php echo htmlspecialchars($searchOrderId); ?>">
        </div>
      </div>
      <div class="col-md-4">
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Search</button>
      </div>
    </form>
    
    <!-- Generate Report Button -->
    <div class="mb-4">
      <a href="customer_generate_report.php" class="btn btn-success">
        <i class="fas fa-file-alt"></i> Generate Report
      </a>
    </div>
    
    <?php if ($result->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th scope="col"><i class="fas fa-hashtag"></i> Order ID</th>
              <th scope="col"><i class="fas fa-calendar-alt"></i> Date</th>
              <th scope="col"><i class="fas fa-dollar-sign"></i> Total</th>
              <th scope="col"><i class="fas fa-info-circle"></i> Status</th>
              <th scope="col"><i class="fas fa-eye"></i> Details</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($order = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo date("M d, Y", strtotime($order['order_date'])); ?></td>
                <td>$<?php echo number_format($order['total'], 2); ?></td>
                <td>
                  <?php 
                    $status = strtolower($order['status']);
                    $icon = ($status == "completed") ? "<i class='fas fa-check-circle status-completed'></i>" : 
                             (($status == "cancelled") ? "<i class='fas fa-times-circle status-cancelled'></i>" : "<i class='fas fa-clock status-pending'></i>");
                    echo $icon . " " . ucfirst($status);
                  ?>
                </td>
                <td>
                  <a href="order_details.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-sm btn-info">
                    <i class="fas fa-eye"></i> View
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info" role="alert">
        <i class="fas fa-info-circle"></i> No orders found for your account.
      </div>
    <?php endif; ?>
    
  </div>

  <?php include 'footer.php'; ?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
