<?php
// forgot_password.php
session_start();
require_once 'db_connect.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    
    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // In a real application, generate a secure token, save it, and send a reset email.
        $success = "A password reset link has been sent to your email address.";
    } else {
        $error = "This email is not registered.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fa;
    }
    .navbar-custom {
      background-color: #004085;
    }
    .input-group-text {
      background-color: #004085;
      color: #fff;
    }
    .btn-primary {
      background-color: #004085;
      border-color: #004085;
    }
    .btn-primary:hover {
      background-color: #003366;
      border-color: #002244;
    }
    .container {
      max-width: 500px;
      margin-top: 50px;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="container">
    <h2 class="text-center mb-4"><i class="fas fa-unlock-alt"></i> Forgot Password</h2>
    
    <?php if ($error): ?>
      <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
      </div>
    <?php elseif ($success): ?>
      <div class="alert alert-success" role="alert">
        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
      </div>
    <?php endif; ?>

    <p class="text-center">Enter your registered email address below to receive a password reset link.</p>
    
    <form action="forgot_password.php" method="POST">
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        <input type="email" class="form-control" name="email" placeholder="Email Address" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send Reset Link</button>
      </div>
    </form>
    
    <div class="mt-3 text-center">
      <a href="login.php" class="text-decoration-none"><i class="fas fa-arrow-left"></i> Back to Login</a>
    </div>
  </div>

  <?php include 'footer.php'; ?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
