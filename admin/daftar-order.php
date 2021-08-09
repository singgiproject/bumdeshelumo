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

$unitOrder = query("SELECT * FROM tb_order");


// searching
if( isset($_GET["search-order"]) ){
	$unitOrder = searchOrder($_GET["q"]);
}
// check query searching
if( isset($_GET["search-order"]) ){
	if( empty($_GET["q"]) ){
		header("Location:daftar-order");
		exit;
	}
}

if( isset($_POST["cut-order"]) ){
	if( cutOrder($_POST) > 0 ){
		echo "
		<script>
			alert('Pesanan berhasil dihapus');
			document.location.href = '';
		</script>";
	} else{
		echo "
		<script>
			alert('Pesana gagal dihapus');
			document.location.href = '';
		</script>";
	}
}

// add-stock
if( isset($_POST["add-stock"]) ){
	if( addStockTenda($_POST) > 0 ){
		echo "
		<script>
			document.location.href = 'tenda';
		</script>";
	} else{
		echo "
		<script>
			document.location.href = 'tenda';
		</script>";
	}
}



// Set date
date_default_timezone_set('Asia/Makassar');
$date = date("d M Y");


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
	<title>Daftar Pesanan</title>
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
					<a href="daftar-order" class="active"><i class="fa fa-shopping-cart"></i> Daftar Pesanan</a>
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
					<li class="dashboard-responsive"><a href="index"><i class="fa fa-tachometer"></i> Dashboard</a></li>
					
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
						<a href="daftar-order" class="active"><i class="fa fa-shopping-cart"></i> Daftar Pesanan</a>
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
				<h2>Daftar Pesanan</h2>
			</div>

			<!-- content data members -->
			<div class="container-data-members">
				<div class="card-data-members">

					<div class="table-data-members">
						<header>Daftar Pesanan</header>

						<form action="" method="get">
							<table>
								<tr>
									<td id="row-form-search"><input type="search" name="q" placeholder="Cari pesanan..." maxlength="50"></td>
									<td id="row-form-search"><button type="submit" name="search-order"><i class="fa fa-search"></i></button></td>
								</tr>
							</table>
						</form>

						<!-- notifikasi pencarian -->
						<div class="notif-search">
							<?php if( isset($_GET["search-order"]) ) : ?>
								<p>
									Hasil pencarian keyword : <strong><?= htmlspecialchars($_GET["q"]); ?></strong>
									<?php if( empty($unitOrder) ) : ?>
										tidak ditemukan
									<?php endif; ?>
								</p>
							<?php endif; ?>
						</div>

						<table>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Nomor Telepon</th>
								<th>Alamat</th>
								<th>Jenis</th>
								<th>Jumlah</th>
								<th>Tanggal Pakai</th>
								<th>Jangka Waktu</th>
								<th>Total</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>

							<tr>
								<?php if( empty($unitOrder) ) : ?>
									<td colspan="11" class="pd-20">Tidak ada data dalam tabel</td>
								<?php endif; ?>
							</tr>

							<?php $id_no = 1; ?>
								<?php foreach( $unitOrder as $row ) : ?>
								<tr>
									<td><?= $id_no; ?></td>
									<td><?= $row["nama"]; ?></td>
									<td><?= $row["no_telp"]; ?></td>
									<td><?= $row["alamat"]; ?></td>
									<td><?= $row["jenis"]; ?></td>
									<td><?= $row["jumlah_unit"]; ?> Unit</td>
									<td><?= $row["tgl_pakai"]; ?></td>
									<td><?= $row["jangka_waktu"]; ?> Hari</td>
									<td>Rp. <?= number_format($row["total"], 0, ',', '.'); ?></td>
									<td>
										<?php if( $row["status"] == 0 ) : ?>
											<span class="color-gray"><strong>Belum Diproses</strong></span>
										<?php endif; ?>

										<?php if( $row["status"] == 1 ) : ?>
											<span class="color-warning"><strong>Sedang Diproses</strong></span>
										<?php endif; ?>

										<?php if( $row["status"] == 2 ) : ?>
											<span class="color-green"><strong>Selesai Diproses</strong></span>
										<?php endif; ?>

										<?php if( $row["status"] == 3 ) : ?>
											<span class="color-red"><strong>Telah Dikembalikan</strong></span>
										<?php endif; ?>
									</td>
									<td>
										<table>
											<tr>
												<td>
													<td>
														<a href="order?order=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($row["id"])))))); ?>" class="btn-green-gradient" title="Lihat"><i class="fa fa-eye"></i></a>
													</td>
													<td>
														<a href="delete-order?delete-order=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($row["id"])))))); ?>" class="btn-danger" title="Hapus" onclick="return confirm('Hapus?');"><i class="fa fa-trash"></i></a>
													</td>
												</td>

											</tr>
										</table>
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