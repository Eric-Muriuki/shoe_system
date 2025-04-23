<?php
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: admin_login.php');
    exit();
}

$result = $conn->query("SELECT * FROM customers");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Customers - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: url('logo.jpg') no-repeat center center/cover;
    }
  </style>
</head>
<body>
  <?php include 'admin_header.php'; ?>
  <div class="container mt-4">
    <h2>Manage Customers</h2>
    <a href="admin_add_customer.php" class="btn btn-primary mb-3">
      <i class="fas fa-plus"></i> Add Customer
    </a>
    <table class="table table-bordered">
       <thead>
          <tr>
             <th>ID</th>
             <th>Name</th>
             <th>Email</th>
             <th>Admin?</th>
             <th>Actions</th>
          </tr>
       </thead>
       <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
             <tr>
               <td><?php echo $row['id']; ?></td>
               <td><?php echo htmlspecialchars($row['name']); ?></td>
               <td><?php echo htmlspecialchars($row['email']); ?></td>
               <td><?php echo $row['is_admin'] ? 'Yes' : 'No'; ?></td>
               <td>
                 <a href="admin_edit_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                   <i class="fas fa-edit"></i> Edit
                 </a>
                 <a href="admin_delete_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                   <i class="fas fa-trash"></i> Delete
                 </a>
               </td>
             </tr>
          <?php endwhile; ?>
       </tbody>
    </table>
  </div>
  <?php include 'admin_footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
