<!DOCTYPE html>
<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
include 'config/variabel_url.php';
session_start();
if (isset($_SESSION['idUsers'])) {
	header('location:index.php?view=dashboard');
}
$idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
?>
<html>

<head>
	<title>Login | <?= $idt['singkatanAplikasi'] ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="shortcut icon" href="<?= $lokasi_penyimpanan_logo . $idt['logo_kiri'] ?>">
	<link rel="stylesheet" href="css/menu.css" />
	<link rel="stylesheet" href="css/main.css" />
	<link rel="stylesheet" href="css/bgimg.css" />
	<link rel="stylesheet" href="css/font.css" />
	<link rel="stylesheet" href="css/font-awesome.min.css" />
	<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<link rel="stylesheet" href="plugins/toastr/toastr.min.css">
	<script src="plugins/toastr/toastr.min.js"></script>
	<script type="text/javascript">
		toastr.options = {
			"closeButton": true,
			"debug": false,
			"newestOnTop": false,
			"progressBar": true,
			"positionClass": "toast-top-right",
			"preventDuplicates": false,
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "7000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}
	</script>
</head>

<body>
	<?php
	if ($_SESSION['notif'] == 'gagalLogin') {
		echo '<script>toastr["error"]("Email dan Password salah.","Gagal!")</script>';
	}
	unset($_SESSION['notif']);
	?>
	<div class="background"></div>
	<div class="backdrop"></div>
	<div class="login-form-container" id="login-form"><br><br>
		<div class="login-form-content">
			<div class="login-form-header">
				<div class="logo">
					<img src="gambar/logo/<?= $idt['logo_kiri'] ?>" width="64px" />
				</div>
				<h3>Login Admin</h3>
			</div>
			<form method="post" action="cek_login.php" class="login-form">
				<div class="input-container">
					<i class="fa fa-envelope"></i>
					<input type="text" class="input" name="username" placeholder="Email" />
				</div>
				<div class="input-container">
					<i class="fa fa-lock"></i>
					<input type="password" id="login-password" class="input" name="password" placeholder="Password" />
					<i id="show-password" class="fa fa-eye"></i>
				</div>
				<br>
				<input type="submit" name="login" value="Login" class="button" />
			</form>
		</div>

		<div class="separator"></div>
		<div class="socmed-login">
			<a href="#facebook" class="socmed-btn facebook-btn">
				<i class="fa fa-facebook"></i>
				<span>Login dengan Facebook</span>
			</a>
			<a href="#g-plus" class="socmed-btn google-btn">
				<i class="fa fa-google"></i>
				<span>Login dengan Google</span>
			</a>
			<a href="#g-plus" class="socmed-btn yahoo-btn">
				<i class="fa fa-yahoo"></i>
				<span>Login dengan Yahoo</span>
			</a>
		</div>
	</div>
</body>

</html>