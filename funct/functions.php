<?php 
// connection to database bumdes
$host = "localhost";
$username = "root";
$password = "admin9o0d3vil";
$database = "bumdes";
$conn = mysqli_connect($host, $username, $password, $database);

// $host = "localhost";
// $username = "id17346133_root";
// $password = "[Yza)6(\@wUb~Ja/";
// $database = "id17346133_bumdeshelumo";
// $conn = mysqli_connect($host, $username, $password, $database);




// function query
function query($query){
	global $conn;

	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ){
		$rows[] = $row;
	}
	return $rows;
}


// === FUNCTION USERS ===

// function register user
function register($data){
	global $conn;

	$nama = htmlspecialchars($data["nama"]);
	$username = stripslashes(strtolower($data["username"]));
	$opsi_harga = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["opsi_harga"]))))))))));
	$alamat = htmlspecialchars($data["alamat"]);
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);
	$regulations = htmlspecialchars(
		base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["regulations"]))))))))));

	if( base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($regulations))))))))) ){
		echo "
		<script>
			alert('Pendaftaranmu diblokir!');
			document.location.href = 'register';
		</script>";
		return false;
	}

	if( base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($opsi_harga))))))))) ){
		echo "
		<script>
			alert('Pendaftaranmu diblokir!');
			document.location.href = 'register';
		</script>";
		return false;
	}

	// check double username/telepon
	$result = mysqli_query($conn, "SELECT username FROM tb_users WHERE username = '$username' ");
	if( mysqli_fetch_assoc($result) ){
		echo "
		<script>
			alert('Nomor ini sudah digunakan. Silahkan gunakan nomor telepon lain!');
			document.location.href = 'register';
		</script>";
		return false;
	}

	// check what the user enters is a phone number
	if( !is_numeric($username) ){
		echo "
		<script>
			alert('Yang anda masukan bukan nomor telepon!');
			document.location.href = 'register';
		</script>";
		return false;	
	}

	// check empty nama
	if( empty($nama) ){
		echo "
		<script>
			alert('Nama tidak boleh kosong!');
			document.location.href = 'register';
		</script>";
		return false;
	}


	// check empty alamat
	if( empty($alamat) ){
		echo "
		<script>
			alert('Alamat tidak boleh kosong!');
			document.location.href = 'register';
		</script>";
		return false;	
	}


	// check empty username/telepon
	if( empty($username) ){
		echo "
		<script>
			alert('Nomor telepon tidak boleh kosong!');
			document.location.href = 'register';
		</script>";
		return false;	
	}

	// check empty password
	if( empty($password) ){
		echo "
		<script>
			alert('Passowrd tidak boleh kosong!');
			document.location.href = 'register';
		</script>";
		return false;	
	}

	// check empty regulations
	if( empty($regulations) ){
		echo "
		<script>
			alert('Pendaftaranmu diblokir!');
			document.location.href = 'register';
		</script>";
		return false;	
	}

	// check leng nama
	if( strlen($nama) > 50 ){
		echo "
		<script>
			alert('Nama terlalu panjang maksimal 50 karakter!');
			document.location.href = 'register';
		</script>";
		return false;
	}

	// check leng nomor telepon
	if( strlen($username) > 15 ){
		echo "
		<script>
			alert('Nomor telepon anda salah!');
			document.location.href = 'register';
		</script>";
		return false;
	}
	// check leng nomor telepon
	if( strlen($username) < 10 ){
		echo "
		<script>
			alert('Nomor telepon anda salah!');
			document.location.href = 'register';
		</script>";
		return false;
	}


	// check leng alamat
	if( strlen($alamat) > 255 ){
		echo "
		<script>
			alert('Alamat terlalu panjang maksimal 255 karakter!');
			document.location.href = 'register';
		</script>";
		return false;
	}

	// check leng alamat
	if( strlen($alamat) < 5 ){
		echo "
		<script>
			alert('Alamat terlalu pendek!');
			document.location.href = 'register';
		</script>";
		return false;
	}


	// check leng password
	if( strlen($password) < 8 ){
		echo "
		<script>
			alert('Untuk Menjaga Kemanan Akun Anda, Masukan Minimal 8 Karakter Kata Sandi!');
			document.location.href = 'register';
		</script>";
		return false;
	}


	// check confirmation password
	if( $password !== $password2 ){
		echo "
		<script>
			alert('Konfirmasi Password Tidak Sesuai!');
			document.location.href = 'register';
		</script>";
		return false;
	}

	// enkription password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// add all data to database
	$query = "INSERT INTO tb_users VALUES(null, '$nama', '$username', '$opsi_harga', '$alamat', '$password', '$regulations') ";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);

}

