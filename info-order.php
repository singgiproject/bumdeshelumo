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

if( isset($_POST["notification"]) ){
	header("Location:notification");
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
	<title>Info Pesanan | Helumo</title>
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
							<a href="#" id="menu-active"><i class="fa fa-shopping-cart" id="menu-active"></i>Pesananmu
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

				<div class="title-content title-content-order title-content-info-order">
					<h1>Info Pesanan</h1>
				</div>

				<!-- INFO ORDER DESKTOP -->
				<!-- table info order -->
				<?php if( !empty($rowSessionOrderId) ) : ?>
					<div class="table-order-desktop">
						<div class="box-table-order-desktop">
							<div class="update-order">
								<!-- <a href="update-order?unit=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSessionOrderId["id"]))))))))); ?>">Tambah Pesanan</a> -->
								<a href="" onclick="return confirm('Fitur ini masih dalam perbaikan');">Tambah Pesanan</a>
							</div>
							<table border="1" cellpadding="10" cellspacing="0">
								<?php $id_no = 1; ?>
									<tr>
										<th>No</th>
										<th>Nama</th>
										<th>Nomor Telepon</th>
										<th>Alamat</th>
										<th>Jenis</th>
										<th>Jumlah</th>
										<th>Tanggal</th>
										<th>Jangka Waktu</th>
										<th>Total</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
									<tr>
										<td><?= $id_no; ?></td>
										<td><?= $rowSessionOrderId["nama"]; ?></td>
										<td><?= $rowSessionOrderId["no_telp"]; ?></td>
										<td><?= $rowSessionOrderId["alamat"]; ?></td>
										<td><?= $rowSessionOrderId["jenis"]; ?></td>
										<td><?= $rowSessionOrderId["jumlah_unit"]; ?> Unit</td>
										<td><?= $rowSessionOrderId["tgl_pakai"]; ?></td>
										<td><?= $rowSessionOrderId["jangka_waktu"]; ?> Hari</td>
										<td>Rp. <?= number_format($rowSessionOrderId["total"], 0, ',', '.'); ?></td>
										<td>
											<?php if( $rowSessionOrderId["status"] == 0 ) : ?>
												<p class="unprocessed">Menunggu Diproses</p>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 1 ) : ?>
												<p class="being-processed">Sedang Diproses</p>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 2 ) : ?>
												<p class="successfully-processed">Selesai Diproses</p>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 3 ) : ?>
												<p class="returned">Telah dikembalikan</p>
											<?php endif; ?>
										</td>
										<td>
											<?php if( $rowSessionOrderId["status"] == 3 ) : ?>
												<a href="cancel-order?unit=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSessionOrderId["id_user"])))))))); ?>" id="cancel-order-info" onclick="return confirm('Batalkan Pemesanan?');"><i class="fa fa-trash" title="Batalkan Pemesanan"></i></a>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 2 ) : ?>
												<a onclick="return confirm('Pemesanan tidak dapat dibatalkan');"><i class="fa fa-trash not-cancel-order-info"></i></a>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 1 ) : ?>
												<a onclick="return confirm('Pemesanan tidak dapat dibatalkan');"><i class="fa fa-trash not-cancel-order-info"></i></a>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 0 ) : ?>
												<a href="cancel-order?unit=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSessionOrderId["id_user"])))))))); ?>" id="cancel-order-info" onclick="return confirm('Batalkan Pemesanan?');"><i class="fa fa-trash" title="Batalkan Pemesanan"></i></a>
											<?php endif; ?>
										</td>
									</tr>
								<?php $id_no++; ?>
							</table>
						</div>
						<div class="clear-both"></div>
					</div>
				<?php endif; ?>

				<?php if( empty($rowSessionOrderId) ) : ?>
					<div class="table-order-desktop">
						<div class="box-table-order-desktop">
							<table border="1" cellpadding="10" cellspacing="0">
								<?php $id_no = 1; ?>
									<tr>
										<th>No</th>
										<th>Nama</th>
										<th>Nomor Telepon</th>
										<th>Alamat</th>
										<th>Jenis</th>
										<th>Jumlah</th>
										<th>Tanggal</th>
										<th>Jangka Waktu</th>
										<th>Total</th>
										<th>Status</th>
										<th>Aksi</th>
									</tr>
									<tr>
										<td colspan="11"><center>Tidak ada data dalam tabel</center></td>
									</tr>
								<?php $id_no++; ?>
							</table>
						</div>
						<div class="clear-both"></div>
					</div>
				<?php endif; ?>
					<!-- end box infor order desktop -->


					<!-- INFO ORDER MOBILE -->
				<!-- table info order -->
				<?php if( !empty($rowSessionOrderId) ) : ?>
					<div class="table-order-mobile">
						<div class="box-table-order-mobile">
							<table cellpadding="10" cellspacing="0">
								<tr>
									<td>Nama</td>
									<td><?= $rowSessionOrderId["nama"]; ?></td>
								</tr>
								<tr>
									<td>Nomor Telepon</td>
									<td><?= $rowSessionOrderId["no_telp"]; ?></td>
								</tr>
								<tr>
										<td>Alamat</td>
										<td><?= $rowSessionOrderId["alamat"]; ?></td>
								</tr>
								<tr>
									<td>Jenis</td>
									<td><?= $rowSessionOrderId["jenis"]; ?></td>
								</tr>
								<tr>
									<td>Jumlah</td>
									<td><?= $rowSessionOrderId["jumlah_unit"]; ?> Unit</td>
								</tr>
								<tr>
									<td>Tanggal</td>
									<td><?= $rowSessionOrderId["tgl_pakai"]; ?></td>
								</tr>
								<tr>
									<td>Jangka Waktu</td>
									<td><?= $rowSessionOrderId["jangka_waktu"]; ?> Hari</td>
								</tr>
								<tr>
									<td>Total</td>
									<td>Rp. <?= number_format($rowSessionOrderId["total"], 0, ',', '.'); ?></td>
								</tr>
								<tr>
									<td>Status</td>
									<td>
											<?php if( $rowSessionOrderId["status"] == 0 ) : ?>
												<p class="unprocessed">Menunggu Diproses</p>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 1 ) : ?>
												<p class="being-processed">Sedang Diproses</p>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 2 ) : ?>
												<p class="successfully-processed">Selesai Diproses</p>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 3 ) : ?>
												<p class="returned">Telah dikembalikan</p>
											<?php endif; ?>
									</td>
								</tr>
								<tr>
									<td colspan="2">
											<?php if( $rowSessionOrderId["status"] == 3 ) : ?>
												<a href="cancel-order?unit=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSessionOrderId["id_user"])))))))); ?>" id="cancel-order-info-mobile" onclick="return confirm('Batalkan Pemesanan?');"><i class="fa fa-trash" title="Batalkan Pemesanan"></i> Batalkan / Hapus Pemesanan</a>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 2 ) : ?>
												<a onclick="return confirm('Pemesanan tidak dapat dibatalkan');" id="not-cancel-order-info-mobile"><i class="fa fa-trash" title="Batalkan Pemesanan"></i> Batalkan / Hapus Pemesanan</a>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 1 ) : ?>
												<a onclick="return confirm('Pemesanan tidak dapat dibatalkan');" id="not-cancel-order-info-mobile"><i class="fa fa-trash" title="Batalkan Pemesanan"></i> Batalkan / Hapus Pemesanan</a>
											<?php endif; ?>

											<?php if( $rowSessionOrderId["status"] == 0 ) : ?>
												<a href="cancel-order?unit=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowSessionOrderId["id_user"])))))))); ?>" id="cancel-order-info-mobile" onclick="return confirm('Batalkan Pemesanan?');"><i class="fa fa-trash" title="Batalkan Pemesanan"></i> Batalkan / Hapus Pemesanan</a>
											<?php endif; ?>
									</td>
								</tr>
							</table>
						</div>
						<div class="clear-both"></div>
					</div>
				<?php endif; ?>



				<?php if( empty($rowSessionOrderId) ) : ?>
					<div class="table-order-mobile">
						<div class="box-table-order-mobile">
							<img src="assets/images/undraw/download_undraw_No_data_re_kwbl.svg" alt="">
							<p>Tidak Ada Pesanan</p>
						</div>
						<div class="clear-both"></div>
					</div>
				<?php endif; ?>
				<!-- end box infor order mobile -->


				</div>
				<!-- END BOX ORDER -->

				<!-- END INFO ORDER -->

				

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