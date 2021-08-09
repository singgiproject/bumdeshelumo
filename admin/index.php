<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:logout");
	exit;
}
// connection to functions-admin
require('../funct/functions-admin.php');
require('../funct/count-table.php');

// SESSION USER LOGIN
if( isset($_SESSION["login"]) ){
	$userSession = $_SESSION["username"];
	$resultSession = $conn->query("SELECT * FROM tb_admin WHERE username = '$userSession' ");
	$rowSession = mysqli_fetch_assoc($resultSession);
	$idSession = $rowSession["id"];
	$dataUsers = query("SELECT * FROM tb_admin WHERE id = '$idSession' ");

}

// count stock LPG
$resultLpg = $conn->query("SELECT stok_unit FROM tb_lpg");
$rowLpg = mysqli_fetch_assoc($resultLpg);

// count stock TENDA
$resultTenda = $conn->query("SELECT stok_unit FROM tb_tenda");
$rowTenda = mysqli_fetch_assoc($resultTenda);


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- META TAG -->
	<meta name="keywords" content="Desa Helumo, Desa Helumo Gorontalo, Bumdes, Badan Usaha Milik Desa, Badan Usaha Milik Desa Helumo" />
  <meta name="description" content="Aplikasi Badan Usaha Milik Desa (BUMDES)" />
	<!-- END META TAG -->

	<meta charset="UTF-8">
	<!-- META TAG RESPONSIVE -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- END META TAG RESPONSIVE -->

	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="pragma" content="no-cache" />
	<title>Admin - Dashboard</title>
	<link rel="stylesheet" href="../assets/css/admin.style.css">
	<link rel="stylesheet" href="../assets/css/singgi.all.min.css">
	<link rel="stylesheet" href="../assets/css/admin.responsive.css">
	<link rel="stylesheet" href="../assets/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css">
	<link rel="icon" type="images/png" href="../assets/images/logo/Logo_Kabupaten_Bone_Bolango.png">
