<?php 
//We will destroy all of the data associated with the current session
	session_start();

	include_once('../database/config.php');

	session_destroy();

	header("Location: ../Forms/login.php");


 ?>