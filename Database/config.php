<?php
$user="root";
$pass="";
$server="localhost";
$dbname="gertidb1";


try {
    $conn = new PDO("mysql:host=localhost;dbname=gertidb1", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

