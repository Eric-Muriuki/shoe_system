<?php
session_start();
require_once 'db_connect.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: admin_login.php');
    exit();
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($new_password !== $confirm_password) {
        $error = "New password and confirmation do not match.";
    } else {
        // Here, verify the current password from your database.
        // For demonstration purposes, we'll assume the current password is "admin123".
        if ($current_password !== 'admin123') {
            $error = "Current password is incorrect.";
        } else {
            // Update the password in the database here (hash the password in production).
            $success = "Password updated successfully.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Security - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: url('logo.jpg') no-repeat center center/cover; 
    }
    .form-container { 
      margin-top: 50px; 
      margin-bottom: 50px; 
    }
    .form-label { 
      font-weight: bold; 
    }
  </style>
</head>
<body>
  <?php include 'admin_header.php'; ?>
  
  <div class="container form-container">
    <h2 class="mb-4 text-center"><i class="fas fa-lock"></i> Security Settings</h2>
    <?php if($success): ?>
      <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
    <?php endif; ?>
    <?php if($error): ?>
      <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="mb-3">
        <label for="current_password" class="form-label"><i class="fas fa-key"></i> Current Password:</label>
        <input type="password" name="current_password" id="current_password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="new_password" class="form-label"><i class="fas fa-lock-open"></i> New Password:</label>
        <input type="password" name="new_password" id="new_password" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label"><i class="fas fa-check"></i> Confirm New Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Password</button>
    </form>
  </div>
  
  <?php include 'admin_footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
