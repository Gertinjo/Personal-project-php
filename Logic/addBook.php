<?php
session_start();
include_once('../Database/config.php');

// Check if user is logged in and is admin
if (!isset($_SESSION['id'])) {
    header("Location: ../Forms/login.php");
    exit;
}

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    echo "Access denied. You are not an admin.";
    exit;
}

// Handle form submission to add a new book
if (isset($_POST['submit'])) {
    if (
        isset($_POST['Book_name'], $_POST['description'], $_POST['Price'], $_POST['rating'], $_POST['Books_image'])
        && $_POST['Book_name'] !== '' && $_POST['description'] !== '' && $_POST['Price'] !== ''
        && $_POST['rating'] !== '' && $_POST['Books_image'] !== ''
    ) {
        $Book_name = $_POST['Book_name'];
        $description = $_POST['description'];
        $Price = $_POST['Price'];
        $rating = $_POST['rating'];
        $Books_image = $_POST['Books_image'];

        try {
            // Use backticks for column names with spaces
            $sql = "INSERT INTO books (`Book name`, description, Price, rating, Books_image) 
                    VALUES (:Book_name, :description, :Price, :rating, :Books_image)";
            $insertbook = $conn->prepare($sql);

            $insertbook->bindParam(':Book_name', $Book_name, PDO::PARAM_STR);
            $insertbook->bindParam(':description', $description, PDO::PARAM_STR);
            $insertbook->bindParam(':Price', $Price, PDO::PARAM_STR);
            $insertbook->bindParam(':rating', $rating, PDO::PARAM_INT);
            $insertbook->bindParam(':Books_image', $Books_image, PDO::PARAM_STR);

            $insertbook->execute();

            $_SESSION['success_message'] = "Book added successfully!";
            header("Location: ../Main/admin_dashboard.php");
            exit;
        } catch (PDOException $e) {
            $_SESSION['error_message'] = "Database error: " . $e->getMessage();
            header("Location: ../Main/admin_dashboard.php");
            exit;
        }
    } else {
        $_SESSION['error_message'] = "All fields are required!";
        header("Location: ../Main/admin_dashboard.php");
        exit;
    }
}

// Fetch users
$sql = "SELECT * FROM user";
$selectUsers = $conn->prepare($sql);
$selectUsers->execute();
$users_data = $selectUsers->fetchAll(PDO::FETCH_ASSOC);

// Fetch books
$sql_Books = "SELECT * FROM books";
$selectBooks = $conn->prepare($sql_Books);
try {
    $selectBooks->execute();
    $Books_data = $selectBooks->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $Books_data = [];
}
?>
