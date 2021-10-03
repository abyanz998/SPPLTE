<?php
    include '../../config/koneksi.php';

    $idKamar=$_POST['idKamar'];
    $tipe_kamar=$_POST['tipe_kamar'];
 
    echo '<option value="" disabled="" selected="">- Pilih Kamar -</option>';
    if ($tipe_kamar == 'kamarTidakAda'){
        if($idKamar == '0'){
            echo '<option value="0" selected> Tidak Ada </option>';
        }else{
             echo '<option value="0"> Tidak Ada </option>';
        }
    }

    if ($tipe_kamar == 'semuaKamar'){
        if($idKamar == 'all'){
            echo '<option value="all" selected> Semua Kamar </option>';
        }else{
             echo '<option value="all"> Semua Kamar </option>';
        }
    }
    $query = mysqli_query($koneksi,"SELECT * FROM kamar WHERE stdel='0' ORDER BY idKamar ASC");

    while ($q = mysqli_fetch_array($query)) {
        if ($idKamar == $q['idKamar']){
            echo '<option value="'.$q['idKamar'].'" selected>'.$q['namaKamar'].'</option>';
        }else{
            echo '<option value="'.$q['idKamar'].'">'.$q['namaKamar'].'</option>';
        }
    }
    
    
    
?>