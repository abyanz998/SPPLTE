<?php
    include '../../config/koneksi.php';

    $idAkunBiaya=$_POST['idAkunBiaya'];
    $idUnitUsers=$_POST['idUnitUsers'];
    $idUnit=$_POST['idUnit'];

    if ($idUnitUsers != 0){
        $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%5-5%' AND keterangan not like '%Biaya Gaji%' AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnitUsers' ORDER BY idAkun ASC");
    }else{
        $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%5-5%' AND keterangan not like '%Biaya Gaji%' AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnit' ORDER BY idAkun ASC");
    }
    echo '<option disabled selected value="0">- Pilih Kode Akun -</option>';
    while ($q = mysqli_fetch_array($query)) {
        if ($idAkunBiaya == $q['idAkun']){
            echo '<option value="'.$q['idAkun'].'" selected>'.$q['kodeAkun'].' - '.$q['keterangan'].'</option>';
        }else{
            echo '<option value="'.$q['idAkun'].'">'.$q['kodeAkun'].' - '.$q['keterangan'].'</option>';
        }
        
    }
?>