// query chekc username in database
function login($username){
	global $conn;

	$query = "SELECT * FROM tb_users WHERE 
	username = '$username'
	";
	return query($query);
}


// === USER ORDER ===
function order($dataOrder){
	global $conn;

	$id_user = htmlspecialchars($dataOrder["id_user"]);

	$nama = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["nama"])))))))));

	$no_telp = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["no_telp"])))))))));

	$alamat = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["alamat"])))))))));

	$jenis = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["jenis"])))))))));

	$jumlah_unit = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["jumlah_unit"])))))))));

	$tgl_pakai = htmlspecialchars($dataOrder["tgl_pakai"]);

	$jangka_waktu = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["jangka_waktu"])))))))));

	$total = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["total"])))))))));

	$status = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["status"])))))))));

	$tgl_transaksi = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["tgl_transaksi"])))))))));

	$bln_transaksi = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["bln_transaksi"])))))))));

	$thn_transaksi = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["thn_transaksi"])))))))));


	// check empty tgl_transaksi
	if( empty($tgl_transaksi) ){
		echo "
		<script>
			alert('Server Error!');
		</script>";
		return false;
	}

	// check empty bln_transaksi
	if( empty($bln_transaksi) ){
		echo "
		<script>
			alert('Server Error!');
		</script>";
		return false;
	}

	// check empty thn_transaksi
	if( empty($thn_transaksi) ){
		echo "
		<script>
			alert('Server Error!');
		</script>";
		return false;
	}

	// check encode tgl_transaksi
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($tgl_transaksi)))))))) ){
		echo "
		<script>
			alert('Server Error!');
		</script>";
		return false;
	}

	// check encode bln_transaksi
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($bln_transaksi)))))))) ){
		echo "
		<script>
			alert('Server Error!');
		</script>";
		return false;
	}

	// check encode thn_transaksi
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($thn_transaksi)))))))) ){
		echo "
		<script>
			alert('Server Error!');
		</script>";
		return false;
	}





	// check encode nama
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($nama)))))))) ){
		echo "
		<script>
			alert('Nama tidak sesuai!');
		</script>";
		return false;
	}
	// check empty nama
	if( empty($nama) ){
		echo "
		<script>
			alert('Nama tidak sesuai!');
		</script>";
		return false;
	}

	// check encode no_telp
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($no_telp)))))))) ){
		echo "
		<script>
			alert('Nomor telepon tidak sesuai!');
		</script>";
		return false;
	}
	// check empty no_telp
	if( empty($no_telp) ){
		echo "
		<script>
			alert('Nomor telepon tidak sesuai!');
		</script>";
		return false;
	}

	// check encode alamat
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($alamat)))))))) ){
		echo "
		<script>
			alert('Alamat tidak sesuai!');
		</script>";
		return false;
	}
	// check empty alamat
	if( empty($alamat) ){
		echo "
		<script>
			alert('Alamat tidak sesuai!');
		</script>";
		return false;
	}

		// check encode jenis
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($jenis)))))))) ){
		echo "
		<script>
			alert('Server Error!');
		</script>";
		return false;
	}
	// check empty jenis
	if( empty($jenis) ){
		echo "
		<script>
			alert('Server Error!');
		</script>";
		return false;
	}

	// check encode jumlah_unit
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($jumlah_unit)))))))) ){
		echo "
		<script>
			alert('Jumlah tidak sesuai!');
		</script>";
		return false;
	}
	// check empty jumlah_unit
	if( empty($jumlah_unit) ){
		echo "
		<script>
			alert('Jumlah tidak sesuai!');
		</script>";
		return false;
	}

	// check encode jangka_waktu
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($jangka_waktu)))))))) ){
		echo "
		<script>
			alert('Jangka waktu tidak sesuai!');
		</script>";
		return false;
	}
	// check empty jangka_waktu
	if( empty($jangka_waktu) ){
		echo "
		<script>
			alert('Jangka waktu tidak sesuai!');
		</script>";
		return false;
	}

	// check encode total
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($total)))))))) ){
		echo "
		<script>
			alert('Total tidak sesuai!');
		</script>";
		return false;
	}
	// check empty total
	if( empty($total) ){
		echo "
		<script>
			alert('Total tidak sesuai!');
		</script>";
		return false;
	}
	

	// query_order
	$query_order = "INSERT INTO tb_order VALUES(null, '$id_user', '$nama', '$no_telp', '$alamat', '$jenis', '$jumlah_unit', '$tgl_pakai', '$jangka_waktu', '$total', '$status', '$tgl_transaksi', '$bln_transaksi', '$thn_transaksi') ";
	mysqli_query($conn, $query_order);

	// query_laporan
	$query_laporan = "INSERT INTO tb_laporan VALUES(null, '$id_user', '$nama', '$no_telp', '$alamat', '$jenis', '$jumlah_unit', '$tgl_pakai', '$jangka_waktu', '$total', '$status', '$tgl_transaksi', '$bln_transaksi', '$thn_transaksi') ";
	mysqli_query($conn, $query_laporan);
	return mysqli_affected_rows($conn);
}


