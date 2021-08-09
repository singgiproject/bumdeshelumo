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


// === QUERT DATA TABLE TENDA ===
$tableTenda = $conn->query("SELECT * FROM tb_tenda");
$rowTableTenda = mysqli_fetch_assoc($tableTenda);

// === QUERT DATA TABLE ORDER ===
$tableOrder = $conn->query("SELECT * FROM tb_order");
$rowTableOrder = mysqli_fetch_assoc($tableOrder);

// get data table order from URL
$id = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["order"]))))));
$unitOrder = query("SELECT * FROM tb_order WHERE id = '$id' ")[0];

// set & check Stok Unit otomatic
$stok1 = $rowTableTenda["stok_unit"];
$stok2 = $unitOrder["jumlah_unit"];
$updateStok = $stok1 + $stok2;


// URL SECURITY TAMBAHAN 
if( !isset($_GET["order"]) ){
	header("Location:daftar-order");
	return false;
}
if( empty($_GET["order"]) ){
	header("Location:daftar-order");
	return false;	
}
if( strlen($_GET["order"]) < 12 ){
	header("Location:daftar-order");
	return false;	
}
if( !base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["order"])))))) ){
	header("Location:daftar-order");
	return false;	
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

// verifikasi
if( isset($_POST["verifikasi"]) ){
	if( verifikasiUnprocessedOrder($_POST) > 0 ){
		echo "
		<script>
			alert('Berhasil');
			document.location.href = '';
		</script>";
	} else{
		echo "
		<script>
			alert('Gagal');
			document.location.href = '';
		</script>";
	}
}



// verifikasi-returned
if( isset($_POST["verifikasi"]) ){
	if( verifikasiUpdateStokTenda($_POST) > 0 ){
		echo "
		<script>
			alert('Berhasil');
			document.location.href = '';
		</script>";
	} else{
		echo "
		<script>
			alert('Gagal');
			document.location.href = '';
		</script>";
	}
}

// notification
if( isset($_POST["submit-notifications"]) ){
	if( notifications($_POST) > 0 ){
		echo "
		<script>
			alert('Berhasil');
			document.location.href = '';
		</script>";
	} else{
		echo "
		<script>
			alert('Berhasil');
			document.location.href = '';
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
	<title>Daftar Pesanan - <?= $unitOrder["nama"]; ?></title>
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
				<h2>Data Pesanan - <?= $unitOrder["nama"]; ?></h2>
			</div>

			<!-- content data order -->
			<div class="container-data-order">
				<div class="card-data-order">

					<div class="menu-data-members">
						<ul>
							<li><a href="daftar-order"><i class="fa fa-angle-left"></i> Kembali</a></li>
						</ul>
					</div>

					<div class="table-data-order">
						<header>Data Pesanan - <?= $unitOrder["nama"]; ?></header>

						<table>
							<tr>
								<td id="label-order">
									<label for="">Nama</label>
								</td>
								<td><?= $unitOrder["nama"]; ?></td>
							</tr>

							<tr>
								<td id="label-order">
									<label for="">Nomor Telepon</label>
								</td>
								<td><?= $unitOrder["no_telp"]; ?></td>
							</tr>

							<tr>
								<td id="label-order">
									<label for="">Alamat</label>
								</td>
								<td><?= $unitOrder["alamat"]; ?></td>
							</tr>

							<tr>
								<td id="label-order">
									<label for="">Jenis</label>
								</td>
								<td><?= $unitOrder["jenis"]; ?></td>
							</tr>

							<tr>
								<td id="label-order">
									<label for="">Jumlah</label>
								</td>
								<td><?= $unitOrder["jumlah_unit"]; ?> Unit</td>
							</tr>

							<tr>
								<td id="label-order">
									<label for="">Tanggal Pakai</label>
								</td>
								<td><?= $unitOrder["tgl_pakai"]; ?></td>
							</tr>

							<tr>
								<td id="label-order">
									<label for="">Jangka Waktu</label>
								</td>
								<td><?= $unitOrder["jangka_waktu"]; ?> Hari</td>
							</tr>

							<tr>
								<td id="label-order">
									<label for="">Total</label>
								</td>
								<td>Rp. <?= number_format($unitOrder["total"], 0, ',', '.'); ?></td>
							</tr>

							<tr>
								<td id="label-order">
									<label for="">Status</label>
								</td>
								<td>
										<?php if( $unitOrder["status"] == 0 ) : ?>
											<span class="color-gray"><strong>Belum Diproses</strong></span>
										<?php endif; ?>

										<?php if( $unitOrder["status"] == 1 ) : ?>
											<span class="color-warning"><strong>Sedang Diproses</strong></span>
										<?php endif; ?>

										<?php if( $unitOrder["status"] == 2 ) : ?>
											<span class="color-green"><strong>Selesai Diproses</strong></span>
										<?php endif; ?>

										<?php if( $unitOrder["status"] == 3 ) : ?>
											<span class="color-red"><strong>Telah Dikembalikan</strong></span>
										<?php endif; ?>
								</td>
							</tr>


							<tr>
								<td id="label-order">
									<label for="">Verifikasi</label>
								</td>
								<td>
									<div class="form-verifikasi">
										<form action="" method="post">
											<input type="hidden" name="id_user" value="<?= $rowTableOrder["id_user"]; ?>">
											<input type="hidden" name="id" value="<?= $unitOrder["id"]; ?>">
											<input type="hidden" name="status" value="0">
											<input type="hidden" name="subject" id="subject" placeholder="Subject" required oninvalid="this.setCustomValidity('Subject Harus Diisi!')" oninput="setCustomValidity('')" value="Pesananmu Tidak Dapat Diproses">
											<textarea hidden name="notifications" id="notifications" placeholder="Masukan Notifikasi" required oninvalid="this.setCustomValidity('Notifikasi Harus Diisi!')" oninput="setCustomValidity('')">Halo <?= $unitOrder["nama"]; ?>, Pesananmu tidak dapat kami proses karena terdapat data-data yang tidak valid. Silahkan periksa data-data anda dan lakukan kembali pemesanan.</textarea>
											<input type="hidden" name="date" value="<?= $date; ?>">
											<button type="submit" name="verifikasi" id="belum-diproses" class="btn-gray">Tidak Bisa Diproses</button>
										</form>

										<form action="" method="post">
											<input type="hidden" name="id_user" value="<?= $rowTableOrder["id_user"]; ?>">
											<input type="hidden" name="id" value="<?= $unitOrder["id"]; ?>">
											<input type="hidden" name="status" value="1">
											<input type="hidden" name="subject" id="subject" placeholder="Subject" required oninvalid="this.setCustomValidity('Subject Harus Diisi!')" oninput="setCustomValidity('')" value="Pesananmu Sedang Diproses">
											<textarea hidden name="notifications" id="notifications" placeholder="Masukan Notifikasi" required oninvalid="this.setCustomValidity('Notifikasi Harus Diisi!')" oninput="setCustomValidity('')">Halo <?= $unitOrder["nama"]; ?>, Pesananmu sedang diproses yaa Silahkan cek secara berkala pesananmu.</textarea>
											<input type="hidden" name="date" value="<?= $date; ?>">
											<button type="submit" name="verifikasi" id="belum-diproses" class="btn-warning">Sedang Diproses</button>
										</form>

										<form action="" method="post">
											<input type="hidden" name="id_user" value="<?= $rowTableOrder["id_user"]; ?>">
											<input type="hidden" name="id" value="<?= $unitOrder["id"]; ?>">
											<input type="hidden" name="status" value="2">
											<input type="hidden" name="subject" id="subject" placeholder="Subject" required oninvalid="this.setCustomValidity('Subject Harus Diisi!')" oninput="setCustomValidity('')" value="Pesananmu Selesai Diproses">
											<textarea hidden name="notifications" id="notifications" placeholder="Masukan Notifikasi" required oninvalid="this.setCustomValidity('Notifikasi Harus Diisi!')" oninput="setCustomValidity('')">Yeay! <?= $unitOrder["nama"]; ?>, Pesananmu selesai diproses. Terimakasih.</textarea>
											<input type="hidden" name="date" value="<?= $date; ?>">
											<button type="submit" name="verifikasi" id="belum-diproses" class="btn-green">Selesai Diproses</button>
										</form>

										<form action="" method="post">
											<input type="hidden" name="id_tenda" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($rowTableTenda["id_tenda"]))))))))); ?>">
											<input type="hidden" name="stok_unit" value="<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($updateStok))))))))); ?>">
											<input type="hidden" name="id_user" value="<?= $rowTableOrder["id_user"]; ?>">
											<input type="hidden" name="id" value="<?= $unitOrder["id"]; ?>">
											<input type="hidden" name="status" value="3">
											<input type="hidden" name="subject" id="subject" placeholder="Subject" required oninvalid="this.setCustomValidity('Subject Harus Diisi!')" oninput="setCustomValidity('')" value="Pesananmu Telah Dikembalikan">
											<textarea hidden name="notifications" id="notifications" placeholder="Masukan Notifikasi" required oninvalid="this.setCustomValidity('Notifikasi Harus Diisi!')" oninput="setCustomValidity('')">Yeay! <?= $unitOrder["nama"]; ?>, Terimakasih sudah menggunakan layanan kami ya.. Semoga anda senang dengan layanan ini. Anda bisa memesan lagi unit usaha dan dengan senang hati kami akan melayani anda dengan baik.</textarea>
											<input type="hidden" name="date" value="<?= $date; ?>">
											<button type="submit" name="verifikasi" id="belum-diproses" class="btn-danger">Telah Dikembalikan</button>
										</form>

										<div class="clear-both"></div>
									</div>
								</td>
							</tr>

							<tr>
								<td id="label-order">
									<label for="">Kirim Notifikasi</label>
								</td>

								<!-- check status belum diproses (FORM) -->
									<td>
										<div class="form-notifikasi">
											<form action="" method="post">
												<input type="hidden" name="id_user" value="<?= $unitOrder["id_user"]; ?>">
												<input type="text" name="subject" id="subject" placeholder="Subject" required oninvalid="this.setCustomValidity('Subject Harus Diisi!')" oninput="setCustomValidity('')">
												<textarea name="notifications" id="notifications" placeholder="Masukan Notifikasi" required oninvalid="this.setCustomValidity('Notifikasi Harus Diisi!')" oninput="setCustomValidity('')"></textarea>
												<input type="hidden" name="date" value="<?= $date; ?>">
												<button type="submit" name="submit-notifications" id="belum-diproses" class="btn-green">Kirim</button>
											</form>
										</div>
									</td>
								<!-- end check status belum diproses (FORM)  -->

								
								<!-- end check status telah dikembalikan (FORM)  -->


							</tr>

							<tr>
								<td id="label-order">
									<label for="">Tanggal Transaksi</label>
								</td>
								<td><?= $unitOrder["tgl_transaksi"]; ?> <?= $unitOrder["bln_transaksi"]; ?> <?= $unitOrder["thn_transaksi"]; ?></td>
							</tr>

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