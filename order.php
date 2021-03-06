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

// === QUERY TABLE TENDA (ID) ===
// query table tenda
	$idUnit = $_GET["unit"];
	$unitTendaId = query("SELECT * FROM tb_tenda WHERE id_tenda = '$idUnit' ")[0];


// VALUE STATUS
$status = "0";

// check URL order
if( empty($_GET["unit"]) ){
	header("Location:index");
	exit;
}
if( !isset($_GET["unit"]) ){
	header("Location:index");
	exit;
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

// check stok_unit
$orderStokUnit = $conn->query("SELECT COUNT(*) orderStokUnit FROM tb_order");
$countStokUnit = mysqli_fetch_assoc($orderStokUnit);

// $orderStokUnit = $conn->query("SELECT jumlah_unit FROM tb_order");
// $countStokUnit = mysqli_fetch_assoc($orderStokUnit);
// $fieldStokUnit = $countStokUnit["jumlah_unit"];



// Set date
date_default_timezone_set('Asia/Makassar');
$year = date("Y");

// Set date
date_default_timezone_set('Asia/Makassar');
$tgl_transaksi = date("d");
$bln_transaksi = date("M");
$thn_transaksi = date("Y");




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
	<title>Badan Usaha Milik Desa | Helumo</title>
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
							<a href="index" id="menu-active">
								<i class="fa fa-home" id="menu-active"></i>Beranda
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
							<a href="profile?u=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["id"]))))))))); ?>"><i class="fa fa-user"></i>Akun
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
										<li><a href="profile?u=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["id"]))))))))); ?>"><i class="fa fa-cog"></i> Profilmu</a></li>
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
			<div class="container">

				<div class="title-content title-content-order">
					<h1>Silahkan Lakukan Pemesanan</h1>
				</div>

				<!-- BOX ORDER -->
				<div class="box-order">
					<!-- logo unit -->
					<div class="logo-unit">
						<img src="assets/images/kanopi/<?= $unitTendaId["gambar_unit"]; ?>" alt="">
						<h2><?= $unitTendaId["nama_unit"]; ?></h2>

						<!-- chek opsi harga -->
						<?php if( $rowSession["opsi_harga"] == 0 ) : ?>
							<p>Rp. <?= number_format($unitTendaId["harga_unit_1"], 0, ",", "."); ?>/ Unit (1 Hari Dalam Desa)</p>
						<?php endif; ?>

						<?php if( $rowSession["opsi_harga"] == 1 ) : ?>
							<p>Rp. <?= number_format($unitTendaId["harga_unit_2"], 0, ",", "."); ?>/ Unit (1 Hari Luar Desa)</p>
						<?php endif; ?>
						<!-- end chek opsi harga -->

						<?php if( $unitTendaId["stok_unit"] ) : ?>
							<p>Stok Tersedia : <?= $unitTendaId["stok_unit"]; ?></p>
						<?php endif; ?>

						<?php if( $unitTendaId["stok_unit"] == 0 ) : ?>
							<p>Stok Sudah Habis</p>
						<?php endif; ?>
					</div>
					<!-- end logo unit -->

					<!-- box form order -->
					<div class="box-form-order">
						<form action="confirm-order" method="get">
							<input type="hidden" name="id_user" value="<?= $rowSession["id"]; ?>">
							<div class="container-form-order">
								<div class="form-left-order">
									<table>
										<tr>
											<td>
												<label for="nama">Nama</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="text" id="nama" placeholder="Nama Lengkap" required oninvalid="this.setCustomValidity('Nama lengkap harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= $rowSession["nama"]; ?>" readonly>
												<input type="hidden" name="nama" id="nama" placeholder="Nama Lengkap" required oninvalid="this.setCustomValidity('Nama lengkap harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["nama"])))))))); ?>" readonly>
											</td>
										</tr>

										<tr>
											<td>
												<label for="no_telp">Nomor Telepon</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="number" id="no_telp" placeholder="Nomor Telepon" required oninvalid="this.setCustomValidity('Nomor telepon harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= $rowSession["username"]; ?>" readonly>
												<input type="hidden" name="no_telp" id="no_telp" placeholder="Nomor Telepon" required oninvalid="this.setCustomValidity('Nomor telepon harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["username"])))))))); ?>" readonly>
											</td>
										</tr>

										<tr>
											<td>
												<label for="alamat">Alamat</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="text" id="alamat" placeholder="Alamat Lengkap" required oninvalid="this.setCustomValidity('Masukan alamat tinggal!')" oninput="setCustomValidity('')" maxlength="255" value="<?= $rowSession["alamat"]; ?>" readonly></input>
												<input type="hidden" name="alamat" id="alamat" placeholder="Alamat Lengkap" required oninvalid="this.setCustomValidity('Masukan alamat tinggal!')" oninput="setCustomValidity('')" maxlength="255" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSession["alamat"])))))))); ?>" readonly></input>
											</td>
										</tr>
									</table>
								</div>

								<div class="form-right-order">
									<table>
										<tr>
											<td>
												<label for="jumlah_unit">Jumlah</label>
											</td>
										</tr>
										<tr>
											<td>
												<?php if( $unitTendaId["stok_unit"] ) : ?>
													<select name="jumlah_unit" id="jumlah_unit">
														<?php for( $jumlah_unit = 1; $jumlah_unit < $unitTendaId["stok_unit"] + 1; $jumlah_unit++ ) : ?>
															<option value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($jumlah_unit)))))))); ?>"><?= $jumlah_unit; ?> Unit</option>
														<?php endfor; ?>
													</select>
												<?php endif; ?>

													<?php if( $unitTendaId["stok_unit"] == 0 ) : ?>
														<input type="text" readonly>
													<?php endif; ?>
											</td>
										</tr>
										<tr>
											<td>
												<label for="tgl_pakai">Tanggal Pakai</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="date" name="tgl_pakai" id="tgl_pakai" placeholder="Pilih tanggal" required oninvalid="this.setCustomValidity('Masukan tanggal pemakaian!')" oninput="setCustomValidity('')" maxlength=3 title="Masukan tanggal pemakaian"></input>
											</td>
										</tr>

										<tr>
											<td>
												<label for="jangka_waktu">Jangka Waktu</label>
											</td>
										</tr>
										<tr>
											<td>
												<select name="jangka_waktu" id="jangka_waktu">
													<option>--- Pilih Jangka Waktu ---</option>
													<?php for( $jangka_waktu = 1; $jangka_waktu < 10; $jangka_waktu++ ) : ?>
														<option value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($jangka_waktu)))))))); ?>"><?= $jangka_waktu; ?> Hari</option>
													<?php endfor; ?>
												</select>
											</td>
										</tr>
									</table>
								</div>

								<div class="form-order-button">
									<table>
										<tr>
											<td>
												<input type="hidden" name="stok_unit" value="<?= $unitTendaId["stok_unit"]; ?>">
												<input type="hidden" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($status)))))))); ?>" name="status">
												<input type="hidden" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($unitTendaId["nama_unit"])))))))); ?>" name="jenis">

												<?php if( $rowSession["opsi_harga"] == 0 ) : ?>
													<input type="hidden" name="harga_unit_1" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($unitTendaId["harga_unit_1"])))))))); ?>">
												<?php endif; ?>

												<?php if( $rowSession["opsi_harga"] == 1 ) : ?>
													<input type="hidden" name="harga_unit_2" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($unitTendaId["harga_unit_2"])))))))); ?>">
												<?php endif; ?>

												<input type="hidden" name="tgl_transaksi" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($tgl_transaksi)))))))); ?>">

												<input type="hidden" name="bln_transaksi" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($bln_transaksi)))))))); ?>">

												<input type="hidden" name="thn_transaksi" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($thn_transaksi)))))))); ?>">
												
												<?php if( $unitTendaId["stok_unit"] ) : ?>
													<button type="submit" name="next-button">Selanjutnya</button>
												<?php endif; ?>

												<?php if( $unitTendaId["stok_unit"] == 0 ) : ?>
													<a id="empty-stok">Selanjutnya</a>
												<?php endif; ?>

											</td>
										</tr>
									</table>
								</div>

								<div class="clear-both"></div>
							</div>
						</form>
						<div class="clear-both"></div>
					</div>
					<!-- end box form order -->
				</div>
				<!-- END BOX ORDER -->

				<!-- FOOTER -->
				<section>
					<footer>
						<div class="footer">
							<p>?? <?= $year; ?> Bumdes Helumo | All right reserved.</p>
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