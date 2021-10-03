<?php

	date_default_timezone_set('Asia/Jakarta');
	$server = "localhost";
	$username = "root";
	$password = "";
	$database = "spplte";
	//$database = "spp_dummy";
	$koneksi = mysqli_connect($server,$username,$password,$database);
	 
	if (mysqli_connect_errno()){
		echo "Koneksi database gagal : " . mysqli_connect_error();
	}
