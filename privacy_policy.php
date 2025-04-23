<?php
// privacy_policy.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Privacy Policy - Jambo Shoes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    .navbar-custom { background-color: #004085; }
    footer { background-color: #004085; color: #fff; padding: 30px 0; }
    footer a { color: #ffc107; text-decoration: none; }
    footer a:hover { text-decoration: underline; }
    body { font-family: Arial, sans-serif; background: #f8f9fa; }
    .policy-content { padding: 20px; background: #fff; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  <div class="container mt-5">
    <h1 class="mb-4">Privacy Policy</h1>
    <div class="policy-content">
      <p>At Jambo Shoes, we value your privacy and are committed to protecting your personal data. This privacy policy explains how we collect, use, and safeguard your information when you visit our website or make a purchase.</p>
      <h3>Information We Collect</h3>
      <p>We may collect personal data such as your name, email address, postal address, and payment details when you register on our site or place an order.</p>
      <h3>How We Use Your Information</h3>
      <p>Your information is used to process your orders, improve our services, and provide personalized shopping experiences. We may also use your data to send you updates and promotional offers, but only with your consent.</p>
      <h3>Data Security</h3>
      <p>We take appropriate measures to ensure your data is securely stored and processed. However, please note that no method of transmission over the internet is 100% secure.</p>
      <h3>Your Rights</h3>
      <p>You have the right to access, correct, or request deletion of your personal data. For any privacy-related concerns, please contact our support team.</p>
      <h3>Changes to This Policy</h3>
      <p>We may update our privacy policy from time to time. Any changes will be posted on this page, and your continued use of the site indicates your acceptance of any updated policy.</p>
      <p>If you have any questions about our privacy practices, please <a href="contact_us.php">contact us</a>.</p>
    </div>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
