<?php
	function hitungMasaKerja($tgl_masuk,$tgl_keluar){
		$tgl_masuk = new DateTime($tgl_masuk); 
		$tgl_keluar = new DateTime($tgl_keluar);
		$perbedaan = $tgl_masuk->diff($sekarang);

		return $perbedaan->y.' Tahun '.$perbedaan->m.' Bulan '.$perbedaan->d.' Hari';		 
	}	
?>