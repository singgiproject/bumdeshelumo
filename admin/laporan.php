<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:logout");
	exit;
}
// connection to functions-admin
require('../funct/functions-admin.php');
require('../funct/query.php');

// SESSION USER LOGIN
if( isset($_SESSION["login"]) ){
	$userSession = $_SESSION["username"];
	$resultSession = $conn->query("SELECT * FROM tb_admin WHERE username = '$userSession' ");
	$rowSession = mysqli_fetch_assoc($resultSession);
	$idSession = $rowSession["id"];
	$dataUsers = query("SELECT * FROM tb_admin WHERE id = '$idSession' ");

}

$unitLaporan = query("SELECT * FROM tb_laporan");


// searching field tgl_transaksi
if( isset($_GET["search-laporan"]) ){
	$unitLaporan = searchLaporanTgl($_GET["tgl"]);
}

// searching field bln_transaksi
if( isset($_GET["search-laporan"]) ){
	$unitLaporan = searchLaporanBln($_GET["bln"]);
}

// searching field thn_transaksi
if( isset($_GET["search-laporan"]) ){
	$unitLaporan = searchLaporanThn($_GET["thn"]);
}

// check URL Empty
if( isset($_GET["search-laporan"]) ){
	if( empty($_GET["tgl"]) ){
		header("Location:laporan");
		exit;
	}
}

if( isset($_GET["search-laporan"]) ){
	if( empty($_GET["bln"]) ){
		header("Location:laporan");
		exit;
	}
}

if( isset($_GET["search-laporan"]) ){
	if( empty($_GET["thn"]) ){
		header("Location:laporan");
		exit;
	}
}




