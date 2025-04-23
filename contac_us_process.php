<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Simple validation
    if(empty($name) || empty($email) || empty($subject) || empty($message)) {
        $_SESSION['contact_error'] = "All fields are required.";
        header("Location: contact_us.php");
        exit();
    }

    // Prepare email details
    $to = "support@jamboshoes.com";  // Change to your support email
    $headers  = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $fullMessage  = "You have received a new message from Jambo Shoes contact form.\n\n";
    $fullMessage .= "Name: " . $name . "\n";
    $fullMessage .= "Email: " . $email . "\n";
    $fullMessage .= "Subject: " . $subject . "\n\n";
    $fullMessage .= "Message:\n" . $message;

    // Attempt to send the email
    if(mail($to, $subject, $fullMessage, $headers)) {
        $_SESSION['contact_success'] = "Your message has been sent successfully. We will contact you soon!";
    } else {
        $_SESSION['contact_error'] = "There was an error sending your message. Please try again later.";
    }
    header("Location: contact_us.php");
    exit();
} else {
    header("Location: contact_us.php");
    exit();
}
?>
