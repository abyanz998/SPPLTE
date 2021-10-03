<?php
    include '../../config/koneksi.php';

    $idAkunKas=$_POST['idAkunKas'];
    $idUnitUsers=$_POST['idUnitUsers'];
    $idUnitPegawai=$_POST['idUnitPegawai'];
    

    if ($idUnitUsers != 0){
        // $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas%' AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnitUsers' ORDER BY idAkun ASC");
      $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE keterangan like '%Kas%' AND stdel='0' AND unitSekolah='$idUnitPegawai' ORDER BY idAkun ASC");
    }else{
    //   $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas%' AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnitPegawai' ORDER BY idAkun ASC");
      $query = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE keterangan like '%Kas%' AND stdel='0' AND unitSekolah='$idUnitPegawai' ORDER BY idAkun ASC");
    }
    
    echo '<option disabled selected value="">- Pilih Kode Akunn -</option>';
    while ($q = mysqli_fetch_array($query)) {
    	if(preg_match("/Kas Tunai/i", $q['keterangan'])) {
            echo '<option value="'.$q['idAkun'].'" selected>'.$q['kodeAkun'].' - '.$q['keterangan'].'</option>';
        }elseif ($idAkunKas == $q['idAkun']){
    		echo '<option value="'.$q['idAkun'].'" selected>'.$q['kodeAkun'].' - '.$q['keterangan'].'</option>';
    	}else{
    		echo '<option value="'.$q['idAkun'].'">'.$q['kodeAkun'].' - '.$q['keterangan'].'</option>';
    	}
    	
    }
?>
  