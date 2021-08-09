<?php 
session_start();
if( isset($_SESSION["login"]) ){
	header("Location:../");
	exit;
}
// connection functions.php
require('../funct/functions.php');

// header location login
if( isset($_POST["login"]) ){
	header("Location:login");
	exit;
}

$valueRegulations = 1;

// opsi harga
$opsiHarga0 = 0;
$opsiHarga1 = 1;


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
								<label for="nama"><i class="fa fa-user"></i></label>
							</td>
							<td>
								<input type="text" name="nama" id="nama" placeholder="Nama Lengkap" required oninvalid="this.setCustomValidity('Nama lengkap harus diisi!')" oninput="setCustomValidity('')" maxlength="50">
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
								<label for="opsi-harga"><i class="fa fa-map-marker"></i></label>
							</td>
							<td>
								<select name="opsi_harga" id="opsi-harga">
									<option>--- Pilih Lokasi Anda ---</option>
									<option value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($opsiHarga0))))))))); ?>">Desa Helumo</option>
									<option value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($opsiHarga1))))))))); ?>">Luar Desa Helumo</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="icon-td">
								<label for="alamat"><i class="fa fa-map-marker"></i></label>
							</td>
							<td>
								<input type="text" name="alamat" id="alamat" placeholder="Alamat Lengkap" required oninvalid="this.setCustomValidity('Masukan alamat tinggal!')" oninput="setCustomValidity('')" maxlength="255"></input>
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
						<tr>
							<td></td>
							<td>
								<input type="checkbox" id="check-regulations">
								<label for="check-regulations">
									<p id="label-regulations">Baca peraturan pendaftaran</p>
									<a id="btn-close-regulations">Selanjutnya</a>
								</label>
								<div class="box-regulations">
									<h2>Peraturan Pendaftaran Akun Baru</h2>
									<div class="paragraf-regulations">
										<p>1. Kami mempercayai setiap data-data yang anda masukan adalah benar</p>
										<p>2. Jika nanti kami mendapatkan data-data yang tidak sesuai dengan kebenaran, maka akan bermasalah pada saat anda memesan unit-unit usaha. Dan bisa saja kami akan menonaktifkan akun anda secara permanen</p>
										<p>3. Jika anda lupa kata sandi silahkan hubungi Administrator, atau langsung datang ke Balai Desa Helumo, Gorontalo</p>
									</div>
								</div>
							</td>
						</tr>

						<tr>
							<td></td>
							<td>
								<input type="checkbox" name="regulations" id="check-regis" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($valueRegulations))))))))); ?>" required oninvalid="this.setCustomValidity('Setujui peraturan pendaftaran akun')" oninput="setCustomValidity('')">
								<label for="check-regis">
									<p id="label-regis">Saya menyetujui bahwa data-data yang saya masukan adalah benar</p>
								</label>
							</td>
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