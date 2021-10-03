<?php
	include "../config/koneksi.php";
	include "../config/library.php";
	
	$id_unit = $_POST['id_unit'];
	$unit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$id_unit' "));
	$inisial = 'JK'.$unit['singkatanUnit'].date('dmy');

	$query = mysqli_query($koneksi, "SELECT max(noRefrensi) as kodeTerbesar FROM kas WHERE idUnitSekolah='$id_unit' AND tanggal='$tanggal_sekarang' AND stdel='0'");
	$data = mysqli_fetch_array($query);
	$kode = $data['kodeTerbesar'];
	$urutan = (int) substr($kode, -4);
	$urutan++;
	$kodeREFF = $inisial . sprintf("%04s", $urutan);

	echo $kodeREFF;

?>
  