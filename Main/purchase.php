<?php
include '../database/config.php';

if (!isset($_GET['purchase_id']) || !is_numeric($_GET['purchase_id'])) {
    die("Invalid purchase reference.");
}

$purchase_id = (int)$_GET['purchase_id'];

$sql = "SELECT p.quantity, p.purchase_datetime, b.Book_name, b.Price, b.Books_image
        FROM purchases p
        JOIN books b ON p.book_id = b.id
        WHERE p.id = :purchase_id
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->execute(['purchase_id' => $purchase_id]);
$purchase = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$purchase) {
    die("Purchase not found.");
}

$total = $purchase['Price'] * $purchase['quantity'];
$date = date('Y-m-d', strtotime($purchase['purchase_datetime']));
$time = date('H:i:s', strtotime($purchase['purchase_datetime']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Purchase Confirmation</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f2f5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        padding: 20px;
    }
    .receipt {
        background: white;
        padding: 30px 40px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        max-width: 400px;
        text-align: center;
    }
    .receipt img {
        width: 180px;
        height: 250px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 25px;
    }
    h2 {
        margin-bottom: 10px;
        color: #0984e3;
    }
    .details {
        font-size: 16px;
        color: #2d3436;
        margin: 15px 0;
    }
    .details strong {
        color: #10ac84;
    }
    .thank-you {
        font-size: 18px;
        margin-top: 25px;
        color: #27ae60;
        font-weight: 700;
    }
    .btn-back {
        margin-top: 30px;
        display: inline-block;
        padding: 12px 30px;
        background: #0984e3;
        color: white;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }
    .btn-back:hover {
        background: #065a9d;
    }
</style>
</head>
<body>
    <div class="receipt">
        <img src="<?php echo htmlspecialchars($purchase['Books_image']); ?>" alt="Book Image" />
        <h2>Purchase Confirmed!</h2>
        <div class="details"><strong>Book:</strong> <?php echo htmlspecialchars($purchase['Book_name']); ?></div>
        <div class="details"><strong>Quantity (Sasia):</strong> <?php echo (int)$purchase['quantity']; ?></div>
        <div class="details"><strong>Price per Book:</strong> $<?php echo number_format($purchase['Price'], 2); ?></div>
        <div class="details"><strong>Total Paid:</strong> $<?php echo number_format($total, 2); ?></div>
        <div class="details"><strong>Date:</strong> <?php echo $date; ?></div>
        <div class="details"><strong>Time:</strong> <?php echo $time; ?></div>
        <div class="thank-you">Thank you for your purchase!</div>
        <a href="user_dashboard.php" class="btn-back">Back to Books</a>
    </div>
</body>
</html>
