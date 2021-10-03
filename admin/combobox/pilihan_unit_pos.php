<?php
    include '../../config/koneksi.php';

    $idUnitPos=$_POST['idUnitPos'];
    $idUnitUsers=$_POST['idUnitUsers'];
    $idUnit = $_POST['idUnit'];

    if ($idUnitUsers != 0){
        $query = mysqli_query($koneksi,"SELECT * FROM unit_pos WHERE stdel='0' AND unitSekolah='$idUnitUsers' ORDER BY idUnitPos ASC");
    }else{
        $query = mysqli_query($koneksi,"SELECT * FROM unit_pos WHERE stdel='0' AND unitSekolah='$idUnit' ORDER BY idUnitPos ASC");
    }

    echo '<option value="0">Tidak Ada</option>';
    while ($q = mysqli_fetch_array($query)) {
        if ($idUnitPos == $q['idUnitPos']){
            echo '<option value="'.$q['idUnitPos'].'" selected>'.$q['nmUnitPos'].'</option>';
        }else{
            echo '<option value="'.$q['idUnitPos'].'">'.$q['nmUnitPos'].'</option>';
        }
    }
?>