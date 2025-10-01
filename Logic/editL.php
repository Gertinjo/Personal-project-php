<?php 
/*
We will get the changed data from editUsers.php file and update them into database
*/

	include_once('../database/config.php');

	if (isset($_POST['submit'])) {
		$id = $_POST['id'];
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$email = $_POST['email'];

		$sql = "UPDATE user SET id=:id, name=:name, surname=:surname, email=:email WHERE id=:id";

		$prep = $conn->prepare($sql);
		$prep->bindParam(':id',$id);
		$prep->bindParam(':name',$name);
		$prep->bindParam(':surname',$surname);
		$prep->bindParam(':email',$email);
		$prep->execute();
		header("Location: ../Main/admin_dashboard.php");
	}
 ?>