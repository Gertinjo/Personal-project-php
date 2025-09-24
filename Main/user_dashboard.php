<?php
include_once('../Database/config.php');

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../Forms/login.php");
    exit;
}
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 0) {
    echo "Access denied. You are not a regular user.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    123
</body>
</html>