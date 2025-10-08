<?php 
// Delete a book by ID — Safe version
include_once('../Database/config.php');

// Validate the ID before using it
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid ID.");
}

$id = (int)$_GET['id'];

try {
    $sql = "DELETE FROM books WHERE id = :id";
    $prep = $conn->prepare($sql);
    $prep->bindParam(':id', $id, PDO::PARAM_INT);
    $prep->execute();

    // Redirect if deletion successful
    header("Location: ../Main/admin_dashboard.php");
    exit;
} catch (PDOException $e) {
    echo "Error deleting book: " . $e->getMessage();
}
?>