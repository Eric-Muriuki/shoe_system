<?php
session_start();
require_once 'db_connect.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Jambo Shoes Admin Panel</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('logo.jpg') no-repeat center center/cover;
    }
    .card i {
      font-size: 3rem;
      color: #004085;
    }
    .card-title {
      font-weight: bold;
      color: #004085;
    }
    .navbar-brand i {
      margin-right: 8px;
    }
    .btn-primary {
      background: #004085;
      border: none;
    }
    .btn-primary:hover {
      background: #003366;
    }
    footer a {
      color: #ffc107;
      text-decoration: none;
    }
    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <?php include 'admin_header.php'; ?>
  
  <div class="container mt-5">
    <div class="text-center py-5">
      <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
      <p class="lead">This is your Admin Panel. Use the options below to manage the system.</p>
    </div>
    <div class="row">
      <!-- Manage Customers Card -->
      <div class="col-md-4 mb-4">
        <div class="card h-100 text-center">
          <div class="card-body">
            <i class="fas fa-users"></i>
            <h5 class="card-title mt-3">Manage Customers</h5>
            <p class="card-text">View, add, update, and delete customer accounts.</p>
            <a href="admin_customers.php" class="btn btn-primary">
              <i class="fas fa-arrow-right"></i> Go
            </a>
          </div>
        </div>
      </div>
      <!-- Manage Products Card -->
      <div class="col-md-4 mb-4">
        <div class="card h-100 text-center">
          <div class="card-body">
            <i class="fas fa-box-open"></i>
            <h5 class="card-title mt-3">Manage Products</h5>
            <p class="card-text">View, add, update, and delete products (shoes).</p>
            <a href="admin_products.php" class="btn btn-primary">
              <i class="fas fa-arrow-right"></i> Go
            </a>
          </div>
        </div>
      </div>
      <!-- Manage Orders Card -->
      <div class="col-md-4 mb-4">
        <div class="card h-100 text-center">
          <div class="card-body">
            <i class="fas fa-shopping-cart"></i>
            <h5 class="card-title mt-3">Manage Orders</h5>
            <p class="card-text">Review and process customer orders.</p>
            <a href="admin_orders.php" class="btn btn-primary">
              <i class="fas fa-arrow-right"></i> Go
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <?php include 'admin_footer.php'; ?>
</body>
</html>
