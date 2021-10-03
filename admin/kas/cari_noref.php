<?php
	include "../../config/koneksi.php";
	include "../../config/library.php";
	

	$tipe = $_POST['tipe'];

	if ($tipe == 'Keluar'){
		$id_unit = $_POST['id_unit'];
		$unit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$id_unit' "));
		$inisial = 'JK'.$unit['singkatanUnit'].date('dmy');

		$query = mysqli_query($koneksi, "SELECT max(noRefrensi) as kodeTerbesar FROM kas WHERE idUnitSekolah='$id_unit' AND tanggal='$tanggal_sekarang' AND stdel='0' AND tipe='Kas Keluar'");
		$data = mysqli_fetch_array($query);
		$kode = $data['kodeTerbesar'];
		$urutan = (int) substr($kode, -4);
		$urutan++;
		$kodeREFF = $inisial . sprintf("%04s", $urutan);

		echo $kodeREFF;
	}elseif ($tipe == 'Masuk'){
		$id_unit = $_POST['id_unit'];
		$unit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$id_unit' "));
		$inisial = 'JM'.$unit['singkatanUnit'].date('dmy');

		$query = mysqli_query($koneksi, "SELECT max(noRefrensi) as kodeTerbesar FROM kas WHERE idUnitSekolah='$id_unit' AND tanggal='$tanggal_sekarang' AND stdel='0' AND tipe='Kas Masuk'");
		$data = mysqli_fetch_array($query);
		$kode = $data['kodeTerbesar'];
		$urutan = (int) substr($kode, -4);
		$urutan++;
		$kodeREFF = $inisial . sprintf("%04s", $urutan);

		echo $kodeREFF;
	}
	

?>
  