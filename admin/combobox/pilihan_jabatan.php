<?php
    include '../../config/koneksi.php';

    $idUnit=$_POST['idUnit'];
    $idJabatan=$_POST['idJabatan'];
    $tipe_unit=$_POST['tipe_unit'];
    $tipe_jabatan=$_POST['tipe_jabatan'];

    echo '<option value="" disabled="" selected="">- Pilih Jabatan Pegawai-</option>';
    if ($idUnit == 'all'){
        if ($tipe_unit == 'pencarian'){
            if ($idJabatan == 'all'){
                echo '<option value="all" selected>Semua Jabatan Pegawai</option>';
            }else{
                echo '<option value="all">Semua Jabatan Pegawai</option>';
            }  
        }
    }else{
        if ($tipe_jabatan == 'pencarian'){
            if ($idJabatan == 'all'){
                echo '<option value="all" selected>Semua Jabatan Pegawai</option>';
            }else{
                echo '<option value="all">Semua Jabatan Pegawai</option>';
            }  
        }

        $query = mysqli_query($koneksi,"SELECT * FROM jabatan_pegawai WHERE idUnit='$idUnit' AND stdel='0' ORDER BY idJabatan ASC");
    
        while ($q = mysqli_fetch_array($query)) {
            if ($idJabatan == $q['idJabatan']){
                echo '<option value="'.$q['idJabatan'].'" selected>'.$q['namaJabatan'].'</option>';
            }else{
                echo '<option value="'.$q['idJabatan'].'">'.$q['namaJabatan'].'</option>';
            }
        }
    }
    
    
?>