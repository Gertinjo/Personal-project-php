<?php	

//Including config.php file for connection with dataBase 
	include_once('../database/config.php');

//If the Button Add Book in Books.php is pressed, we will get datas that users added into the form, and insert them into dataBase :
	if(isset($_POST['submit']))
	{

		$Books_name = $_POST['Books_name'];
		$Books_desc = $_POST['Books_desc'];
		$Books_price = $_POST['Books_price'];
		$Books_rating = $_POST['Books_rating'];
		$Books_image = $_POST['Books_image'];
	

		$sql = "INSERT INTO books(Books_name, Books_desc, Books_price, Books_rating, Books_image) VALUES (:Books_name, :Books_desc, :Books_price, :Books_rating, :Books_image)";

        $insertbook = $conn->prepare($sql);
			

		$insertbooks->BindParam(':Books_name', $Books_name);
		$insertbooks->BindParam(':Books_desc', $Books_desc);
		$insertbooks->BindParam(':Books_preice', $Books_price);
		$insertbooks->BindParam(':Books_rating', $Books_rating);
		$insertbooks->BindParam(':Books_image', $Books_image);

		$insertbooks->execute();

		// Set success message
		session_start();
		$_SESSION['success_message'] = "Book added successfully!";

		// Redirect to dashBoard
		header("Location: dashBoard.php");
		exit;
	}
?>