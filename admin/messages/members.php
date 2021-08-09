<?php 
session_start();
if( !isset($_SESSION["login"]) ){
	header("Location:../../auth/login");
	exit;
}
// connect file functions
include("../../funct/functions.php");
include("../../funct/funct_main.php");
include("../../funct/funct_hitung.php");
include("../../funct/funct_sessionUserLogin.php");

// cek search messages
if( isset($_GET["search_messages"]) ){
	$tbMessagesAll = search_table_messages($_GET["q"]);
}

// SECURITY TAMBAHAN - SEARCHING/URL
if( isset($_GET["search_messages"]) ){
	if( empty($_GET["q"]) ){
		header("Location:members");
		exit;
	}
}
if( isset($_GET["search_messages"]) ){
	if( strlen($_GET["q"]) > 50 ){
		header("Location:members");
		exit;
	}
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- META TAG -->
	<?php foreach( $tbMeta as $row ) : ?>
	<meta name="keywords" content="<?= $row["keywords"]; ?>"/>
	<meta name="description" content="<?= $row["description"]; ?>"/>
	<?php endforeach; ?>
	<!-- END META TAG -->

	<meta charset="UTF-8">
	<!-- META TAG RESPONSIVE -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- END META TAG RESPONSIVE -->

	<meta http-equiv="cache-control" content="max-age=0" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="expires" content="0" />
	<meta http-equiv="pragma" content="no-cache" />
	<title>Pesan</title>
	<link rel="stylesheet" href="../../assets/css/admin.style.css">
	<link rel="stylesheet" href="../../assets/css/singgi.all.min.css">
	<link rel="stylesheet" href="../../assets/css/admin.responsive.css">
	<link rel="stylesheet" href="../../assets/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="../../assets/font-awesome/css/font-awesome.min.css">
	<link rel="icon" type="img/png" href="../../assets/img/icon.png">
</head>
<body>

	<!-- TOP BAR -->
	<div class="top-bar">
		<div class="top-bar-avatar">
			<a href="../index"><img src="../../assets/img/icon.png" alt=""></a>
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
				<span id="btn-view-profile"><span id="profile-name"><?= $rowSession["first_name"]; ?> <?= $rowSession["last_name"]; ?></span> <img src="../../assets/img/profile/singgi.jpg" alt="" class="fas fa-user user-nav"></span>
				<a id="close-profile"></a>
			</label>
			<div class="box-view-profile">
				<table>
					<tr>
						<td>
							<a href=""><i class="fa fa-user"></i> Profile</a>
						</td>
					</tr>
					<tr>
						<td>
							<a href=""><i class="fa fa-cogs"></i> Pengaturan</a>
						</td>
					</tr>
					<tr id="line-profile">
						<td>
							<a href="../../auth/logout" class="logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out logout"></i> Keluar</a>
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
					<i class="fa fa-envelope" id="notif-messages" title="<?php echo "{$resultDataMessages["jmlhDataMessages"]}"; ?> Pesan diterima">
						<sup id="sup-messages">
							<?php echo "{$resultDataMessages["jmlhDataMessages"]}"; ?>
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
					<?php foreach( $tbMessagesLimit as $row ) : ?>
						<tr class="text-messages">
							<td>
								<a href="../messages/members?q=<?= $row["first_name"]; ?>&search_messages=">
									<i class="fa fa-user avatar-messages" title="<?= $row["first_name"]; ?> <?= $row["last_name"]; ?>"></i>
									<div class="text-messages-truncate">
										<span title="<?= $row["isi_pesan"]; ?>"><?= $row["isi_pesan"]; ?></span>
									</div>
									<span id="info-messages-user" title="Dikirim pada tanggal <?= $row["waktu"]; ?> oleh <?= $row["first_name"];  ?> <?= $row["last_name"]; ?>">
										<?= $row["first_name"]; ?> <?= $row["last_name"]; ?> | <?= $row["waktu"]; ?>
									</span>
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
					<tr id="line-messages">
						<td>
							<a href="../messages/members" class="more-messages">Lihat Pesan Lainnya</a>
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
			<header><?= $rowSession["first_name"]; ?> <?= $rowSession["last_name"]; ?> <span>Administrator</span></header>
			<ul>
				<li class="dashboard"><a href="../index"><i class="fa fa-tachometer"></i> Dashboard</a></li>
				
				<!-- check menu post -->
				<li>
					<input type="checkbox" id="check-post">
					<label for="check-post">
						<a id="btn-view-post"><i class="fa fa-thumbtack"></i> Pos <i class="fa fa-angle-right fa-angle-check"></i></a>
					</label>
					<div class="box-view-post">
						<ul>
							<li><span>PILIHAN POS:</span></li>
							<li><a href="../post/members">Anggota</a></li>
							<li><a href="../post/gallery">Galeri</a></li>
						</ul>
					</div>
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
							<li><a href="../pages/myTeam">Tim Saya</a></li>
							<li><a href="../pages/about">Tentang</a></li>
							<li><a href="../pages/infoContact">Info Kontak</a></li>
							<li><a href="../pages/otherInfo">Info Lainnya</a></li>
							<li><a href="../pages/copyright">Copyright</a></li>
						</ul>
					</div>
				</li>

				<li>
					<a href="" class="active"><i class="fa fa-envelope"></i> Pesan 
						<sup class="sup-contact"><?php echo "{$resultDataMessages["jmlhDataMessages"]}"; ?></sup>
					</a>
				</li>

				<li><a href="../../auth/logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out"></i> Keluar</a></li>
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
					<li class="dashboard-responsive"><a href="../index"><i class="fa fa-tachometer"></i> Dashboard</a></li>
					
					<!-- check menu post -->
					<li>
						<input type="checkbox" id="check-post-responsive">
						<label for="check-post-responsive">
							<a id="btn-view-post-responsive"><i class="fa fa-thumbtack"></i> Pos <i class="fa fa-angle-right fa-angle-check-responsive"></i></a>
						</label>
						<div class="box-view-post-responsive">
							<ul>
								<li><span>PILIHAN POS:</span></li>
								<li><a href="../post/members">Anggota</a></li>
								<li><a href="../post/gallery">Galeri</a></li>
							</ul>
						</div>
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
								<li><a href="../pages/myTeam">Tim Saya</a></li>
								<li><a href="../pages/about">Tentang</a></li>
								<li><a href="../pages/infoContact">Info Kontak</a></li>
								<li><a href="../pages/otherInfo">Info Lainnya</a></li>
								<li><a href="../pages/copyright">Copyright</a></li>
							</ul>
						</div>
					</li>

					<li>
						<a href="" class="active"><i class="fa fa-envelope"></i> Pesan 
							<sup class="sup-contact-responsive"><?php echo "{$resultDataMessages["jmlhDataMessages"]}"; ?></sup>
						</a>
					</li>
					<li><a href="../../auth/logout" onclick="return confirm('Pilih Oke jika anda siap untuk mengakhiri sesi anda saat ini.');"><i class="fa fa-sign-out"></i> Keluar</a></li>
				</ul>
			</div>
		</div>
		
		<!-- container-content -->
		<div class="container-content">
			<div class="header">
				<h2>Pesan</h2>
			</div>

			<!-- content data messages -->
			<div class="container-data-messages">
				<div class="card-data-messages">
					<div class="table-data-messages">
						<header>Pesan</header>
						<form action="" method="get">
							<table>
								<tr>
									<td id="row-form-search"><input type="search" name="q" placeholder="Cari pesan..."></td>
									<td id="row-form-search">
										<button type="submit" name="search_messages"><i class="fa fa-search"></i>
										</button>
									</td>
									<td><a href="" title="Refresh"><i class="fa fa-refresh fa-refresh-messages"></i></a></td>
								</tr>
							</table>
						</form>
						
						<!-- notifikasi pencarian -->
						<div class="notif-search">
							<?php if( isset($_GET["search_messages"]) ) : ?>
								<p>
									Hasil pencarian keyword : <strong><?= htmlspecialchars($_GET["q"]); ?></strong>
									<?php if( empty($tbMessagesAll) ) : ?>
										tidak ditemukan
									<?php endif; ?>
								</p>
							<?php endif; ?>
						</div>

						<table>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Email</th>
								<th>Whatsapp</th>
								<th>Pesan</th>
								<th>Terkirim</th>
								<th>Aksi</th>
							</tr>

							<tr>
								<?php if( empty($tbMessagesAll) ) : ?>
									<td colspan="7" class="pd-20">Tidak ada data dalam tabel</td>
								<?php endif; ?>
							</tr>
							
							<?php $id_no = 1; ?>
							<?php foreach( $tbMessagesAll as $row ) : ?>
								<tr>
									<td><?= $id_no; ?></td>
									<td><?= $row["first_name"]; ?> <?= $row["last_name"]; ?></td>
									<td><?= $row["email"]; ?></td>
									<td>
										<a href="https://api.whatsapp.com/send?phone=62<?= $row["whatsapp"]; ?>&text=Assalamu'alaikum apa benar ini dengan kak <?= $row["first_name"]; ?> <?= $row["last_name"]; ?>? Saya Singgi Mokodompit Admin Vtuber Sulawesi Utara apakah ada yang bisa saya bantu mengenai bisnis Vtube?" class="whatsapp-messages" target="blank"><?= $row["whatsapp"]; ?></a>
									</td>
									<td><?= $row["isi_pesan"]; ?></td>
									<td>
										<?= $row["waktu"]; ?>
									</td>
									<td>
										<table>
											<tr>
												<td><a href="delete?members=<?= base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode(base64_encode($row["id"]))))))))); ?>" class="btn-danger" title="Hapus Pesan" onclick="return confirm('Hapus Pesan?');"><i class="fa fa-trash"></i></a></td>
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
				<?php foreach( $tbCopyright as $row ) : ?>
					<footer>&copy; 2020 Built with <i class="fa fa-heart"></i> by : <?= $row["copyright"]; ?></footer>
				<?php endforeach; ?>
			</div>

		</div>


	</div>

	
</body>
</html>