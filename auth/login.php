<?php 
session_start();
if( isset($_SESSION["login"]) ){
	header("Location:../");
	exit;
}
require('process-login.php');


// header location
if( isset($_POST["register"]) ){
	header("Location:register");
	exit;
}

if( isset($_POST["login"]) ){
	$tbUser = login($_POST["username"]);
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
	<title>Masuk | Badan Usaha Milik Desa | Helumo</title>
	<link rel="stylesheet" href="../assets/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
	<link rel="icon" type="img/png" href="../assets/images/logo/">
	<link rel="stylesheet" href="../assets/css/login.css">
	<link rel="stylesheet" href="../assets/css/responsive-login.css">
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
				<h2>MASUK <br> BUMDES HELUMO</h2>
				<p>Silahkan masuk dengan akun yang kamu daftarkan</p>
			</div>
			<!-- end head form -->

			<!-- error login -->
			<?php if( isset($error) ) : ?>
				<div class="error-login">
					<input type="checkbox" id="check-login">
					<label for="check-login">
						<i class="fa fa-times" id="btn-close-login"></i>
					</label>
					<div class="box-error-login">
						<p>
							<?php if( isset($_POST) ) : ?>
								<?php if( !empty($tbUser) ) : ?>	
									Kata Sandi Yang Anda Masukan Salah
								<?php endif; ?>
							<?php endif; ?>

							<!-- check username in database -->
							<?php if( isset($_POST["login"]) ) : ?>
								<?php if( empty($tbUser) ) : ?>
									Nomor Telepon ini tidak terdaftar
								<?php endif; ?>
							<?php endif; ?>
							<!-- end check username in database -->
						</p>
					</div>
				</div>
			<?php endif; ?>
			<!-- end error login -->

			<!-- success registration -->
				<?php if( isset($_POST["submit"]) ) : ?>
					<?php if( register($_POST) > 0 ) : ?>
						<div class="success-registration">
						<input type="checkbox" id="check-registration">
						<label for="check-registration">
							<i class="fa fa-times" id="btn-close-registration"></i>
						</label>
						<div class="box-error-registration">
							<p>Yeay! Akunmu Berhasil Didaftarkan. Silahkan Masuk</p>
						</div>
					</div>
					<?php endif; ?>
				<?php endif; ?>
			<!-- end success registration -->
			
			<!-- box form -->
			<div class="box-form">
				<form action="" method="post">
					<table>
						<tr>
							<td></td>
							<td>
								<div class="jenis-user">
									<input type="checkbox" id="check-user">
									<label for="check-user">
										<a id="btn-view-user">Jenis User : Pengguna</a>
									</label>
									<div class="box-view-user">
										<a href="../admin/login" id="btn-view-user">Administrator</a>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td class="icon-td">
								<label for="username"><i class="fa fa-phone"></i></label>
							</td>
							<td>
								<input type="number" name="username" id="username" placeholder="Nomor Telepon" required oninvalid="this.setCustomValidity('Nomor telepon harus diisi!')" oninput="setCustomValidity('')" autofocus>
							</td>
						</tr>
						<tr>
							<td class="icon-td">
								<label for="password"><i class="fa fa-lock"></i></label>
							</td>
							<td>
								<input type="password" name="password" id="password" placeholder="Kata Sandi">
							</td>
						</tr>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="checkbox" name="required" id="check-required">
								<label for="check-required">
									<p id="label-required">Ingat Saya</p>
								</label>
							</td>
						</tr>
					</table>
					<div class="button-submit">
						<button type="submit" name="login">Masuk</button>
				</form>

						<form action="" method="post">
							<button type="submit" name="register" name="register" id="register-mobile">Belum Punya Akun</button>
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
				<img src="../assets/images/undraw/download_undraw_security_o890.svg" alt="">
			</div>
			<div class="button-login">
					<form action="" method="post">
						<button type="submit" name="register">Belum Punya Akun</button>
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