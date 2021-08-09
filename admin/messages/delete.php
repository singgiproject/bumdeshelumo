<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:../../auth/login");
	exit;
}
// connect file functions
include("../../funct/functions.php");
include("../../funct/funct_main.php");

$id = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["members"])))))))));

// cek fungsi hapus pesan
if( delete_messages($id) > 0 ){
	echo "
	<script>
		alert('Pesan berhasil dihapus!');
		document.location.href = 'members';
	</script>";
} else{
	echo "
	<script>
		alert('Pesan gagal dihapus!');
		document.location.href = 'members';
	</script>";
}


// URL SECURITY TAMBAHAN 
if( !isset($_GET["members"]) ){
	header("Location:members");
	return false;
}
if( empty($_GET["members"]) ){
	header("Location:members");
	return false;	
}
if( strlen($_GET["members"]) < 12 ){
	header("Location:members");
	return false;	
}
if( !base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["members"]))))))))) ){
	header("Location:members");
	return false;	
}



 ?>