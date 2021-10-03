<?php
    include '../../config/koneksi.php';

    $idAkunKasSelect = $_POST['idAkunKasSelect'];

    $query = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.kodeAkun like '%1-1%' AND akun_biaya.keterangan like '%Kas%' AND akun_biaya.stdel='0' AND akun_biaya.jenisAkun='Sub Menu 2'  AND akun_biaya.idAkun!='$idAkunKasSelect' ORDER BY akun_biaya.idAkun ASC");

    while ($q = mysqli_fetch_array($query)) {
    	echo '<option value="'.$q['idAkun'].'">'.$q['kodeAkun'].' - '.$q['keterangan'].' '.$q['singkatanUnit'].'</option>';
    }
?>
  