<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:logout");
	exit;
}
// connection to functions-admin
require('../funct/functions-admin.php');
require('../funct/query.php');

$id = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["delete-laporan"]))))));
if( deleteLaporan($id) > 0 ){
	echo "
	<script>
		alert('Data laporan berhasil dihapus!');
		document.location.href = 'laporan';
	</script>";
} else{
	echo "
	<script>
		alert('Data laporan gagal dihapus!');
		document.location.href = 'laporan';
	</script>";
}

// check url delete-laporan
if( empty($_GET["delete-laporan"]) ){
	header("Location:laporan");
	exit;
}
if( !isset($_GET["delete-laporan"]) ){
	header("Location:laporan");
	exit;
}


 ?>