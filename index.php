<?php 
session_start();

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

// check stok_unit
$orderStokUnit = $conn->query("SELECT COUNT(*) orderStokUnit FROM tb_order");
$countStokUnit = mysqli_fetch_assoc($orderStokUnit);

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

// SET ACCESS WEBSITE
// $realWaktu = date("h:i:sa");
// $setWaktu = "04:33:00";
// if( $realWaktu > $setWaktu){
// 	header("Location:error");
// } else{
// 	!$realWaktu > $setWaktu;
// }





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

	<!-- Messenger Plugin Obrolan Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin Obrolan code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "109235747563418");
      chatbox.setAttribute("attribution", "biz_inbox");

      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v11.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/id_ID/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

	<!-- INFO WEBSITE -->
	<!-- <div class="info-web">
		<input type="checkbox" id="check-info-web">
		<label for="check-info-web">
			<i class="fa fa-times" id="btn-close-info-web"></i>
			<i id="btn-close-black"></i>
		</label>
		<div class="box-info-web">
			<h3>Informasi Penting <span>Administrator, 8 Mei 2021</span></h3>
			<p>
				Haii 
				<?php if( !isset($_SESSION["login"]) ) : ?>
					Sobat Bumdes Helumo!
				<?php endif; ?> 
				<?php if( isset($_SESSION["login"]) ) : ?> 
					<?= $rowSession["nama"]; ?> 
				<?php endif; ?>
				 Alamat domain https://bumdes-helumo.000webhostapp.com/ Sudah dipindahkan ke <a href="http://bumdeshelumo.online/">http://bumdeshelumo.online/</a> Website sudah bisa gigunakan yahh. Jika ada kendala tentang fitur-fitur website silahkan hubungi <a href="https://api.whatsapp.com/send?phone=6282346455079&text=Beri Pertanyaan kamu tentang aplikasi ini"><i class="fa fa-envelope"></i> Admin</a></p>
		</div>
	</div> -->

	<!-- === BOTTOM BAR === -->
	<div class="bottom-bar">
		<div class="nav-bottom-bar">
			<div class="menu-bottom-bar">
				<ul>
					<?php if( isset($_SESSION["login"]) ) : ?>
						<li>
							<a href="" id="menu-active">
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
							<a href=""><img src="assets/images/logo/Logo_Kabupaten_Bone_Bolango.png" alt="" id="logo-mobile"></a>
							<a href=""><img src="assets/images/logo/kemendes.png" alt="" id="logo-mobile"></a>
							<a href="" id="logo-desktop"><h2>Bumdes <sup>Desa Helumo</sup></h2></a></a>
							
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
								<li><a href="" class="bg-menu"><i class="fa fa-home"></i> Beranda</a></li>
								<li><a href="#product" class="bg-menu">Produk</a></li>
								<!-- <li><a href="" class="bg-menu">Profil</a></li> -->

								<!-- checkbox profile -->
								<input type="checkbox" id="check-profile">
								<label for="check-profile">
									<li><a class="bg-menu" id="btn-view-profile">Profil <i class="fa fa-angle-down"></i></a></li>
								</label>
								<div class="box-list-menu-profile">
									<ul>
										<li><a href="#sejarah-desa">Sejarah Desa</a></li>
									<li><a href="#visi-misi">Visi Misi</a></li>
									<li><a href="#struktur-bumdes">Struktur Bumdes</a></li>
									<li><a href="#struktur-kades">Struktur Kantor Desa</a></li>
									</ul>
								</div>

								<li><a href="#faq" class="bg-menu">FAQ</a></li>
								<li><a href="#tutorial" class="bg-menu">Cara Pengunaan</a></li>
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

				<!-- BANNER -->
				<section>
					<div class="banner">
							
						<div class="content-banner">
							<h2>Badan Usaha Milik Desa Helumo, Gorontalo</h2>
							<p>Halo sobatku! selamat datang di website Bumdes Desa Helumo. Silahkan lakukan pembelian/pemesanan unit usahamu di sini yah.</p>
							<a href="#product" class="bt-banner">Beli Barang</a>
							<?php if( !isset($_SESSION["login"]) ) : ?>
								<a href="https://bit.ly/apkbumdeshelumo" class="bt-banner bt-banner-apk" target="blank"><i class="fa fa-download"></i> Download Bumdes Helumo.apk (14.3 MB)</a>
							<?php endif; ?>
						</div>

						<div class="hero-banner">
							<img src="assets/images/undraw/download_undraw_business_shop_qw5t.svg" alt="Gambar Hiro">
						</div>
						<div class="clear-both"></div>

					</div>
				</section>
				<!-- END BANNER -->


				<!-- PRODUCT/BARANG -->
					<section id="product">
						<content>
							<div class="product">
								<div class="title-content">
									<h2>Produk Teratas</h2>
									<h1>Silahkan Lakukan Pemesanan</h1>
									<p>Berikut ini adalah produk atau barang yang bisa anda pesan</p>
								</div>

								<?php foreach( $unitLpg as $row ) : ?>
									<div class="box-product">
										<div class="img-box-product">
											<a href="assets/images/lpg/<?= $row["gambar_unit"]; ?>" title="LPG">
												<img src="assets/images/lpg/<?= $row["gambar_unit"]; ?>" alt="" class="fa fa-image fa-image-product">
											</a>
										</div>

										<div class="title-box-product">
											<h3><?= $row["nama_unit"]; ?></h3>
										</div>
										<div class="price-box-product">
											<p>Rp. <?= number_format($row["harga_unit"], 0, ',', '.'); ?>/ <span>Tabung</span></p>
										</div>
										<div class="stock">
											<p>Stok Tersedia : <span><?= $row["stok_unit"]; ?></span></p>
										</div>
										<div class="button-order">
											<input type="checkbox" id="check-info-barang">
											<label for="check-info-barang">
												<a id="bt-info">Info Barang <i class="fa fa-angle-right angle-right-info"></i></a>
											</label>
											<div class="box-info-barang">
												<p><i class="fa fa-info-circle"></i> <?= $row["info_unit"]; ?></p>
											</div>
										</div>
									<div class="clear-both"></div>
								<?php endforeach; ?>
								</div>

								<?php foreach( $unitTenda as $row ) : ?>
									<div class="box-product">
										<div class="img-box-product">
											<a href="assets/images/kanopi/<?= $row["gambar_unit"]; ?>" title="Kanopi">
												<img src="assets/images/kanopi/<?= $row["gambar_unit"]; ?>" alt="" class="fa fa-image fa-image-product">
											</a>
										</div>
										<div class="title-box-product">
											<h3><?= $row["nama_unit"]; ?></h3>
										</div>
										<div class="price-box-product">
											<p>
												Rp. <?= number_format($row["harga_unit_1"], 0, ',', '.'); ?>/ <span>Unit (Dalam Desa)
												<?php if( isset($_SESSION["login"]) ) : ?>
													<?php if( $rowSession["opsi_harga"] == 0 ) : ?>
														<i class="fa fa-check"></i>
													<?php endif; ?>
												<?php endif; ?>
												</span>
											</p>
											<p>
												Rp. <?= number_format($row["harga_unit_2"], 0, ',', '.'); ?>/ <span>Unit (Luar Desa)
												<?php if( isset($_SESSION["login"]) ) : ?>
													<?php if( $rowSession["opsi_harga"] == 1 ) : ?>
														<i class="fa fa-check"></i>
													<?php endif; ?>
												<?php endif; ?>
												</span>
											</p>
										</div>
										<div class="stock">
											<p>Stok Tersedia : <span><?= $row["stok_unit"]; ?></span></p>
										</div>
										<div class="button-order">
											<a href="order?unit=<?= $row["id_tenda"]; ?>" id="bt-info">Pesan Sekarang</a>
										</div>
									<div class="clear-both"></div>
									</div>
								<?php endforeach; ?>

							</div>
						</content>
					</section>
				<!-- END PRODUCT/BARANG -->



				<!-- PROFILE -->
				<section id="sejarah-desa">
					<content>
						<div class="sejarah-desa">
							<div class="title-content">
								<h2>PROFIL</h2>
								<h1>Sejarah Desa Helumo</h1>
								<p>Berikut ini sejarah dari desa helumo</p>
							</div>
							<div class="box-profile-desa">
								
								<?php foreach( $unitDeskripsiDesa as $row ) : ?>
									<div class="img-profile-desa">
										<a href="assets/images/banner/<?= $row["gambar"]; ?>">
											<img src="assets/images/banner/<?= $row["gambar"]; ?>" alt="">
										</a>
									</div>
									<div class="paragraf-profile-desa">
										<div class="admin-profile-sejarah">
											<span>Dipost : <i class="fa fa-user"></i> <?= $row["posted"]; ?></span>
										</div>
										<p><?= $row["deskripsi"]; ?></p>

										<div class="maps-village">
											<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7979.273187550906!2d123.13446017218017!3d0.5468546767826823!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x327ed444703495fd%3A0x84e6825484232f37!2sHelumo%2C%20Suwawa%2C%20Bone%20Bolango%20Regency%2C%20Gorontalo!5e0!3m2!1sen!2sid!4v1619113771450!5m2!1sen!2sid" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
										</div>
										<div class="clear-both"></div>
									</div>
								<?php endforeach; ?>

							</div>
						</div>
					</content>
				</section>

				<section id="visi-misi">
					<content>
						<div class="visi-misi">
							<div class="title-content">
								<h2>PROFIL</h2>
								<h1>Visi Dan Misi</h1>
								<p>Pemerintah Desa Helumo Priode 2018-2024</p>
							</div>
							<div class="box-profile-vm">
								<div class="paragraf-profile-vm">
									<h3>Visi :</h3>
									<p>Terwujudnya Pemerintahan Desa Yang Memiliki Integritas, Profesional, Transparan dan Akuntabel, Untuk Mewujudnya Masyarakat Mandiri dan Beretika.</p>

									<h3>Misi :</h3>
									<p>
										1. Membangun Sistem Pemerintahan Yang Memiliki Kompetensi dan Kredibilitas Dalam Menyelenggarakan Pemerintah Desa. <br>
										2. Mewujudkan Pemerintahan Desa Yang Transparan, Akuntabel dan Beretika. <br>
										3. Mewujudkan Efektifitas dan Efisiensi Pengolaan Pendapatan Desa Secara Profesional di Segala Bidang.
									</p>
								</div>
							</div>
						</div>
					</content>
				</section>

				<!-- struktur bumdes -->
				<section id="struktur-bumdes">
					<content>
						<div class="struktur-bumdes">
							<div class="title-content">
								<h2>PROFIL</h2>
								<h1>Struktur Bumdes</h1>
								<p>Struktur Badan Usaha Milik Desa Helumo</p>
							</div>
							<div class="box-profile-bumdes">

								<div class="struktur-bagan">
									<div class="content-struktur-bagan1">
										<input type="checkbox" id="check-struktur-bagan1">
										<label for="check-struktur-bagan1">
											<a id="btn-view-struktur-bagan1">Penasehat <i class="fa fa-angle-down fa-angle-struktur-bagan1"></i></a>
										</label>
										<div class="box-struktur-bagan1">
											<p>Kepala Desa</p>
										</div>
									</div>

									<div class="content-struktur-bagan2">
										<input type="checkbox" id="check-struktur-bagan2">
										<label for="check-struktur-bagan2">
											<a id="btn-view-struktur-bagan2">Badan Pengawas <i class="fa fa-angle-down fa-angle-struktur-bagan2"></i></a>
										</label>
										<div class="box-struktur-bagan2">
											<p>Amin Daud, S.pd</p>
											<p>Hasan Pakaya</p>
											<p>Abdul Mulis Komendangi</p>
										</div>
									</div>

									<div class="content-struktur-bagan3">
										<input type="checkbox" id="check-struktur-bagan3">
										<label for="check-struktur-bagan3">
											<a id="btn-view-struktur-bagan3">Bendahara <i class="fa fa-angle-down fa-angle-struktur-bagan3"></i></a>
										</label>
										<div class="box-struktur-bagan3">
											<p>Hamzah Galapa</p>
										</div>
									</div>

									<div class="content-struktur-bagan4">
										<input type="checkbox" id="check-struktur-bagan4">
										<label for="check-struktur-bagan4">
											<a id="btn-view-struktur-bagan4">Ketua <i class="fa fa-angle-down fa-angle-struktur-bagan4"></i></a>
										</label>
										<div class="box-struktur-bagan4">
											<p>Arman Daud</p>
										</div>
									</div>

									<div class="content-struktur-bagan5">
										<input type="checkbox" id="check-struktur-bagan5">
										<label for="check-struktur-bagan5">
											<a id="btn-view-struktur-bagan5">Sekretaris <i class="fa fa-angle-down fa-angle-struktur-bagan5"></i></a>
										</label>
										<div class="box-struktur-bagan5">
											<p>Nurhayati Talib</p>
										</div>
									</div>

									<div class="content-struktur-bagan6">
										<input type="checkbox" id="check-struktur-bagan6">
										<label for="check-struktur-bagan6">
											<a id="btn-view-struktur-bagan6">KA Unit usaha Penyediaan LPG <i class="fa fa-angle-down fa-angle-struktur-bagan6"></i></a>
										</label>
										<div class="box-struktur-bagan6">
											<p>Felmiyanti Manti</p>
										</div>
									</div>

									<div class="content-struktur-bagan7">
										<input type="checkbox" id="check-struktur-bagan7">
										<label for="check-struktur-bagan7">
											<a id="btn-view-struktur-bagan7">KA Unit usaha Penyediaan Tenda <i class="fa fa-angle-down fa-angle-struktur-bagan7"></i></a>
										</label>
										<div class="box-struktur-bagan7">
											<p>Arifin Rohani</p>
										</div>
									</div>
								</div>

								<div class="img-bumdes">
									<a href="assets/images/struktur/bumdes-black.png" class="img-bumdes-black"><img src="assets/images/struktur/bumdes-black.png" alt=""></a>
									<a href="assets/images/struktur/bumdes-black.png" class="img-bumdes-white"><img src="assets/images/struktur/bumdes-white.png" alt=""></a>
								</div>
								<div class="clear-both"></div>

							</div>
						</div>
					</content>
				</section>

				<!-- struktur kantor desa -->
				<section id="struktur-kades">
					<content>
						<div class="struktur-kades">
							<div class="title-content">
								<h2>PROFIL</h2>
								<h1>Struktur Kantor Desa</h1>
								<p>Struktur Kantor Desa Helumo</p>
							</div>
							<div class="box-profile-kades">

								<div class="img-kades">
									<a href="assets/images/struktur/STRUKTUR-KANTOR-DESA.png" class="img-kades-black"><img src="assets/images/struktur/STRUKTUR-KANTOR-DESA.png" alt=""></a>
									<a href="assets/images/struktur/STRUKTUR-KANTOR-DESA.png" class="img-kades-white"><img src="assets/images/struktur/STRUKTUR-KANTOR-DESA-WHITE.png" alt=""></a>
								</div>

								<div class="struktur-bagan-kades">
									<div class="content-struktur-kades-bagan1">
										<input type="checkbox" id="check-struktur-kades-bagan1">
										<label for="check-struktur-kades-bagan1">
											<a id="btn-view-struktur-kades-bagan1">Kepala Desa <i class="fa fa-angle-down fa-angle-struktur-kades-bagan1"></i></a>
										</label>
										<div class="box-struktur-kades-bagan1">
											<p>Beyca S. Kude, S.IP</p>
										</div>
									</div>

									<div class="content-struktur-kades-bagan2">
										<input type="checkbox" id="check-struktur-kades-bagan2">
										<label for="check-struktur-kades-bagan2">
											<a id="btn-view-struktur-kades-bagan2">Sekretaris Desa <i class="fa fa-angle-down fa-angle-struktur-kades-bagan2"></i></a>
										</label>
										<div class="box-struktur-kades-bagan2">
											<p>Lian A. Abdul, SE</p>
											<h4>Sekretasi</h4>
											<p>Nurhayati Talib</p>
										</div>
									</div>

									<div class="content-struktur-kades-bagan3">
										<input type="checkbox" id="check-struktur-kades-bagan3">
										<label for="check-struktur-kades-bagan3">
											<a id="btn-view-struktur-kades-bagan3">Kasie Pemerintahan <i class="fa fa-angle-down fa-angle-struktur-kades-bagan3"></i></a>
										</label>
										<div class="box-struktur-kades-bagan3">
											<p>Hamzah Usman</p>
										</div>
									</div>

									<div class="content-struktur-kades-bagan4">
										<input type="checkbox" id="check-struktur-kades-bagan4">
										<label for="check-struktur-kades-bagan4">
											<a id="btn-view-struktur-kades-bagan4">Kasie Kesejahteraan & Pelayanan <i class="fa fa-angle-down fa-angle-struktur-kades-bagan4"></i></a>
										</label>
										<div class="box-struktur-kades-bagan4">
											<p>Sri Ivon karnain</p>
										</div>
									</div>

									<div class="content-struktur-kades-bagan5">
										<input type="checkbox" id="check-struktur-kades-bagan5">
										<label for="check-struktur-kades-bagan5">
											<a id="btn-view-struktur-kades-bagan5">Kepala Dusun I <i class="fa fa-angle-down fa-angle-struktur-kades-bagan5"></i></a>
										</label>
										<div class="box-struktur-kades-bagan5">
											<p>Pandry Rahman</p>
										</div>
									</div>

									<div class="content-struktur-kades-bagan6">
										<input type="checkbox" id="check-struktur-kades-bagan6">
										<label for="check-struktur-kades-bagan6">
											<a id="btn-view-struktur-kades-bagan6">Kepala Dusun II <i class="fa fa-angle-down fa-angle-struktur-kades-bagan6"></i></a>
										</label>
										<div class="box-struktur-kades-bagan6">
											<p>Fraswito Buyu</p>
										</div>
									</div>

									<div class="content-struktur-kades-bagan7">
										<input type="checkbox" id="check-struktur-kades-bagan7">
										<label for="check-struktur-kades-bagan7">
											<a id="btn-view-struktur-kades-bagan7">Kepala Dusun III <i class="fa fa-angle-down fa-angle-struktur-kades-bagan7"></i></a>
										</label>
										<div class="box-struktur-kades-bagan7">
											<p>Amalia Tangahu</p>
										</div>
									</div>


								</div>
								<div class="clear-both"></div>

							</div>
						</div>
					</content>
				</section>


				<!-- FAQ -->
				<section id="faq">
					<content>
						<div class="faq">
							<div class="title-content">
								<h2>PENTING UNTUK DIBACA!</h2>
								<h1>Pertanyaan yang Sering Diajukan</h1>
								<p>Sebelum kalian memutuskan untuk menggunakan layanan ini, ada baiknya informasi berikut ini dibaca terlebih dahulu untuk menghindari kebingungan dan adanya salah paham. </p>
							</div>
							<div class="box-faq">

								<div class="faq-bagan">
									<div class="content-faq-bagan1">
										<input type="checkbox" id="check-faq-bagan1">
										<label for="check-faq-bagan1">
											<a id="btn-view-faq-bagan1">Untuk Apa Web Ini Dibuat? <i class="fa fa-angle-down fa-angle-faq-bagan1"></i></a>
										</label>
										<div class="box-faq-bagan1">
											<p>Untuk mempermudah masyarakat mengetahui kondisi dan ketersediaan stok unit-unit usaha yang tersedia.</p>
										</div>
									</div>

									<div class="content-faq-bagan2">
										<input type="checkbox" id="check-faq-bagan2">
										<label for="check-faq-bagan2">
											<a id="btn-view-faq-bagan2">Apakah Pendaftaran Akun Baru Di Web Ini Gratis? <i class="fa fa-angle-down fa-angle-faq-bagan2"></i></a>
										</label>
										<div class="box-faq-bagan2">
											<p>Pendaftaran pengguna akun baru tidak dipunggut biaya sepeserpun Gratis!</p>
										</div>
									</div>

									<div class="content-faq-bagan3">
										<input type="checkbox" id="check-faq-bagan3">
										<label for="check-faq-bagan3">
											<a id="btn-view-faq-bagan3">Apa Keuntungan Menggunakan Aplikasi Berbasis Web Ini? <i class="fa fa-angle-down fa-angle-faq-bagan3"></i></a>
										</label>
										<div class="box-faq-bagan3">
											<p>Masyarakat bisa mengetahui secara pasti stok-stok unit usaha yang tersedia. Masyarakat juga bisa memesan unit-unit yang dibutuhkan hanya dengan menggunakan HP/Laptop</p>
										</div>
									</div>

									<div class="content-faq-bagan4">
										<input type="checkbox" id="check-faq-bagan4">
										<label for="check-faq-bagan4">
											<a id="btn-view-faq-bagan4">Bagaimana Cara Menggunakan Aplikasi Ini? <i class="fa fa-angle-down fa-angle-faq-bagan4"></i></a>
										</label>
										<div class="box-faq-bagan4">
											<p>Silahkan akses dan lihat cara penggunaan aplikasi baik itu pendaftaran pengguna/akun baru, ataupun pemesanan unit usaha di menu "Cara Penggunaan"</p>
										</div>
									</div>

								</div>

								<div class="img-faq">
									<img src="assets/images/undraw/download_undraw_Questions_re_1fy7.svg" alt="">
								</div>
								<div class="clear-both"></div>

							</div>
						</div>
					</content>
				</section>
				<!-- END FAQ -->


				<!-- TUTORIAL -->
				<section id="tutorial">
					<content>
						<div class="tutorial">
							<div class="title-content">
								<h2>Belum Tahu Menggunakan?</h2>
								<h1>Cara Menggunakan Aplikasi</h1>
								<p>Berikut adalah cara menggunakan aplikasi Bumdes. </p>
							</div>
							<div class="container-box-tutorial">

								<div class="box-tutorial">
									<div class="gambar-tutorial">
										<img src="assets/images/tutorial/1.jpg" alt="">
									</div>
									<div class="title-tutorial">
										<h2>Pilih Menu Daftar</h2>
									</div>
									<div class="paragraf-tutorial">
										<p>Pilih menu "Daftar/Masuk" di sudut kanan atas dan nantinya anda akan diarahkan ke halaman Masuk.</p>
									</div>
								</div>

								<div class="box-tutorial">
									<div class="gambar-tutorial">
										<img src="assets/images/tutorial/2.jpg" alt="">
									</div>
									<div class="title-tutorial">
										<h2>Registrasi Akun</h2>
									</div>
									<div class="paragraf-tutorial">
										<p>Silahkan Buat Akun Baru Jika Belum Ada</p>
									</div>
								</div>

								<div class="box-tutorial">
									<div class="gambar-tutorial">
										<img src="assets/images/tutorial/3.jpg" alt="">
									</div>
									<div class="title-tutorial">
										<h2>Masuk Akun</h2>
									</div>
									<div class="paragraf-tutorial">
										<p>Jika Akun Baru Berhasil Dibuat Silahkan Masuk Ke Akun Anda</p>
									</div>
								</div>

								<div class="box-tutorial">
									<div class="gambar-tutorial">
										<img src="assets/images/tutorial/1.jpg" alt="">
									</div>
									<div class="title-tutorial">
										<h2>Pemesanan</h2>
									</div>
									<div class="paragraf-tutorial">
										<p>Jika Berhasil Masuk ke Akun Anda, Silahkan Lakukan Pemesanan Unit Usaha</p>
									</div>
								</div>
								<div class="clear-both"></div>

							</div>
						</div>
					</content>
				</section>
				<!-- END TUTORIAL -->


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