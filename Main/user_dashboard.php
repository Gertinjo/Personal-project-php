<?php
include '../database/config.php';

$sql = "SELECT * FROM books";
$stmt = $conn->prepare($sql);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Book Heaven</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
    * {
        box-sizing: border-box;
        margin: 0; padding: 0;
    }
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6f8;
        color: #2d3436;
    }
    header {
        background-color: #2d98da;
        color: #fff;
        padding: 30px;
        text-align: center;
        font-size: 32px;
        letter-spacing: 1px;
    }
    nav {
        background-color: #54a0ff;
        display: flex;
        justify-content: center;
        gap: 25px;
        padding: 15px 0;
    }
    nav a {
        color: white;
        text-decoration: none;
        font-size: 16px;
        transition: all 0.3s;
    }
    nav a:hover {
        text-decoration: underline;
    }
    .hero {
        background: linear-gradient(135deg, #48dbfb, #1dd1a1);
        color: white;
        text-align: center;
        padding: 60px 20px;
    }
    .hero h1 {
        font-size: 40px;
        margin-bottom: 10px;
    }
    .hero p {
        font-size: 18px;
        opacity: 0.9;
    }
    .container {
        padding: 40px 20px;
        max-width: 1200px;
        margin: auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 30px;
        width: 650px;
    }
    a.book-link {
        text-decoration: none;
        color: inherit;
    }
    .book {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        transition: all 0.3s;
        cursor: pointer;
        height: 100%;
    }
    .book:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    .book img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        object-position: center;
        border-bottom: 1px solid #eee;
        background-color: #f0f0f0;
    }
    .book-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .book h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #2d3436;
    }
    .book p {
        font-size: 14px;
        color: #636e72;
        flex-grow: 1;
    }
    .book-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
    }
    .price {
        color: #10ac84;
        font-size: 18px;
        font-weight: bold;
    }
    .rating {
        background: #feca57;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: bold;
    }
    footer {
        margin-top: 50px;
        padding: 25px;
        text-align: center;
        background-color: #2d3436;
        color: white;
    }
    @media (max-width: 600px) {
        .hero h1 {
            font-size: 28px;
        }
        .hero p {
            font-size: 16px;
        }
        nav {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
</head>
<body>
<header>📚 Book Heaven</header>
<nav>
    <a href="#">Home</a>
    <a href="about.php">About us</a>
    <a href="contact.php">Contact</a>

</nav>
<div class="hero">
    <h1>Explore The World of Books</h1>
    <p>Dive into new stories. Buy your next read today.</p>
</div>
<div class="container">
    <?php if (!empty($books)): ?>
        <?php foreach ($books as $book): ?>
            <a class="book-link" href="book_details.php?id=<?php echo $book['id']; ?>">
                <div class="book">
                    <img src="<?php echo htmlspecialchars($book['Books_image']); ?>" alt="Book Image" />
                    <div class="book-content">
                        <h3><?php echo htmlspecialchars($book['Book_name']); ?></h3>
                        <p><?php echo htmlspecialchars(mb_strimwidth($book['description'], 0, 100, "...")); ?></p>
                        <div class="book-footer">
                            <div class="price">$<?php echo number_format($book['Price'], 2); ?></div>
                            <div class="rating"><?php echo htmlspecialchars($book['rating']); ?> ★</div>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center; font-size: 18px; grid-column: 1 / -1;">No books available at the moment.</p>
    <?php endif; ?>
</div>
<footer>
    &copy; <?php echo date("Y"); ?> Book Heaven. All rights reserved.
</footer>
</body>
</html>
