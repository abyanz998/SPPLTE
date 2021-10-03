<?php
    include '../../config/koneksi.php';

    $idTahunAjaran=$_POST['idTahunAjaran'];
    
    $query = mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE stdel='0' ORDER BY idTahunAjaran DESC");

    while ($q = mysqli_fetch_array($query)) {
        if ($idTahunAjaran == ''){
            if ($q['status'] == 'Aktif'){
                echo '<option value="'.$q['idTahunAjaran'].'" selected>'.$q['nmTahunAjaran'].'</option>';
            }else{
                echo '<option value="'.$q['idTahunAjaran'].'">'.$q['nmTahunAjaran'].'</option>';
            }
        }elseif ($idTahunAjaran == $q['idTahunAjaran']){
            echo '<option value="'.$q['idTahunAjaran'].'" selected>'.$q['nmTahunAjaran'].'</option>';
        }else{
            echo '<option value="'.$q['idTahunAjaran'].'">'.$q['nmTahunAjaran'].'</option>';
        }
    }
    
    
    
?>