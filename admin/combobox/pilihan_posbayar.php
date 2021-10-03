<?php
    include '../../config/koneksi.php';

    $idUnit=$_POST['idUnit'];
    $idPosBayar=$_POST['idPosBayar'];

    echo '<option value="" disabled="" selected="">- Pilih Pos -</option>';
    
    $query = mysqli_query($koneksi,"SELECT pos_bayar.*, akun_biaya.unitSekolah FROM pos_bayar LEFT JOIN akun_biaya ON pos_bayar.kodeAkun = akun_biaya.idAkun WHERE akun_biaya.unitSekolah='$idUnit' AND pos_bayar.stdel='0' ORDER BY pos_bayar.idPosBayar ASC");
    
    while ($q = mysqli_fetch_array($query)) {
        if ($idPosBayar == $q['idPosBayar']){
            echo '<option value="'.$q['idPosBayar'].'" selected>'.$q['nmPosBayar'].'</option>';
        }else{
            echo '<option value="'.$q['idPosBayar'].'">'.$q['nmPosBayar'].'</option>';
        }
    }
    
    
    
?>