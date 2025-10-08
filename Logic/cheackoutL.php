<?php
include '../database/config.php';

// Validate request method
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Sanitize and validate input
$book_id = (int) $_POST['book_id'];
$price = (float) $_POST['price'];
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$address = trim($_POST['address']);
$quantity = (int) $_POST['quantity'];

$quantity = 1;
if (isset($_GET['quantity']) && is_numeric($_GET['quantity']) && $_GET['quantity'] > 0) {
    $quantity = (int) $_GET['quantity'];
}


// Simulate payment processing
if ($quantity < 1) {
    die("Invalid quantity.");
}

// Insert into purchases table
try {
    $stmt = $conn->prepare("INSERT INTO purchases (book_id, quantity, customer_name, customer_email, address, purchase_datetime) VALUES (:book_id, :quantity, :name, :email, :address, NOW())");
    $stmt->execute([
        ':book_id' => $book_id,
        ':quantity' => $quantity,
        ':name' => $name,
        ':email' => $email,
        ':address' => $address
    ]);

    $purchase_id = $conn->lastInsertId();
    header("Location: cart.php?purchase_id=$purchase_id");
    exit;
} catch (PDOException $e) {
    die("Error saving purchase: " . $e->getMessage());
}
?>
