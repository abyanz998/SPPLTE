<?php
    include '../../config/koneksi.php';

    $idUnit=$_POST['idUnit'];
    $idUsers=$_POST['idUsers'];
    $tipe_users=$_POST['tipe_users'];

    if ($tipe_users == 'semuaUsers'){
        if($idUsers == 'all'){
            echo '<option value="all" selected>- Semua Users -</option>';
        }else{
             echo '<option value="all">- Semua Users -</option>';
        }
    }

    $query = mysqli_query($koneksi,"SELECT * FROM users WHERE stdel='0' AND unit='$idUnit' ORDER BY idUsers ASC");
    while ($q = mysqli_fetch_array($query)) {
    	if ($idUsers == $q['idUsers']){
    		echo '<option value="'.$q['idUsers'].'" selected>'.$q['nama_lengkap'].'</option>';
    	}else{
    		echo '<option value="'.$q['idUsers'].'">'.$q['nama_lengkap'].'</option>';
    	}
    	
    }
?>