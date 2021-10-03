<?php
    include '../../config/koneksi.php';

    $idTahunAjaran=$_POST['idTahunAjaran'];
    $tipe_tahunajaran=$_POST['tipe_tahunajaran'];
    
    $query = mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE stdel='0' ORDER BY idTahunAjaran DESC");

    echo '<option disabled selected value="">- Pilih Tahun Ajaran -</option>';
     if ($tipe_tahunajaran == 'semuaTahunAjaran'){
        if($idTahunAjaran == 'all'){
            echo '<option value="all" selected> Semua Tahun Ajaran </option>';
        }else{
             echo '<option value="all"> Semua Tahun Ajaran </option>';
        }
    }
    while ($q = mysqli_fetch_array($query)) {
        if ($idTahunAjaran == $q['idTahunAjaran']){
            echo '<option value="'.$q['idTahunAjaran'].'" selected>'.$q['nmTahunAjaran'].'</option>';
        }else{
            echo '<option value="'.$q['idTahunAjaran'].'">'.$q['nmTahunAjaran'].'</option>';
        }
    }
    
    
    
?>