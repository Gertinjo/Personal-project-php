<?php
// Include database config
include_once('../Database/config.php');

if (isset($_POST['submit'])) {

    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $email = $_POST['email'] ?? '';
    $tempPass = $_POST['password'] ?? '';
    $password = password_hash($tempPass, PASSWORD_DEFAULT);

    // Check for empty fields
    if (empty($name) || empty($surname) || empty($email) || empty($tempPass)) {
        echo "You have not filled in all the fields.";
        exit;
    }

    try {
        // Prepare SQL and bind parameters
        $sql = "INSERT INTO user(name, surname, email, password) 
                VALUES (:name, :surname, :email, :password)";
        $insertSql = $conn->prepare($sql);

        $insertSql->bindParam(':name', $name);
        $insertSql->bindParam(':surname', $surname);
        $insertSql->bindParam(':email', $email);
        $insertSql->bindParam(':password', $password);

        $insertSql->execute();

        // Redirect to login page
        header("Location: ../Forms/login.php");
        exit;

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

session_start();
include_once('../Database/config.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $adminCode = $_POST['admin_code'] ?? '';

    if (empty($email) || empty($password)) {
        echo "Please fill in all fields.";
        exit;
    }

    $sql = "SELECT * FROM user WHERE email = :email LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        if ($adminCode === '667') {
            $_SESSION['is_admin'] = 1;
            header("Location: ../Dashboard/admin_dashboard.php");
        } else {
            $_SESSION['is_admin'] = (int)$user['is_admin'];
            if ($_SESSION['is_admin'] === 1) {
                header("Location: ../Dashboard/admin_dashboard.php");
            } else {
                header("Location: ../main/user_dashboard.php");
            }
        }
        exit;
    } else {
        echo "Invalid email or password.";
    }
}


?>
