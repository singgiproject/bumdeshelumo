<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:auth/login");
}


// connection to functions.php
require('funct/functions.php');
require('funct/location-link.php');
require('funct/query.php');
require('funct/count.php');

// SESSION USER LOGIN
if( isset($_SESSION["login"]) ){
	$userSession = $_SESSION["username"];
	$resultSession = $conn->query("SELECT * FROM tb_users WHERE username = '$userSession' ");
	$rowSession = mysqli_fetch_assoc($resultSession);
	$idSession = $rowSession["id"];
	$dataUsers = query("SELECT * FROM tb_users WHERE id = '$idSession' ");

	// check if there are still user accounts in the database (which are changed or deleted)
	if( empty($idSession) ){
		header("Location:auth/logout");
		exit;
	}

}

// SESSION USER ORDER
if( isset($_SESSION["login"]) ){
	$userSessionOrder = $_SESSION["username"];
	$resultSessionOrder = $conn->query("SELECT * FROM tb_users WHERE username = '$userSessionOrder' ");
	$rowSessionOrder = mysqli_fetch_assoc($resultSessionOrder);
	$idSessionOrder = $rowSessionOrder["id"];
	$dataUsersOrder = $conn->query("SELECT * FROM tb_order WHERE id_user = '$idSessionOrder' ");
	$rowSessionOrderId = mysqli_fetch_assoc($dataUsersOrder);

}

// QUERY DATA USER FROM URL
$idUser = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["u"])))))))));
$dataUserUrl = query("SELECT * FROM tb_users WHERE id = '$idUser' ")[0];

// check keyword URL user
if( empty($idUser) ){
	header("Location:index");
	exit;
}
if( strlen($idUser) > 20 ){
	header("Location:index");
	exit;	
}
if( !isset($idUser) ){
	header("Location:index");
	exit;
}

// check button save-data 
if( isset($_POST["save-data"]) ){
	if( updateProfile($_POST) > 0 ){
		echo "
		<script>
			alert('Profile Berhasil Diubah!')
			document.location.href = '';
		</script>";
	} else{
		echo "
		<script>
			document.location.href = '';
		</script>";
	}
}

// check button save-username 
if( isset($_POST["save-username"]) ){
	if( updateUsername($_POST) > 0 ){
		echo "
		<script>
			alert('Nomor Telepon Berhasil Diubah!. Silahkan Login Kembali')
			document.location.href = 'auth/logout';
		</script>";
	} else{
		echo "
		<script>
			document.location.href = '';
		</script>";
	}
}

// check button save-password 
if( isset($_POST["save-password"]) ){
	if( updatePassword($_POST) > 0 ){
		echo "
		<script>
			alert('Kata Sandi Berhasil Diubah!. Silahkan Login Kembali')
			document.location.href = 'auth/logout';
		</script>";
	} else{
		echo "
		<script>
			document.location.href = '';
		</script>";
	}
}


// SESSION USER LOGIN (NOTIFICATION)
if( isset($_SESSION["login"]) ){
	$notifSession = $_SESSION["username"];
	$notifResultSession = $conn->query("SELECT * FROM tb_users WHERE username = '$notifSession' ");
	$notifRowSession = mysqli_fetch_assoc($notifResultSession);

	$notifIdSession = $notifRowSession["id"];
	$notifDataSession = $conn->query("SELECT * FROM tb_notifications WHERE id_user = '$notifIdSession' ");
	$notifDataRowSession = mysqli_fetch_assoc($notifDataSession);

}




if( isset($_POST["notification"]) ){
	header("Location:notification");
	exit;
}



// Set date
date_default_timezone_set('Asia/Makassar');
$year = date("Y");




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
	<title>Profil | Helumo</title>
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/darkMode.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
	<link rel="stylesheet" href="assets/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
	<link rel="icon" type="images/png" href="assets/images/logo/Logo_Kabupaten_Bone_Bolango.png">
