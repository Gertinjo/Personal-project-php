<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Contact Us - Book Heaven</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
    /* All the same styles copied from your original design */
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
        max-width: 700px;
        margin: 40px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .container h2 {
        margin-bottom: 20px;
        font-size: 28px;
        text-align: center;
        color: #2d3436;
    }
    form label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        margin-top: 20px;
    }
    form input, form textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }
    form textarea {
        height: 120px;
        resize: vertical;
    }
    form button {
        margin-top: 20px;
        padding: 12px 20px;
        background-color: #2d98da;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    form button:hover {
        background-color: #1e7ecb;
    }
    footer {
        margin-top: 50px;
        padding: 25px;
        text-align: center;
        background-color: #2d3436;
        color: white;
    }
</style>
</head>
<body>
<header>📚 Book Heaven</header>
<nav>
    <a href="user_dashboard.php">Home</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact</a>
</nav>

<div class="hero">
    <h1>Contact Us</h1>
    <p>We're here to help! Get in touch with Book Heaven.</p>
</div>

<div class="container">
    <h2>Send a Message</h2>
    <form action="../Logic/contactL.php" method="POST">
        <label for="name">Your Name</label>
        <input type="text" id="name" name="name" required />

        <label for="email">Your Email</label>
        <input type="email" id="email" name="email" required />

        <label for="message">Message</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Send Message</button>
    </form>
</div>

<footer>
    &copy; <?php echo date("Y"); ?> Book Heaven. All rights reserved.
</footer>
</body>
</html>
