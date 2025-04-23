<?php
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // 'is_admin' will be "0" for customer and "1" for admin as selected from the drop‑down
    $is_admin = $_POST['is_admin'];

    $stmt = $conn->prepare("INSERT INTO customers (name, email, password, is_admin) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $password, $is_admin);
    if ($stmt->execute()) {
        header("Location: admin_customers.php");
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
  <title>Add Customer - Admin</title>
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
    <h2>Add Customer</h2>
    <form action="admin_add_customer.php" method="POST">
      <!-- Name -->
      <div class="mb-3">
        <label class="form-label"><i class="fas fa-user"></i> Name:</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
          <input type="text" name="name" class="form-control" required>
        </div>
      </div>
      <!-- Email -->
      <div class="mb-3">
        <label class="form-label"><i class="fas fa-envelope"></i> Email:</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          <input type="email" name="email" class="form-control" required>
        </div>
      </div>
      <!-- Password -->
      <div class="mb-3">
        <label class="form-label"><i class="fas fa-lock"></i> Password:</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" name="password" class="form-control" required>
        </div>
      </div>
      <!-- Customer Type -->
      <div class="mb-3">
        <label class="form-label"><i class="fas fa-user-shield"></i> Customer Type:</label>
        <select name="is_admin" class="form-select" required>
          <option value="0">Customer</option>
          <option value="1">Admin</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Customer
      </button>
    </form>
  </div>
  <?php include 'admin_footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
