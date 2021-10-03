<?php
    include '../../config/koneksi.php';

    $idPosHutang=$_POST['idPosHutang'];
    $idUnit=$_POST['idUnit'];
    
    $query = mysqli_query($koneksi,"SELECT hutang_pos.*, akun_biaya.unitSekolah FROM hutang_pos LEFT JOIN akun_biaya ON hutang_pos.idAkunHutang = akun_biaya.idAkun WHERE akun_biaya.unitSekolah='$idUnit' AND hutang_pos.stdel='0' ORDER BY hutang_pos.idPosHutang ASC");

    echo '<option disabled selected value="">- Pilih Pos Hutang -</option>';
    while ($q = mysqli_fetch_array($query)) {
    	if ($idPosHutang == $q['idPosHutang']){
    		echo '<option value="'.$q['idPosHutang'].'" selected>'.$q['namaPosHutang'].'</option>';
    	}else{
    		echo '<option value="'.$q['idPosHutang'].'">'.$q['namaPosHutang'].'</option>';
    	}
    	
    }
?>