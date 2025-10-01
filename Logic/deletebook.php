<?php 
	/*
	We will include config.php for connection with database.
	Delete a user based on his id.
	*/
	include_once('../Database/config.php');

	$id = $_GET['id'];
	$sql = "DELETE FROM books WHERE id=:id";
	$prep = $conn->prepare($sql);
	$prep->bindParam(':id',$id);
	$prep->execute();

	header("Location: ../main/admin_dashboard.php");
 ?>