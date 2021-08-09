<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:auth/login");
}
require('funct/functions.php');

$idUser = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["unit"]))))))));
if( cancelOrder($idUser) > 0 ){
	echo "
	<script>
		alert('Pesanan anda berhasil dibatalkan!');
		document.location.href = 'index';
	</script>";
} else{
	echo "
	<script>
		alert('Pesanan anda gagal dibatalkan!');
		document.location.href = 'index';
	</script>";
}

// check url cancel-order
if( empty($_GET["unit"]) ){
	header("Location:index");
	exit;
}

if( !isset($_GET["unit"]) ){
	header("Location:index");
	exit;
}


 ?>