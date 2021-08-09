<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:auth/login");
}
require('funct/functions.php');

$id = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["notif"]))))))));
if( deleteNotification($id) > 0 ){
	header("Location:notification");
	exit;
} else{
	header("Location:notification");
	exit;
}

// check url delete-notification
if( empty($_GET["notif"]) ){
	header("Location:index");
	exit;
}
if( !isset($_GET["notif"]) ){
	header("Location:index");
	exit;
}

 ?>