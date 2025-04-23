<?php
session_start();

// Check if the shoe_id is provided and exists in the cart
if (isset($_GET['shoe_id']) && isset($_SESSION['cart'])) {
    $shoe_id = intval($_GET['shoe_id']);
    if (isset($_SESSION['cart'][$shoe_id])) {
        unset($_SESSION['cart'][$shoe_id]);
    }
}
header("Location: cart.php");
exit();
?>
