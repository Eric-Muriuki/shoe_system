<?php
// payment_methods.php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Payment Methods - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f8f9fa;
    }

    h1 {
      font-size: 2.5rem;
      color: #004085;
      font-weight: bold;
    }

    .card {
      border: none;
      transition: all 0.3s ease-in-out;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 1rem;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .card i {
      font-size: 3.5rem;
      color: #0d6efd;
    }

    .card-title {
      font-weight: 600;
      font-size: 1.25rem;
    }

    .btn-primary {
      background-color: #0d6efd;
      border-color: #0d6efd;
    }

    .btn-primary:hover {
      background-color: #004085;
      border-color: #004085;
    }

    .lead {
      color: #555;
    }

    a.text-decoration-none:hover {
      text-decoration: none;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="bg-white shadow-lg rounded p-10">
        <div class="text-center mb-4">
          <h1 class="fw-bold text-primary">
            <i class="fas fa-money-check-alt me-2"></i>Payment Methods
          </h1>
          <p class="lead text-secondary">Choose your preferred payment method to proceed with your order.</p>
          <hr class="mx-auto" style="width: 60px; border-top: 3px solid #0d6efd;">
        </div>
      </div>
    </div>
  </div>
</div>

    
    <div class="row g-4">
      <!-- Credit/Debit Card -->
      <div class="col-md-4">
        <a href="process_payment.php?method=card" class="text-decoration-none">
          <div class="card text-center p-3">
            <div class="card-body">
              <i class="fas fa-credit-card"></i>
              <h5 class="card-title mt-3">Credit/Debit Card</h5>
              <p class="card-text">Pay securely with your card.</p>
              <button class="btn btn-primary mt-2">
                <i class="fas fa-arrow-right"></i> Proceed
              </button>
            </div>
          </div>
        </a>
      </div>

      <!-- PayPal -->
      <div class="col-md-4">
        <a href="process_payment.php?method=paypal" class="text-decoration-none">
          <div class="card text-center p-3">
            <div class="card-body">
              <i class="fab fa-paypal"></i>
              <h5 class="card-title mt-3">PayPal</h5>
              <p class="card-text">Use your PayPal account for secure payment.</p>
              <button class="btn btn-primary mt-2">
                <i class="fas fa-arrow-right"></i> Proceed
              </button>
            </div>
          </div>
        </a>
      </div>

      <!-- Mpesa -->
      <div class="col-md-4">
        <a href="process_payment.php?method=mpesa" class="text-decoration-none">
          <div class="card text-center p-3">
            <div class="card-body">
              <i class="fas fa-mobile-alt"></i>
              <h5 class="card-title mt-3">Mpesa</h5>
              <p class="card-text">Pay quickly using Mpesa.</p>
              <button class="btn btn-primary mt-2">
                <i class="fas fa-arrow-right"></i> Proceed
              </button>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>

  <?php include 'footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
