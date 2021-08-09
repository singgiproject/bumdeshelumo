<?php 
// proses hitung jumlah data dalam tabel members
$jmlhDataMembers = $conn->query("SELECT COUNT(*) jmlhDataMembers FROM tb_users ");
$resultDataMembers = mysqli_fetch_assoc($jmlhDataMembers);

// proses hitung jumlah data dalam tabel pesanan
$jmlhDataOrder = $conn->query("SELECT COUNT(*) jmlhDataOrder FROM tb_order ");
$resultDataOrder = mysqli_fetch_assoc($jmlhDataOrder);

 ?>