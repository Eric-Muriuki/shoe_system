<?php
// notifications.php - Dummy notifications page for customers
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notifications - Jambo Shoes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
  <?php include 'header.php'; ?>
  <div class="container mt-4">
    <h2>Notifications</h2>
    <ul class="list-group">
      <li class="list-group-item">New product launch: Summer Collection is here! <small class="text-muted">10 minutes ago</small></li>
      <li class="list-group-item">Your order #1234 has been shipped. <small class="text-muted">1 hour ago</small></li>
      <li class="list-group-item">Limited-time offer: 20% off on selected items. <small class="text-muted">2 hours ago</small></li>
    </ul>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
