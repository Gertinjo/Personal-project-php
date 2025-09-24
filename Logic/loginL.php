<?php
// Start the session
session_start();

// Include the database connection
include_once('../database/config.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Collect form data (username and password)
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Debugging: Check if form data is being passed correctly
    var_dump($_POST); // See what data we are receiving from the form

    // Check if any field is empty
    if (empty($email) || empty($password)) {
        echo "Please fill in all fields";
    } else {
        // If fields are not empty, query the database for the user
        try {
            $sql = "SELECT id, name, surname, email, password, is_admin FROM user WHERE email = :email";
            $selectUser = $conn->prepare($sql);
            $selectUser->bindParam(":email", $email);
            $selectUser->execute();

            // Fetch the user data
            $data = $selectUser->fetch(PDO::FETCH_ASSOC);

            // Debugging: Show the data retrieved from the database
            var_dump($data); // Check the password hash and other user data

            // Check if the user exists
            if ($data == false) {
                echo "User not found";
            } else {
                // Verify the password
                if (password_verify($password, $data['password'])) {
                    $_SESSION['id'] = $data['id'];
                    $_SESSION['surname'] = $data['surname'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['name'] = $data['name'];
                    $_SESSION['is_admin'] = (int)$data['is_admin'];

                    // Redirect to the correct dashboard
                    if ($_SESSION['is_admin'] === 1) {
                        header("Location: ../Main/admin_dashboard.php");
                    } else {
                        header("Location: ../Main/user_dashboard.php");
                    }
                    exit();
                } else {
                    echo "Incorrect password";
                    var_dump($password, $data['password']); // Debug the password comparison
                }
            }
        } catch (PDOException $e) {
            // Handle any database connection errors
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
