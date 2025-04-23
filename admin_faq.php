<?php
session_start();
require_once 'db_connect.php';

// Ensure only admins can access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin FAQ - Jambo Shoes</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fa;
    }
    .faq-container {
      padding: 80px 0;
    }
    .faq-header {
      text-align: center;
      margin-bottom: 40px;
    }
    .accordion-button:not(.collapsed) {
      color: #fff;
      background-color: #004085;
    }
    .accordion-button i {
      margin-right: 10px;
    }
    .accordion-header h2 {
      font-size: 1.25rem;
    }
  </style>
</head>
<body>
  <?php include 'admin_header.php'; ?>
  
  <div class="container faq-container">
    <div class="faq-header">
      <h1><i class="fas fa-question-circle"></i> Admin FAQ</h1>
      <p class="lead">Frequently Asked Questions for the Admin Panel</p>
    </div>
    <div class="accordion" id="faqAccordion">
      <!-- FAQ 1 -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
            <i class="fas fa-info-circle"></i> How do I manage customer accounts?
          </button>
        </h2>
        <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Navigate to the <strong>Customers</strong> section from the dashboard to view, add, update, or delete customer accounts.
          </div>
        </div>
      </div>
      <!-- FAQ 2 -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
            <i class="fas fa-info-circle"></i> How can I update product information?
          </button>
        </h2>
        <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Go to the <strong>Products</strong> section, select the product to update, and click the edit button to modify its details such as price, stock, and description.
          </div>
        </div>
      </div>
      <!-- FAQ 3 -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingThree">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
            <i class="fas fa-info-circle"></i> How do I process customer orders?
          </button>
        </h2>
        <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Visit the <strong>Orders</strong> section to review customer orders. You can then update the order status and process the order accordingly.
          </div>
        </div>
      </div>
      <!-- FAQ 4 -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqHeadingFour">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseFour" aria-expanded="false" aria-controls="faqCollapseFour">
            <i class="fas fa-info-circle"></i> Who do I contact for technical support?
          </button>
        </h2>
        <div id="faqCollapseFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            For technical support, please contact our team at <a href="mailto:support@jamboshoes.com">support@jamboshoes.com</a>.
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <?php include 'admin_footer.php'; ?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
