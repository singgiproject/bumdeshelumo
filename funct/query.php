<?php 
// === QUERY TABLE LPG ===
// query table lpg
$unitLpg = $conn->query("SELECT * FROM tb_lpg");

// === QUERY TABLE TENDA ===
// query table tenda
$unitTenda = $conn->query("SELECT * FROM tb_tenda");

// query table order
$unitOrder = $conn->query("SELECT * FROM tb_order");

// query table laporan
$unitLaporan = $conn->query("SELECT * FROM tb_laporan");

// query table deskripsi_desa
$unitDeskripsiDesa = $conn->query("SELECT * FROM tb_deskripsi_desa");






 ?>