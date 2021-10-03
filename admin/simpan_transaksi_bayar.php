<?php

	include "../config/koneksi.php";
	include '../config/user_agent.php';
	include '../config/variabel_url.php';

	$id_akun_kas 		= $_POST['Cakunkas'];
	$kas_noref	 		= $_POST['kas_noref'];
	$nis_siswa	 		= $_POST['nis_siswa'];
	$id_tahun_ajaran	= $_POST['period'];

	$siswa = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM siswa WHERE nisSiswa='$nis_siswa'"));

	mysqli_query($koneksi,"INSERT INTO transaksi_pembayaran(noRefrensi,idAkunKas,idSiswa,idTahunAjaran) VALUES('$kas_noref','$id_akun_kas','$siswa[idSiswa]','$id_tahun_ajaran')");
	mysqli_query($koneksi,"UPDATE tagihan_bulanan SET statusKas='1' WHERE noRefrensi='$kas_noref'");
	mysqli_query($koneksi,"UPDATE tagihan_bebas_bayar SET statusKas='1' WHERE noRefrensi='$kas_noref'");

	$info = 'NIS:'.$nis_siswa.';Title:Simpan No. Ref: '.$kas_noref;
    mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Pembayaran','Simpan Pembayaran','$info','$idUsers','$browser_ok','$user_os','$ip')");
    
    $_SESSION['notif'] = 'sukses_transaksi';
    
?>