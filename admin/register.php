<?php 
session_start();
if( isset($_SESSION["login"]) ){
	header("Location:index");
	exit;
}
// connection functions-admin.php
require('../funct/functions-admin.php');

// header location login
if( isset($_POST["login"]) ){
	header("Location:login");
	exit;
}
if( isset($_POST["register"]) ){
	if( register($_POST) > 0 ){
		echo "berhasil";die;
	} else{
		echo "gagal";die;

	}
}


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- META TAG -->
	<meta name="keywords" content="Desa Helumo, Desa Helumo Gorontalo, Bumdes, Badan Usaha Milik Desa, Badan Usaha Milik Desa Helumo" />
    <meta name="description" content="Aplikasi Badan Usaha Milik Desa (BUMDES)" />
	<!-- END META TAG -->

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Daftar Akun Baru | Badan Usaha Milik Desa | Helumo</title>
	<link rel="stylesheet" href="../assets/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
	<link rel="icon" type="img/png" href="../assets/images/logo/">
	<link rel="stylesheet" href="../assets/css/register.css">
	<link rel="stylesheet" href="../assets/css/responsive-register.css">
</head>
<body>


	<!-- === CONTAINER === -->
	<div class="container">

		<div class="top-logo">
			<img src="../assets/images/logo/gelombang1.png" alt="">
		</div>
		
		<!-- form -->
		<div class="form">

			<!-- head form -->
			<div class="head-form">
				<div class="logo-mobile">
					<a href="../">
						<img src="../assets/images/logo/LOGO_UNG.png" alt="LOGO_UNG" class="logo-ung">
						<img src="../assets/images/logo/Logo_Kabupaten_Bone_Bolango.png" alt="Logo_Kabupaten_Bone_Bolango">
						<img src="../assets/images/logo/kemendes.png" alt="Logo_Kemendes" class="logo-kemendes">
					</a>
				</div>
				<h2>PENDAFTARAN <br> BUMDES HELUMO</h2>
				<p>Silahkan buat akun baru anda sekarang</p>
			</div>
			<!-- end head form -->

			<!-- box form -->
			<div class="box-form">
				<form action="login" method="post">
					<table>
						<tr>
							<td class="icon-td">
								<label for="first_name"><i class="fa fa-user"></i></label>
							</td>
							<td>
								<input type="text" name="first_name" id="first_name" placeholder="Nama Depan" required oninvalid="this.setCustomValidity('Nama depan harus diisi!')" oninput="setCustomValidity('')" maxlength="30">
							</td>
						</tr>
						<tr>
							<td class="icon-td">
								<label for="last_name"><i class="fa fa-user"></i></label>
							</td>
							<td>
								<input type="text" name="last_name" id="last_name" placeholder="Nama Belakang" maxlength="30">
							</td>
						</tr>
						<tr>
							<td class="icon-td">
								<label for="username"><i class="fa fa-phone"></i></label>
							</td>
							<td>
								<input type="number" name="username" id="username" placeholder="Nomor Telepon" required oninvalid="this.setCustomValidity('Nomor telepon harus diisi!')" oninput="setCustomValidity('')" maxlength="50">
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<span id="notif-username">Gunakan Nomor Telepon Yang Aktif</span>
							</td>
						</tr>
						<tr>
							<td class="icon-td">
								<label for="password"><i class="fa fa-lock"></i></label>
							</td>
							<td>
								<input type="password" name="password" id="password" placeholder="Kata Sandi" required oninvalid="this.setCustomValidity('Untuk Menjaga Kemanan Akun Anda, Masukan Minimal 8 Karakter Kata Sandi!')" oninput="setCustomValidity('')" minlength="8">
							</td>
						</tr>
						<tr>
							<td class="icon-td">
								<label for="password2"><i class="fa fa-lock"></i></label>
							</td>
							<td>
								<input type="password" name="password2" id="password2" placeholder="Konfirmasi Kata Sandi">
							</td>
						</tr>
						</tr>
					</table>
					<div class="button-submit">
						<button type="submit" name="submit">Daftarkan Akun</button>
				</form>

						<form action="" method="post">
							<button type="submit" name="login" id="register-mobile">Sudah Punya Akun</button>
						</form>
					</div>
				
			</div>
			<!-- end box form -->

		</div>
		<!-- end form -->

		<!-- content right -->
		<div class="content-right">
			<div class="head-content-right">
				<a href="../">
					<img src="../assets/images/logo/LOGO_UNG.png" alt="LOGO_UNG" class="logo-ung">
					<img src="../assets/images/logo/Logo_Kabupaten_Bone_Bolango.png" alt="Logo_Kabupaten_Bone_Bolango">
					<img src="../assets/images/logo/kemendes.png" alt="Logo_Kemendes" class="logo-kemendes">
				</a>
				<p>Silahkan sobat gunakan aplikasi ini untuk memudahkan sobat mendapatkan unit usaha</p>
			</div>
			<div class="img-content-right">
				<img src="../assets/images/undraw/download_undraw_Forms_re_pkrt.svg" alt="">
			</div>
			<div class="button-login">
					<form action="" method="post">
						<button type="submit" name="login">Sudah Punya Akun</button>
					</form>
			</div>
		</div>
		<!-- end content right -->

		<div class="bottom-logo">
			<img src="../assets/images/logo/gelombang2.png" alt="">
		</div>

		<div class="clear-both"></div>


	</div>
	<!-- === END CONTAINER === -->
	
</body>
</html>