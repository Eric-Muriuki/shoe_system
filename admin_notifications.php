<?php
// admin_notifications.php - Dummy notifications page for admins
session_start();
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
  <title>Admin Notifications - Jambo Shoes Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
  <?php include 'admin_header.php'; ?>
  <div class="container mt-4">
    <h2>Notifications</h2>
    <ul class="list-group">
      <li class="list-group-item">New customer registration: John Doe. <small class="text-muted">5 minutes ago</small></li>
      <li class="list-group-item">Low stock alert: "Summer Sandals" only 3 left. <small class="text-muted">30 minutes ago</small></li>
      <li class="list-group-item">Order #5678 requires processing. <small class="text-muted">1 hour ago</small></li>
      <li class="list-group-item">System update available. <small class="text-muted">2 hours ago</small></li>
      <li class="list-group-item">New feedback from customer: Jane Smith. <small class="text-muted">3 hours ago</small></li>
    </ul>
  </div>
  <?php include 'admin_footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
