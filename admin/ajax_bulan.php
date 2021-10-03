<?php
	
	include "../config/koneksi.php";

	$bulan = array();
	$idTahun = $_GET['idTahun'];
	$qthn = mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahun'");
	if ($qthn) {
		while ($thn = mysqli_fetch_array($qthn)){
			$nmTahun=$thn['nmTahunAjaran'];
			$pecah = explode("/", $nmTahun);
		 	$thn_ganjil = $pecah[0];
			$thn_genap = $pecah[1];
		}
	}

	$query = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
	
	if ($query) {
		while ($bln = mysqli_fetch_array($query)){
			$data = array(
				'id' => $bln['urutan'],
				'name' => $bln['nmBulan'],
				'thn_ganjil' => $thn_ganjil,
				'thn_genap' => $thn_genap,
			);
			array_push($bulan, $data);
		}
	}
	else {
		$bulan = array('error' => 'cannot find bulan with id '.$idTahun);
	}
	 
	echo json_encode($bulan);
?>