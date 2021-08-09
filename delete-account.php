<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:auth/login");
}
require('funct/functions.php');

// SESSION USER ORDER
if( isset($_SESSION["login"]) ){
	$userSessionOrder = $_SESSION["username"];
	$resultSessionOrder = $conn->query("SELECT * FROM tb_users WHERE username = '$userSessionOrder' ");
	$rowSessionOrder = mysqli_fetch_assoc($resultSessionOrder);
	$idSessionOrder = $rowSessionOrder["id"];
	$dataUsersOrder = $conn->query("SELECT * FROM tb_order WHERE id_user = '$idSessionOrder' ");
	$rowSessionOrderId = mysqli_fetch_assoc($dataUsersOrder);

}

// SECURITY URL / SQL INJECTION HACKING
if( $rowSessionOrderId["status"] == 0 ){
	$id = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["u"])))))))));

	if( deleteAccount($id) > 0 ){
		echo "
		<script>
			alert('Akun berhasil dihapus.');
			document.location.href = 'auth/logout';
		</script>";
	}

} else{
	if( $rowSessionOrderId["status"] == 3 ){
		$id = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["u"])))))))));

		if( deleteAccount($id) > 0 ){
			echo "
			<script>
				alert('Akun berhasil dihapus.');
				document.location.href = 'auth/logout';
			</script>";
		}
	} else{
		if( empty($rowSessionOrderId)  ){
			$id = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["u"])))))))));

			if( deleteAccount($id) > 0 ){
				echo "
				<script>
					alert('Akun berhasil dihapus.');
					document.location.href = 'auth/logout';
				</script>";
			}
		} else{
				echo "
				<script>
					alert('Akun tidak dapat dihapus.');
					document.location.href = 'index';
				</script>";
		}
	}
} 



// check url delete-notification
if( empty($_GET["u"]) ){
	header("Location:index");
	exit;
}
if( !isset($_GET["u"]) ){
	header("Location:index");
	exit;
}

 ?>