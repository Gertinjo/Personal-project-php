<?php
session_start();
include_once('../Database/config.php');

// Check if user is logged in and is admin (optional, remove if not needed)
if (!isset($_SESSION['id'])) {
    header("Location: ../Forms/login.php");
    exit;
}

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    echo "Access denied. You are not an admin.";
    exit;
}

// Fetch books from database
try {
    $sql = "SELECT id, `Book_name`, description, Price, rating, Books_image FROM books ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Books List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Books List</h1>

    <?php if (count($books) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Book Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Rating</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= htmlspecialchars($book['id']) ?></td>
                        <td><?= htmlspecialchars($book['Book_name']) ?></td>
                        <td><?= htmlspecialchars(strlen($book['description']) > 50 ? substr($book['description'], 0, 50) . '...' : $book['description']) ?></td>
                        <td><?= htmlspecialchars($book['Price']) ?></td>
                        <td><?= htmlspecialchars($book['rating']) ?></td>
                        <td>
                            <?php if (!empty($book['Books_image'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($book['Books_image']) ?>" alt="Book Image" style="max-height: 80px;" />
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No books found.</p>
    <?php endif; ?>

    <a href="admin_dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
