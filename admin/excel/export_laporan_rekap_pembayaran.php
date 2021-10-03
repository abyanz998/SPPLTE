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
    $idKelas = $_GET['kelas'];

    $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
    $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    $kls = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));

    $file = 'Laporan Rekap Pembayaran Kelas '.$kls['nmKelas'].' T.A. '.$ta['nmTahunAjaran'].' '.date('d-m-Y');
    $nama_file    =str_replace(' ', '_', $file);
    header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=".$nama_file.".xls");


    echo '<table border="0" cellpadding="2px" style="white-space: nowrap;">
            <tr>
                <td colspan="4" style="font-weight: bold; font-size: 14pt">'.$idt['nmSekolah'].'</td>
            </tr>
            <tr style="border-bottom:0.5px solid black">
             	<td colspan="4" style="font-size: 10pt;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</td>
            </tr> 
          </table><br>';

	    echo '<table style="white-space: nowrap; font-size: 12pt; font-weight:bold;" cellpadding="2" border="0">
	        	<tr>
	           		<td colspan="4" align="center">Rekapitulasi Pembayaran Kelas '.$kls['nmKelas'].' T.A. '.$ta['nmTahunAjaran'].'</td>
	       	    </tr>
	         </table><br>';

	    echo '<table style="font-size: 9pt; white-space: nowrap;" border="0" cellpadding="1" >
	        	<tr><td colspan="3" style="font-weight:bold">Dibuat pada tanggal : '.date('m-d-Y',strtotime($tanggal_sekarang)).'</td></tr>
	        </table><br>';

        echo '<table style="font-size:9pt; font-family: arial; white-space: nowrap; text-align:center;" border="1" cellpadding="10">
                <thead>
                	<tr>
                        <th rowspan="2" style="width:150px">Kelas</th>
                        <th rowspan="2" style="width:150px">Nama</th>';
                        $sqljenisBayar = mysqli_query($koneksi,"SELECT jenis_bayar.*, tagihan_bulanan.idTagihanBulanan, tagihan_bebas.idTagihanBebas, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN tagihan_bulanan ON jenis_bayar.idJenisBayar=tagihan_bulanan.idJenisBayar LEFT JOIN tagihan_bebas ON jenis_bayar.idJenisBayar=tagihan_bebas.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND jenis_bayar.idUnit='$idUnit' GROUP BY jenis_bayar.idJenisBayar");
                        while ($jb = mysqli_fetch_array($sqljenisBayar)) {
                          if ($jb['tipeBayar'] == 'Bulanan'){
                            echo '<th colspan="12">'.$jb['nmPosBayar'].' T.A. '.$ta['nmTahunAjaran'].'</th>';
                          }else if ($jb['tipeBayar'] == 'Bebas'){
                            echo '<th rowspan="2">'.$jb['nmPosBayar'].' T.A. '.$ta['nmTahunAjaran'].'</th>';
                          }
                        }
        echo '      </tr>
                    <tr>';
                    $sqljenisBayar = mysqli_query($koneksi,"SELECT jenis_bayar.*, tagihan_bulanan.idTagihanBulanan, tagihan_bebas.idTagihanBebas, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN tagihan_bulanan ON jenis_bayar.idJenisBayar=tagihan_bulanan.idJenisBayar LEFT JOIN tagihan_bebas ON jenis_bayar.idJenisBayar=tagihan_bebas.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND jenis_bayar.idUnit='$idUnit' GROUP BY jenis_bayar.idJenisBayar");
                    while ($jb = mysqli_fetch_array($sqljenisBayar)) {
                        if ($jb['tipeBayar'] == 'Bulanan'){
                            $bulan = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
                            while ($bln = mysqli_fetch_array($bulan)) {
                            echo '<th>'.$bln['nmBulan'].'</th>';
                            }
                        }
                    }
        echo '      </tr>
                </thead>
                <tbody>';
                    $siswaTagihan = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.idJenisBayar as idJenisBayarBulanan, tagihan_bebas.idJenisBayar as idJenisBayarBebas, kelas_siswa.nmKelas FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa=tagihan_bulanan.idSiswa LEFT JOIN tagihan_bebas ON siswa.idSiswa=tagihan_bebas.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE siswa.kelasSiswa='$idKelas' AND siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' GROUP BY siswa.idSiswa ORDER BY siswa.idSiswa DESC");
                    while ($siswa = mysqli_fetch_array($siswaTagihan)) {
                        echo '<tr>';
                        echo '<td style="text-align:center">'.$kls['nmKelas'].'</td>';
                        echo '<td style="text-align:center">'.$siswa['nmSiswa'].'</td>';
                  
                        $sqljenisBayar = mysqli_query($koneksi,"SELECT jenis_bayar.*, tagihan_bulanan.idTagihanBulanan, tagihan_bebas.idTagihanBebas, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN tagihan_bulanan ON jenis_bayar.idJenisBayar=tagihan_bulanan.idJenisBayar LEFT JOIN tagihan_bebas ON jenis_bayar.idJenisBayar=tagihan_bebas.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND jenis_bayar.idUnit='$idUnit' GROUP BY jenis_bayar.idJenisBayar");
                        while ($jb = mysqli_fetch_array($sqljenisBayar)) {
                            if ($jb['tipeBayar'] == 'Bulanan'){
                                //TAGIHAN BULANAN
                                $TagihanBulanan = mysqli_query($koneksi,"SELECT tagihan_bulanan.*, bulan.urutan FROM tagihan_bulanan LEFT JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND tagihan_bulanan.idJenisBayar='$jb[idJenisBayar]' ORDER BY bulan.urutan ASC");
                                if (mysqli_num_rows($TagihanBulanan) == 0){
                                    echo '<td colspan="12" style="text-align:center"> - </td>';
                                }else{
                                    while ($bln = mysqli_fetch_array($TagihanBulanan)) {
                                        if ($bln['statusBayar'] == '1'){
                                            $ket = '<label style="color:#00E640">Lunas</label>';
                                        }else{
                                            $ket = '<label style="color:red">'.rupiah($bln['jumlahTagihan']).'</label>';
                                        }
                                        echo '<td style="text-align:center">'.$ket.'</td>';
                                    }
                                }
                            }else if ($jb['tipeBayar'] == 'Bebas'){
                                //TAGIHAN BEBAS
                                $TagihanBebas = mysqli_query($koneksi,"SELECT idTagihanBebas, SUM(totalTagihan) as totalTagihanBebas, statusBayar FROM tagihan_bebas WHERE idSiswa='$siswa[idSiswa]' AND idJenisBayar='$jb[idJenisBayar]' GROUP BY idSiswa");
                                if (mysqli_num_rows($TagihanBebas) == 0){
                                    echo '<td style="text-align:center"> - </td>';
                                }else{
                                    while ($bebas = mysqli_fetch_array($TagihanBebas)) {
                                        if ($bebas['statusBayar'] == '1'){
                                            $ket = '<label style="color:#00E640">Lunas</label>';
                                        }else{
                                            $TagihanBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(jumlahBayar) as totalTagihanBebasBayar FROM tagihan_bebas_bayar WHERE idTagihanBebas='$bebas[idTagihanBebas]' GROUP BY idTagihanBebas")); 
                                            $sisaTagihan = $bebas['totalTagihanBebas'] - $TagihanBebasBayar['totalTagihanBebasBayar'];
                                            $ket = '<label style="color:red">'.rupiah($sisaTagihan).'</label>';
                                        }
                                        echo '<td style="text-align:center">'.$ket.'</td>';
                                    }
                                }
                            }
                        }
                        echo '</tr>'; 
                    }                 
        echo '  </tbody>
            </table>';

    echo '<br><br>';
    echo '	<table border="0" style="font-size:9pt">
    			<tr>
    				<td colspan="10"></td>
                    <td colspan="2" align="center">'.$idt['kabupaten'].', '.tgl_raport(date('Y-m-d')).'</td>
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


}else{
    include "../../login.php";
}