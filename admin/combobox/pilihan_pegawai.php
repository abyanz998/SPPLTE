<?php
    include '../../config/koneksi.php';

    $idPegawai=$_POST['idPegawai'];
    $idJabatan=$_POST['idJabatan'];
    
    $query = mysqli_query($koneksi,"SELECT * FROM pegawai WHERE jabatanPegawai='$idJabatan' AND stdel='0' ORDER BY idPegawai ASC");

    echo '<option disabled selected value="">- Pilih Pegawai -</option>';
    while ($q = mysqli_fetch_array($query)) {
        if ($idPegawai == $q['idPegawai']){
            echo '<option value="'.$q['idPegawai'].'" selected>'.$q['namaPegawai'].'</option>';
        }else{
            echo '<option value="'.$q['idPegawai'].'">'.$q['namaPegawai'].'</option>';
        }
        
    }
?>