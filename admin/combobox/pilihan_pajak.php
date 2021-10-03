<?php
    include '../../config/koneksi.php';

    $idPajak=$_POST['idPajak'];

    $query = mysqli_query($koneksi,"SELECT * FROM pajak WHERE stdel='0' ORDER BY besaranPajak ASC");
    
    echo '<option value="0">0 %</option>';
    while ($q = mysqli_fetch_array($query)) {
        if ($idPajak == $q['idPajak']){
            echo '<option value="'.$q['idPajak'].'" selected>'.$q['besaranPajak'].' %</option>';
        }else{
            echo '<option value="'.$q['idPajak'].'">'.$q['besaranPajak'].' %</option>';
        }
        
    }
?>