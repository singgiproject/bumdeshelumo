<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:../../logout");
	exit;
}
// connection to functions-admin
require('../../../funct/functions-admin.php');

// SESSION USER LOGIN
if( isset($_SESSION["login"]) ){
	$userSession = $_SESSION["username"];
	$resultSession = $conn->query("SELECT * FROM tb_admin WHERE username = '$userSession' ");
	$rowSession = mysqli_fetch_assoc($resultSession);
	$idSession = $rowSession["id"];
	$dataUsers = query("SELECT * FROM tb_admin WHERE id = '$idSession' ");

}

$id = base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["lpg"]))))));
$unitLpg = query("SELECT * FROM tb_lpg WHERE id = '$id' ")[0];


// URL SECURITY TAMBAHAN 
if( !isset($_GET["lpg"]) ){
	header("Location:../lpg");
	return false;
}
if( empty($_GET["lpg"]) ){
	header("Location:../lpg");
	return false;	
}
if( strlen($_GET["lpg"]) < 12 ){
	header("Location:../lpg");
	return false;	
}
if( !base64_decode(base64_decode(base64_decode(base64_decode(base64_decode(base64_decode($_GET["lpg"])))))) ){
	header("Location:../lpg");
	return false;	
}

if( isset($_POST["update_lpg"]) ){
	if( updateLpg($_POST) > 0 ){
		echo "
		<script>
			alert('Lpg Berhasil diubah!');
			document.location.href = '../lpg';
		</script>";
	} else{
		echo "
		<script>
			document.location.href = '../lpg';
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
	<title>Ubah Data <?= $unitLpg["nama_unit"]; ?></title>
	<link rel="stylesheet" href="../../../assets/css/admin.style.css">
	<link rel="stylesheet" href="../../../assets/css/singgi.all.min.css">
	<link rel="stylesheet" href="../../../assets/css/admin.responsive.css">
	<link rel="stylesheet" href="../../../assets/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="../../../assets/font-awesome/css/font-awesome.min.css">
	<link rel="icon" type="images/png" href="../../../assets/images/logo/Logo_Kabupaten_Bone_Bolango.png">
</head>
<body>

	<!-- TOP BAR -->
	<div class="top-bar">
		<div class="top-bar-avatar">
			<a href="../../index"><img src="../../../assets/images/logo/Logo_Kabupaten_Bone_Bolango.png" alt=""> Bumdes <sup>Helumo</sup></a>
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
				<span id="btn-view-profile"><span id="profile-name"><?= $rowSession["first_name"]; ?> <?= $rowSession["last_name"]; ?></span><img src="../../../assets/images/profile/avatar.png" alt="" class="fas fa-user user-nav"></span>
				<a id="close-profile"></a>
			</label>
			<div class="box-view-profile">
				<table>
					<tr>
						<td>
							<a href="../../account/profile"><i class="fa fa-user"></i> Profil</a>
						</td>
					</tr>
					<tr id="line-profile">
						<td>
							<a href="../../logout" class="logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out logout"></i> Keluar</a>
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
			<header><img src="../../../assets/images/profile/avatar.png" alt=""> <?= $rowSession["first_name"]; ?> <?= $rowSession["last_name"]; ?>  <span>Administrator</span></header>
			<ul>
				<li class="dashboard"><a href="../../"><i class="fa fa-tachometer"></i> Dashboard</a></li>
				
				<!-- check menu post -->
				<li>
					<input type="checkbox" id="check-post">
					<label for="check-post">
						<a id="btn-view-post" class="active"><i class="fa fa-thumbtack"></i> Input Barang <i class="fa fa-angle-right fa-angle-check"></i></a>
					</label>
					<div class="box-view-post">
						<ul>
							<li><span>PILIHAN INPUT:</span></li>
							<li><a href="../lpg">Tabung Gas LPG</a></li>
							<li><a href="../tenda">Tenda/Kanopi</a></li>
						</ul>
					</div>
				</li>

				<li>
					<a href="../../daftar-order"><i class="fa fa-shopping-cart"></i> Daftar Pesanan</a>
				</li>

				<li>
					<a href="../../laporan"><i class="fas fa-book-open"></i> Laporan</a>
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
							<li><a href="../../pages/sejarah-desa">Sejarah Desa</a></li>
						</ul>
					</div>
				</li>

				<!-- <li>
					<a href="messages/members"><i class="fa fa-envelope"></i> Pesan 
						<sup class="sup-contact">2</sup>
					</a>
				</li>
 -->				<li><a href="../../logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out"></i> Keluar</a></li>
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
					<li class="dashboard-responsive"><a href="../../"><i class="fa fa-tachometer"></i> Dashboard</a></li>
					
					<!-- check menu post -->
					<li>
						<input type="checkbox" id="check-post-responsive">
						<label for="check-post-responsive">
							<a id="btn-view-post-responsive" class="active"><i class="fa fa-thumbtack"></i> Input Barang <i class="fa fa-angle-right fa-angle-check-responsive"></i></a>
						</label>
						<div class="box-view-post-responsive">
							<ul>
								<li><span>PILIHAN INPUT:</span></li>
								<li><a href="../lpg">Tabung Gas LPG</a></li>
								<li><a href="../tenda">Tenda/Kanopi</a></li>
							</ul>
						</div>
					</li>

					<li>
						<a href="../../daftar-order"><i class="fa fa-shopping-cart"></i> Daftar Pesanan</a>
					</li>

					<li>
						<a href="../../laporan"><i class="fas fa-book-open"></i> Laporan</a>
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
								<li><a href="../../pages/sejarah-desa">Sejarah Desa</a></li>
							</ul>
						</div>
					</li>

					<!-- <li>
						<a href="messages/members"><i class="fa fa-envelope"></i> Pesan 
							<sup class="sup-contact-responsive">2</sup>
						</a>
					</li> -->
					<li><a href="../../logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out"></i> Keluar</a></li>
				</ul>
			</div>
		</div>


		
		<!-- container-content -->
		<div class="container-content">
			<div class="header">
				<h2>Ubah Data <?= $unitLpg["nama_unit"]; ?></h2>
			</div>

			<!-- content data members -->
			<div class="container-data-members">
				<div class="card-data-members">
					<div class="menu-data-members">
						<ul>
							<li><a href="../lpg"><i class="fa fa-angle-left"></i> Kembali</a></li>
						</ul>
					</div>
					<div class="table-form-members">
						<header>Form Ubah Data <?= $unitLpg["nama_unit"]; ?></header>

						<fieldset>
							<legend>Form <?= $unitLpg["nama_unit"]; ?></legend>
							<form action="" method="post" enctype="multipart/form-data">
								<input type="hidden" name="id" value="<?= $unitLpg["id"]; ?>">
								<input type="hidden" name="gambarLama" value="<?= $unitLpg["gambar_unit"]; ?>">
								<button type="submit" name="update_lpg" class="btn-green-gradient pd-10 btn-post-members" onclick="return confirm('Publikasi sekarang?');"><i class="fa fa-save"></i> Simpan</button>
								<table>
									<tr>
										<td>
											<label for="nama_unit">Nama Unit</label>
										</td>
										<td>
											<input type="text" name="nama_unit" id="nama_unit" placeholder="Nama Unit" required oninvalid="this.setCustomValidity('Nama unit harus diisi.')" oninput="setCustomValidity('')" value="<?= $unitLpg["nama_unit"]; ?>" maxlength="100">
										</td>
									</tr>

									<tr>
										<td>
											<label for="harga_unit">Harga</label>
										</td>
										<td>
											<input type="text" name="harga_unit" id="harga_unit" placeholder="Hara Unit" value="<?= $unitLpg["harga_unit"]; ?>">
										</td>
									</tr>

									<tr>
										<td>
											<label for="stok_unit">Stok</label>
										</td>
										<td>
											<input type="text" name="stok_unit" id="stok_unit" placeholder="Stok Unit" required oninvalid="this.setCustomValidity('Stok unit harus diisi.')" oninput="setCustomValidity('')" value="<?= $unitLpg["stok_unit"]; ?>">
										</td>
									</tr>

									<tr>
										<td></td>
										<td>
											<img src="../../../assets/images/lpg/<?= $unitLpg["gambar_unit"]; ?>" alt="" width="60">
										</td>
									</tr>

									<tr>
										<td>
											<label for="gambar_unit">Update Foto <i class="fa fa-image"></i></label>
										</td>
										<td>
											<input type="file" name="gambar_unit" id="gambar_unit" style="cursor: pointer;">
										</td>
									</tr>
									<tr>
										<td id="format-img">Maks 1MB, Format:jpg/png</td>
									</tr>

									<tr>
										<td>
											<label for="info_unit">Info</label>
										</td>
										<td>
											<textarea name="info_unit" id="info_unit" placeholder="Masukan Info Unit" required oninvalid="this.setCustomValidity('Masukan minimal 10 kata tanggapan anda!.')" oninput="setCustomValidity('')" maxlength="500" minlength="10"><?= $unitLpg["info_unit"]; ?></textarea>
										</td>
									</tr>

									<tr>
										<td></td>
										<td>
											<button type="submit" name="update_lpg" class="btn-green-gradient" onclick="return confirm('Publikasi sekarang?');"><i class="fa fa-save"></i> Simpan</button>
											<button type="reset" class="btn-danger"><i class="fa fa-refresh"></i> Data Asli</button>
											<a href="../lpg" class="btn-gray">Batalkan</a>
										</td>
									</tr>

								</table>
							</form>
						</fieldset>

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