<?php
    include '../../config/koneksi.php';

    $idUnit=$_POST['idUnit'];
    $idUsers=$_POST['idUsers'];
    $tipe_unit=$_POST['tipe_unit'];

    $users = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM users WHERE idUsers='$idUsers'"));

    echo '<option value="" disabled="" selected="">- Pilih Unit Sekolah -</option>';
    if ($users['unit'] == '0'){
        if ($tipe_unit == 'pencarian'){
            if ($idUnit == 'all'){
                echo '<option value="all" selected>Semua Unit Sekolah</option>';
            }else{
                echo '<option value="all">Semua Unit Sekolah</option>';
            }
        }
        $query = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' ORDER BY idUnit ASC");
    }else{
        $query = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$users[unit]' AND status='1' AND stdel='0' ORDER BY idUnit ASC");
    }
    while ($q = mysqli_fetch_array($query)) {
        if ($idUnit == $q['idUnit']){
            echo '<option value="'.$q['idUnit'].'" selected>'.$q['singkatanUnit'].'</option>';
        }else{
            echo '<option value="'.$q['idUnit'].'">'.$q['singkatanUnit'].'</option>';
        }
    }
?>