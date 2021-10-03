<?php
    include '../../config/koneksi.php';

    $idSiswa=$_POST['idSiswa'];
    $idKelas=$_POST['idKelas'];
    $tipe_siswa=$_POST['tipe_siswa'];
    echo '<option disabled selected value="">- Pilih Siswa -</option>';
    if ($tipe_siswa == 'semuaSiswa'){
        if($idSiswa == 'all'){
            echo '<option value="all" selected> Semua Siswa </option>';
        }else{
             echo '<option value="all"> Semua Siswa </option>';
        }
    }
    $query = mysqli_query($koneksi,"SELECT * FROM siswa WHERE kelasSiswa='$idKelas' AND stdel='0' AND statusSiswa='Aktif' ORDER BY idSiswa ASC");
    while ($q = mysqli_fetch_array($query)) {
    	if ($idSiswa == $q['idSiswa']){
    		echo '<option value="'.$q['idSiswa'].'" selected>'.$q['nmSiswa'].'</option>';
    	}else{
    		echo '<option value="'.$q['idSiswa'].'">'.$q['nmSiswa'].'</option>';
    	}
    	
    }
?>