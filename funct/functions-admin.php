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


// FUNCTION REGISTER ADMIN
function register($data){
	global $conn;

	$first_name = htmlspecialchars($data["first_name"]);
	$last_name = htmlspecialchars($data["last_name"]);
	$username = stripslashes(strtolower($data["username"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// check double username/telepon
	$result = mysqli_query($conn, "SELECT username FROM tb_admin WHERE username = '$username' ");
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

	// check empty first_name
	if( empty($first_name) ){
		echo "
		<script>
			alert('Nama depan tidak boleh kosong!');
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


	// check leng first_name
	if( strlen($first_name) > 30 ){
		echo "
		<script>
			alert('Nama depan terlalu panjang maksimal 30 karakter!');
			document.location.href = 'register';
		</script>";
		return false;
	}
	// check leng last_name
	if( strlen($last_name) > 30 ){
		echo "
		<script>
			alert('Nama belakang terlalu panjang maksimal 30 karakter!');
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
	if( strlen($username) < 5 ){
		echo "
		<script>
			alert('Nomor telepon anda salah!');
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
	$query = "INSERT INTO tb_admin VALUES(null, '$first_name', '$last_name', '$username', '$password') ";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);

}

// query chekc username in database
function login($username){
	global $conn;

	$query = "SELECT * FROM tb_admin WHERE 
	username = '$username'
	";
	return query($query);
}



// FUNCTION UPLOAD GAMBAR LPG
function uploadImgLpg(){

	$namaFile = $_FILES['gambar_unit']['name'];
	$ukuranFile = $_FILES['gambar_unit']['size'];
	$error = $_FILES['gambar_unit']['error'];
	$tmpName = $_FILES['gambar_unit']['tmp_name'];

	// cek apakah ada gambar yang diupload atau tidak
	if( $error === 4 ){
		echo "
		<script>
			alert('Upload gambar terlebih dahulu!');
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar) );
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ){
		echo "
		<script>
			alert('Yang anda upload bukan gambar!');
		</script>";
		return false;
	}

	// cek ukurang gambar yang diupload
	if( $ukuranFile > 1000000 ){
		echo "
		<script>
			alert('Ukuran gambar terlalu besar!');
		</script>";
		return false;
	}

	// lolos pengecekan gambar siap di upload
	// generate nama gambar baru
	$namaFileBaru = uniqid('Lpg_');
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, '../../../assets/images/lpg/' . $namaFileBaru);
	return $namaFileBaru;
}


// FUNCTION UPLOAD GAMBAR TENDA
function uploadImgTenda(){

	$namaFile = $_FILES['gambar_unit']['name'];
	$ukuranFile = $_FILES['gambar_unit']['size'];
	$error = $_FILES['gambar_unit']['error'];
	$tmpName = $_FILES['gambar_unit']['tmp_name'];

	// cek apakah ada gambar yang diupload atau tidak
	if( $error === 4 ){
		echo "
		<script>
			alert('Upload gambar terlebih dahulu!');
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar) );
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ){
		echo "
		<script>
			alert('Yang anda upload bukan gambar!');
		</script>";
		return false;
	}

	// cek ukurang gambar yang diupload
	if( $ukuranFile > 1000000 ){
		echo "
		<script>
			alert('Ukuran gambar terlalu besar!');
		</script>";
		return false;
	}

	// lolos pengecekan gambar siap di upload
	// generate nama gambar baru
	$namaFileBaru = uniqid('Kanopi_');
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, '../../../assets/images/kanopi/' . $namaFileBaru);
	return $namaFileBaru;
}


// function UPDATE LPG
function updateLpg($data){
	global $conn;

	$id = htmlspecialchars($data["id"]);
	$nama_unit = htmlspecialchars($data["nama_unit"]);
	$harga_unit = htmlspecialchars($data["harga_unit"]);
	$stok_unit = htmlspecialchars($data["stok_unit"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// cek apakah gambar diubah atau tidak
	if( $_FILES['gambar_unit']['error'] === 4 ){
		$gambar_unit = $gambarLama;
	} else{
		$gambar_unit = uploadImgLpg();
	}

	$info_unit = htmlspecialchars($data["info_unit"]);

	$query = "UPDATE tb_lpg SET 
	nama_unit = '$nama_unit',
	harga_unit = '$harga_unit',
	stok_unit = '$stok_unit',
	gambar_unit = '$gambar_unit',
	info_unit = '$info_unit'
	WHERE id = '$id'
	";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}


// function UPDATE TENDA
function updateTenda($data){
	global $conn;

	$id_tenda = htmlspecialchars($data["id_tenda"]);
	$nama_unit = htmlspecialchars($data["nama_unit"]);
	$harga_unit_1 = htmlspecialchars($data["harga_unit_1"]);
	$harga_unit_2 = htmlspecialchars($data["harga_unit_2"]);
	$stok_unit = htmlspecialchars($data["stok_unit"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);

	// cek apakah gambar diubah atau tidak
	if( $_FILES['gambar_unit']['error'] === 4 ){
		$gambar_unit = $gambarLama;
	} else{
		$gambar_unit = uploadImgTenda();
	}

	$query = "UPDATE tb_tenda SET 
	nama_unit = '$nama_unit',
	harga_unit_1 = '$harga_unit_1',
	harga_unit_2 = '$harga_unit_2',
	stok_unit = '$stok_unit',
	gambar_unit = '$gambar_unit'
	WHERE id_tenda = '$id_tenda'
	";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}


// === FUNCTION UPDATE STOK TENDA ===
function updateStokTenda($data){
	global $conn;

	$id_tenda = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["id_tenda"]))))))))));
	$stok_unit = htmlspecialchars(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($data["stok_unit"]))))))))));

	// check encode id
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



