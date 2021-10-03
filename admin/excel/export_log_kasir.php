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
        
    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];
    $modul = $_GET['modul'];
    $users = $_GET['users'];
    if ($modul == 'all'){
      $tipeModul = 'Semua Modul';
    }else{
      $tipeModul = 'Modul '.$modul;
    }
    if ($users == 'all'){
      $tipeUsers = 'Semua Kasir';
      $nama_kasir = 'Semua Kasir';
    }else{
      $users = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM users WHERE idUsers='$users'"));
      $tipeUsers = 'Kasir '.$users['nama_lengkap'];
      $nama_kasir = $users['nama_lengkap'];
    }

    $saldo_awal = 0;
    if ($_SESSION['unit'] == '0'){
      if(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] != 'all'){
        $tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) < '$_GET[dari]') AND log_transaksi.modul='$_GET[modul]' AND log_transaksi.penulis='$_GET[users]' ORDER BY log_transaksi.idTransaksi DESC");
      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] == 'all'){
        $tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) < '$_GET[dari]') ORDER BY log_transaksi.idTransaksi DESC");
      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] == 'all'){
        $tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) < '$_GET[dari]') AND log_transaksi.modul='$_GET[modul]' ORDER BY log_transaksi.idTransaksi DESC");
      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] != 'all'){
        $tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) < '$_GET[dari]') AND log_transaksi.penulis='$_GET[users]' ORDER BY log_transaksi.idTransaksi DESC");
      }else{
        $tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers ORDER BY log_transaksi.idTransaksi DESC");
      }
    }else{
      if(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] != 'all'){
        $tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) < '$_GET[dari]') AND log_transaksi.modul='$_GET[modul]' AND log_transaksi.penulis='$_GET[users]' AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] == 'all'){
        $tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) < '$_GET[dari]')  AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] == 'all'){
        $tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) < '$_GET[dari]') AND log_transaksi.modul='$_GET[modul]' AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] != 'all'){
        $tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) < '$_GET[dari]') AND log_transaksi.penulis='$_GET[users]' AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
      }else{
        $tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
      }
    } 

    while($r=mysqli_fetch_array($tampil)){
      if ($r['aksi'] == 'Bayar'){
        $saldo_awal += $r['nominal'];
      }elseif ($r['aksi'] == 'Hapus'){
        $saldo_awal -= $r['nominal'];
      }elseif ($r['aksi'] == 'Simpan Transaksi'){
        $saldo_awal += $r['nominal'];
      }elseif ($r['aksi'] == 'Hapus Transaksi'){
        $saldo_awal -= $r['nominal'];
      }
    }

    $file = 'Laporan Kasir '.$users['nama_lengkap'].' Dari Tanggal '.tgl_raport($dari).' Sampai Tanggal '.tgl_raport($sampai).' '.$tipeModul.' '.$tipeUsers;
    $nama_file    =str_replace(' ', '_', $file);
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=".$nama_file.".xls");


            echo '<table border="0" cellpadding="2px">
                        <tr>
                            <td style="font-weight: bold; font-size: 14pt" colspan="8">'.$idt['nmSekolah'].'</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;" colspan="8">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</td>
                        </tr>
                    </table><br>';

            echo '<table style="font-size: 8pt" cellpadding="1" border="0">
                        <tr>
                            <td align="center" style="font-size: 10pt"><b>LAPORAN KASIR : '.strtoupper($nama_kasir).'</td>
                        </tr>
                        <tr>
                            <td align="center" style="font-size: 10pt"><b>Periode : '.tgl_raport($dari).' s.d '.tgl_raport($sampai).'</td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td>
                              <div class="box-body table-responsive">
                                <table style="font-size:8pt; font-family: arial; text-align:center" border="1" cellpadding="2">
                                  <thead>
                                    <tr>
                                      <th style="font-weight:bold">No</th>
                                      <th style="font-weight:bold">Tanggal</th>
                                      <th style="font-weight:bold">Kode Akun</th>
                                      <th style="font-weight:bold">Keterangan Akun</th>
                                      <th style="font-weight:bold">Uraian</th>
                                      <th style="font-weight:bold">No. Ref</th>
                                      <th style="font-weight:bold">Masuk</th>
                                      <th style="font-weight:bold">Keluar</th>
                                    </tr>
                                  </thead>
                                  <tbody>';
                                    if ($_SESSION['unit'] == '0'){
                                      if(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] != 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_transaksi.modul='$_GET[modul]' AND log_transaksi.penulis='$_GET[users]' ORDER BY log_transaksi.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] == 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') ORDER BY log_transaksi.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] == 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_transaksi.modul='$_GET[modul]' ORDER BY log_transaksi.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] != 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_transaksi.penulis='$_GET[users]' ORDER BY log_transaksi.idTransaksi DESC");
                                      }else{
                                        $query = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers ORDER BY log_transaksi.idTransaksi DESC");
                                      }
                                    }else{
                                      if(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] != 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_transaksi.modul='$_GET[modul]' AND log_transaksi.penulis='$_GET[users]' AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] == 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]')  AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] == 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_transaksi.modul='$_GET[modul]' AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] != 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_transaksi.penulis='$_GET[users]' AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
                                      }else{
                                        $query = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
                                      }
                                    }
                                    $no = 1;
                                    $total_penerimaan = 0;
                                    $total_pengeluaran = 0;
                                    while($r=mysqli_fetch_array($query)){
                                      if ($r['jenisBayar'] == 'Bulanan'){
                                        $bulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bulanan.*, jenis_bayar.idPosBayar, pos_bayar.kodeAkun, akun_biaya.kodeAkun as kdAKun, akun_biaya.keterangan FROM tagihan_bulanan LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar LEFT JOIN akun_biaya ON pos_bayar.kodeAkun=akun_biaya.idAkun WHERE tagihan_bulanan.idTagihanBulanan='$r[idBayar]'"));
                                        $siswa =  mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM siswa WHERE nisSiswa='$r[nis_nip]'"));
                                        echo '<tr>
                                                <td>'.$no++.'</td>
                                                <td>'.tgl_miring(date('Y-m-d',strtotime($r['tanggal']))).'</td>
                                                <td>'.$bulanan['kdAKun'].'</td>
                                                <td>'.$bulanan['keterangan'].'</td>
                                                <td>'.$siswa['nmSiswa'].' ('.$siswa['nisSiswa'].') '.$r['title'].'</td>
                                                <td>'.$r['noRefrensi'].'</td>';
                                                if ($r['aksi'] == 'Bayar'){
                                                  echo '<td>'.buatRp($r['nominal']).'</td>
                                                        <td align="center">-</td>';
                                                  $total_penerimaan += $r['nominal'];
                                                }elseif ($r['aksi'] == 'Hapus'){
                                                  echo '<td align="center">-</td>
                                                        <td>'.buatRp($r['nominal']).'</td>';
                                                  $total_pengeluaran += $r['nominal'];
                                                }
                                        echo '</tr>';
                                      }elseif ($r['jenisBayar'] == 'Bebas'){
                                        $bebas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*, jenis_bayar.idPosBayar, pos_bayar.kodeAkun, akun_biaya.kodeAkun as kdAKun, akun_biaya.keterangan FROM tagihan_bebas LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar LEFT JOIN akun_biaya ON pos_bayar.kodeAkun=akun_biaya.idAkun WHERE tagihan_bebas.idTagihanBebas='$r[idBayar]'"));
                                        $siswa =  mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM siswa WHERE nisSiswa='$r[nis_nip]'"));
                                        echo '<tr>
                                                <td>'.$no++.'</td>
                                                <td>'.tgl_miring(date('Y-m-d',strtotime($r['tanggal']))).'</td>
                                                <td>'.$bebas['kdAKun'].'</td>
                                                <td>'.$bebas['keterangan'].'</td>
                                                <td>'.$siswa['nmSiswa'].' ('.$siswa['nisSiswa'].') '.$r['title'].'</td>
                                                <td>'.$r['noRefrensi'].'</td>';
                                                if ($r['aksi'] == 'Bayar'){
                                                  echo '<td>'.buatRp($r['nominal']).'</td>
                                                        <td align="center">-</td>';
                                                  $total_penerimaan += $r['nominal'];
                                                }elseif ($r['aksi'] == 'Hapus'){
                                                  echo '<td align="center">-</td>
                                                        <td>'.buatRp($r['nominal']).'</td>';
                                                  $total_pengeluaran += $r['nominal'];
                                                }
                                        echo '</tr>';
                                      }elseif ($r['jenisBayar'] == 'Gaji'){
                                        $gaji = mysqli_fetch_array(mysqli_query($koneksi,"SELECT pegawai_gaji_slip.*, pegawai_gaji.idAKunGaji, akun_biaya.kodeAkun as kdAKun, akun_biaya.keterangan FROM pegawai_gaji_slip LEFT JOIN pegawai_gaji ON pegawai_gaji.idGaji=pegawai_gaji.idGaji LEFT JOIN akun_biaya ON pegawai_gaji.idAKunGaji=akun_biaya.idAkun WHERE pegawai_gaji_slip.idSlipGaji='$r[idBayar]'"));
                                        $pegawai =  mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM pegawai WHERE nipPegawai='$r[nis_nip]'"));
                                        echo '<tr>
                                                <td>'.$no++.'</td>
                                                <td>'.tgl_miring(date('Y-m-d',strtotime($r['tanggal']))).'</td>
                                                <td>'.$gaji['kdAKun'].'</td>
                                                <td>'.$gaji['keterangan'].'</td>
                                                <td>'.$pegawai['namaPegawai'].' ('.$pegawai['nipPegawai'].') '.$r['title'].'</td>
                                                <td>'.$r['noRefrensi'].'</td>';
                                                if ($r['aksi'] == 'Bayar'){
                                                  echo '<td align="center">-</td>
                                                        <td>'.buatRp($r['nominal']).'</td>';
                                                  $total_pengeluaran += $r['nominal'];
                                                }elseif ($r['aksi'] == 'Hapus'){
                                                  echo '<td>'.buatRp($r['nominal']).'</td>
                                                        <td align="center">-</td>';
                                                  $total_penerimaan += $r['nominal'];
                                                }
                                        echo '</tr>';
                                      }elseif ($r['jenisBayar'] == 'Kas' && $r['modul'] == 'Kas Masuk' ){
                                        $kas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT kas.*, akun_biaya.kodeAkun as kdAKun, akun_biaya.keterangan FROM kas LEFT JOIN akun_biaya ON kas.idKodeAkun=akun_biaya.idAkun WHERE kas.idKas='$r[idBayar]'"));
                                        
                                        echo '<tr>
                                                <td>'.$no++.'</td>
                                                <td>'.tgl_miring(date('Y-m-d',strtotime($r['tanggal']))).'</td>
                                                <td>'.$kas['kdAKun'].'</td>
                                                <td>'.$kas['keterangan'].'</td>
                                                <td>'.$r['title'].'</td>
                                                <td>'.$r['noRefrensi'].'</td>';
                                                if ($r['aksi'] == 'Simpan Transaksi'){
                                                  echo '<td>'.buatRp($r['nominal']).'</td>
                                                        <td align="center">-</td>';
                                                  $total_penerimaan += $r['nominal'];
                                                }elseif ($r['aksi'] == 'Hapus Transaksi'){
                                                  echo '<td align="center">-</td>
                                                        <td>'.buatRp($r['nominal']).'</td>';
                                                  $total_pengeluaran += $r['nominal'];
                                                }
                                        echo '</tr>';
                                      }elseif ($r['jenisBayar'] == 'Kas' && $r['modul'] == 'Kas Keluar' ){
                                        $kas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT kas.*, akun_biaya.kodeAkun as kdAKun, akun_biaya.keterangan FROM kas LEFT JOIN akun_biaya ON kas.idKodeAkun=akun_biaya.idAkun WHERE kas.idKas='$r[idBayar]'"));
                                        
                                        echo '<tr>
                                                <td>'.$no++.'</td>
                                                <td>'.tgl_miring(date('Y-m-d',strtotime($r['tanggal']))).'</td>
                                                <td>'.$kas['kdAKun'].'</td>
                                                <td>'.$kas['keterangan'].'</td>
                                                <td>'.$r['title'].'</td>
                                                <td>'.$r['noRefrensi'].'</td>';
                                                if ($r['aksi'] == 'Simpan Transaksi'){
                                                  echo '<td>-</td>
                                                        <td align="center">'.buatRp($r['nominal']).'</td>';
                                                  $total_pengeluaran += $r['nominal'];
                                                }elseif ($r['aksi'] == 'Hapus Transaksi'){
                                                  echo '<td>'.buatRp($r['nominal']).'</td>
                                                        <td align="center">-</td>';
                                                  $total_penerimaan += $r['nominal'];
                                                }
                                        echo '</tr>';
                                      }
                                    
                                    }
            echo'                 
                                    <tr>
                                      <th colspan="5"></th>
                                      <th align="right">Sub Total</th>
                                      <th>'.buatRp($total_penerimaan).'</th>
                                      <th>'.buatRp($total_pengeluaran).'</th>
                                    </tr>
                                    <tr><td colspan="8"></td></tr>
                                    <tr>
                                      <th colspan="5"></th>
                                      <th align="right">Saldo Awal</th>
                                      <th colspan="2">'.buatRp($saldo_awal).'</th>
                                    </tr>
                                    <tr>
                                      <th colspan="5"></th>
                                      <th align="right">Total (Masuk + Keluar)</th>
                                      <th colspan="2">'.buatRp($total_penerimaan - $total_pengeluaran).'</th>
                                    </tr>
                                    <tr>
                                      <th colspan="5"></th>
                                      <th align="right">Saldo Akhir</th>
                                      <th colspan="2">'.buatRp($saldo_awal + ($total_penerimaan - $total_pengeluaran)).'</th>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>';
            echo'           </td>
                        </tr>
                      </table>';

}else{
    include "../../login.php";
}