</head>
<body>

	<!-- TOP BAR -->
	<div class="top-bar">
		<div class="top-bar-avatar">
			<a href="" title="Beranda - Dashboard"><img src="../assets/images/logo/Logo_Kabupaten_Bone_Bolango.png" alt=""> Bumdes <sup>Helumo</sup></a>
		</div>
		
		<!-- top bar searching -->
		<div class="top-bar-searching">
			<form action="" method="post">
				<table>
					<tr>
						<td>
							<input type="search" name="q" placeholder="Masukan pencarian untuk...">
						</td>
						<td>
							<button type="submit" name="search"><i class="fa fa-search"></i></button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	
		<!-- top bar profile -->
		<div class="top-bar-profile">
			<input type="checkbox" id="check-profile">
			<label for="check-profile">
				<span id="btn-view-profile"><span id="profile-name"><?= $rowSession["first_name"]; ?> <?= $rowSession["last_name"]; ?></span><img src="../assets/images/profile/avatar.png" alt="" class="fas fa-user user-nav"></span>
				<a id="close-profile"></a>
			</label>
			<div class="box-view-profile">
				<table>
					<tr>
						<td>
							<a href="account/profile"><i class="fa fa-user"></i> Profil</a>
						</td>
					</tr>
					<tr id="line-profile">
						<td>
							<a href="logout" class="logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out logout"></i> Keluar</a>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<!-- top bar messages -->
		<div class="top-bar-messages">
			<input type="checkbox" id="check-messages">
			<label for="check-messages">
				<span id="btn-view-messages">
					<i class="fa fa-envelope" id="notif-messages" title="2 Pesan diterima">
						<sup id="sup-messages">
							2
						</sup>
					</i>
				</span>
				<a id="close-messages"></a>
			</label>
			<div class="box-view-messages">
				<div class="message-center">
					<span>Pusat Pesan</span>
				</div>
				<table>
					
						<tr class="text-messages">
							<td>
								<a href="messages/members?q=<?= $row["first_name"]; ?>&search_messages=">
									<i class="fa fa-user avatar-messages" title="Singgi Mokodompit "></i>
									<div class="text-messages-truncate">
										<span title="Halo Singgi Mokodompit">Halo Singgi Mokodompit</span>
									</div>
									<span id="info-messages-user" title="Dikirim pada tanggal 12 Mei 2021 oleh Singgi Mokodompit">
										Singgi Mokodompit | 12 Mei 2021
									</span>
								</a>
							</td>
						</tr>
					
					<tr id="line-messages">
						<td>
							<a href="messages/members" class="more-messages">Lihat Pesan Lainnya</a>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="clear-both"></div>
	</div>

	<!-- CONTAINER -->
	<div class="container">
		
		<!-- sidebar -->
		<div class="container-sidebar">
			<header><img src="../assets/images/profile/avatar.png" alt=""> <?= $rowSession["first_name"]; ?> <?= $rowSession["last_name"]; ?>  <span>Administrator</span></header>
			<ul>
				<li class="dashboard"><a href="" class="active"><i class="fa fa-tachometer"></i> Dashboard</a></li>
				
				<!-- check menu post -->
				<li>
					<input type="checkbox" id="check-post">
					<label for="check-post">
						<a id="btn-view-post"><i class="fa fa-thumbtack"></i> Input Barang <i class="fa fa-angle-right fa-angle-check"></i></a>
					</label>
					<div class="box-view-post">
						<ul>
							<li><span>PILIHAN INPUT:</span></li>
							<li><a href="input/lpg">Tabung Gas LPG</a></li>
							<li><a href="input/tenda">Tenda/Kanopi</a></li>
						</ul>
					</div>
				</li>

				<li>
					<a href="daftar-order"><i class="fa fa-shopping-cart"></i> Daftar Pesanan</a>
				</li>

				<li>
					<a href="laporan"><i class="fas fa-book-open"></i> Laporan</a>
				</li>

				<!-- check menu pages -->
				<li>
					<input type="checkbox" id="check-pages">
					<label for="check-pages">
						<a id="btn-view-pages"><i class="fa fa-file-alt"></i> Halaman <i class="fa fa-angle-right fa-angle-check"></i></a>
					</label>
					<div class="box-view-pages">
						<ul>
							<li><span>PILIHAN HALAMAN:</span></li>
							<li><a href="pages/sejarah-desa">Sejarah Desa</a></li>
						</ul>
					</div>
				</li>

				<!-- <li>
					<a href="messages/members"><i class="fa fa-envelope"></i> Pesan 
						<sup class="sup-contact">2</sup>
					</a>
				</li>
 -->				<li><a href="logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out"></i> Keluar</a></li>
			</ul>
		</div>


		<!-- sidebar responsive -->
		<!-- check view close sidebar responsive -->
		<div class="check-container-sidebar-responsive">
			<input type="checkbox" id="check-container-sidebar-responsive">
			<label for="check-container-sidebar-responsive">
				<i class="fa fa-align-left" id="btn-view-container-sidebar-responsive"></i>
				<i class="fa fa-times" id="btn-close-container-sidebar-responsive"></i>
				<i id="black-close-container-sidebar-responsive"></i>
			</label>
			<div class="container-sidebar-responsive">
				<header><?= $rowSession["first_name"]; ?> <?= $rowSession["last_name"]; ?> <span>Administrator</span></header>
				<ul>
					<li class="dashboard-responsive"><a href="" class="active"><i class="fa fa-tachometer"></i> Dashboard</a></li>
					
					<!-- check menu post -->
					<li>
						<input type="checkbox" id="check-post-responsive">
						<label for="check-post-responsive">
							<a id="btn-view-post-responsive"><i class="fa fa-thumbtack"></i> Input Barang <i class="fa fa-angle-right fa-angle-check-responsive"></i></a>
						</label>
						<div class="box-view-post-responsive">
							<ul>
								<li><span>PILIHAN INPUT:</span></li>
								<li><a href="input/lpg">Tabung Gas LPG</a></li>
								<li><a href="input/tenda">Tenda/Kanopi</a></li>
							</ul>
						</div>
					</li>

					<li>
						<a href="daftar-order"><i class="fa fa-shopping-cart"></i> Daftar Pesanan</a>
					</li>

					<li>
						<a href="laporan"><i class="fas fa-book-open"></i> Laporan</a>
					</li>

					<!-- check menu pages -->
					<li>
						<input type="checkbox" id="check-pages-responsive">
						<label for="check-pages-responsive">
							<a id="btn-view-pages-responsive"><i class="fa fa-file-alt"></i> Halaman <i class="fa fa-angle-right fa-angle-check-responsive"></i></a>
						</label>
						<div class="box-view-pages-responsive">
							<ul>
								<li><span>PILIHAN HALAMAN:</span></li>
								<li><a href="pages/sejarah-desa">Sejarah Desa</a></li>
							</ul>
						</div>
					</li>

					<!-- <li>
						<a href="messages/members"><i class="fa fa-envelope"></i> Pesan 
							<sup class="sup-contact-responsive">2</sup>
						</a>
					</li> -->
					<li><a href="logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out"></i> Keluar</a></li>
				</ul>
			</div>
		</div>



		
		<!-- container-content -->
		<div class="container-content">
			<div class="header">
				<h2>Dashboard</h2>
			</div>
			<!-- content 1 -->
			<div class="container-content1">

				<div class="container-box-content1">
					<div class="box-content1 br-green">
						<div class="card-box-content1">
							<div class="title-box-content1">
								<h5 class="color-green">User</h5>
							</div>
							
								<div class="value-box-content1">
									<h3><?php echo "{$resultDataMembers["jmlhDataMembers"]}"; ?></h3>
								</div>
							
							<div class="col-auto">
								<i class="fa fa-users"></i>
							</div>
						</div>
						<div class="clear-both"></div>
					</div>

					<div class="box-content1 br-primary">
						<div class="card-box-content1">
							<div class="title-box-content1">
								<h5 class="color-primary">Pesanan</h5>
							</div>
								<div class="value-box-content1">
									<h3><?php echo "{$resultDataOrder["jmlhDataOrder"]}"; ?></h3>
								</div>
							<div class="col-auto">
								<i class="fa fa-shopping-cart"></i>
							</div>
						</div>
						<div class="clear-both"></div>
					</div>
				</div>

				<div class="container-box-content1">
					<div class="box-content1 br-cyan">
						<div class="card-box-content1">
							<div class="title-box-content1">
								<h5 class="color-cyan">Stok LPG</h5>
							</div>
							
								<div class="value-box-content1">
									<h3><?= $rowLpg["stok_unit"]; ?></h3>
								</div>
							
							<div class="col-auto">
								<i class="fas fa-boxes"></i>
							</div>
						</div>
						<div class="clear-both"></div>
					</div>

					<div class="box-content1 br-warning">
						<div class="card-box-content1">
							<div class="title-box-content1">
								<h5 class="color-warning">Stok Tenda</h5>
							</div>
							
								<div class="value-box-content1">
									<h3><?= $rowTenda["stok_unit"]; ?></h3>
								</div>
							
							<div class="col-auto">
								<i class="fas fa-campground"></i>
							</div>
						</div>
						<div class="clear-both"></div>
					</div>
				</div>

			</div>

			<!-- content 2 -->
			<div class="container-content2">

				<div class="container-box-content2">
					<div class="box-content2">
						
							<div class="title-box-content2">
								<h3>Tentang Kami</h3>
							</div>
						
						<div class="card-box-content2">
							<div class="img-box-content2">
								<img src="../assets/images/undraw/download_undraw_Development_re_g5hq.svg" alt="" class="fa fa-image img-box-content2-about">
							</div>
							
								<div class="descript-box-content2">
									<p>Budan Usaha Milik Desa Helumo atau yang sering disingkat BUMDES HELUMO adalah website yang dibuat untuk memudahkan masyarakat yang ada di desa Helumo maupun luar desa mendapatkan unit-unit usaha seperti Tabung Lpg dan Tenda/Kanopi. Website ini dibuat pada tanggal 25 April 2021 dan diluncurkan pada tanggal 18 Mei 2021.</p>
								</div>
							
						</div>
					</div>

					<div class="box-content2">
						
							<div class="title-box-content2">
								<h3>Info Lainnya</h3>
							</div>
						
						<div class="card-box-content2">
							<div class="img-box-content2">
								<img src="../assets/images/undraw/download_undraw_My_current_location_re_whmt.svg" alt="" class="fa fa-image">
							</div>
							
								<div class="descript-box-content2">
									<li><i class="fa fa-home" id="fa-home-info"></i>  Desa Helumo, Gorontalo</li>
									<li><i class="fa fa-mobile" id="fa-mobile-info"></i> 082346455079 (Administrator)</li>
									<li><i class="fa fa-envelope" id="fa-envelope-info"></i>  helumo.gorontalo@gmail.com</li>
									<li><i class="fa fa-globe" id="fa-globe"></i>  http://www.bumdeshelumo.online</li>
								</div>
							
						</div>
					</div>
				</div>

			</div>



			<!-- footer -->
			<div class="footer">
				<footer>&copy; 2021 Bumdes Helumo | All right reserved.</footer>
			</div>

		</div>


	</div>

	
</body>
</html>