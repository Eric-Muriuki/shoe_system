<?php
session_start();
require_once 'db_connect.php';
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: admin_login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: admin_customers.php");
    exit();
}
$id = $_GET['id'];

// Retrieve customer details
$stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "Customer not found";
    exit();
}
$customer = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    // Using dropdown, is_admin is submitted as "0" or "1"
    $is_admin = $_POST['is_admin'];
    
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE customers SET name = ?, email = ?, password = ?, is_admin = ? WHERE id = ?");
        $stmt->bind_param("sssii", $name, $email, $password, $is_admin, $id);
    } else {
        $stmt = $conn->prepare("UPDATE customers SET name = ?, email = ?, is_admin = ? WHERE id = ?");
        $stmt->bind_param("ssii", $name, $email, $is_admin, $id);
    }
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
  <title>Edit Customer - Admin</title>
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
    <h2>Edit Customer</h2>
    <form action="admin_edit_customer.php?id=<?php echo $id; ?>" method="POST">
      <!-- Name -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-user"></i> Name:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-user"></i></span>
           <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($customer['name']); ?>" required>
         </div>
      </div>
      <!-- Email -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-envelope"></i> Email:</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-envelope"></i></span>
           <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($customer['email']); ?>" required>
         </div>
      </div>
      <!-- Password -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-lock"></i> Password (leave blank to keep current):</label>
         <div class="input-group">
           <span class="input-group-text"><i class="fas fa-lock"></i></span>
           <input type="password" name="password" class="form-control">
         </div>
      </div>
      <!-- Customer Type -->
      <div class="mb-3">
         <label class="form-label"><i class="fas fa-user-shield"></i> Customer Type:</label>
         <select name="is_admin" class="form-select" required>
           <option value="0" <?php echo ($customer['is_admin'] == 0) ? 'selected' : ''; ?>>Customer</option>
           <option value="1" <?php echo ($customer['is_admin'] == 1) ? 'selected' : ''; ?>>Admin</option>
         </select>
      </div>
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Update Customer
      </button>
    </form>
  </div>
  <?php include 'admin_footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
