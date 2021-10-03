<?php 
session_start();
error_reporting(0);
include "../../config/koneksi.php";
include "../../config/koneksi.php";
include "../../config/rupiah.php";
include "../../config/library.php";
include "../../config/fungsi_indotgl.php";
include "../../config/variabel_default.php";

if (isset($_SESSION['idUsers'])){

    $idTahunAjaran = $_GET['thn_ajar'];
    $idUnit = $_GET['unit'];
    $idJenisBayar = $_GET['jenis'];
    $idKelas = $_GET['kelas'];

	$idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
	$TA = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    $jenis_bayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT jenis_bayar.*, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idJenisBayar='$idJenisBayar'"));
   	if ($idKelas !='all'){
    	$kls = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));
        $kelas=$kls['nmKelas'];
    }else{
        $kelas = 'Semua Kelas';
    }

    if ($jenis_bayar['tipeBayar'] == 'Bulanan'){
        if ($idKelas == 'all'){
            $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.* FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' GROUP BY siswa.idSiswa");
        }else{
            $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.* FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' AND siswa.kelasSiswa='$idKelas' GROUP BY siswa.idSiswa");
        }
    }elseif ($jenis_bayar['tipeBayar'] == 'Bebas'){
        if ($idKelas == 'all'){
            $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bebas.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa = tagihan_bebas.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' GROUP BY siswa.idSiswa");
        }else{
            $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bebas.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa = tagihan_bebas.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' AND siswa.kelasSiswa='$idKelas' GROUP BY siswa.idSiswa");
        }
    }
    
    $file = 'Laporan Pembayaran '.$jenis_bayar['nmPosBayar'].' T.A. '.$TA['nmTahunAjaran'].' Kelas '.$kelas.' '.date('d-m-Y');
    $nama_file    =str_replace(' ', '_', $file);
    header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=".$nama_file.".xls");

	

    if (isset($_GET['Bulanan'])){
    	echo '<table border="0" cellpadding="2px">
            <tr>
                <td  colspan="15" style="font-weight: bold; font-size: 14pt">'.$idt['nmSekolah'].'</td>
            </tr>
            <tr style="border-bottom:0.5px solid black">
             	<td  colspan="15" style="font-size: 10pt;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</td>
            </tr> 
          </table><br>';

	    echo '<table style="font-size: 10pt; font-weight:bold;" cellpadding="1" border="0">
	        	<tr>
	           		<td align="center" colspan="15">Laporan Pembayaran '.$jenis_bayar['nmPosBayar'].'</td>
	       	    </tr>
	         </table>';

	    echo '<table style="font-size: 9pt" border="0" cellpadding="1">
	        	<tr>
	                <td colspan="2" style="width:120px">Tahun Ajaran</td>
	                <td >: '.$TA['nmTahunAjaran'].'</td>
	            </tr>
	            <tr>
	              	<td colspan="2" style="width:120px">Kelas</td>
	                <td>: '.$kelas.'</td>
	            </tr>
	            <tr>
	            	<td></td>
	            </tr>
	        </table>';
        echo '<table style="font-size:9pt; font-family: arial;" border="1" cellpadding="10" cellspasing="5">
                <thead>
                	<tr align="center">
                    	<th style="font-weight:bold; width:40px">No</th>
                        <th style="font-weight:bold; width:80px">NIS</th>
                        <th style="font-weight:bold; width:100px">Nama Siswa</th>';
                        $bulan = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
                        while ($bln = mysqli_fetch_array($bulan)) {
                        	echo '<th style="font-weight:bold;">'.getBulan($bln['idBulan']).'</th>';
                        }
                        echo '        </tr>
                                    </thead>
                                    <tbody>';
                                       $no = 1;
                                       $total_pembayaran = 0;
                                        while ($siswa = mysqli_fetch_array($sqlSiswa)) {
                                          echo '<tr align="center" valign="middle">
                                                  <td>'.$no++.'</td>
                                                  <td>'.$siswa['nisSiswa'].'</td>
                                                  <td>'.$siswa['nmSiswa'].'</td>';
                                                  $bulan = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
                                                  while ($bln = mysqli_fetch_array($bulan)) {
                                                    $tagihanBulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bulanan.*, jenis_bayar.idTahunAjaran FROM tagihan_bulanan LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' AND jenis_bayar.idTahunAjaran='$TA[idTahunAjaran]' AND idBulan='$bln[idBulan]'"));
                                                    if ($tagihanBulanan['statusBayar'] == '1'){
                                                      $keterangan = buatRp($tagihanBulanan['jumlahTagihan']).'<br>'.date('d/m/Y',strtotime($tagihanBulanan['tglBayar']));
                                                      $total_pembayaran += $tagihanBulanan['jumlahTagihan'];
                                                    }else{
                                                      $keterangan = '-';
                                                    }
                                                    echo '<td>'.$keterangan.'</td>';
                                                  }
                                          echo "</tr>";

                                        }

                echo '            </tbody>
                                </table>';

        		echo '<br><br>
        			<table>
        				<tr>
                        	<th colspan="15" style="font-weight:bold; text-align:left; font-size:9pt">Total Pembayaran '.buatRp($total_pembayaran).'</th>
                        </tr>
                    </table>';

    echo '	<table border="0" style="font-size:9pt">
    			<tr>
    				<td colspan="10"></td>
                    <td  colspan="2" align="center">'.$idt['kabupaten'].', '.tgl_raport(date('Y-m-d')).'</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
	            	<td colspan="10"></td>
	            	<td colspan="2" align="center">Bendahara</td>
	            	<td colspan="3"></td>
                </tr>
                <tr><td colspan="15"></td></tr>
                <tr><td colspan="15"></td></tr>
                <tr><td colspan="15"></td></tr>
                <tr>
                	<td colspan="10"></td>
                    <td colspan="2" align="center" style="font-weight:bold;">'.$idt['nmBendahara'].'</td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                	<td colspan="10"></td>
                    <td colspan="2" align="center">Nip. '.$idt['nipBendahara'].'</td>
                    <td colspan="3"></td>
                </tr>
            </table>';



    }elseif (isset($_GET['Bebas'])){
    	
    	echo '<table border="0" cellpadding="2px">
            <tr>
                <td  colspan="7" style="font-weight: bold; font-size: 14pt">'.$idt['nmSekolah'].'</td>
            </tr>
            <tr style="border-bottom:0.5px solid black">
             	<td  colspan="7" style="font-size: 10pt;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</td>
            </tr> 
          </table><br>';

	    echo '<table style="font-size: 10pt; font-weight:bold;" cellpadding="1" border="0">
	        	<tr>
	           		<td align="center" colspan="7">Laporan Pembayaran '.$jenis_bayar['nmPosBayar'].'</td>
	       	    </tr>
	         </table>';

	    echo '<table style="font-size: 9pt" border="0" cellpadding="1">
	        	<tr>
	                <td colspan="2" style="width:120px">Tahun Ajaran</td>
	                <td >: '.$TA['nmTahunAjaran'].'</td>
	            </tr>
	            <tr>
	              	<td colspan="2" style="width:120px">Kelas</td>
	                <td>: '.$kelas.'</td>
	            </tr>
	            <tr>
	            	<td></td>
	            </tr>
	        </table>';

    	echo '<table style="font-size:9pt; font-family: arial;" border="1" cellpadding="2">
                <thead>
                	<tr align="center">
                    	<th width="20px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">No</th>
                        <th width="100px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">NIS</th>
                        <th width="110px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Nama Siswa</th>
                        <th width="75px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Tagihan</th>
                        <th width="75px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Sudah Dibayar</th>
                        <th width="75px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Kekurangan</th>
                        <th width="75px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Keterangan</th>
                    </tr>
                </thead>
                <tbody>';
                	$no = 1;
                    $total_pembayaran_siswa=0;
                    while ($siswa = mysqli_fetch_array($sqlSiswa)) {
                    	$tagihanBebas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.idTagihanBebas, SUM(tagihan_bebas.totalTagihan) as totalTagihanBebas, jenis_bayar.idTahunAjaran FROM tagihan_bebas LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' AND jenis_bayar.idTahunAjaran='$TA[idTahunAjaran]'"));
                        $tagihanBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(jumlahBayar) as totalTagihanBebasBayar FROM tagihan_bebas_bayar WHERE idTagihanBebas='$tagihanBebas[idTagihanBebas]' GROUP BY idTagihanBebas"));
                                          
                        $sisaTagihanBebas = $tagihanBebas['totalTagihanBebas'] - $tagihanBebasBayar['totalTagihanBebasBayar'];
                        if ($sisaTagihanBebas == 0){
                        	$keterangan = 'LUNAS';
                        }else{
                        	$keterangan = 'BELUM LUNAS';
                        }

                        echo '<tr align="center">
                        		<td>'.$no++.'</td>
                        		<td>'.$siswa['nisSiswa'].'</td>
                        		<td>'.$siswa['nmSiswa'].'</td>
                        		<td>'.buatRp($tagihanBebas['totalTagihanBebas']).'</td>
                                <td>'.buatRp($tagihanBebasBayar['totalTagihanBebasBayar']).'</td>
                                <td>'.buatRp($sisaTagihanBebas).'</td>
                                <td>'.$keterangan.'</td>
                              </tr>';
                        $total_pembayaran_siswa += $tagihanBebasBayar['totalTagihanBebasBayar'];
                    }
        echo '  </tbody>
        		<tfoot>
        			<tr align="center" style="background-color:#e3e3e3; font-weight:bold">
                       	<th colspan="4" align="left">Total Pembayaran Siswa</th>
                        <th>'.buatRp($total_pembayaran_siswa).'</th>
                        <th colspan="2"></th>
                    </tr>
   	            </tfoot>
            </table><br>';

        echo '<table border="0" style="font-size:9pt">
    			<tr>
    				<td colspan="5"></td>
                    <td  colspan="2" align="center">'.$idt['kabupaten'].', '.tgl_raport(date('Y-m-d')).'</td>
                </tr>
                <tr>
	            	<td colspan="5"></td>
	            	<td colspan="2" align="center">Bendahara</td>
                </tr>
                <tr><td colspan="7"></td></tr>
                <tr><td colspan="7"></td></tr>
                <tr><td colspan="7"></td></tr>
                <tr>
                	<td colspan="5"></td>
                    <td colspan="2" align="center" style="font-weight:bold;">'.$idt['nmBendahara'].'</td>
                </tr>
                <tr>
                	<td colspan="5"></td>
                    <td colspan="2" align="center">Nip. '.$idt['nipBendahara'].'</td>
                </tr>
            </table>';
    }

   

}else{
    include "../../login.php";
}