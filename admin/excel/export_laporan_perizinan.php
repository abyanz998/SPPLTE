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
    $kategori = $_GET['kategori'];
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

    $file = 'Laporan Perizinan '.$kategori.' Kelas '.$kelas.' Kamar '.$kamar.' Tanggal'.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir).'Tahun Ajaran '.$ta['nmTahunAjaran'];
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
                                        <td width="70px">Kategori :</td>
                                        <td>'.$kategori.'</td>
                                    </tr>
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
                            <td align="center" style="font-size: 10pt"><b>Laporan Perizinan per Tanggal '.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir).'</b><br>Tahun Ajaran '.$ta['nmTahunAjaran'].'</td>
                        </tr>
                        <tr><td></td></tr>';
                echo    '<tr>
                            <td>';
                                if ($kategori == 'Pulang Kerumah'){
                                    echo '<table id="example1" class="table table-hover table-bordered dataTable no-footer text-center" style="white-space: nowrap;" border="1">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>NIS</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Kamar</th>
                                                <th>Penjemput</th>
                                                <th>Waktu Izin</th>
                                                <th>Keterangan</th>
                                            </tr>';
                                            if ($idKelas == 'all' && $idKamar == 'all'){
                                                $sql_izin = mysqli_query($koneksi,"SELECT izin_pulang.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_pulang LEFT JOIN siswa ON izin_pulang.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_pulang.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_pulang.idTahunAjaran='$idTahunAjaran' AND izin_pulang.stdel='0' AND siswa.unitSiswa='$idUnit' ORDER BY izin_pulang.tanggal ASC");
                                            }elseif ($idKelas != 'all' && $idKamar == 'all'){
                                                $sql_izin = mysqli_query($koneksi,"SELECT izin_pulang.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_pulang LEFT JOIN siswa ON izin_pulang.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_pulang.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_pulang.idTahunAjaran='$idTahunAjaran' AND izin_pulang.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' ORDER BY izin_pulang.tanggal ASC");
                                            }elseif ($idKelas != 'all' && $idKamar == 'all'){
                                                $sql_izin = mysqli_query($koneksi,"SELECT izin_pulang.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_pulang LEFT JOIN siswa ON izin_pulang.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_pulang.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_pulang.idTahunAjaran='$idTahunAjaran' AND izin_pulang.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kamarSiswa='$idKamar' ORDER BY izin_pulang.tanggal ASC");
                                            }else{
                                                $sql_izin = mysqli_query($koneksi,"SELECT izin_pulang.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_pulang LEFT JOIN siswa ON izin_pulang.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_pulang.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_pulang.idTahunAjaran='$idTahunAjaran' AND izin_pulang.stdel='0'  AND siswa.kelasSiswa='$idKelas' AND siswa.unitSiswa='$idUnit' AND siswa.kamarSiswa='$idKamar' ORDER BY izin_pulang.tanggal ASC");
                                            }
                                            $no=1;
                                            while ($izin = mysqli_fetch_array($sql_izin)) {
                                            echo '<tr>
                                                    <td align="center">'.$no++.'</td>
                                                    <td align="center">'.tgl_miring($izin['tanggal']).'</td>
                                                    <td align="center">'.$izin['nisSiswa'].'</td>
                                                    <td align="center">'.$izin['nmSiswa'].'</td>
                                                    <td align="center">'.$izin['nmKelas'].'</td>
                                                    <td align="center">'.$izin['namaKamar'].'</td>
                                                    <td align="center">'.$izin['penjemput'].'</td>
                                                    <td align="center">'.$izin['waktuIzin'].' Hari</td>
                                                    <td align="center">'.$izin['keterangan'].'</td>
                                                   </tr>';
                                              }
                                    echo '</table>';
               
                                }elseif ($kategori == 'Keluar Pesantren'){
                                    echo '<table id="example1" class="table table-hover table-bordered dataTable no-footer text-center" style="white-space: nowrap;" border="1">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>NIS</th>
                                                <th>Nama Siswa</th>
                                                <th>Kelas</th>
                                                <th>Kamar</th>
                                                <th>Jam Keluar</th>
                                                <th>Jam Kembali</th>
                                                <th>Keterangan</th>
                                            </tr>';
                                            if ($idKelas == 'all' && $idKamar == 'all'){
                                                $sql_izin = mysqli_query($koneksi,"SELECT izin_keluar.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_keluar LEFT JOIN siswa ON izin_keluar.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_pulang.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_keluar.idTahunAjaran='$idTahunAjaran' AND izin_keluar.stdel='0' AND siswa.unitSiswa='$idUnit' ORDER BY izin_keluar.tanggal ASC");
                                            }elseif ($idKelas != 'all' && $idKamar == 'all'){
                                                $sql_izin = mysqli_query($koneksi,"SELECT izin_keluar.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_keluar LEFT JOIN siswa ON izin_pulang.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_keluar.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_keluar.idTahunAjaran='$idTahunAjaran' AND izin_keluar.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' ORDER BY izin_keluar.tanggal ASC");
                                            }elseif ($idKelas != 'all' && $idKamar == 'all'){
                                                $sql_izin = mysqli_query($koneksi,"SELECT izin_keluar.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_keluar LEFT JOIN siswa ON izin_keluar.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_keluar.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_keluar.idTahunAjaran='$idTahunAjaran' AND izin_keluar.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kamarSiswa='$idKamar' ORDER BY izin_keluar.tanggal ASC");
                                            }else{
                                                $sql_izin = mysqli_query($koneksi,"SELECT izin_keluar.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_keluar LEFT JOIN siswa ON izin_keluar.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_keluar.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_keluar.idTahunAjaran='$idTahunAjaran' AND izin_keluar.stdel='0'  AND siswa.kelasSiswa='$idKelas' AND siswa.unitSiswa='$idUnit' AND siswa.kamarSiswa='$idKamar' ORDER BY izin_keluar.tanggal ASC");
                                            }
                                            $no=1;
                                            while ($izin = mysqli_fetch_array($sql_izin)) {
                                                echo '<tr>
                                                        <td align="center">'.$no++.'</td>
                                                        <td align="center">'.tgl_miring($izin['tanggal']).'</td>
                                                        <td align="center">'.$izin['nisSiswa'].'</td>
                                                        <td align="center">'.$izin['nmSiswa'].'</td>
                                                        <td align="center">'.$izin['nmKelas'].'</td>
                                                        <td align="center">'.$izin['namaKamar'].'</td>
                                                        <td align="center">'.$izin['penjemput'].'</td>
                                                        <td align="center">'.$izin['waktuIzin'].' Hari</td>
                                                        <td align="center">'.$izin['keterangan'].'</td>
                                                      </tr>';
                                               
                                            }
                                    echo '</table>';
                                }
                echo'       </td>
                        </tr>';
                                
                echo'   <tr><td></td></tr>
                        <tr>
                            <td>
                                <table border="0" style="font-size:8pt">
                                    <tr>
                                        <td colspan="6"></td>
                                        <td colspan="4" align="center">'.$idt['kabupaten'].', '.tgl_raport(date('Y-m-d')).'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td colspan="4" align="center">Bendahara</td>
                                    </tr>
                                    <tr><td colspan="10"></td></tr>
                                    <tr><td colspan="10"></td></tr>
                                    <tr><td colspan="10"></td></tr>
                                    <tr><td colspan="10"></td></tr>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td colspan="4" align="center" style="font-weight:bold;">'.$idt['nmBendahara'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td colspan="4" align="center">Nip. '.$idt['nipBendahara'].'</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>';

}else{
    include "../../login.php";
}