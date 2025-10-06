<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>About Us - Book Heaven</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f9fafb;
        color: #333;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        padding: 60px 20px;
    }
    .about-container {
        max-width: 900px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 12px 30px rgba(0,0,0,0.1);
        padding: 40px 50px;
        text-align: center;
    }
    h1 {
        color: #0984e3;
        font-size: 42px;
        margin-bottom: 15px;
        font-weight: 700;
    }
    .subtitle {
        font-size: 20px;
        color: #636e72;
        margin-bottom: 40px;
        font-style: italic;
    }
    p {
        font-size: 18px;
        line-height: 1.7;
        margin-bottom: 30px;
        color: #444;
    }
    .highlight {
        color: #10ac84;
        font-weight: 700;
    }
    .team {
        margin-top: 40px;
        font-size: 18px;
        color: #555;
    }
    @media (max-width: 600px) {
        .about-container {
            padding: 30px 20px;
        }
        h1 {
            font-size: 32px;
        }
        p, .subtitle, .team {
            font-size: 16px;
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
    <div class="about-container">
        <h1>Welcome to <span class="highlight">Book Heaven</span></h1>
        <div class="subtitle">Your sanctuary for stories, knowledge, and imagination</div>
        <p>
            At <strong>Book Heaven</strong>, we believe every book is a doorway to a new world — a place where adventures begin, ideas flourish, and emotions run deep. Our mission is to connect passionate readers with the perfect stories that inspire, comfort, and transform.
        </p>
        <p>
            Founded by book lovers, <strong>Book Heaven</strong> is more than just an online bookstore. It's a community that cherishes the joy of reading and the magic of discovering new authors and timeless classics alike.
        </p>
        <p>
            Whether you seek heartwarming tales, thrilling mysteries, or thought-provoking non-fiction, <strong>Book Heaven</strong> offers a curated collection of books to satisfy every taste and mood — delivered straight to your door with care and love.
        </p>
        <p class="team">
            Join us on this literary journey. Dive into <span class="highlight">Book Heaven</span> and let your imagination soar!
        </p>
    </div>
    <a class="back-link" href="user_dashboard.php">&larr; Back to Home</a>
</body>
</html>
