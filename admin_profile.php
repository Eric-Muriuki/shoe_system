<?php
session_start();
require_once 'db_connect.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: admin_login.php');
    exit();
}

// For demonstration, we'll assume the admin's current details are stored in session.
// In a real application, you'd retrieve these from your database.
$username = $_SESSION['username'];
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process profile update
    $new_username = trim($_POST['username']);
    $new_email = trim($_POST['email']);
    
    // Here, perform database update (omitted for brevity)
    // If update is successful, update session variables:
    $_SESSION['username'] = $new_username;
    $_SESSION['email'] = $new_email;
    $success = "Profile updated successfully.";
    
    // Update local variables
    $username = $new_username;
    $email = $new_email;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Profile - Jambo Shoes</title>
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
    <h2 class="mb-4 text-center"><i class="fas fa-user-cog"></i> Admin Profile</h2>
    <?php if($success): ?>
      <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
    <?php endif; ?>
    <?php if($error): ?>
      <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="mb-3">
        <label for="username" class="form-label"><i class="fas fa-user"></i> Username:</label>
        <input type="text" name="username" id="username" class="form-control" value="<?php echo htmlspecialchars($username); ?>" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email:</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
      </div>
      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Profile</button>
    </form>
  </div>
  
  <?php include 'admin_footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
