<?php
   	include "config/koneksi.php";
   	include 'config/variabel_url.php';
   

   	$idt = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM identitas"));
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Portal | <?= $idt['singkatanAplikasi'] ?></title>
	<link rel="shortcut icon" href="<?= $lokasi_penyimpanan_logo.$idt['logo_kiri']?>">
	<link rel="stylesheet" href="./assets/font-awesome-4.6.3/css/font-awesome.min.css">
	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/load-font-googleapis.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Custom CSS -->
	<link href="css/frontend-style.css" rel="stylesheet">
	<link href="css/portal.css" rel="stylesheet">
	<font face="Source Sans Pro">
</head>

<body>

	
	<section class="content-section">
		<div class="container text-center">
			<div class="row">
				<div class="col-md-12">
					<h2><i class="fa fa-graduation-cap"></i> Selamat Datang</h2>
					<p class="lead mb-5 colr"><?= $idt['nmAplikasi']?></p>
				</div>
				<div class="col-md-4">
					<a href="login.php">
					<div class="box">
						<i class="fa fa-desktop icon-menu"></i>
						<br>
						Login Admin
					</div>
				</a>
				</div>
				<div class="col-md-4">
					<a href="home.php">
					<div class="box">
						<i class="fa fa-credit-card icon-menu"></i>
						<br>
						Cek Pembayaran Siswa
					</div>
				</a>
				</div>
				<div class="col-md-4">
					<a href="login-siswa.php">
					<div class="box">
						<i class="fa fa-users icon-menu"></i>
						<br>
						Login Siswa
					</div>
				</a>
				</div>
			</div>
		</div>
	</section>


</body>

</html>
