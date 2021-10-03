<?php
	include "../config/koneksi.php";
	include "../config/library.php";
	
	$noref = $_POST['noref'];
	$idUsers = $_POST['users'];

	$data = array();
	$query = mysqli_query($koneksi,"SELECT kas_transaksi.idTransaksiKas, kas_transaksi.tanggal, kas_transaksi.noRefrensi, kas_transaksi.keterangan,kas_transaksi.nominal, concat(akun_biaya.kodeAkun,' - ',akun_biaya.keterangan,' ',unit_sekolah.singkatanUnit) as akunBiaya,  pajak.besaranPajak, unit_pos.nmUnitpos FROM kas_transaksi 
		LEFT JOIN akun_biaya ON kas_transaksi.idAkunBiaya = akun_biaya.idAkun 
		LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah=unit_sekolah.idUnit
		LEFT JOIN pajak ON kas_transaksi.idPajak=pajak.idPajak
		LEFT JOIN unit_pos ON kas_transaksi.idUnitPos=unit_pos.idUnitPos 
		WHERE kas_transaksi.idUsers='$idUsers' AND kas_transaksi.noRefrensi='$noref'");
	while ($r = mysqli_fetch_assoc($query)) {
		$data[] = $r;
	}

	echo json_encode($data);
?>
  