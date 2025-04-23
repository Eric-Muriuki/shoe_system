<?php
session_start();

// Check if the cart and quantities are set
if (isset($_POST['quantities']) && isset($_SESSION['cart'])) {
    foreach ($_POST['quantities'] as $shoe_id => $quantity) {
        // Ensure quantity is a positive integer; if not, remove the item
        $quantity = intval($quantity);
        if ($quantity > 0) {
            $_SESSION['cart'][$shoe_id] = $quantity;
        } else {
            // Remove the product if the quantity is invalid
            unset($_SESSION['cart'][$shoe_id]);
        }
    }
}
header("Location: cart.php");
exit();
?>
