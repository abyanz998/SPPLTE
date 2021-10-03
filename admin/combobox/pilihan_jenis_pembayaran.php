<?php
    include '../../config/koneksi.php';

    $idUnit=$_POST['idUnit'];
    $idTahunAjaran=$_POST['idTahunAjaran'];
    $idJenisPembayaran=$_POST['idJenisPembayaran'];

    echo '<option disabled selected value="">- Pilih Jenis Pembayaran -</option>';

    $query = mysqli_query($koneksi,"SELECT jenis_bayar.*, pos_bayar.nmPosBayar, tahun_ajaran.nmTahunAjaran FROM jenis_bayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran=tahun_ajaran.idTahunAjaran WHERE jenis_bayar.idUnit='$idUnit' AND jenis_bayar.idTahunAjaran='$idTahunAjaran' AND jenis_bayar.stdel='0' ORDER BY jenis_bayar.idJenisBayar ASC");
    while ($q = mysqli_fetch_array($query)) {
    	if ($idJenisPembayaran == $q['idJenisBayar']){
    		echo '<option value="'.$q['idJenisBayar'].'" selected>'.$q['nmPosBayar'].' T.A '.$q['nmTahunAjaran'].'</option>';
    	}else{
    		echo '<option value="'.$q['idJenisBayar'].'">'.$q['nmPosBayar'].' T.A '.$q['nmTahunAjaran'].'</option>';
    	}
    	
    }
?>