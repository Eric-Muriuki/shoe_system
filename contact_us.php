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
    .contact-info { margin-top: 20px; 
    }
    .contact-info h4 { font-size: 1.5rem; margin-bottom: 10px; color: #004085; }
    .contact-info p { font-size: 1rem; color: #555; }
    .contact-info i { color: #004085; font-size: 1.5rem; margin-right: 10px; }
    .contact-info .col-md-4 { text-align: center; }
    .contact-form { margin-top: 40px; }
    .contact-form .card {
  border-radius: 12px;
  background-color: #ffffff;
}

.contact-form .form-control {
  border-radius: 8px;
  transition: all 0.2s ease-in-out;
}

.contact-form .form-control:focus {
  border-color: #004085;
  box-shadow: 0 0 0 0.2rem rgba(0,64,133,.25);
}

    .contact-container {
  background-color: #ffffff;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  
  <div class="container mt-5 contact-container">
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
  <div class="col-md-10 offset-md-1">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h4 class="mb-4 text-primary">
          <i class="fas fa-paper-plane me-2"></i>Send Us a Message
        </h4>
        <form action="contact_us_process.php" method="POST">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label"><i class="fas fa-user me-1"></i>Your Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
            </div>
            <div class="col-md-6">
              <label class="form-label"><i class="fas fa-envelope me-1"></i>Your Email</label>
              <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="col-12">
              <label class="form-label"><i class="fas fa-info-circle me-1"></i>Subject</label>
              <input type="text" name="subject" class="form-control" placeholder="Subject" required>
            </div>
            <div class="col-12">
              <label class="form-label"><i class="fas fa-comment me-1"></i>Message</label>
              <textarea name="message" class="form-control" rows="5" placeholder="Your message here..." required></textarea>
            </div>
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-paper-plane"></i> Send Message
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

  </div>
  
  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
