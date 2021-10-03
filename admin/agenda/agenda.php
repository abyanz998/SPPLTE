<?php
session_start();
// Koneksi
include '../../config/koneksi.php';

$tipe = $_POST['tipe'];
if ($tipe == 'tambah'){
	
	if (isset($_POST['keterangan']) && isset($_POST['tgl_mulai']) && isset($_POST['tgl_selesai']) && isset($_POST['warna'])){

		$title = $_POST['keterangan'];
		$start = $_POST['tgl_mulai'];
		$end = $_POST['tgl_selesai'];
		$color = $_POST['warna'];
		$idUsers = $_GET['id'];
		$tgl = date('Y-m-d H:i:s');

		$query = mysqli_query($koneksi,"INSERT INTO  agenda(nama, tgl_mulai, tgl_selesai, warna, stdel, cby, cdate) VALUES ('$title', '$start', '$end', '$color', '0', '$idUsers', '$tgl')");
		if($query){
			$_SESSION['notif'] = 'csukses';
		}else{
			$_SESSION['notif'] = 'gagal';
		}
	}

}elseif ($tipe=='edit'){
	if (isset($_POST['hapus']) && isset($_POST['id'])){
		
		$id = $_POST['id'];
		$idUsers = $_GET['id'];
		$tgl = date('Y-m-d H:i:s');

		$query = mysqli_query($koneksi,"UPDATE agenda SET stdel='1', dby='$idUsers', ddate='$tgl' WHERE id = '$id'");
		if($query){
			$_SESSION['notif'] = 'dsukses';
		}else{
			$_SESSION['notif'] = 'gagal';
		}
		
	}elseif (isset($_POST['simpan']) && isset($_POST['id'])){
		
		$id = $_POST['id'];
		$title = $_POST['keterangan'];
		$color = $_POST['warna'];
		$idUsers = $_GET['id'];
		$tgl = date('Y-m-d H:i:s');

		$query = mysqli_query($koneksi,"UPDATE agenda SET nama='$title', warna='$color', uby='$idUsers', udate='$tgl' WHERE id = '$id'");
		if($query){
			$_SESSION['notif'] = 'usukses';
		}else{
			$_SESSION['notif'] = 'gagal';
		}
	}
}elseif ($tipe == 'edit_tanggal'){

	if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){

		$id = $_POST['Event'][0];
		$start = $_POST['Event'][1];
		$end = $_POST['Event'][2];
		$idUsers = $_GET['id'];
		$tgl = date('Y-m-d H:i:s');

		$query = mysqli_query($koneksi,"UPDATE agenda SET tgl_mulai='$start', tgl_selesai='$end', uby='$idUsers', udate='$tgl' WHERE id = '$id'");
		if ($query){
			die ('berhasil');
		}else{
			die ('gagal');
		}
	}
}

header('Location: '.$_SERVER['HTTP_REFERER']);

?>
