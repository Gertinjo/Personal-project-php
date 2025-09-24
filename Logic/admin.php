
<?php
session_start();

$sql = "SELECT * FROM user WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['is_admin'] = $user['is_admin'];

    if ($user['is_admin']) {
        header("Location: ../Dashboard/admin_dashboard.php");
    } else {
        header("Location: ../Dashboard/user_dashboard.php");
    }
    exit;
} else {
    echo "Invalid email or password.";
}
?>