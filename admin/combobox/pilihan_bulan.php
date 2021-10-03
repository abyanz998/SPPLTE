<?php
    include '../../config/koneksi.php';

    $idBulan=$_POST['idBulan'];

    $query = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
    while ($q = mysqli_fetch_array($query)) {
    	if ($idBulan == $q['idBulan']){
    		echo '<option value="'.$q['idBulan'].'" selected>'.$q['nmBulan'].'</option>';
    	}else{
    		echo '<option value="'.$q['idBulan'].'">'.$q['nmBulan'].'</option>';
    	}
    	
    }
?>