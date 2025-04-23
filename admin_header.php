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
  <title>Jambo Shoes Admin Panel</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    .navbar-custom {
      background-color: #D2B48C; /* Light brown */
    }
    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link {
      color: #4B3621; /* Dark brown for contrast */
    }
    .navbar-custom .nav-link:hover {
      color: #ffc107;
    }
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
      <a class="navbar-brand" href="admin_index.php">
        <i class="fas fa-tachometer-alt"></i> Admin Dashboard
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
         <span class="navbar-toggler-icon">
           <i class="fas fa-bars" style="color:#4B3621;"></i>
         </span>
      </button>
      <div class="collapse navbar-collapse" id="adminNavbar">
         <ul class="navbar-nav me-auto mb-2 mb-lg-0">
             <li class="nav-item">
               <a class="nav-link" href="admin_customers.php">
                 <i class="fas fa-users"></i> Customers
               </a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="admin_products.php">
                 <i class="fas fa-box-open"></i> Products
               </a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="admin_orders.php">
                 <i class="fas fa-shopping-cart"></i> Orders
               </a>
             </li>
             <!-- New Generate Report Section -->
             <li class="nav-item">
               <a class="nav-link" href="generate_report.php">
                 <i class="fas fa-file-alt"></i> Generate Report
               </a>
             </li>
         </ul>
         <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
             <li class="nav-item">
               <a class="nav-link" href="admin_settings.php">
                 <i class="fas fa-cog"></i> Settings
               </a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="admin_logout.php">
                 <i class="fas fa-sign-out-alt"></i> Logout
               </a>
             </li>
         </ul>
      </div>
    </div>
  </nav>
  <!-- Include Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
