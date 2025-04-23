<?php
session_start();
require_once 'db_connect.php';

// Check if a shoe_id is provided
if (!isset($_GET['shoe_id'])) {
    die("No product specified.");
}

$shoe_id = intval($_GET['shoe_id']);

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add or update the item in the cart
if (isset($_SESSION['cart'][$shoe_id])) {
    $_SESSION['cart'][$shoe_id]++;
} else {
    $_SESSION['cart'][$shoe_id] = 1;
}

// Redirect to the cart page so the customer can review their selections
header("Location: cart.php");
exit();
?>