</head>
<body>

	<!-- === BOTTOM BAR === -->
	<div class="bottom-bar">
		<div class="nav-bottom-bar">
			<div class="menu-bottom-bar">
				<ul>
					<?php if( isset($_SESSION["login"]) ) : ?>
						<li>
							<a href="index">
								<i class="fa fa-home"></i>Beranda
							</a>
						</li>
						<li>
							<a href="notification">
								<i class="fa fa-bell">
									<?php if( !empty($notifDataRowSession) ) : ?>
										<sup><?php echo "{$notifResultAmount["amountNotif"]}"; ?></sup>
									<?php endif; ?>
								</i>Notifikasi
							</a>
						</li>
						<li>
							<a href="info-order"><i class="fa fa-shopping-cart"></i>Pesananmu
							</a>
						</li>
						<li>
							<a href="#" id="menu-active"><i class="fa fa-user" id="menu-active"></i>Akun
							</a>
						</li>
					<?php endif; ?>

					<?php if( !isset($_SESSION["login"]) ) : ?>
						<li>
							<a href="">
								<i class="fa fa-home"></i>Beranda
							</a>
						</li>
						<li>
							<a href="#product">
								<i class="fab fa-sellsy"></i>Unit Usaha
							</a>
						</li>
						<li>
							<a href="#sejarah-desa">
								<i class="fas fa-book-open"></i>Sejarah Desa
							</a>
						</li>
						<li>
							<a href="auth/login">
								<i class="fa fa-sign-in"></i>Masuk
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
	<!-- === END BOTTOM BAR === -->


	<!-- === TOP BAR === -->
	<section>
		<top-bar>
			<div class="top-bar">
				
				<!-- nav -->
				<nav>
					<div class="nav">
						<div class="logo-top-bar">
							<a href="index"><img src="assets/images/logo/Logo_Kabupaten_Bone_Bolango.png" alt="" id="logo-mobile"></a>
							<a href="index"><img src="assets/images/logo/kemendes.png" alt="" id="logo-mobile"></a>
							<a href="index" id="logo-desktop"><h2>Bumdes <sup>Desa Helumo</sup></h2></a></a>
							
							<!-- mobile menu -->
							<div class="mobile-menu">
								<input type="checkbox" id="check-menu">
								<label for="check-menu">
									<i class="fa fa-bars" id="btn-view-menu"></i>
									<i class="fa fa-times" id="btn-close-menu"> <span class="menu-utama">Menu Utama</span></i>
								</label>
								<div class="box-mobile-menu">
									<div class="info-account">
										<?php if( !isset($_SESSION["login"]) ) : ?>
											<ul>
												<li><a href="auth/login" class="link-login">Masuk</a></li>
												<li><a href="auth/register" class="link-regis">Daftar</a></li>
											</ul>
										<?php endif; ?>
									</div>
									<div class="info-account-session">
										<?php if( isset($_SESSION["login"]) ) : ?>
											<ul>
												<span><i class="fas fa-user"></i> <?= $rowSession["nama"]; ?></span>
											</ul>
										<?php endif; ?>
									</div>
									<div class="link-mobile-menu">
										<ul>
											<form action="" method="post">
												<span>Layanan</span>
												<li>
													<a><i class="fab fa-sellsy"></i>
														<button type="submit" name="product">Produk / Unit Usaha</button>
													</a>
												</li>

												<span>Profil</span>
												<li>
													<a><i class="fas fa-book-open"></i>
														<button type="submit" name="sejarah-desa">Sejarah Desa</button>
													</a>
												</li>

												<li>
													<a><i class="fa fa-star"></i>
														<button type="submit" name="visi-misi">Visi Misi</button>
													</a>
												</li>
												<li>
													<a><i class="fa fa-code-branch"></i>
														<button type="submit" name="struktur-bumdes">Struktur Bumdes</button>
													</a>
												</li>
												<li>
													<a><i class="fas fa-project-diagram"></i>
														<button type="submit" name="struktur-kades">Struktur Kantor Desa</button>
													</a>
												</li>

												<span>Pusat Bantuan</span>
												<li>
													<a><i class="fa fa-question-circle fa-question-menu"></i>
														<button type="submit" name="faq">FAQ</button>
													</a>
												</li>
												<li>
													<a><i class="fa fa-gear"></i>
														<button type="submit" name="tutorial">Cara Penggunaan</button>
													</a>
												</li>
												<?php if( isset($_SESSION["login"]) ) : ?>
													<li>
														<a><i class="fa fa-sign-out"></i>
															<button type="submit" name="logout">Keluar</button>
														</a>
													</li>
												<?php endif; ?>
											</form>

											<span>Tema Gelap</span>
											<!-- checbox DarkMode MOBILE-->
											<li>
												<input type="checkbox" id="check-darkMode-mobile">
												<label for="check-darkMode-mobile">
													<a id="btn-toggle-off" onclick="setDarkMode(true)" title="Tema Gelap"><i class="fa fa-toggle-off"></i></a>

													<a id="btn-toggle-on" onclick="setDarkMode(false)" title="Tema Terang"><i class="fa fa-toggle-on"></i></a>
												</label>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="menu <?php if( !isset($_SESSION["login"]) ) : ?> menu-session <?php endif; ?>">
							<ul>
								<li><a href="index" class="bg-menu"><i class="fa fa-home"></i> Beranda</a></li>
								<li><a href="index#product" class="bg-menu">Produk</a></li>
								<!-- <li><a href="" class="bg-menu">Profil</a></li> -->

								<!-- checkbox profile -->
								<input type="checkbox" id="check-profile">
								<label for="check-profile">
									<li><a class="bg-menu" id="btn-view-profile">Profil <i class="fa fa-angle-down"></i></a></li>
								</label>
								<div class="box-list-menu-profile">
									<ul>
										<li><a href="index#sejarah-desa">Sejarah Desa</a></li>
									<li><a href="index#visi-misi">Visi Misi</a></li>
									<li><a href="index#struktur-bumdes">Struktur Bumdes</a></li>
									<li><a href="index#struktur-kades">Struktur Kantor Desa</a></li>
									</ul>
								</div>

								<li><a href="index#faq" class="bg-menu">FAQ</a></li>
								<li><a href="index#tutorial" class="bg-menu">Cara Pengunaan</a></li>

								<?php if( isset($_SESSION["login"]) ) : ?>
									<li>
										<a href="notification" class="bg-menu"><i class="fa fa-bell"></i>
											Notifikasi<sup id="jumlah-notif"><?php echo "{$notifResultAmount["amountNotif"]}"; ?></sup>
										</a>
									</li>
								<?php endif; ?>

								<!-- checkbox search -->
								<div class="container-box-search">
									<input type="checkbox" id="check-search">
									<label for="check-search">
										<li><a class="bg-search" id="btn-view-search"><i class="fa fa-search"></i></a></li>
										<a id="btn-close-search" title="Hidden"><i class="fa fa-angle-right"></i></a>
									</label>
									<div class="box-list-search">
										<form action="" method="get">
											<table>
												<tr>
													<td colspan="2">
														<center><img src="assets/images/undraw/download_undraw_Web_search_re_efla.svg" alt=""></center>
													</td>
												</tr>
												<tr>
													<td>
														<input type="search" name="q" placeholder="Cari Barang..">
													</td>
													<td>
														<button type="submit" name="search"><i class="fa fa-search"></i></button>
													</td>
												</tr>
											</table>
										</form>
									</div>
								</div>

								<!-- checkbox account -->
								<?php if( !isset($_SESSION["login"]) ) : ?>
									<li><a href="auth/login" class="bg-menu bg-auth">Masuk / Daftar</a></li>
								<?php endif; ?>

								<?php if( isset($_SESSION["login"]) ) : ?>
									<input type="checkbox" id="check-account">
									<label for="check-account">
										<li><a class="bt-acccount" id="btn-view-account"><i class="fa fa-user bt-menu"></i></a></li>
									</label>
									<div class="box-list-menu">
										<li><a href="#"><i class="fa fa-cog"></i> Profilmu</a></li>
										<li><a href="info-order"><i class="fa fa-info-circle"></i> Info Pesanan</a></li>
										<li><a href="auth/logout"><i class="fa fa-sign-out"></i> Keluar</a></li>
									</div>
								<?php endif; ?>

								<!-- checbox DarkMode -->
								<li>
									<input type="checkbox" id="check-darkMode">
									<label for="check-darkMode">
										<a id="btn-moon" onclick="setDarkMode(true)" title="Tema Gelap"><i class="fa fa-moon"></i></a>
										<a id="btn-sun" onclick="setDarkMode(false)" title="Tema Terang"><i class="fa fa-sun"></i></a>
									</label>
								</li>

							</ul>
						</div>
						<div class="clear-both"></div>
					</div>
				</nav>
				<!-- end nav -->
				<div class="clear-both"></div>

			</div>
		</top-bar>
	</section>
	<!-- === END TOP BAR === -->

	
	<!-- === CONTAINER === -->
		<section>
			<div class="container container-profile-user">

				<div class="title-content title-content-profile">
					<h1>Profil</h1>
				</div>

				<!-- === PROFILE USER === -->
				<div class="profile-user">
					<div class="clear-both"></div>

					<!-- left profile user -->
					<div class="left-profile-user">
						<div class="header-left-profile-user">
							<h2>Ubah Profil Anda</h2>
						</div>
						<div class="img-left-profile-user">
							<i class="fa fa-user"></i>
							<h3><?= $dataUserUrl["nama"]; ?></h3>
							<span><?= $dataUserUrl["username"]; ?></span>
						</div>
						<div class="table-left-profile-user">
							<form action="" method="post">
								<input type="hidden" name="id" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($dataUserUrl["id"]))))))))); ?>">
								<table>
									<tr>
										<td class="icon-td">
											<label for="nama">Nama Lengkap</label>
										</td>
										<td>
											<input type="text" name="nama" id="nama" placeholder="Nama Lengkap" required oninvalid="this.setCustomValidity('Nama lengkap harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= $dataUserUrl["nama"]; ?>">
										</td>
									</tr>
									<tr>
										<td class="icon-td">
											<label for="alamat">Alamat Lengkap</label>
										</td>
										<td>
											<input type="text" name="alamat" id="alamat" placeholder="Alamat Lengkap" required oninvalid="this.setCustomValidity('Masukan alamat tinggal!')" oninput="setCustomValidity('')" maxlength="255" value="<?= $dataUserUrl["alamat"]; ?>"></input>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<button type="submit" name="save-data"><i class="fa fa-save"></i> Simpan Data</button>
										</td>
									</tr>
								</table>
							</form>

							<div class="username-left-profile-user">
								<form action="" method="post">
									<input type="hidden" name="id" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($dataUserUrl["id"]))))))))); ?>">
									<table>
										<tr>
											<td class="icon-td">
												<label for="username">Nomor Telepon</label>
											</td>
											<td>
												<input type="number" name="username" id="username" placeholder="Nomor Telepon" required oninvalid="this.setCustomValidity('Nomor telepon harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= $dataUserUrl["username"]; ?>">
											</td>
										</tr>
										<tr>
											<td></td>
											<td>
												<span id="notif-username">Gunakan Nomor Telepon Yang Aktif</span>
											</td>
										</tr>
										<tr>
											<td></td>
											<td>
												<button type="submit" name="save-username" onclick="return confirm('Ganti Nomor Telepon?');"><i class="fa fa-save"></i> Ganti Nomor Telepon</button>
											</td>
										</tr>
									</table>	
								</form>
							</div>

						</div>
						<div class="clear-both"></div>
					</div>
					<!-- end left profile user -->

					<!-- right profile user -->
					<div class="right-profile-user">

						<!-- box right profile user -->
						<div class="box-right-profile-user">
							<div class="header-right-profile-user">
								<h2>Ganti Kata Sandi</h2>
							</div>
							<div class="table-right-profile-user">
								<form action="" method="post">
									<input type="hidden" name="id" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($dataUserUrl["id"]))))))))); ?>">
									<table>
										<tr>
											<td class="icon-td">
												<label for="password">Kata Sandi Baru</label>
											</td>
											<td>
												<input type="password" name="password" id="password" placeholder="Kata Sandi Baru" required oninvalid="this.setCustomValidity('Untuk Menjaga Kemanan Akun Anda, Masukan Minimal 8 Karakter Kata Sandi!')" oninput="setCustomValidity('')" minlength="8">
											</td>
										</tr>
										<tr>
											<td class="icon-td">
												<label for="password2">Konfirmasi Kata Sandi Baru</label>
											</td>
											<td>
												<input type="password" name="password2" id="password2" placeholder="Konfirmasi Kata Sandi Baru">
											</td>
										</tr>
										<tr>
											<td></td>
											<td>
												<button type="submit" name="save-password" onclick="return confirm('Gani Kata Sandi?');"><i class="fa fa-save"></i> Ganti Kata Sandi</button>
											</td>
										</tr>
									</table>
								</form>
							</div>
						</div>
						<!-- end box right profile user -->

						<!-- box right profile user -->
						<div class="box-right-profile-user">
							<div class="header-right-profile-user">
								<h2>Hapus Akun</h2>
							</div>

							<?php if( empty($rowSessionOrderId)  ) : ?>
								<div class="table-right-profile-user">
									<p>Perhatian: Penghapusan akun bersifat permanen, dan akunmu tidak dapat dipulihkan kembali.</p>
									<a href="delete-account?u=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["id"]))))))))); ?>" onclick="return confirm('Hal ini bersifat permanen. Hapus Akun?');">Hapus Akun</a>
								</div>
							<?php endif; ?>

							<?php if( !empty($rowSessionOrderId)  ) : ?>
								<?php if( $rowSessionOrderId["status"] == 0 ) : ?>
									<div class="table-right-profile-user">
										<p>Perhatian: Penghapusan akun bersifat permanen, dan akunmu tidak dapat dipulihkan kembali.</p>
										<a href="delete-account?u=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["id"]))))))))); ?>" onclick="return confirm('Hal ini bersifat permanen. Hapus Akun?');">Hapus Akun</a>
									</div>
								<?php endif; ?>
							<?php endif; ?>

							<?php if( !empty($rowSessionOrderId)  ) : ?>
								<?php if( $rowSessionOrderId["status"] == 1 ) : ?>
									<div class="table-right-profile-user">
										<p>Perhatian: Saat ini akunmu belum bisa dihapus. Masih ada pesanan yang belum dikembalikan.</p>
										<a onclick="return confirm('Pesanan Anda Sedang Diproses. Akun tidak dapat dihapus');" class="not-delete-account">Hapus Akun</a>
									</div>
								<?php endif; ?>
							<?php endif; ?>

							<?php if( !empty($rowSessionOrderId)  ) : ?>
								<?php if( $rowSessionOrderId["status"] == 2 ) : ?>
									<div class="table-right-profile-user">
										<p>Perhatian: Saat ini akunmu belum bisa dihapus. Masih ada pesanan yang belum dikembalikan.</p>
										<a onclick="return confirm('Pesanan Anda Selesai Diproses. Akun tidak dapat dihapus');" class="not-delete-account">Hapus Akun</a>
									</div>
								<?php endif; ?>
							<?php endif; ?>

							<?php if( !empty($rowSessionOrderId)  ) : ?>
								<?php if( $rowSessionOrderId["status"] == 3 ) : ?>
									<div class="table-right-profile-user">
										<p>Perhatian: Penghapusan akun bersifat permanen, dan akunmu tidak dapat dipulihkan kembali.</p>
										<a href="delete-account?u=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["id"]))))))))); ?>" onclick="return confirm('Hal ini bersifat permanen. Hapus Akun?');">Hapus Akun</a>
									</div>
								<?php endif; ?>
							<?php endif; ?>

							<div class="table-right-profile-user">
								<br>
								<a href="auth/logout" onclick="return confirm('Keluar?');"><i class="fa fa-sign-out"></i> Keluar</a>
							</div>

						</div>
						<!-- end box right profile user -->

					</div>

					<div class="clear-both"></div>
				</div>

				

				<!-- FOOTER -->
				<section>
					<footer>
						<div class="footer">
							<p>© <?= $year; ?> Bumdes Helumo | All right reserved.</p>
						</div>
					</footer>
				</section>
				<!-- END FOOTER -->


			</div>
		</section>
	<!-- === END CONTAINER === -->


	<!-- COPYRIGHT IMAGES/IMG/ILUSTRATIONS -->
	<!-- https://undraw.co/illustrations -->
	
	<!-- DARK MODE -->
	<script>
		function setDarkMode(isDark){

			if( isDark ){
				document.body.setAttribute('id', 'darkmode')
			} else{
				document.body.setAttribute('id', '')
			}
		}
	</script>

</body>
</html>