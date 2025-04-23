<?php
// contact_us.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: #f8f9fa; 
    }
    .navbar-custom { background-color: #004085; }
    footer { background-color: #004085; color: #fff; padding: 30px 0; }
    footer a { color: #ffc107; text-decoration: none; }
    footer a:hover { text-decoration: underline; }
    .contact-info { margin-top: 20px; }
    .contact-info h4 { color: #004085; }
    .contact-form { margin-top: 40px; }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  
  <div class="container mt-5">
    <h1>Contact Us</h1>
    <p>If you have any questions, please feel free to reach out. You can contact us using any of the methods below or fill out the contact form.</p>
    
    <!-- Additional Contact Information -->
    <div class="row contact-info">
      <div class="col-md-4">
        <h4><i class="fas fa-map-marker-alt"></i> Our Address</h4>
        <p>123 Shoe Street<br>Fashion City, FC 12345</p>
      </div>
      <div class="col-md-4">
        <h4><i class="fas fa-phone-alt"></i> Phone</h4>
        <p>(123) 456-7890</p>
      </div>
      <div class="col-md-4">
        <h4><i class="fas fa-envelope"></i> Email</h4>
        <p>support@jamboshoes.com</p>
      </div>
    </div>
    
    <!-- Contact Form -->
    <div class="row contact-form">
      <div class="col-md-8 offset-md-2">
        <h4><i class="fas fa-paper-plane"></i> Send Us a Message</h4>
        <form action="contact_us_process.php" method="POST">
          <div class="mb-3">
            <label class="form-label"><i class="fas fa-user"></i> Your Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
          </div>
          <div class="mb-3">
            <label class="form-label"><i class="fas fa-envelope"></i> Your Email</label>
            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
          </div>
          <div class="mb-3">
            <label class="form-label"><i class="fas fa-info-circle"></i> Subject</label>
            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
          </div>
          <div class="mb-3">
            <label class="form-label"><i class="fas fa-comment"></i> Message</label>
            <textarea name="message" class="form-control" rows="5" placeholder="Your message here..." required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-paper-plane"></i> Send Message
          </button>
        </form>
      </div>
    </div>
  </div>
  
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
