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
    // For demonstration, we'll assume there's one setting: "Maintenance Mode".
    $maintenance_mode = isset($_POST['maintenance_mode']) ? 1 : 0;
    
    // Update your settings in the database here.
    // For demonstration, we'll assume the update is successful.
    $success = "System settings updated successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin System Settings - Jambo Shoes</title>
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
    <h2 class="mb-4 text-center"><i class="fas fa-tools"></i> System Settings</h2>
    <?php if($success): ?>
      <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if($error): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="mb-3 form-check">
        <input type="checkbox" name="maintenance_mode" id="maintenance_mode" class="form-check-input">
        <label for="maintenance_mode" class="form-check-label">Enable Maintenance Mode</label>
      </div>
      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Settings</button>
    </form>
  </div>
  
  <?php include 'admin_footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
