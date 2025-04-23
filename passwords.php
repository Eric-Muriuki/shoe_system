<?php
// passwords.php
session_start();
require_once 'db_connect.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST["current_password"];
    $new_password     = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    $user_id          = $_SESSION['user_id'];

    // Retrieve current hashed password from the database
    $stmt = $conn->prepare("SELECT password FROM customers WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($db_password);
    $stmt->fetch();
    $stmt->close();

    // Validate current password and matching of new passwords
    if (!password_verify($current_password, $db_password)) {
        $error = "Current password is incorrect.";
    } elseif ($new_password !== $confirm_password) {
        $error = "New password and confirmation do not match.";
    } else {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Optional: Save the current password in password_history table
        /*
        $stmt = $conn->prepare("INSERT INTO password_history (customer_id, old_password) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $db_password);
        $stmt->execute();
        $stmt->close();
        */
        
        $stmt = $conn->prepare("UPDATE customers SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed, $user_id);
        if ($stmt->execute()) {
            $success = "Password updated successfully.";
        } else {
            $error = "Error updating password: " . $conn->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Your Passwords - Jambo Shoes</title>
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
    #password-strength {
      margin-top: 5px;
      font-weight: bold;
    }
  </style>
  <script>
    // Simple password strength meter function
    function checkPasswordStrength(password) {
      let strength = 0;
      if (password.length >= 8) strength++;
      if (/[A-Z]/.test(password)) strength++;
      if (/[0-9]/.test(password)) strength++;
      if (/[\W]/.test(password)) strength++;

      let strengthText = "";
      let strengthColor = "";
      switch (strength) {
        case 0:
        case 1:
          strengthText = "Very Weak";
          strengthColor = "red";
          break;
        case 2:
          strengthText = "Weak";
          strengthColor = "orange";
          break;
        case 3:
          strengthText = "Good";
          strengthColor = "blue";
          break;
        case 4:
          strengthText = "Strong";
          strengthColor = "green";
          break;
      }
      document.getElementById("password-strength").innerText = strengthText;
      document.getElementById("password-strength").style.color = strengthColor;
    }
  </script>
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="container">
    <h2 class="text-center mb-4"><i class="fas fa-key"></i> Manage Your Passwords</h2>
    <p class="text-center">Manage your account passwords securely. If you forgot your password, please use our <a href="forgot_password.php" class="text-decoration-none"><i class="fas fa-unlock-alt"></i> recovery process</a>.</p>
    
    <?php if ($error): ?>
      <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
      </div>
    <?php elseif ($success): ?>
      <div class="alert alert-success" role="alert">
        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
      </div>
    <?php endif; ?>

    <form action="passwords.php" method="POST">
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="fas fa-lock"></i></span>
        <input type="password" name="current_password" class="form-control" placeholder="Current Password" required>
      </div>
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="fas fa-key"></i></span>
        <input type="password" name="new_password" class="form-control" placeholder="New Password" onkeyup="checkPasswordStrength(this.value)" required>
      </div>
      <div id="password-strength" class="mb-3"></div>
      <div class="mb-3 input-group">
        <span class="input-group-text"><i class="fas fa-key"></i></span>
        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Password</button>
      </div>
    </form>
    
    <div class="mt-3 text-center">
      <a href="forgot_password.php" class="text-decoration-none"><i class="fas fa-question-circle"></i> Forgot Password?</a>
    </div>
  </div>

  <?php include 'footer.php'; ?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
