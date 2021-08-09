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

// === QUERT DATA TABLE TENDA ===
$tableTenda = $conn->query("SELECT * FROM tb_tenda");
$rowTableTenda = mysqli_fetch_assoc($tableTenda);


// === QUERY DATA TABLE TENDA (URL) ===
// query data table tenda
	if( $rowSession["opsi_harga"] == 0 ){
		$hargaUnit1 = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["harga_unit_1"]))))))));
	}

	if( $rowSession["opsi_harga"] == 1 ){
		$hargaUnit2 = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["harga_unit_2"]))))))));
	}

	$tglTransaksi = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["tgl_transaksi"]))))))));
	$blnTransaksi = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["bln_transaksi"]))))))));
	$thnTransaksi = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["thn_transaksi"]))))))));

	$namaUser = $_GET["nama"];
	$noTelp = $_GET["no_telp"];
	$alamatUser = $_GET["alamat"];
	$jumlahUnit = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["jumlah_unit"]))))))));
	$tglPakai = $_GET["tgl_pakai"];
	$jangka_waktu = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["jangka_waktu"]))))))));
	$jenis = $_GET["jenis"];
	$stok_unit = $_GET["stok_unit"];
	$status = $_GET["status"];

	// set aritmatika
	if( $rowSession["opsi_harga"] == 0 ){
		$hasil1 = $jumlahUnit * $hargaUnit1;
		$hasilAkhir = $hasil1 * $jangka_waktu;
	}
	if( $rowSession["opsi_harga"] == 1 ){
		$hasil1 = $jumlahUnit * $hargaUnit2;
		$hasilAkhir = $hasil1 * $jangka_waktu;
	}

	// set & check Stok Unit otomatic
	$countUnit = $stok_unit - $jumlahUnit;


// check URL confirm-order
if( $rowSession["opsi_harga"] == 0 ){
	if( !isset($_GET["harga_unit_1"] ) ){
		header("Location:index");
		exit;
	}
}
if( $rowSession["opsi_harga"] == 1 ){
	if( !isset($_GET["harga_unit_2"] ) ){
		header("Location:index");
		exit;
	}
}

