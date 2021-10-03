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

    $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
        
    $tgl_mulai = $_GET['tgl_mulai'];
    $tgl_akhir = $_GET['tgl_akhir'];
    $idTahunAjaran = $_GET['thn_ajar'];
    $idUnit = $_GET['unit'];
    $idKelas = $_GET['kelas'];
    $idKamar = $_GET['kamar'];

    $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    $unit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$idUnit'"));
    if ($idKelas !='all'){
      $kls = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));
      $kelas=$kls['nmKelas'];
    }else{
      $kelas = 'Semua Kelas';
    }
    if ($idKamar !='all'){
      $kmr = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kamar WHERE idKamar='$idKamar'"));
      $kamar=$kmr['namaKamar'];
    }else{
      $kamar = 'Semua Kamar';
    }

    $file = 'Laporan Kesehatan Kelas '.$kelas.' Kamar '.$kamar.' Tanggal'.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir).'Tahun Ajaran '.$ta['nmTahunAjaran'];
    $nama_file    =str_replace(' ', '_', $file);
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=".$nama_file.".xls");

            echo '<table border="0" cellpadding="2px">
                        <tr>
                            <td style="font-weight: bold; font-size: 14pt" colspan="7">'.$idt['nmSekolah'].'</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;" colspan="7">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</td>
                        </tr>
                    </table><br>';

            echo '<table style="font-size: 8pt" cellpadding="1" border="0">
                        <tr>
                            <td style=" font-size: 8pt">
                                <table align="left">
                                    <tr>
                                        <td width="70px">Unit Sekolah :</td>
                                        <td>'.$unit['singkatanUnit'].'</td>
                                    </tr>
                                    <tr>
                                        <td width="70px">Kelas :</td>
                                        <td>'.$kelas.'</td>
                                    </tr>
                                    <tr>
                                        <td width="70px">Kamar :</td>
                                        <td>'.$kamar.'</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td align="center" style="font-size: 10pt"><b>Laporan Kesehatan per Tanggal '.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir).'</b><br>Tahun Ajaran '.$ta['nmTahunAjaran'].'</td>
                        </tr>
                        <tr><td></td></tr>';
                echo    '<tr>
                            <td>
                                <table id="example1" border="1" class="table table-hover table-bordered dataTable no-footer text-center" style="white-space: nowrap;">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Kamar</th>
                                        <th>Sakit</th>
                                        <th>Obat</th>
                                        <th>Keterangan</th>
                                    </tr>';
                                    if ($idKelas == 'all' && $idKamar == 'all'){
                                        $sql_kesehatan = mysqli_query($koneksi,"SELECT siswa_kesehatan.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa_kesehatan LEFT JOIN siswa ON siswa_kesehatan.siswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(siswa_kesehatan.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa_kesehatan.tahunAjaran='$idTahunAjaran' AND siswa_kesehatan.stdel='0' AND siswa.unitSiswa='$idUnit' ORDER BY siswa_kesehatan.tanggal ASC");
                                    }elseif ($idKelas != 'all' && $idKamar == 'all'){
                                        $sql_kesehatan = mysqli_query($koneksi,"SELECT siswa_kesehatan.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa_kesehatan LEFT JOIN siswa ON siswa_kesehatan.siswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(siswa_kesehatan.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa_kesehatan.tahunAjaran='$idTahunAjaran' AND siswa_kesehatan.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' ORDER BY siswa_kesehatan.tanggal ASC");
                                    }elseif ($idKelas != 'all' && $idKamar == 'all'){
                                        $sql_kesehatan = mysqli_query($koneksi,"SELECT siswa_kesehatan.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa_kesehatan LEFT JOIN siswa ON siswa_kesehatan.siswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(siswa_kesehatan.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa_kesehatan.tahunAjaran='$idTahunAjaran' AND siswa_kesehatan.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kamarSiswa='$idKamar' ORDER BY siswa_kesehatan.tanggal ASC");
                                    }else{
                                        $sql_kesehatan = mysqli_query($koneksi,"SELECT siswa_kesehatan.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa_kesehatan LEFT JOIN siswa ON siswa_kesehatan.siswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(siswa_kesehatan.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa_kesehatan.tahunAjaran='$idTahunAjaran' AND siswa_kesehatan.stdel='0'  AND siswa.kelasSiswa='$idKelas' AND siswa.unitSiswa='$idUnit' AND siswa.kamarSiswa='$idKamar' ORDER BY siswa_kesehatan.tanggal ASC");
                                    }
                                    $no=1;
                                    while ($kesehatan = mysqli_fetch_array($sql_kesehatan)) {
                                        echo '<tr>
                                                  <td align="center">'.$no++.'</td>
                                                  <td align="center">'.tgl_miring($kesehatan['tanggal']).'</td>
                                                  <td align="center">'.$kesehatan['nisSiswa'].'</td>
                                                  <td align="center">'.$kesehatan['nmSiswa'].'</td>
                                                  <td align="center">'.$kesehatan['nmKelas'].'</td>
                                                  <td align="center">'.$kesehatan['namaKamar'].'</td>
                                                  <td align="center">'.$kesehatan['nmSakit'].'</td>
                                                  <td align="center">'.$kesehatan['obat'].'</td>
                                                  <td align="center">'.$kesehatan['keterangan'].'</td>
                                                </tr>';
                                    }
                echo'           </table>
                            </td>
                        </tr>';
                                
                echo'   <tr><td></td></tr>
                        <tr>
                            <td>
                                <table border="0" style="font-size:8pt">
                                    <tr>
                                        <td colspan="5"></td>
                                        <td colspan="4" align="center">'.$idt['kabupaten'].', '.tgl_raport(date('Y-m-d')).'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td colspan="4" align="center">Bendahara</td>
                                    </tr>
                                    <tr><td colspan="9"></td></tr>
                                    <tr><td colspan="9"></td></tr>
                                    <tr><td colspan="9"></td></tr>
                                    <tr><td colspan="9"></td></tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td colspan="4" align="center" style="font-weight:bold;">'.$idt['nmBendahara'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td colspan="4" align="center">Nip. '.$idt['nipBendahara'].'</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>';

}else{
    include "../../login.php";
}