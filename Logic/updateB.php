<?php 
/*
We will get the changed data from edit.php file and update them into database
*/
	include_once('../database/config.php');
	


	if (isset($_POST['submit1'])) {
		$id = $_POST['id'];
		$Book_name = $_POST['Book_name'];
		$description = $_POST['description'];
		$Price = $_POST['Price'];
		  $rating=$_POST['rating'];
		

		$sql = "UPDATE books SET id=:id,  Book_name=:Book_name, description=:description, Price=:Price,rating=:rating WHERE id=:id";

		$prep = $conn->prepare($sql);
		$prep->bindParam(':id',$id);
		$prep->bindParam(':Book_name',$Book_name);
		$prep->bindParam(':description',$description);
		$prep->bindParam(':Price',$Price);
		$prep->bindParam(':rating',$rating);
		
		$prep->execute();
		header("Location: ../main/admin_dashboard.php");
	}
 ?>