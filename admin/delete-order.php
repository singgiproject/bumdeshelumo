<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:logout");
	exit;
}
// connection to functions-admin
require('../funct/functions-admin.php');
require('../funct/query.php');

$id = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["delete-order"]))))));
if( deleteOrder($id) > 0 ){
	echo "
	<script>
		alert('Data pesanan berhasil dihapus!');
		document.location.href = 'daftar-order';
	</script>";
} else{
	echo "
	<script>
		alert('Data pesanan gagal dihapus!');
		document.location.href = 'daftar-order';
	</script>";
}

// check url delete-laporan
if( empty($_GET["delete-order"]) ){
	header("Location:daftar-order");
	exit;
}
if( !isset($_GET["delete-order"]) ){
	header("Location:daftar-order");
	exit;
}


 ?>