if( !isset($_GET["nama"] ) ){
	header("Location:index");
	exit;
}
if( !isset($_GET["no_telp"] ) ){
	header("Location:index");
	exit;
}
if( !isset($_GET["alamat"] ) ){
	header("Location:index");
	exit;
}
if( !isset($_GET["jumlah_unit"] ) ){
	header("Location:index");
	exit;
}
if( !isset($_GET["tgl_pakai"] ) ){
	header("Location:index");
	exit;
}
if( !isset($_GET["jangka_waktu"] ) ){
	header("Location:index");
	exit;
}
if( !isset($_GET["jenis"] ) ){
	header("Location:index");
	exit;
}
if( !isset($_GET["status"] ) ){
	header("Location:index");
	exit;
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


// SESSION USER LOGIN (NOTIFICATION)
if( isset($_SESSION["login"]) ){
	$notifSession = $_SESSION["username"];
	$notifResultSession = $conn->query("SELECT * FROM tb_users WHERE username = '$notifSession' ");
	$notifRowSession = mysqli_fetch_assoc($notifResultSession);

	$notifIdSession = $notifRowSession["id"];
	$notifDataSession = $conn->query("SELECT * FROM tb_notifications WHERE id_user = '$notifIdSession' ");
	$notifDataRowSession = mysqli_fetch_assoc($notifDataSession);

}


// check button next-order
if( isset($_POST["next-order"]) ){
	if( order($_POST) > 0 ){
		echo "
		<script>
			alert('Pesanan anda berhasil dikirimkan!');
			document.location.href = 'proof-order';
		</script>";
	} else{
		echo "
		<script>
			alert('Pesanan anda gagal dikirimkan!');
			document.location.href = 'proof-order';
		</script>";
	}
}

// check button next-order
if( isset($_POST["next-order"]) ){
	if( updateStokTenda($_POST) > 0 ){
		echo "
		<script>
			alert('Stok Berubah!');
			document.location.href = 'proof-order';
		</script>";
	} else{
		echo "
		<script>
			alert('Stok Tidak Berubah!');
			document.location.href = 'proof-order';
		</script>";
	}
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
	<title>Konfirmasi Pemesanan | Helumo</title>
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
										<a href="notification" class="bg-menu">
											<i class="fa fa-bell">
												<?php if( !empty($notifDataRowSession) ) : ?>
													<sup><?php echo "{$notifResultAmount["amountNotif"]}"; ?></sup>
												<?php endif; ?>
											</i>Notifikasi
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
					<h1>Konfirmasi Pemesanan Unit Usaha</h1>
				</div>

				<!-- Konfirmasi PEMESANAN -->
				<!-- box form order -->
					<div class="box-form-order box-form-order-confirm">
						<form action="" method="post">
							<input type="hidden" name="id_user" value="<?= $rowSession["id"]; ?>">
							<input type="hidden" name="tgl_transaksi" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($tglTransaksi))))))));  ?>">

							<input type="hidden" name="bln_transaksi" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($blnTransaksi))))))));  ?>">

							<input type="hidden" name="thn_transaksi" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($thnTransaksi))))))));  ?>">

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
												<input type="text" id="nama" placeholder="Nama Lengkap" required oninvalid="this.setCustomValidity('Nama lengkap harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($namaUser)))))))); ?>" readonly>
												<input type="hidden" name="nama" id="nama" placeholder="Nama Lengkap" required oninvalid="this.setCustomValidity('Nama lengkap harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= $namaUser; ?>" readonly>
											</td>
										</tr>

										<tr>
											<td>
												<label for="no_telp">Nomor Telepon</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="number" id="no_telp" placeholder="Nomor Telepon" required oninvalid="this.setCustomValidity('Nomor telepon harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($noTelp)))))))); ?>" readonly>
												<input type="hidden" name="no_telp" id="no_telp" placeholder="Nomor Telepon" required oninvalid="this.setCustomValidity('Nomor telepon harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= $noTelp; ?>" readonly>
											</td>
										</tr>

										<tr>
											<td>
												<label for="alamat">Alamat</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="text" id="alamat" placeholder="Alamat Lengkap" required oninvalid="this.setCustomValidity('Masukan alamat tinggal!')" oninput="setCustomValidity('')" maxlength="255" value="<?= base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($alamatUser)))))))); ?>" readonly></input>
												<input type="hidden" name="alamat" id="alamat" placeholder="Alamat Lengkap" required oninvalid="this.setCustomValidity('Masukan alamat tinggal!')" oninput="setCustomValidity('')" maxlength="255" value="<?= $alamatUser; ?>" readonly></input>
											</td>
										</tr>

										<tr>
											<td>
												<label for="jenis">Jenis</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="text" id="jenis" required oninvalid="this.setCustomValidity('Nama lengkap harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($jenis)))))))); ?>" readonly>
												<input type="hidden" name="jenis" id="jenis" required oninvalid="this.setCustomValidity('Nama lengkap harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= $jenis; ?>" readonly>
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
												<input type="text" id="jumlah_unit" maxlength="50" value="<?= $jumlahUnit; ?> Unit" readonly>
												<input type="hidden" name="jumlah_unit" id="jumlah_unit" maxlength="50" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($jumlahUnit)))))))); ?> Unit" readonly>
											</td>
										</tr>
										<tr>
											<td>
												<label for="tgl_pakai">Tanggal Pakai</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="text" name="tgl_pakai" id="tgl_pakai" placeholder="Pilih tanggal" required oninvalid="this.setCustomValidity('Masukan tanggal pemakaian!')" oninput="setCustomValidity('')" maxlength=3 title="Masukan tanggal pemakaian" value="<?= $tglPakai; ?>" readonly></input>
											</td>
										</tr>

										<tr>
											<td>
												<label for="jangka_waktu">Jangka Waktu</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="text" id="jangka_waktu" maxlength="50" value="<?= $jangka_waktu; ?> Hari" readonly>
												<input type="hidden" name="jangka_waktu" id="jangka_waktu" maxlength="50" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($jangka_waktu)))))))); ?> Hari" readonly>
											</td>
										</tr>

										<tr>
											<td>
												<label for="total">Total</label>
											</td>
										</tr>
										<tr>
											<td>
												<input type="text" id="total" required oninvalid="this.setCustomValidity('Nama lengkap harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="Rp. <?= number_format($hasilAkhir, 0, ',', '.'); ?>" readonly>
												<input type="hidden" name="total" id="total" required oninvalid="this.setCustomValidity('Nama lengkap harus diisi!')" oninput="setCustomValidity('')" maxlength="50" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($hasilAkhir)))))))); ?>" readonly>
											</td>
										</tr>

									</table>
								</div>

								<div class="form-order-button">
									<table>
										<tr>
											<td>
												<input type="hidden" value="<?= $status; ?>" name="status">
												<?php foreach( $unitTenda as $row ) : ?>
													<a href="order?unit=<?= $row["id_tenda"]; ?>" id="prev-order">Kembali</a>
												<?php endforeach; ?>
												
												<?php if( empty($rowSessionOrderId) ) : ?>
													<input type="hidden" name="id_tenda" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowTableTenda["id_tenda"]))))))))); ?>">
													<input type="hidden" name="stok_unit" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($countUnit))))))))); ?>">
													<button type="submit" name="next-order" onclick="return confirm('Kirim Pesanan?');">Kirim Pesanan</button>
												<?php endif; ?>

												<?php if( $rowSessionOrderId ) : ?>
													<?php if( $rowSessionOrderId["status"] == 3 ) : ?>
													<a href="info-order" onclick="return confirm('Hapus Terlebih Dahulu Pesanan anda yang lama');" id="block-order">Kirim Pesanan</a>
													<p><br>Untuk memesan kembali hapus terlebih dahulu pesanan anda yang lama di <a href="info-order">Pesananmu</a></p>
													<?php endif; ?>
												<?php endif; ?>
												
												<?php if( !empty($rowSessionOrderId ) ) : ?>
													<?php if( $rowSessionOrderId["status"] == 0 ) : ?>
														<a onclick="return confirm('Anda bisa memesan lagi ketika pesanan anda sudah diproses admin, dan barang sudah dikembalikan');" id="block-order">Kirim Pesanan</a>
													<?php endif; ?>
												<?php endif; ?>

												<?php if( !empty($rowSessionOrderId ) ) : ?>
													<?php if( $rowSessionOrderId["status"] == 1 ) : ?>
														<a onclick="return confirm('Anda bisa memesan lagi ketika pesanan anda sudah diproses admin, dan barang sudah dikembalikan');" id="block-order">Kirim Pesanan</a>
													<?php endif; ?>
												<?php endif; ?>

												<?php if( !empty($rowSessionOrderId ) ) : ?>
													<?php if( $rowSessionOrderId["status"] == 2 ) : ?>
														<a onclick="return confirm('Anda bisa memesan lagi ketika pesanan anda sudah diproses admin, dan barang sudah dikembalikan');" id="block-order">Kirim Pesanan</a>
													<?php endif; ?>
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

				<!-- END Konfirmasi PEMESANAN -->

				

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