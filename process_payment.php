<?php
session_start();
require_once 'db_connect.php';

// Check if payment method is provided
if (!isset($_GET['method'])) {
    header("Location: payment_methods.php");
    exit();
}

// For demonstration, simulate payment success.
$payment_method = $_GET['method'];

// Ensure required session data exists
if (!isset($_SESSION['shipping']) || !isset($_SESSION['order_total']) || !isset($_SESSION['cart'])) {
    // If not, redirect customer back to checkout to complete shipping details.
    header("Location: checkout.php");
    exit();
}

// Retrieve shipping info and order total from session
$shipping = $_SESSION['shipping'];
$total    = $_SESSION['order_total'];
$cart     = $_SESSION['cart'];
$customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$order_date  = date("Y-m-d H:i:s");
$status      = "Pending";

// Insert the order into the orders table
$stmt = $conn->prepare("INSERT INTO orders (customer_id, order_date, total, status, shipping_name, shipping_address, shipping_phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssss", $customer_id, $order_date, $total, $status, $shipping['shipping_name'], $shipping['shipping_address'], $shipping['shipping_phone']);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

// Fetch product details for each item in the cart
$productIDs = array_keys($cart);
$ids = implode(',', $productIDs);
$sql = "SELECT * FROM shoes WHERE shoe_id IN ($ids)";
$result = $conn->query($sql);
$products = [];
while ($row = $result->fetch_assoc()) {
    $row['quantity'] = $cart[$row['shoe_id']];
    $products[] = $row;
}

// Insert each product into the order_details table
foreach ($products as $product) {
    $stmt = $conn->prepare("INSERT INTO order_details (order_id, shoe_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $order_id, $product['shoe_id'], $product['quantity'], $product['price']);
    $stmt->execute();
    $stmt->close();
}

// Clear the cart and shipping details after order placement
unset($_SESSION['cart']);
unset($_SESSION['shipping']);
unset($_SESSION['order_total']);

// Redirect to thank_you.php with the new order ID
header("Location: thank_you.php?order_id=" . $order_id);
exit();
?>
