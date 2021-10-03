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
    $idSiswa = $_GET['siswa'];
    
    $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));

    
    if ($idTahunAjaran != 'all'){
      $ta = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
      $tahun_ajaran .= $ta['nmTahunAjaran'];
    }else{
      $tahun_ajaran .= 'Semua Tahun Ajaran';
    }
    if ($idUnit != 'all'){
      $unt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM unit_sekolah WHERE idUnit='$idUnit'"));
      $unit_sekolah= $unt['singkatanUnit'];
    }else{
      $unit_sekolah = 'Semua Unit';
    }
    if ($idKelas != 'all'){
      $kls = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));
      $kelas_siswa = $kls['nmKelas'];
    }else{
      $kelas_siswa = 'Semua Kelas';
    }
    if ($idSiswa != 'all'){
      $sws = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE idSiswa='$idSiswa'"));
      $siswa = $sws['nmSiswa'];
    }else{
      $siswa = 'Semua Siswa';
    }

    $file = 'Laporan Tabungan T.A. '.$tahun_ajaran.' '.$unit_sekolah.' '.$kelas_siswa.' '.$siswa.' '.date('d-m-Y');
    $nama_file    =str_replace(' ', '_', $file);
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=".$nama_file.".xls");

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
                <td align="center" colspan="7">Rekap Tabungan</td>
              </tr>
           </table>';

    echo '<table style="font-size: 9pt" border="0" cellpadding="1">
            <tr>
              <td colspan="2" style="width:120px">Tahun Ajaran</td>
              <td >: '.$tahun_ajaran.'</td>
            </tr>
            <tr>
              <td colspan="2" style="width:120px">Unit</td>
              <td>: '.$unit_sekolah.'</td>
            </tr>
              <tr>
                  <td colspan="2" style="width:120px">Kelas</td>
                  <td>: '.$kelas_siswa.'</td>
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
                    <th style="font-weight:bold; width:100px">Nama</th>
                    <th style="font-weight:bold; width:100px">Kelas</th>
                    <th style="font-weight:bold; width:100px">Debit</th>
                    <th style="font-weight:bold; width:100px">Kredit</th>
                    <th style="font-weight:bold; width:100px">Saldo</th>
                  </tr>
                  </thead>
                  <tbody>';
                    $no = 1;
                    if ($idTahunAjaran=='all'){
                      if ($idUnit != ''){
                        if ($idKelas == 'all' OR $idKelas == ''){
                          $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND siswa.unitSiswa='$idUnit' GROUP BY tabungan_siswa.siswa");
                        }else{
                          if ($idSiswa == 'all' OR $idSiswa == ''){
                            $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' GROUP BY tabungan_siswa.siswa");
                          }else{
                            $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' AND tabungan_siswa.siswa='$idSiswa' GROUP BY tabungan_siswa.siswa");
                          }
                        }
                      }else{
                        $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' GROUP BY tabungan_siswa.siswa");
                      }
                    }else{
                      if ($idUnit != ''){
                        if ($idKelas == 'all' OR $idKelas == ''){
                          $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND tahunAjaran='$idTahunAjaran' AND siswa.unitSiswa='$idUnit' GROUP BY tabungan_siswa.siswa");
                        }else{
                          if ($idSiswa == 'all' OR $idSiswa == ''){
                            $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND tahunAjaran='$idTahunAjaran' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' GROUP BY tabungan_siswa.siswa");
                          }else{
                            $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND tahunAjaran='$idTahunAjaran' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' AND tabungan_siswa.siswa='$idSiswa' GROUP BY tabungan_siswa.siswa");
                          }
                        } 
                      }else{
                        $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND tahunAjaran='$idTahunAjaran' GROUP BY tabungan_siswa.siswa");
                      }
                    }
                    
                    while ($tabSiswa = mysqli_fetch_array($TabunganSiswa)) {
                      $jumlah_debit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as nominalDebit FROM tabungan_siswa WHERE siswa='$tabSiswa[idSiswa]' AND stdel='0' AND kode='SETORAN'"));
                      $jumlah_kredit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as nominalKredit FROM tabungan_siswa WHERE siswa='$tabSiswa[idSiswa]' AND stdel='0' AND kode='PENARIKAN'"));
                      $saldo = $jumlah_debit['nominalDebit'] - $jumlah_kredit['nominalKredit'];
                      echo '<tr>
                              <td>'.$no++.'</td>
                              <td>'.$tabSiswa['nisSiswa'].'</td>
                              <td>'.$tabSiswa['nmSiswa'].'</td>
                              <td>'.$tabSiswa['nmKelas'].'</td>
                              <td>'.buatRp($jumlah_debit['nominalDebit']).'</td>
                              <td>'.buatRp($jumlah_kredit['nominalKredit']).'</td>
                              <td>'.buatRp($saldo).'</td>
                            </tr>';

                    }             

        echo '    </tbody>
                </table>';

    echo '<table border="0" style="font-size:9pt">
            <tr>
              <td colspan="4"></td>
              <td  colspan="3" align="center">'.$idt['kabupaten'].', '.tgl_raport(date('Y-m-d')).'</td>
            </tr>
            <tr>
              <td colspan="4"></td>
              <td colspan="3" align="center">Bendahara</td>
            </tr>
              <tr><td colspan="7"></td></tr>
              <tr><td colspan="7"></td></tr>
              <tr><td colspan="7"></td></tr>
            <tr>
              <td colspan="4"></td>
              <td colspan="3" align="center" style="font-weight:bold;">'.$idt['nmBendahara'].'</td>
            </tr>
            <tr>
              <td colspan="4"></td>
              <td colspan="3" align="center">Nip. '.$idt['nipBendahara'].'</td>
            </tr>
          </table>';   

}else{
    include "../../login.php";
}