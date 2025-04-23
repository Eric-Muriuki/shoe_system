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
  <title>Admin Settings - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      /* Updated background image */
      background: url('logo.jpg') no-repeat center center/cover;
    }
    .card {
      border: 1px solid #ddd;
      border-radius: 15px;
      background: #fff;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    .card:hover {
      transform: translateY(-5px);
    }
    .card i {
      font-size: 3rem;
      color: #004085;
    }
    .card-title {
      font-weight: bold;
      color: #004085;
    }
    .btn-primary {
      background: #004085;
      border: none;
    }
    .btn-primary:hover {
      background: #003366;
    }
    /* Footer styling */
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
  </style>
</head>
<body>
  <?php include 'admin_header.php'; ?>
  
  <div class="container mt-5">
    <div class="text-center py-5">
      <h1><i class="fas fa-cogs"></i> Admin Settings</h1>
      <p class="lead">Configure your admin preferences and update your profile settings.</p>
    </div>
    <div class="row">
      <!-- Profile Settings Card -->
      <div class="col-md-6 mb-4">
        <div class="card h-100 text-center">
          <div class="card-body">
            <i class="fas fa-user-cog"></i>
            <h5 class="card-title mt-3">Profile Settings</h5>
            <p class="card-text">Update your admin profile information.</p>
            <a href="admin_profile.php" class="btn btn-primary">
              <i class="fas fa-arrow-right"></i> Update Profile
            </a>
          </div>
        </div>
      </div>
      <!-- Security Settings Card -->
      <div class="col-md-6 mb-4">
        <div class="card h-100 text-center">
          <div class="card-body">
            <i class="fas fa-lock"></i>
            <h5 class="card-title mt-3">Security Settings</h5>
            <p class="card-text">Change your password and manage security options.</p>
            <a href="admin_security.php" class="btn btn-primary">
              <i class="fas fa-arrow-right"></i> Update Security
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- System Settings Card -->
    <div class="row">
      <div class="col-md-12 mb-4">
        <div class="card h-100 text-center">
          <div class="card-body">
            <i class="fas fa-tools"></i>
            <h5 class="card-title mt-3">System Settings</h5>
            <p class="card-text">Configure overall system settings and preferences.</p>
            <a href="admin_system.php" class="btn btn-primary">
              <i class="fas fa-arrow-right"></i> Configure System
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <?php include 'admin_footer.php'; ?>
</body>
</html>
