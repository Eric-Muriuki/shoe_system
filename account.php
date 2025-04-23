<?php
session_start();

// Redirect to login if the customer is not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

// Optionally include header (if your header.php contains HTML structure, consider using include_once)
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>My Account - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: #f8f9fa; 
    }
    .account-container {
      margin-top: 2rem;
    }
  </style>
</head>
<body>
<div class="container account-container">
  <h1 class="mb-4">My Account</h1>
  <div class="card">
    <div class="card-header">
      Account Details
    </div>
    <div class="card-body">
      <p><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['customer_name']); ?></p>
      <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['customer_email']); ?></p>
      <!-- Add additional details as needed -->
    </div>
  </div>
  <div class="mt-3">
    <a href="edit_account.php" class="btn btn-primary">
      <i class="fas fa-edit"></i> Edit Account
    </a>
  </div>
</div>
<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
