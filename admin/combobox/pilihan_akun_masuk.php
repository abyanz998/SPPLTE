<?php
    include '../../config/koneksi.php';

    $idAkunBiaya=$_POST['idAkunBiaya'];
    $idUnitUsers=$_POST['idUnitUsers'];
    $idUnit=$_POST['idUnit'];

    if ($idUnitUsers != 0){
        $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE akun_biaya.kodeAkun like '%4-4%' AND akun_biaya.kategori='Keuangan' AND akun_biaya.stdel='0' AND akun_biaya.jenisAkun='Sub Menu 2' AND akun_biaya.unitSekolah='$idUnitUsers' ORDER BY akun_biaya.idAkun ASC");
    }else{
        $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE akun_biaya.kodeAkun like '%4-4%' AND akun_biaya.kategori='Keuangan' AND akun_biaya.stdel='0' AND akun_biaya.jenisAkun='Sub Menu 2' AND akun_biaya.unitSekolah='$idUnit' ORDER BY akun_biaya.idAkun ASC");
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