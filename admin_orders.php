<?php
session_start();
require_once 'db_connect.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: admin_login.php');
    exit();
}

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    // Update order status
    if ($_POST['action'] == 'update' && isset($_POST['order_id']) && isset($_POST['new_status'])) {
        $order_id = intval($_POST['order_id']);
        $new_status = $_POST['new_status'];
        $allowed_statuses = array("Pending", "Shipped", "Delivered", "Cancelled");
        if (!in_array($new_status, $allowed_statuses)) {
            $new_status = "Pending";
        }
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
        $stmt->bind_param("si", $new_status, $order_id);
        $stmt->execute();
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    
    // Delete order
    if ($_POST['action'] == 'delete' && isset($_POST['order_id'])) {
        $order_id = intval($_POST['order_id']);
        
        // Delete dependent order_details first
        $stmt = $conn->prepare("DELETE FROM order_details WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
        
        // Now delete the order
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Fetch orders for display
$result = $conn->query("SELECT o.order_id, o.order_date, o.total, o.status, c.name AS customer_name 
                         FROM orders o 
                         JOIN customers c ON o.customer_id = c.id 
                         ORDER BY o.order_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Orders - Admin</title>
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
    <h2>Manage Orders</h2>
    <table class="table table-bordered">
       <thead>
         <tr>
           <th>Order ID</th>
           <th>Date</th>
           <th>Customer</th>
           <th>Total</th>
           <th>Status</th>
           <th>Actions</th>
         </tr>
       </thead>
       <tbody>
         <?php while($row = $result->fetch_assoc()): ?>
         <tr>
           <td><?php echo $row['order_id']; ?></td>
           <td><?php echo $row['order_date']; ?></td>
           <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
           <td>$<?php echo number_format($row['total'], 2); ?></td>
           <td>
             <!-- Update Status Form -->
             <form action="" method="POST" class="d-flex align-items-center">
               <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
               <input type="hidden" name="action" value="update">
               <select name="new_status" class="form-select form-select-sm me-2" style="width:auto;">
                 <?php
                   $statuses = array("Pending", "Shipped", "Delivered", "Cancelled");
                   foreach ($statuses as $status) {
                       $selected = ($row['status'] == $status) ? "selected" : "";
                       echo "<option value=\"$status\" $selected>$status</option>";
                   }
                 ?>
               </select>
               <button type="submit" class="btn btn-sm btn-primary" title="Update">
                 <i class="fas fa-check"></i>
               </button>
             </form>
           </td>
           <td>
             <!-- Delete Order Form -->
             <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
               <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
               <input type="hidden" name="action" value="delete">
               <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                 <i class="fas fa-trash-alt"></i>
               </button>
             </form>
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
