<?php 
require('../funct/functions-admin.php');

if( isset($_POST["login"]) ){

	$username = $_POST["username"];
	$password = $_POST["password"];

	$result = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$username' ");
	// check username
	if( mysqli_num_rows($result) === 1 ){

		// check password
		$row = mysqli_fetch_assoc($result);
		if( password_verify($password, $row["password"]) ){

			// set session
			$_SESSION["login"] = true;
			$_SESSION["username"] = $username;

			header("Location:index");
			exit;
		}
	}
	$error = true;
}



 ?>