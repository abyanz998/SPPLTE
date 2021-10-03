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
    $bln1 = $_GET['bulan1'];
    $bln2 = $_GET['bulan2'];

    $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    $kls = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));

    
    $file = 'Rekap Laporan Tagihan Kelas '.$kls['nmKelas'].' '.date('d-m-Y');
    $nama_file    =str_replace(' ', '_', $file);
    header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=".$nama_file.".xls");

    echo '<table id="" class="table text-center" border="1" style="white-space: nowrap;">
            <thead>
              <tr>
                <th style="width:50px;">No.</th>
                <th style="width:200px;">NIS</th>
                <th style="width:200px;">Nama</th>
                <th style="width:100px;">Kelas</th>
                <th style="width:200px;">Total Tagihan</th>
              </tr>
            </thead>
            <tbody>';
                $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.idJenisBayar as idJenisBayarBulanan, tagihan_bebas.idJenisBayar as idJenisBayarBebas, kelas_siswa.nmKelas FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa=tagihan_bulanan.idSiswa LEFT JOIN tagihan_bebas ON siswa.idSiswa=tagihan_bebas.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE siswa.kelasSiswa='$idKelas' AND siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' GROUP BY siswa.idSiswa ORDER BY siswa.idSiswa DESC");
                $no=1;
                while($ds=mysqli_fetch_array($sqlSiswa)){
                    //$totDibayar = 0;
                    $totTagihan = 0;
                    $sqlJenisBayar = mysqli_query($koneksi,"SELECT jenis_bayar.*, tagihan_bulanan.idTagihanBulanan, tagihan_bebas.idTagihanBebas, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN tagihan_bulanan ON jenis_bayar.idJenisBayar=tagihan_bulanan.idJenisBayar LEFT JOIN tagihan_bebas ON jenis_bayar.idJenisBayar=tagihan_bebas.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND jenis_bayar.idUnit='$idUnit' GROUP BY jenis_bayar.idJenisBayar");
                    while($djb=mysqli_fetch_array($sqlJenisBayar)){
                        if($djb['tipeBayar']=='Bulanan'){
                          //menghitung semua tagihan bulanan
                          $tgbul  = mysqli_fetch_array(mysqli_query($koneksi,"SELECT
                                      jenis_bayar.idPosBayar,
                                      pos_bayar.nmPosBayar,
                                      tagihan_bulanan.idSiswa,
                                      Sum(tagihan_bulanan.jumlahTagihan) AS TotalSemuaTagihanBulanan
                                      FROM tagihan_bulanan
                                      INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                      INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                      INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                      WHERE tagihan_bulanan.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bulanan.idSiswa='$ds[idSiswa]' AND bulan.urutan >= '$bln1' AND bulan.urutan <= '$bln2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bulanan.statusBayar <> '1'"));
                          $semuaTagihan = $tgbul['TotalSemuaTagihanBulanan'];
                          $tagihan  = $semuaTagihan;

                        }else{
                          //menghitung semua tagihan bebas
                          $tgb  = mysqli_fetch_array(mysqli_query($koneksi,"SELECT
                                    tagihan_bebas.idTagihanBebas,
                                    jenis_bayar.idPosBayar,
                                    pos_bayar.nmPosBayar,
                                    tagihan_bebas.idSiswa,
                                    SUM(tagihan_bebas.totalTagihan) As TotalSemuaTagihanBebas
                                    FROM
                                    tagihan_bebas
                                    INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                    INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                    WHERE tagihan_bebas.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bebas.idSiswa='$ds[idSiswa]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));
                          $semuaTagihan = $tgb['TotalSemuaTagihanBebas'];

                          $dbayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT
                                      tagihan_bebas.idJenisBayar,
                                      jenis_bayar.idTahunAjaran,
                                      tagihan_bebas_bayar.idTagihanBebas,
                                      SUM(tagihan_bebas_bayar.jumlahBayar) AS TotalPembayaranPerJenis,
                                      tagihan_bebas_bayar.ketBebas
                                      FROM
                                      tagihan_bebas_bayar
                                      INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
                                      INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                      WHERE tagihan_bebas_bayar.idTagihanBebas='$tgb[idTagihanBebas]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));
                          $jBayar   = $dbayar['TotalPembayaranPerJenis'];
                          $tagihan  = $semuaTagihan - $jBayar;
                        }
                        //$totDibayar += $jBayar;
                        $totTagihan += $tagihan;
                    }

                    $qthn = mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'");
                    if ($qthn) {
                        while ($thn = mysqli_fetch_array($qthn)){
                            $nmTahun=$thn['nmTahunAjaran'];
                            $pecah = explode("/", $nmTahun);
                            $thn_ganjil = $pecah[0];
                            $thn_genap = $pecah[1];
                        }
                    }
              
                    $query = mysqli_query($koneksi,"SELECT * FROM bulan WHERE urutan='$bln1' ORDER BY urutan ASC");
                    if ($query) {
                        while ($bln = mysqli_fetch_array($query)){
                            if ($bln['urutan'] <= 6){
                                $bln_awal = $bln['nmBulan'].' '.$thn_ganjil;
                            }else{
                                $bln_awal = $bln['nmBulan'].' '.$thn_genap;
                            }
                        }
                    }
                  
                    $query = mysqli_query($koneksi,"SELECT * FROM bulan WHERE urutan='$bln2' ORDER BY urutan ASC");
                    if ($query) {
                        while ($bln = mysqli_fetch_array($query)){
                            if ($bln['urutan'] <= 6){
                                $bln_akhir = $bln['nmBulan'].' '.$thn_ganjil;
                            }else{
                                $bln_akhir = $bln['nmBulan'].' '.$thn_genap;
                            }
                        }
                    }

                    echo '<tr>
                            <td style="text-align:center">'.$no++.'</td>
                            <td style="text-align:center">'.$ds['nisSiswa'].'</td>
                            <td style="text-align:center">'.$ds['nmSiswa'].'</td>
                            <td style="text-align:center">'.$kls['nmKelas'].'</td>
                            <td style="text-align:right">'.buatRp($totTagihan).'</td>
                         </tr>';
                }
            echo '</tbody>
            </table>';
  

}else{
    include "../../login.php";
}