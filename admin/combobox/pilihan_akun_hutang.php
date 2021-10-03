<?php
    include '../../config/koneksi.php';

    $idAkunHutang=$_POST['idAkunHutang'];
    $idUnitUsers=$_POST['idUnitUsers'];
    if ($idUnitUsers != 0){
        $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun LIKE '%2-2%' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnitUsers' ORDER BY idAkun ASC");
    }else{
        $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun LIKE '%2-2%' AND jenisAkun='Sub Menu 2' ORDER BY idAkun ASC");
    }
    echo '<option disabled selected value="">- Pilih Kode Akun -</option>';
    while ($q = mysqli_fetch_array($query)) {
    	if ($idAkunHutang == $q['idAkun']){
    		echo '<option value="'.$q['idAkun'].'" selected>'.$q['kodeAkun'].' - '.$q['keterangan'].'</option>';
    	}else{
    		echo '<option value="'.$q['idAkun'].'">'.$q['kodeAkun'].' - '.$q['keterangan'].'</option>';
    	}
    	
    }
?>