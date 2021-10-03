<?php
    include '../../config/koneksi.php';

    $role_id = $_GET['role_id'];
    $menu_id = $_GET['menu_id'];

    $users_hakakses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users_hak_akses WHERE IdUsersLevel='$role_id' AND idMenu='$menu_id'"));
    if ($users_hakakses == 0){
        $query = mysqli_query($koneksi, "INSERT INTO users_hak_akses(IdUsersLevel,idMenu) VALUES ('$role_id','$menu_id')");
		if ($query){
			die ('tambahOK');
		}else{
			die ('gagal');
		}
    }else{
        $query = mysqli_query($koneksi, "DELETE FROM users_hak_akses WHERE IdUsersLevel='$role_id' AND idMenu='$menu_id'");
        if ($query){
			die ('hapusOK');
		}else{
			die ('gagal');
		}
    }
?>

