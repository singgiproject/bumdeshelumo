<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:../logout");
	exit;
}
// connection to functions-admin
require('../../funct/functions-admin.php');
require('../../funct/query.php');

// SESSION USER LOGIN
if( isset($_SESSION["login"]) ){
	$userSession = $_SESSION["username"];
	$resultSession = $conn->query("SELECT * FROM tb_admin WHERE username = '$userSession' ");
	$rowSession = mysqli_fetch_assoc($resultSession);
	$idSession = $rowSession["id"];
	$dataUsers = query("SELECT * FROM tb_admin WHERE id = '$idSession' ");

}

// add-stock
if( isset($_POST["add-stock"]) ){
	if( addStock($_POST) > 0 ){
		echo "
		<script>
			document.location.href = 'lpg';
		</script>";
	} else{
		echo "
		<script>
			document.location.href = 'lpg';
		</script>";
	}
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
	<!-- META TAG RESPONSIVE -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- END META TAG RESPONSIVE -->

	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="pragma" content="no-cache" />
	<title>Input - <?php foreach( $unitLpg as $row ) : ?> <?= $row["nama_unit"]; ?> <?php endforeach; ?></title>
	<link rel="stylesheet" href="../../assets/css/admin.style.css">
	<link rel="stylesheet" href="../../assets/css/singgi.all.min.css">
	<link rel="stylesheet" href="../../assets/css/admin.responsive.css">
	<link rel="stylesheet" href="../../assets/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="../../assets/font-awesome/css/font-awesome.min.css">
	<link rel="icon" type="images/png" href="../../assets/images/logo/Logo_Kabupaten_Bone_Bolango.png">
</head>
<body>

	<!-- TOP BAR -->
	<div class="top-bar">
		<div class="top-bar-avatar">
			<a href="../"><img src="../../assets/images/logo/Logo_Kabupaten_Bone_Bolango.png" alt=""> Bumdes <sup>Helumo</sup></a>
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
				<span id="btn-view-profile"><span id="profile-name"><?= $rowSession["first_name"]; ?> <?= $rowSession["last_name"]; ?></span><img src="../../assets/images/profile/avatar.png" alt="" class="fas fa-user user-nav"></span>
				<a id="close-profile"></a>
			</label>
			<div class="box-view-profile">
				<table>
					<tr>
						<td>
							<a href="../account/profile"><i class="fa fa-user"></i> Profil</a>
						</td>
					</tr>
					<tr id="line-profile">
						<td>
							<a href="../logout" class="logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out logout"></i> Keluar</a>
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
				<li class="dashboard"><a href="../"><i class="fa fa-tachometer"></i> Dashboard</a></li>
				
				<!-- check menu post -->
				<li>
					<input type="checkbox" id="check-post">
					<label for="check-post">
						<a id="btn-view-post" class="active"><i class="fa fa-thumbtack"></i> Input Barang <i class="fa fa-angle-right fa-angle-check"></i></a>
					</label>
					<div class="box-view-post">
						<ul>
							<li><span>PILIHAN INPUT:</span></li>
							<li><a href="lpg">Tabung Gas LPG</a></li>
							<li><a href="tenda">Tenda/Kanopi</a></li>
						</ul>
					</div>
				</li>

				<li>
					<a href="../daftar-order"><i class="fa fa-shopping-cart"></i> Daftar Pesanan</a>
				</li>

				<li>
					<a href="../laporan"><i class="fas fa-book-open"></i> Laporan</a>
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
							<li><a href="../pages/sejarah-desa">Sejarah Desa</a></li>
						</ul>
					</div>
				</li>

				<!-- <li>
					<a href="messages/members"><i class="fa fa-envelope"></i> Pesan 
						<sup class="sup-contact">2</sup>
					</a>
				</li>
 -->				<li><a href="../logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out"></i> Keluar</a></li>
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
							<a id="btn-view-post-responsive" class="active"><i class="fa fa-thumbtack"></i> Input Barang <i class="fa fa-angle-right fa-angle-check-responsive"></i></a>
						</label>
						<div class="box-view-post-responsive">
							<ul>
								<li><span>PILIHAN INPUT:</span></li>
								<li><a href="lpg">Tabung Gas LPG</a></li>
								<li><a href="tenda">Tenda/Kanopi</a></li>
							</ul>
						</div>
					</li>

					<li>
						<a href="../daftar-order"><i class="fa fa-shopping-cart"></i> Daftar Pesanan</a>
					</li>

					<li>
						<a href="../laporan"><i class="fas fa-book-open"></i> Laporan</a>
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
								<li><a href="../pages/sejarah-desa">Sejarah Desa</a></li>
							</ul>
						</div>
					</li>

					<!-- <li>
						<a href="messages/members"><i class="fa fa-envelope"></i> Pesan 
							<sup class="sup-contact-responsive">2</sup>
						</a>
					</li> -->
					<li><a href="../logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out"></i> Keluar</a></li>
				</ul>
			</div>
		</div>

		
		<!-- container-content -->
		<div class="container-content">
			<div class="header">
				<?php foreach( $unitLpg as $row ) : ?>
					<h2>Input <?= $row["nama_unit"]; ?></h2>
				<?php endforeach; ?>
			</div>

			<!-- content data members -->
			<div class="container-data-members">
				<div class="card-data-members">

					<!-- tambah stok lpg -->
					<div class="menu-data-members">
						<ul>							
							<form action="" method="post">
								<?php foreach( $unitLpg as $row ) : ?>
									<input type="hidden" name="id" value="<?= $row["id"]; ?>">

									<button type="submit" name="add-stock" class="btn-green-gradient">Tambah</button>
									<select name="stok_unit" id="stok_unit">
										<?php for( $stok = 1; $stok < 50+1; $stok++ ) : ?>
												<option value="<?= $stok + $row["stok_unit"]; ?>">
												<?= $stok; ?>
												</option>
										<?php endfor; ?>
									</select>

								<?php endforeach; ?>
							</form>
						</ul>
					</div>

					<!-- kurangi stok lpg -->
					<div class="menu-data-members">
						<ul>							
							<form action="" method="post">
								<?php foreach( $unitLpg as $row ) : ?>
									<input type="hidden" name="id" value="<?= $row["id"]; ?>">

									<button type="submit" name="add-stock" class="btn-green-gradient">Kurangi</button>
									<select name="stok_unit" id="stok_unit">
										<?php for( $stok = 1; $stok < 50+1; $stok++ ) : ?>
												<option value="<?= $row["stok_unit"] - $stok; ?>">
												<?= $stok; ?>
												</option>
										<?php endfor; ?>
									</select>

								<?php endforeach; ?>
							</form>
						</ul>
					</div>

					<div class="table-data-members">
						<header>Data <?= $row["nama_unit"]; ?></header>

						<table>
							<tr>
								<th>No</th>
								<th>Gambar</th>
								<th>Nama Unit</th>
								<th>Harga</th>
								<th>Stok</th>
								<th>Info</th>
								<th>Aksi</th>
							</tr>

							<tr>
								<!-- <?php if( empty($tbMembersAll) ) : ?>
									<td colspan="5" class="pd-20">Tidak ada data dalam tabel</td>
								<?php endif; ?> -->
							</tr>

							<?php $id_no = 1; ?>
								<?php foreach( $unitLpg as $row ) : ?>
								<tr>
									<td><?= $id_no; ?></td>
									<td>
										<a href="../../assets/images/lpg/<?= $row["gambar_unit"] ?>">
											<img src="../../assets/images/lpg/<?= $row["gambar_unit"] ?>" alt="LPG">
										</a>
									</td>
									<td><?= $row["nama_unit"]; ?></td>
									<td>Rp. <?= number_format($row["harga_unit"], 0, ',', '.'); ?></td>
									<td><?= $row["stok_unit"]; ?></td>
									<td><?= $row["info_unit"]; ?></td>
									<td>
										<table>
											<tr>
												<td>
													<a href="update/lpg?lpg=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($row["id"])))))); ?>" class="btn-warning" title="Ubah"><i class="fa fa-edit"></i></a>
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