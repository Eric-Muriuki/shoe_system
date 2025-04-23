<?php
// about.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>About - Jambo Shoes</title>
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
    footer { 
      background-color: #004085; 
      color: #fff; 
      padding: 30px 0; 
    }
    footer a { 
      color: #ffc107; 
      text-decoration: none; 
    }
    footer a:hover { 
      text-decoration: underline; 
    }
    .about-section {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 30px;
      margin-top: 30px;
    }
    .about-section h2 {
      color: #004085;
    }
    .about-section p {
      font-size: 16px;
      line-height: 1.6;
    }
    .icon-box {
      font-size: 2rem;
      color: #004085;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  
  <div class="container mt-5">
    <h1 class="mb-4 text-center">About Jambo Shoes</h1>
    
    <div class="about-section">
      <div class="mb-4">
        <div class="icon-box text-center">
          <i class="fas fa-info-circle"></i>
        </div>
        <h2>Our Story</h2>
        <p>
          Founded with a passion for style and comfort, Jambo Shoes has grown to become a trusted name in the footwear industry. Our journey started in a small boutique and evolved into a brand that offers exclusive shoe collections for every style and occasion.
        </p>
      </div>
      
      <div class="mb-4">
        <div class="icon-box text-center">
          <i class="fas fa-bullseye"></i>
        </div>
        <h2>Our Mission</h2>
        <p>
          Our mission is to empower our customers with shoes that blend comfort, quality, and style. We are dedicated to ensuring every pair we offer meets the highest standards, so you can step out with confidence every day.
        </p>
      </div>
      
      <div class="mb-4">
        <div class="icon-box text-center">
          <i class="fas fa-handshake"></i>
        </div>
        <h2>Our Commitment</h2>
        <p>
          At Jambo Shoes, customer satisfaction is our top priority. We continually innovate and expand our collections to cater to diverse tastes and needs, ensuring that every customer finds the perfect pair. We are committed to sustainability, quality, and exceptional service.
        </p>
      </div>
      
      <div class="mb-4">
        <div class="icon-box text-center">
          <i class="fas fa-users"></i>
        </div>
        <h2>Community & Support</h2>
        <p>
          We value our community and strive to build long-lasting relationships with our customers. Whether you have a question or need help with your order, our dedicated support team is always here to help.
        </p>
      </div>
    </div>
  </div>
  
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
