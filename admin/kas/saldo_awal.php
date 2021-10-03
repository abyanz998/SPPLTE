<?php
session_start();
// Koneksi
include '../../config/koneksi.php';

$tipe=$_POST['tipe'];

if ($tipe == 'simpan'){

	$id = $_POST['id'];
	$value = $_POST['value'];
	$modul = $_POST['modul'];

	if ((!empty($id)) && (!empty($modul))){
		
		if($modul =='saldo_awal_debit'){
			mysqli_query($koneksi,"UPDATE akun_biaya SET saldo_awal_debit='$value' WHERE idAkun='$id'");
		}
		if($modul =='saldo_awal_kredit'){
			mysqli_query($koneksi,"UPDATE akun_biaya SET saldo_awal_kredit='$value' WHERE idAkun='$id'");
		}
	}

}elseif ($tipe == 'get_total'){

	$id_unit = $_POST['id_unit'];

	$akun = mysqli_fetch_array(mysqli_query($koneksi,"SELECT sum(saldo_awal_debit) as total_debit, sum(saldo_awal_kredit) as total_kredit FROM akun_biaya WHERE kategori!='#' AND unitSekolah='$id_unit'"));
	$total_saldo = $akun['total_debit'] - $akun['total_kredit'];
	if ($total_saldo == 0){
		echo '<table class="table table-hover table-responsive">
	       	<tbody>
	        	<tr style="background-color: #F3F1F1">
	            	<td colspan="3" align="right"><b> Total</b></td>
	                <td>Rp '.$akun['total_debit'].'</td>
	                <td>Rp '.$akun['total_kredit'].'</td>
	            </tr>
	            <tr style="background-color: #93F9B3">
	            	<td colspan="3" align="right"><b>Saldo Awal (Benar, saldo awal sudah 0 (nol))</b></td>
	                <td colspan="2">Rp '.$total_saldo.'</td>
	            </tr>
	        </tbody>
	     </table>';
	}else{
	 	echo '<table class="table table-hover table-responsive">
	        	<tbody>
	        		<tr style="background-color: #F3F1F1">
	            		<td colspan="3" align="right"><b> Total</b></td>
	            		<td>Rp '.$akun['total_debit'].'</td>
	                	<td>Rp '.$akun['total_kredit'].'</td>
		    		</tr>
		    		<tr style="background-color: #FD8989">
	            		<td colspan="3" align="right"><b>Saldo Awal (Kesalahan, saldo awal harus 0 (nol))</b></td>
	            		 <td colspan="2">Rp '.$total_saldo.'</td>
		    		</tr>
		    	</tbody>
		    </table>';
	}

}


?>