// === FUNCTION UPDATE ORDER
function updateOrder($dataOrder){
	global $conn;

	$id = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["id"]))))))))));

	$jumlah_unit = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["jumlah_unit"])))))))));

	$jangka_waktu = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["jangka_waktu"])))))))));

	$total = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($dataOrder["total"])))))))));

	$query = "UPDATE tb_order SET 
	jumlah_unit = '$jumlah_unit', 
	jangka_waktu = '$jangka_waktu',
	total = '$total'
	WHERE id = '$id'
	";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

// === FUNCTION UPDATE STOK TENDA ===
function updateStokTenda($data){
	global $conn;

	$id_tenda = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_tenda"]))))))))));
	$stok_unit = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["stok_unit"]))))))))));

	// check encode id tenda
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($id_tenda))))))))) ){
		echo "
		<script>
			alert('Pesanan diblokir!');
		</script>";
		return false;
	}

	// check encode stok unit
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($stok_unit))))))))) ){
		echo "
		<script>
			alert('Pesanan diblokir!');
		</script>";
		return false;
	}



	$query = "UPDATE tb_tenda SET 
	stok_unit = '$stok_unit'
	WHERE id_tenda = '$id_tenda';
	";


	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}



// === FUNCTION CANCEL ORDER USER ===
function cancelOrder($idUser){
	global $conn;

	mysqli_query($conn, "DELETE FROM tb_order WHERE id_user = '$idUser' ");
	return mysqli_affected_rows($conn);
}



// FUNCTION DELETE NOTIFICATION
function deleteNotification($id){
	global $conn;

	mysqli_query($conn, "DELETE FROM tb_notifications WHERE id = '$id' ");
	return mysqli_affected_rows($conn);
}

