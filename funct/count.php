<?php 
if( isset($_SESSION["login"]) ){

	// SESSION COUNT AMOUNT TB USER
	$notifSession = $_SESSION["username"];
	$notifResultSession = $conn->query("SELECT * FROM tb_users WHERE username = '$notifSession' ");
	$notifRowSession = mysqli_fetch_assoc($notifResultSession);
	$notifIdSession = $notifRowSession["id"];
	$amountNotif = $conn->query("SELECT COUNT(*) amountNotif FROM tb_notifications WHERE id_user = '$notifIdSession' ");
	$notifResultAmount = mysqli_fetch_assoc($amountNotif); 
}





 ?>