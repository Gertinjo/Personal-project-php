<?php
session_start();
include_once('../database/config.php');

// Validate and sanitize ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid book ID.");
}
$id = (int)$_GET['id'];

// Fetch book data
$sql = "SELECT * FROM books WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$book) {
  echo "ID received: " . $id;
  die("Book not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Book | Book Heaven Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background-color: #f5f6fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .container {
        max-width: 650px;
        margin: 60px auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        padding: 40px;
    }
    h2 {
        color: #0984e3;
        margin-bottom: 30px;
    }
    .form-control, .form-label {
        font-size: 16px;
    }
    .btn-primary {
        background-color: #0984e3;
        border: none;
    }
    .btn-primary:hover {
        background-color: #74b9ff;
    }
  </style>
</head>
<body>

<div class="container">
    <h2>Edit Book Details</h2>

    <form action="../Logic/updateB.php" method="post">
        <input type="hidden" name="id" value="<?= $book['id'] ?>">

        <div class="mb-3">
            <label for="book_name" class="form-label">Book Name</label>
            <input type="text" class="form-control" id="Book_name" name="Book_name" value="<?= htmlspecialchars($book['Book_name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Book Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($book['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label for="Price" class="form-label">Price ($)</label>
            <input type="number" step="0.01" class="form-control" id="Price" name="Price" value="<?= $book['Price'] ?>" required>
        </div>

        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-10)</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="10" value="<?= $book['rating'] ?>" required>
        </div>

        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary btn-lg">Update Book</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