// === FUNCTION UPDATE PROFILE ===
// functino update nama, alamat
function updateProfile($data){
	global $conn;

	$id = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id"]))))))))));
	$nama = htmlspecialchars($data["nama"]);
	$alamat = htmlspecialchars($data["alamat"]);

	// check id encode
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($id))))))))) ){
		echo "
		<script>
			alert('Server Error');
			document.location.href = 'index';
		</script>";
	}
	if( empty($id) ){
		echo "
		<script>
			alert('Server Error');
			document.location.href = 'index';
		</script>";
	}
	if( strlen($id) > 20 ){
		echo "
		<script>
			alert('Server Error');
			document.location.href = 'index';
		</script>";
	}

	// check empty nama
	if( empty($nama) ){
		echo "
		<script>
			alert('Nama tidak sesuai!');
		</script>";
		return false;
	}

	// check empty alamat
	if( empty($alamat) ){
		echo "
		<script>
			alert('Alamat tidak sesuai!');
		</script>";
		return false;
	}

	$query = "UPDATE tb_users SET 
	nama = '$nama',
	alamat = '$alamat'
	WHERE id = '$id'
	";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}
// function update username
function updateUsername($data){
	global $conn;

	$id = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id"]))))))))));
	$username = stripslashes(strtolower($data["username"]));

	// check double username/telepon
	$result = mysqli_query($conn, "SELECT username FROM tb_users WHERE username = '$username' ");
	if( mysqli_fetch_assoc($result) ){
		echo "
		<script>
			alert('Nomor ini sudah digunakan. Silahkan gunakan nomor telepon lain!');
			document.location.href = 'register';
		</script>";
		return false;
	}

	// check what the user enters is a phone number
	if( !is_numeric($username) ){
		echo "
		<script>
			alert('Yang anda masukan bukan nomor telepon!');
			document.location.href = 'register';
		</script>";
		return false;	
	}

	// check id encode
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($id))))))))) ){
		echo "
		<script>
			alert('Server Error');
			document.location.href = 'index';
		</script>";
	}
	if( empty($id) ){
		echo "
		<script>
			alert('Server Error');
			document.location.href = 'index';
		</script>";
	}
	if( strlen($id) > 20 ){
		echo "
		<script>
			alert('Server Error');
			document.location.href = 'index';
		</script>";
	}

	// check empty username
	if( empty($username) ){
		echo "
		<script>
			alert('Nomor telepon tidak sesuai!');
		</script>";
		return false;
	}

	// check len username
	if( strlen($username) > 15 ){
		echo "
		<script>
			alert('Nomor telepon yang anda masukan salah!');
		</script>";
		return false;
	}
	// check len username
	if( strlen($username) < 7 ){
		echo "
		<script>
			alert('Nomor telepon yang anda masukan salah!');
		</script>";
		return false;
	}

	$query = "UPDATE tb_users SET 
	username = '$username'
	WHERE id = '$id'
	";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);

}


// function update Password
function updatePassword($data){
	global $conn;

	$id = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id"]))))))))));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// check id encode
	if( !base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($id))))))))) ){
		echo "
		<script>
			alert('Server Error');
			document.location.href = 'index';
		</script>";
	}
	if( empty($id) ){
		echo "
		<script>
			alert('Server Error');
			document.location.href = 'index';
		</script>";
	}
	if( strlen($id) > 20 ){
		echo "
		<script>
			alert('Server Error');
			document.location.href = 'index';
		</script>";
	}

	// check leng password
	if( strlen($password) < 8 ){
		echo "
		<script>
			alert('Untuk Menjaga Kemanan Akun Anda, Masukan Minimal 8 Karakter Kata Sandi!');
			document.location.href = '';
		</script>";
		return false;
	}


	// check confirmation password
	if( $password !== $password2 ){
		echo "
		<script>
			alert('Konfirmasi Password Tidak Sesuai!');
			document.location.href = '';
		</script>";
		return false;
	}

	// enkription password
	$password = password_hash($password, PASSWORD_DEFAULT);

	$query = "UPDATE tb_users SET 
	password = '$password'
	WHERE id = '$id'
	";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);

}

// === FUNCTION DELETE ACCOUNT ===
function deleteAccount($id){
	global $conn;

	$query = "DELETE FROM tb_users WHERE id = '$id' ";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}















 ?>