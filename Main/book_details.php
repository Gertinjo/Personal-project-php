<?php
include '../database/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid book ID.");
}

$book_id = (int)$_GET['id'];

$sql = "SELECT * FROM books WHERE id = :id LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(['id' => $book_id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
    die("Book not found.");
}

$purchase_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy'])) {
    $quantity = isset($_POST['quantity']) && is_numeric($_POST['quantity']) && $_POST['quantity'] > 0 ? (int)$_POST['quantity'] : 1;

    $sqlInsert = "INSERT INTO purchases (book_id, quantity, purchase_datetime) VALUES (:book_id, :quantity, NOW())";
    $stmtInsert = $conn->prepare($sqlInsert);
    if ($stmtInsert->execute(['book_id' => $book_id, 'quantity' => $quantity])) {
        $purchase_id = $conn->lastInsertId();
        header("Location: purchase.php?purchase_id=" . $purchase_id);
        exit;
    } else {
        $purchase_error = "Error processing your purchase. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title><?php echo htmlspecialchars($book['Book_name']); ?> - Book Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f5f7fa;
        margin: 0;
        padding: 40px 20px;
        color: #2d3436;
        display: flex;
        justify-content: center;
    }
    .container {
        max-width: 900px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        display: flex;
        gap: 40px;
        padding: 30px;
        flex-wrap: wrap;
    }
    .image-section img {
        width: 320px;
        height: 450px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    .details-section {
        flex: 1;
        min-width: 300px;
        display: flex;
        flex-direction: column;
    }
    .details-section h1 {
        font-size: 32px;
        margin-bottom: 12px;
        color: #0984e3;
    }
    .rating {
        font-weight: 700;
        font-size: 18px;
        margin-bottom: 18px;
        color: #feca57;
    }
    .description {
        font-size: 16px;
        line-height: 1.6;
        color: #636e72;
        margin-bottom: 25px;
        white-space: pre-wrap;
    }
    .price {
        font-size: 26px;
        font-weight: 700;
        color: #10ac84;
        margin-bottom: 30px;
    }
    form {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    label {
        font-weight: 600;
        font-size: 16px;
    }
    input[type="number"] {
        width: 70px;
        padding: 8px 12px;
        font-size: 16px;
        border: 1.8px solid #dfe6e9;
        border-radius: 6px;
        transition: border-color 0.3s ease;
    }
    input[type="number"]:focus {
        border-color: #0984e3;
        outline: none;
    }
    button {
        padding: 12px 28px;
        background-color: #0984e3;
        border: none;
        border-radius: 8px;
        color: white;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #065a9d;
    }
    .error {
        margin-top: 20px;
        color: #d63031;
        font-weight: 600;
    }
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
            padding: 20px;
        }
        .image-section img {
            width: 100%;
            height: auto;
        }
    }
            a.back-link {
            display: inline-block;
            margin-bottom: 25px;
            color: #2d98da;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
</style>
</head>
<body>
       <a class="back-link" href="user_dashboard.php">&larr; Back to books</a>
<div class="container">
    <div class="image-section">
        <img src="<?php echo htmlspecialchars($book['Books_image']); ?>" alt="<?php echo htmlspecialchars($book['Book_name']); ?>" />
    </div>
    <div class="details-section">
        <h1><?php echo htmlspecialchars($book['Book_name']); ?></h1>
        <div class="rating"><?php echo htmlspecialchars($book['rating']); ?> ★</div>
        <div class="description"><?php echo nl2br(htmlspecialchars($book['description'])); ?></div>
        <div class="price">$<?php echo number_format($book['Price'], 2); ?></div>
        <form method="POST" novalidate>
            <label for="quantity">Quantity (Sasia):</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1" required />
            <button type="submit" name="buy">Buy Now</button>
        </form>
        <?php if ($purchase_error): ?>
            <div class="error"><?php echo $purchase_error; ?></div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