// FUNCTION ADD STOCK LPG
function addStock($data){
	global $conn;

	$id = htmlspecialchars($data["id"]);
	$stok_unit = htmlspecialchars($data["stok_unit"]);

	$query = "UPDATE tb_lpg SET
	stok_unit = '$stok_unit'
	WHERE id = '$id'
	";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

// FUNCTION ADD STOCK TENDA KANOPI
function addStockTenda($data){
	global $conn;

	$id_tenda = htmlspecialchars($data["id_tenda"]);
	$stok_unit = htmlspecialchars($data["stok_unit"]);

	$query = "UPDATE tb_tenda SET
	stok_unit = '$stok_unit'
	WHERE id_tenda = '$id_tenda'
	";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}

// FUNCTION VERIFIKASI UNPROCESSED ORDER
function verifikasiUnprocessedOrder($data){
	global $conn;

	$id_user = htmlspecialchars($data["id_user"]);
	$id = htmlspecialchars($data["id"]);
	$status = htmlspecialchars($data["status"]);
	$subject = htmlspecialchars($data["subject"]);
	$notifications = htmlspecialchars($data["notifications"]);
	$date = htmlspecialchars($data["date"]);


	$queryUpdateOrder = "UPDATE tb_order SET 
	status = '$status'
	WHERE id = '$id'
	";
	mysqli_query($conn, $queryUpdateOrder);

	$queryInsertNotif = "INSERT INTO tb_notifications VALUES(null, '$id_user', '$subject', '$notifications', '$date') ";
	mysqli_query($conn, $queryInsertNotif);

	return mysqli_affected_rows($conn);
}


// FUNCTION VERIFIKASI RETURNED/UPDATE STOK TENDA - ORDER
function verifikasiUpdateStokTenda($data){
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
	WHERE id_tenda = '$id_tenda'
	";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
}



// FUNCTION NOTIFICATIONS 
function notifications($data){
	global $conn;

	$id_user = htmlspecialchars($data["id_user"]);
	$subject = htmlspecialchars($data["subject"]);
	$notifications = $data["notifications"];
	$date = htmlspecialchars($data["date"]);

	$query = "INSERT INTO tb_notifications VALUES(null, '$id_user', '$subject', '$notifications', '$date') ";
	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);
} 

// FUNCTION DELETE ORDER 
function deleteOrder($id){
	global $conn;

	mysqli_query($conn, "DELETE FROM tb_order WHERE id = '$id' ");
	return mysqli_affected_rows($conn);

}

// FUNCTION SEARCHING ORDER
function searchOrder($q){
	$query = "SELECT * FROM tb_order WHERE 
	nama LIKE '%$q%' OR
	no_telp LIKE '%$q%' OR
	alamat LIKE '%$q%' OR
	jenis LIKE '%$q%' OR
	jumlah_unit LIKE '%$q%' OR
	tgl_pakai LIKE '%$q%' OR
	jangka_waktu LIKE '%$q%' OR
	total LIKE '%$q%'
	";
	return query($query);
}

// FUNCTION SEARCHING LAPORAN TANGGAL TRANSAKSI
function searchLaporanTgl($tgl){
	$query = "SELECT * FROM tb_laporan WHERE 
	tgl_transaksi = '$tgl' 
	";
	return query($query);
}

// FUNCTION SEARCHING LAPORAN BULAN TRANSAKSI
function searchLaporanBln($bln){
	$query = "SELECT * FROM tb_laporan WHERE 
	bln_transaksi = '$bln' 
	";
	return query($query);
}

// FUNCTION SEARCHING LAPORAN TAHUN TRANSAKSI
function searchLaporanThn($thn){
	$query = "SELECT * FROM tb_laporan WHERE 
	thn_transaksi = '$thn' 
	";
	return query($query);
}



// FUNCTION DELETE LAPORAN
function deleteLaporan($id){
	global $conn;

	mysqli_query($conn, "DELETE FROM tb_laporan WHERE id = '$id' ");
	return mysqli_affected_rows($conn);
}




// FUNCTION UPLOAD GAMBAR SEJARAH DESA
function uploadImgSejarahDesa(){

	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah ada gambar yang diupload atau tidak
	if( $error === 4 ){
		echo "
		<script>
			alert('Upload gambar terlebih dahulu!');
		</script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar) );
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ){
		echo "
		<script>
			alert('Yang anda upload bukan gambar!');
		</script>";
		return false;
	}

	// cek ukurang gambar yang diupload
	if( $ukuranFile > 1000000 ){
		echo "
		<script>
			alert('Ukuran gambar terlalu besar!');
		</script>";
		return false;
	}

	// lolos pengecekan gambar siap di upload
	// generate nama gambar baru
	$namaFileBaru = uniqid('Helumo_');
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;
	move_uploaded_file($tmpName, '../../../assets/images/banner/' . $namaFileBaru);
	return $namaFileBaru;
}


// FUNCTION UPDATE SEJARAH DESA
function updateSejarahDesa($data){
	global $conn;

	$id = htmlspecialchars($data["id"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);
	
	// cek apakah gambar diubah atau tidak
	if( $_FILES['gambar']['error'] === 4 ){
		$gambar = $gambarLama;
	} else{
		$gambar = uploadImgSejarahDesa();
	}

	$deskripsi = $data["deskripsi"];
	$posted = htmlspecialchars($data["posted"]);

	$query = "UPDATE tb_deskripsi_desa SET
	gambar = '$gambar',
	deskripsi = '$deskripsi',
	posted = '$posted'
	WHERE id = '$id'
	";

	mysqli_query($conn, $query);
	return mysqli_affected_rows($conn);

}




 ?>