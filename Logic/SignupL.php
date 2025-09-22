<?php
 /*
  We will include config.php for connection with database.
  We will get datas from index.php file, and inster them into database when Sign up button is clicked in index.php file.
  If any of session is empty we will get a message
  */

	include_once('../Database/config.php');

	if(isset($_POST['submit']))
	{

		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$email = $_POST['email'];

		$tempPass = $_POST['password'];
		$password = password_hash($tempPass, PASSWORD_DEFAULT);




		if(empty($name) || empty($surname) || empty($email) || empty($password))
		{
			echo "You have not filled in all the fields.";
		}
		else
		{

			$sql = "INSERT INTO users(name,surname,email,password) VALUES (:name, :surname, :email, :password)";

			$insertSql = $conn->prepare($sql);
			

			$insertSql->bindParam(':name', $name);
			$insertSql->bindParam(':surname', $surname);
			$insertSql->bindParam(':email', $email);
			$insertSql->bindParam(':password', $password);

			$insertSql->execute();

			header("Location: login.php");


		}



	}


?>