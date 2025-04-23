<?php
session_start();
require_once 'db_connect.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = "";
$success = "";

// Process form submissions based on form type
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type'])) {
    $form_type = $_POST['form_type'];
    
    if ($form_type == "account_details") {
        // Update account details: name and email
        $name  = trim($_POST["name"]);
        $email = trim($_POST["email"]);
        
        $stmt = $conn->prepare("UPDATE customers SET name = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $email, $user_id);
        if ($stmt->execute()) {
            $success = "Account details updated successfully.";
            $_SESSION['username'] = $name;
        } else {
            $error = "Error updating account details: " . $conn->error;
        }
        $stmt->close();
    }
    elseif ($form_type == "change_password") {
        // Change password form
        $current_password = $_POST["current_password"];
        $new_password     = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];
        
        // Retrieve current hashed password
        $stmt = $conn->prepare("SELECT password FROM customers WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($db_password);
        $stmt->fetch();
        $stmt->close();
        
        if (!password_verify($current_password, $db_password)) {
            $error = "Current password is incorrect.";
        } elseif ($new_password !== $confirm_password) {
            $error = "New password and confirmation do not match.";
        } else {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
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
    elseif ($form_type == "notifications") {
        // Update notification preferences
        $email_notifications = isset($_POST["email_notifications"]) ? 1 : 0;
        $sms_notifications   = isset($_POST["sms_notifications"]) ? 1 : 0;
        $push_notifications  = isset($_POST["push_notifications"]) ? 1 : 0;
        
        // Check if notification settings exist
        $stmt = $conn->prepare("SELECT id FROM notification_settings WHERE customer_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            // Update existing settings
            $stmt->close();
            $stmt = $conn->prepare("UPDATE notification_settings SET email_notifications = ?, sms_notifications = ?, push_notifications = ? WHERE customer_id = ?");
            $stmt->bind_param("iiii", $email_notifications, $sms_notifications, $push_notifications, $user_id);
            if ($stmt->execute()) {
                $success = "Notification preferences updated.";
            } else {
                $error = "Error updating notifications: " . $conn->error;
            }
            $stmt->close();
        } else {
            $stmt->close();
            // Insert new settings
            $stmt = $conn->prepare("INSERT INTO notification_settings (customer_id, email_notifications, sms_notifications, push_notifications) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiii", $user_id, $email_notifications, $sms_notifications, $push_notifications);
            if ($stmt->execute()) {
                $success = "Notification preferences saved.";
            } else {
                $error = "Error saving notifications: " . $conn->error;
            }
            $stmt->close();
        }
    }
}
 
// Fetch current account details for display
$stmt = $conn->prepare("SELECT name, email FROM customers WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($current_name, $current_email);
$stmt->fetch();
$stmt->close();

// Fetch current notification settings (if they exist)
$stmt = $conn->prepare("SELECT email_notifications, sms_notifications, push_notifications FROM notification_settings WHERE customer_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$email_notifications = 1;
$sms_notifications   = 0;
$push_notifications  = 1;
if ($stmt->num_rows > 0) {
    $stmt->bind_result($email_notifications, $sms_notifications, $push_notifications);
    $stmt->fetch();
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Settings - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f8f9fa; }
    .nav-tabs .nav-link { color: #004085; }
    .nav-tabs .nav-link.active { color: #fff; background-color: #004085; }
    .input-group-text { background-color: #004085; color: #fff; }
    .btn-primary { background-color: #004085; border-color: #004085; }
    .btn-primary:hover { background-color: #003366; border-color: #002244; }
    .container { max-width: 600px; margin-top: 50px; }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  
  <div class="container bg-white ">
    <h2 class="mb-4 text-primary  text-center"><i class="fas fa-cogs"></i> Account Settings</h2>
    
    <?php if ($error): ?>
      <div class="alert alert-danger" role="alert">
        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
      </div>
    <?php elseif ($success): ?>
      <div class="alert alert-success" role="alert">
        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
      </div>
    <?php endif; ?>
    
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="true">
          <i class="fas fa-user-cog"></i> Account Details
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">
          <i class="fas fa-key"></i> Change Password
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button" role="tab" aria-controls="notifications" aria-selected="false">
          <i class="fas fa-bell"></i> Notifications
        </button>
      </li>
    </ul>
    
    <!-- Tab content -->
    <div class="tab-content p-4 border border-top-0" id="settingsTabsContent">
      
      <!-- Account Details Tab -->
      <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
        <form action="settings.php" method="POST">
          <input type="hidden" name="form_type" value="account_details">
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" name="name" class="form-control" placeholder="Full Name" value="<?php echo htmlspecialchars($current_name); ?>" required>
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo htmlspecialchars($current_email); ?>" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Account</button>
          </div>
        </form>
      </div>
      
      <!-- Change Password Tab -->
      <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
        <form action="settings.php" method="POST">
          <input type="hidden" name="form_type" value="change_password">
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" name="current_password" class="form-control" placeholder="Current Password" required>
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-key"></i></span>
            <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
          </div>
          <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-key"></i></span>
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Change Password</button>
          </div>
        </form>
      </div>
      
      <!-- Notifications Tab -->
      <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
        <form action="settings.php" method="POST">
          <input type="hidden" name="form_type" value="notifications">
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="email_notifications" id="email_notifications" <?php echo ($email_notifications) ? "checked" : ""; ?>>
            <label class="form-check-label" for="email_notifications"><i class="fas fa-envelope"></i> Email Notifications</label>
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="sms_notifications" id="sms_notifications" <?php echo ($sms_notifications) ? "checked" : ""; ?>>
            <label class="form-check-label" for="sms_notifications"><i class="fas fa-sms"></i> SMS Notifications</label>
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="push_notifications" id="push_notifications" <?php echo ($push_notifications) ? "checked" : ""; ?>>
            <label class="form-check-label" for="push_notifications"><i class="fas fa-bell"></i> Push Notifications</label>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Notifications</button>
          </div>
        </form>
      </div>
      
    </div>
    
  </div>
  
  <?php include 'footer.php'; ?>
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
