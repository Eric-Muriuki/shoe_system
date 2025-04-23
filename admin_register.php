<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username         = $_POST['username'];
    $email            = $_POST['email'];
    $password         = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            echo "<script>alert('Email already registered!');</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $is_admin = 1; // Flag this user as admin
            $stmt = $conn->prepare("INSERT INTO customers (name, email, password, is_admin) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $username, $email, $hashed_password, $is_admin);
            if($stmt->execute()){
                header('Location: admin_login.php');
                exit();
            } else {
                echo "<script>alert('Registration failed!');</script>";
            }
        }
    } else {
        echo "<script>alert('Passwords do not match!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Registration</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
      body {
          margin: 0;
          padding: 0;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          /* Set background image to logo.jpg */
          background: url('logo.jpg') no-repeat center center/cover;
          font-family: Arial, sans-serif;
          position: relative;
      }
      .overlay {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: rgba(0, 0, 0, 0.6);
      }
      .login-container {
          position: relative;
          background: rgba(255, 255, 255, 0.2);
          padding: 25px;
          border-radius: 15px;
          backdrop-filter: blur(15px);
          box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);
          text-align: center;
          width: 320px;
          border: 2px solid blue;
          z-index: 1;
      }
      .login-container h2 {
          color: red;
          margin-bottom: 15px;
      }
      .login-container img {
          width: 80px;
          margin-bottom: 20px;
      }
      .input-group {
          display: flex;
          align-items: center;
          background: rgba(255, 255, 255, 0.4);
          margin: 15px 0;
          padding: 12px;
          border-radius: 8px;
          border: 1px solid blue;
      }
      .input-group input {
          border: none;
          outline: none;
          background: none;
          flex: 1;
          padding: 12px;
          color: white;
          font-size: 16px;
      }
      .input-group i {
          color: red;
          margin-right: 12px;
      }
      .login-btn {
          background: blue;
          border: none;
          color: white;
          padding: 12px;
          width: 100%;
          border-radius: 8px;
          cursor: pointer;
          font-size: 18px;
          transition: background 0.3s;
      }
      .login-btn:hover {
          background: red;
      }
      p {
          margin-top: 15px;
          color: white;
      }
      p a {
          color: yellow;
          text-decoration: none;
      }
      p a:hover {
          text-decoration: underline;
      }
  </style>
</head>
<body>
  <div class="overlay"></div>
  <div class="login-container">
      <!-- Updated logo image source to logo.jpg -->
      <img src="logo.jpg" alt="Logo">
      <h2><i class="fas fa-user-plus"></i> Admin Registration</h2>
      <form action="admin_register.php" method="POST">
          <div class="input-group">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Username" required>
          </div>
          <div class="input-group">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Email" required>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" required>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="confirm_password" placeholder="Confirm Password" required>
          </div>
          <button type="submit" class="login-btn"><i class="fas fa-arrow-right"></i> Register</button>
      </form>
      <p>Already have an account? <a href="admin_login.php"><i class="fas fa-sign-in-alt"></i> Login here</a></p>
  </div>
</body>
</html>
