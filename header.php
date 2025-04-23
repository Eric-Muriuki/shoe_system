<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
    /* Updated navigation bar styling to light brown */
    .navbar-custom { 
      background-color: #D2B48C; 
    }
    .navbar-custom .nav-link, 
    .navbar-custom .navbar-brand { 
      color: #fff; 
    }
    .navbar-custom .nav-link:hover { 
      color: #ffc107; 
    }
    /* Profile Dropdown Styles */
    .profile-dropdown {
      position: relative;
      display: inline-block;
    }
    .profile-dropdown .profile-menu {
      display: none;
      position: absolute;
      right: 0;
      background: #fff;
      min-width: 150px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      z-index: 1000;
      border-radius: 5px;
    }
    .profile-dropdown .profile-menu a {
      display: block;
      padding: 10px;
      text-decoration: none;
      color: #333;
    }
    .profile-dropdown .profile-menu a:hover {
      background: #f8f9fa;
    }
    .profile-dropdown:hover .profile-menu {
      display: block;
    }
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <i class="fas fa-shoe-prints"></i> Jambo Shoes
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
    <span class="navbar-toggler-icon"></span> <!-- Bootstrap handles the hamburger icon here -->
</button>

      <div class="collapse navbar-collapse" id="navbarContent">
         <ul class="navbar-nav me-auto mb-2 mb-lg-0">
             <li class="nav-item">
               <a class="nav-link" href="index.php">
                 <i class="fas fa-home"></i> Home
               </a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="categories.php">
                 <i class="fas fa-th-list"></i> Categories
               </a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="payment_methods.php">
                 <i class="fas fa-credit-card"></i> Payment Methods
               </a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="order_tracking.php">
                 <i class="fas fa-truck"></i> Order Tracking
               </a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="settings.php">
                 <i class="fas fa-cog"></i> Settings
               </a>
             </li>
         </ul>
         <div class="d-flex">
             <?php if (isset($_SESSION['customer_id'])): ?>
                <div class="profile-dropdown">
                  <a href="#" class="btn btn-outline-light">
                    <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['customer_name']); ?>
                  </a>
                  <div class="profile-menu">
                    <a href="account.php"><i class="fas fa-user"></i> My Account</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                  </div>
                </div>
             <?php else: ?>
               <a href="register.php" class="btn btn-outline-light me-2">
                 <i class="fas fa-user-plus"></i> Register
               </a>
               <a href="login.php" class="btn btn-outline-light">
                 <i class="fas fa-sign-in-alt"></i> Login
               </a>
             <?php endif; ?>
         </div>
      </div>
    </div>
  </nav>
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
