<?php
	session_start();
	error_reporting(0);
	include "../../config/koneksi.php";
	include "../../config/library.php";
	include "../../config/variabel_default.php";
	include '../../config/user_agent.php';
	
	$tipe = $_POST['tipe'];
	

	if ($tipe == 'tampil_data'){
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
	}elseif ($tipe == 'simpan_data'){

		$idUsers = $_POST['idUsers'];
		$tanggal = $_POST['tanggal'];
		$noref = $_POST['kas_noref'];
		$id_akun_biaya = $_POST['id_akun_biaya'];
		$keterangan = $_POST['keterangan'];
		$nominal = $_POST['nominal'];
		$id_pajak = $_POST['id_pajak'];
		$id_unit_pos = $_POST['id_unit_pos'];

		mysqli_query($koneksi,"INSERT INTO kas_transaksi(idUsers,tanggal,noRefrensi,idAkunBiaya,keterangan,nominal,idPajak,idUnitPos) VALUES ('$idUsers','$tanggal','$noref','$id_akun_biaya','$keterangan','$nominal','$id_pajak','$id_unit_pos')");

		$pajak = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM pajak WHERE idPajak='$id_pajak'"));
		$biaya_pajak = ($nominal*($pajak['besaranPajak']/100));
		$total = $nominal + $biaya_pajak;

		$info = 'No. Ref:'.$noref.';Title: Input '.$keterangan.' - nominal '.$total;
        mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Kas Keluar','Input Transaksi','$info','$idUsers','$browser_ok','$user_os','$ip')");

	}elseif ($tipe == 'hapus_data'){

		$idTransaksiKas = $_POST['id'];
		$trx_kas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kas_transaksi WHERE idTransaksiKas='$idTransaksiKas'"));
		$pajak = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM pajak WHERE idPajak='$trx_kas[idPajak]'"));
		$biaya_pajak = ($nominal*($pajak['besaranPajak']/100));
		$total = $nominal + $biaya_pajak;

		$info = 'No. Ref:'.$trx_kas['noRefrensi'].';Title: Hapus '.$trx_kas['keterangan'].' - nominal '.$total;
        mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Kas Keluar','Hapus Transaksi','$info','$idUsers','$browser_ok','$user_os','$ip')");

		mysqli_query($koneksi,"DELETE FROM kas_transaksi WHERE idTransaksiKas='$idTransaksiKas'");

	}elseif ($tipe == 'batal'){
		$noref = $_POST['kas_noref'];

		$info = 'No. Ref:'.$noref;
        mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Kas Keluar','Pembatalan Transaksi','$info','$idUsers','$browser_ok','$user_os','$ip')");

		mysqli_query($koneksi,"DELETE FROM kas_transaksi WHERE noRefrensi='$noref'");
	}elseif ($tipe == 'simpan_transaksi'){
		$idUsers = $_POST['idUsers'];
		$id_unit = $_POST['id_unit'];
		$noref = $_POST['noref'];
		$tanggal_kas = $_POST['tanggal_kas'];
		$id_akun_kas = $_POST['id_akun_kas'];
		$id_tahun_ajaran = $_POST['id_tahun_ajaran'];
		$keterangan_kas = $_POST['keterangan_kas'];
		$total_kas = $_POST['total_kas'];
		$cek_data = mysqli_query($koneksi,"SELECT kas_transaksi.*, pajak.besaranPajak FROM kas_transaksi LEFT JOIN pajak ON kas_transaksi.idPajak=pajak.idPajak WHERE kas_transaksi.noRefrensi='$noref'");
		while ($r = mysqli_fetch_array($cek_data)){
			$biaya_pajak = ($r['nominal']*($r['besaranPajak']/100));
			$total = $r['nominal'] + $biaya_pajak;
			$query = mysqli_query($koneksi,"INSERT INTO kas(jenis,tipe,tanggal,idUnitSekolah,noRefrensi,idAkunKas,idKodeAkun,idTahunAjaran, keterangan,keterangan_kas,nominal,idPajak,idUnitPos,total,stdel,cby,cdate) VALUES ('Keluar','Kas Keluar','$tanggal_kas','$id_unit','$noref','$id_akun_kas','$r[idAkunBiaya]','$id_tahun_ajaran','$r[keterangan]','$keterangan_kas','$r[nominal]','$r[idPajak]','$r[idUnitPos]','$total','0','$idUsers','$tanggal_sekarang')");
			mysqli_query($koneksi,"DELETE FROM kas_transaksi WHERE noRefrensi='$noref'");

			$info = 'No. Ref:'.$noref;
        	mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Kas Keluar','Simpan Transaksi','$info','$idUsers','$browser_ok','$user_os','$ip')");

			$ambil_id=mysqli_fetch_array(mysqli_query($koneksi,"SELECT idKas FROM kas WHERE noRefrensi='$noref' ORDER BY idKas DESC LIMIT 1"));
       		$title = 'Input '.$r['keterangan'];
       		mysqli_query($koneksi,"INSERT INTO log_kasir(tanggal,jenisBayar,idBayar,modul,aksi,noRefrensi,nis_nip,title,nominal,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Kas','$ambil_id[idKas]','Kas Keluar','Simpan Transaksi','$noref',null,'$title','$r[nominal]','$idUsers','$browser_ok','$user_os','$ip')");

		}
		if ($query){
			$_SESSION['notif'] = 'csukses';
		}else{
			$_SESSION['notif'] = 'gagal';
		}

	}
	
?>