// Set date
date_default_timezone_set('Asia/Makassar');
$date = date("d M Y");
$thnSekarang = date("Y");


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
	<title>Laporan</title>
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
			<a href="index"><img src="../assets/images/logo/Logo_Kabupaten_Bone_Bolango.png" alt=""> Bumdes <sup>Helumo</sup></a>
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
				<li class="dashboard"><a href="index"><i class="fa fa-tachometer"></i> Dashboard</a></li>
				
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
					<a href="laporan" class="active"><i class="fas fa-book-open"></i> Laporan</a>
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
					<li class="dashboard-responsive"><a href="../"><i class="fa fa-tachometer"></i> Dashboard</a></li>
					
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
						<a href="laporan" class="active"><i class="fas fa-book-open"></i> Laporan</a>
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
				<h2>Laporan</h2>
			</div>

			<!-- content data members -->
			<div class="container-data-members">
				<div class="card-data-members">

					<div class="table-data-members table-data-laporan">
						<header>Laporan</header>

						<form action="" method="get">
							<table>
								<tr>
									<td id="row-form-search">
										<select name="thn" id="q">
											<option value=" ">---Tahun---</option>
											<?php for( $thn = 2015; $thn < $thnSekarang+1; $thn++ ) : ?>
												<option value="<?= $thn; ?>"><?= $thn; ?></option>
											<?php endfor; ?>
										</select>
										<select name="bln" id="q">
											<option value=" ">---Bulan---</option>
											<option value="january">Januari</option>
											<option value="february">Februari</option>
											<option value="march">Maret</option>
											<option value="april">April</option>
											<option value="may">Mei</option>
											<option value="june">Juni</option>
											<option value="july">Juli</option>
											<option value="august">Agustus</option>
											<option value="september">September</option>
											<option value="october">Oktober</option>
											<option value="november">November</option>
											<option value="december">Desember</option>
										</select>
										<select name="tgl" id="q">
											<option value=" ">---Tanggal---</option>
											<?php for( $tgl = 1; $tgl < 31+1; $tgl++ ) : ?>
												<option value="<?= $tgl; ?>"><?= $tgl; ?></option>
											<?php endfor; ?>
										</select>
									</td>
									<td id="row-form-search"><button type="submit" name="search-laporan"><i class="fa fa-search"></i></button></td>
								</tr>
							</table>
						</form>

						<!-- notifikasi pencarian -->
						<div class="notif-search">
							<?php if( isset($_GET["search-laporan"]) ) : ?>
								<p>
									Hasil pencarian keyword : 
									<strong>
										<?= htmlspecialchars($_GET["tgl"]); ?> 

										<?php if( htmlspecialchars($_GET["bln"]) == "january" ) : ?>
											Januari
										<?php endif; ?>

										<?php if( htmlspecialchars($_GET["bln"]) == "february" ) : ?>
											Februari
										<?php endif; ?>

										<?php if( htmlspecialchars($_GET["bln"]) == "march" ) : ?>
											Maret
										<?php endif; ?>

										<?php if( htmlspecialchars($_GET["bln"]) == "april" ) : ?>
											April
										<?php endif; ?>

										<?php if( htmlspecialchars($_GET["bln"]) == "may" ) : ?>
											Mei
										<?php endif; ?>

										<?php if( htmlspecialchars($_GET["bln"]) == "june" ) : ?>
											Juni
										<?php endif; ?>

										<?php if( htmlspecialchars($_GET["bln"]) == "july" ) : ?>
											Juli
										<?php endif; ?>

										<?php if( htmlspecialchars($_GET["bln"]) == "august" ) : ?>
											Agustus
										<?php endif; ?>

										<?php if( htmlspecialchars($_GET["bln"]) == "september" ) : ?>
											September
										<?php endif; ?>

										<?php if( htmlspecialchars($_GET["bln"]) == "october" ) : ?>
											Oktober
										<?php endif; ?>

										<?php if( htmlspecialchars($_GET["bln"]) == "november" ) : ?>
											November
										<?php endif; ?>

										<?php if( htmlspecialchars($_GET["bln"]) == "december" ) : ?>
											Desember
										<?php endif; ?>
										
										<?= htmlspecialchars($_GET["thn"]); ?>
									</strong>

									<?php if( empty($unitLaporan) ) : ?>
										tidak ditemukan
									<?php endif; ?>
								</p>
							<?php endif; ?>
						</div>

						<table>
							<tr>
								<th>No</th>
								<th>Nama Barang</th>
								<th>Jumlah</th>
								<th>Total</th>
								<th>Tanggal Transaksi</th>
							</tr>

							<tr>
								<?php if( empty($unitLaporan) ) : ?>
									<td colspan="11" class="pd-20">Tidak ada data dalam tabel</td>
								<?php endif; ?>
							</tr>

							<?php $id_no = 1; ?>
								<?php foreach( $unitLaporan as $row ) : ?>
								<tr>
									<td><?= $id_no; ?></td>
									<td><?= $row["jenis"]; ?></td>
									<td><?= $row["jumlah_unit"]; ?> Unit</td>
									<td>Rp. <?= number_format($row["total"], 0, ',', '.'); ?></td>
									<td>
										<?= $row["tgl_transaksi"]; ?> 

										<!-- check translate(English Month) to (Indonesian Month) --> 
										<?php if( $row["bln_transaksi"] == "January" ) : ?>
											Januari
										<?php endif; ?>

										<?php if( $row["bln_transaksi"] == "February" ) : ?>
											Februari
										<?php endif; ?>

										<?php if( $row["bln_transaksi"] == "March" ) : ?>
											Maret
										<?php endif; ?>

										<?php if( $row["bln_transaksi"] == "April" ) : ?>
											April
										<?php endif; ?>

										<?php if( $row["bln_transaksi"] == "May" ) : ?>
											Mei
										<?php endif; ?>

										<?php if( $row["bln_transaksi"] == "Jun" ) : ?>
											Juni
										<?php endif; ?>

										<?php if( $row["bln_transaksi"] == "July" ) : ?>
											Juli
										<?php endif; ?>

										<?php if( $row["bln_transaksi"] == "August" ) : ?>
											Agustus
										<?php endif; ?>

										<?php if( $row["bln_transaksi"] == "September" ) : ?>
											September
										<?php endif; ?>

										<?php if( $row["bln_transaksi"] == "October" ) : ?>
											Oktober
										<?php endif; ?>

										<?php if( $row["bln_transaksi"] == "November" ) : ?>
											November
										<?php endif; ?>

										<?php if( $row["bln_transaksi"] == "December" ) : ?>
											Desember
										<?php endif; ?>
										<!-- end check translate(English Month) to (Indonesian Month) --> 
										
										<?= $row["thn_transaksi"]; ?>
									</td>
								</tr>
								<?php $id_no++; ?>
							<?php endforeach; ?>
						</table>
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