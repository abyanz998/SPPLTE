<?php
    include '../../config/koneksi.php';

    $idAkunPendapatan=$_POST['idAkunPendapatan'];
    $idUnitUsers=$_POST['idUnitUsers'];

    if ($idUnitUsers != 0){
        $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%4-4%' AND kategori='Pembayaran' AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnitUsers' ORDER BY idAkun ASC");
    }else{
       $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%4-4%' AND kategori='Pembayaran' AND stdel='0' AND jenisAkun='Sub Menu 2' ORDER BY idAkun ASC");
    }

    echo '<option disabled selected value="0">- Pilih Kode Akun -</option>';
    while ($q = mysqli_fetch_array($query)) {
        if($idAkunPendapatan == $q['idAkun']){
            echo '<option value="'.$q['idAkun'].'" selected>'.$q['kodeAkun'].' - '.$q['keterangan'].'</option>';
        }else{
            echo '<option value="'.$q['idAkun'].'">'.$q['kodeAkun'].' - '.$q['keterangan'].'</option>';
        }
    }
?>