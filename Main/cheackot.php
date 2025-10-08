<?php
include '../database/config.php';

// Simulate getting a book from GET
if (!isset($_GET['book_id']) || !is_numeric($_GET['book_id'])) {
    die("Invalid book.");
}

$book_id = (int)$_GET['book_id'];

$sql = "SELECT * FROM books WHERE id = :id LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $book_id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout - Book Heaven</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6f8;
        margin: 0;
        padding: 40px 20px;
    }
    .checkout-container {
        max-width: 800px;
        margin: auto;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }
    h1 {
        text-align: center;
        margin-bottom: 30px;
        color: #2d3436;
    }
    .book-info {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }
    .book-info img {
        width: 150px;
        height: 220px;
        object-fit: cover;
        border-radius: 8px;
    }
    .book-details {
        flex: 1;
    }
    .book-details h2 {
        margin-bottom: 10px;
    }
    .price {
        color: #10ac84;
        font-weight: bold;
        font-size: 20px;
    }
    form label {
        display: block;
        margin: 15px 0 5px;
        font-weight: bold;
    }
    form input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }
    .btn-submit {
        margin-top: 30px;
        background: #0984e3;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
    }
    .btn-submit:hover {
        background: #065a9d;
    }
</style>
</head>
<body>

<div class="checkout-container">
    <h1>Checkout</h1>
    <div class="book-info">
        <img src="<?php echo htmlspecialchars($book['Books_image']); ?>" alt="Book Image">
        <div class="book-details">
            <h2><?php echo htmlspecialchars($book['Book_name']); ?></h2>
            <p class="price">$<?php echo number_format($book['Price'], 2); ?></p>
        </div>
    </div>

    <form action="process_checkout.php" method="POST">
        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
        <input type="hidden" name="price" value="<?php echo $book['Price']; ?>">

        <label for="name">Full Name</label>
        <input type="text" name="name" required>

        <label for="email">Email</label>
        <input type="email" name="email" required>

        <label for="address">Shipping Address</label>
        <input type="text" name="address" required>

        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" value="1" min="1" required>

        <label for="card">Card Number</label>
        <input type="text" name="card" placeholder="1234 5678 9012 3456" required>

        <label for="expiry">Expiry Date (MM/YY)</label>
        <input type="text" name="expiry" placeholder="12/25" required>

        <label for="cvv">CVV</label>
        <input type="text" name="cvv" placeholder="123" required>

        <button type="submit" class="btn-submit">Confirm Purchase</button>
    </form>
</div>

</body>
</html>
