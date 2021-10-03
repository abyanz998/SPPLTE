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

    $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    if ($_GET['unit'] !='all'){
      $unit_sekolah = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$idUnit'"));
      $unit=$unit_sekolah['singkatanUnit'];
    }else{
      $unit = 'Semua Unit';
    }

    $file = 'Rekap Laporan (Kas Tunai) per Tanggal '.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir).'</b><br>Tahun Ajaran '.$ta['nmTahunAjaran'];
    $nama_file    =str_replace(' ', '_', $file);
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=".$nama_file.".xls");

    $saldo_awal = 0;
        $saldo_keluar = 0;
        $subtotal_penerimaan = 0;
        $subtotal_pengeluaran = 0;
        
        if ($idUnit=='all'){
            $sql_akunKas = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Tunai%' AND stdel='0' AND jenisAkun='Sub Menu 2' ORDER BY idAkun ASC");
            $sql_akunKas1 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Tunai%' AND stdel='0' AND jenisAkun='Sub Menu 2' ORDER BY idAkun ASC");
            $sql_akunKas2 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Tunai%' AND stdel='0' AND jenisAkun='Sub Menu 2' ORDER BY idAkun ASC");
        }else{
            $sql_akunKas = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Tunai%' AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnit' ORDER BY idAkun ASC");
            $sql_akunKas1 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Tunai%' AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnit' ORDER BY idAkun ASC");
            $sql_akunKas2 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Tunai%' AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnit' ORDER BY idAkun ASC");
        }
        while ($kas = mysqli_fetch_array($sql_akunKas)) {
            //SET SALDO AWAL
            $saldo_awal += ($kas['saldo_awal_debit'] - $kas['saldo_awal_kredit']);
            $saldoBulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as total FROM tagihan_bulanan LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.idAkunKas='$kas[idAkun]' AND (DATE(tagihan_bulanan.tglBayar) < '$tgl_mulai')"));
            $saldoBebas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bebas_bayar.jumlahBayar) as total FROM tagihan_bebas_bayar LEFT JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.idAkunKas='$kas[idAkun]' AND (DATE(tagihan_bebas_bayar.tglBayar) < '$tgl_mulai')"));
            $saldoKasMasuk = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalMasuk FROM kas WHERE idAkunKas='$kas[idAkun]' AND (DATE(tanggal) < '$tgl_mulai') AND stdel='0' AND jenis='Masuk' AND idTahunAjaran='$idTahunAjaran'"));
            $saldoKasKeluar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalKeluar FROM kas WHERE idAkunKas='$kas[idAkun]' AND (DATE(tanggal) < '$tgl_mulai') AND stdel='0' AND jenis='Keluar' AND idTahunAjaran='$idTahunAjaran'"));
            $saldoBayarHutang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as totalBayarKeluar FROM hutang_bayar WHERE (DATE(tanggalBayar) < '$tgl_mulai') AND stdel='0' AND keterangan='Lunas' AND idAkunKas='$kas[idAkun]'"));

            $saldo_awal += ($saldoBulanan['total'] + $saldoBebas['total'] + $saldoKasMasuk['totalMasuk']);
            $saldo_keluar += ($saldoKasKeluar['totalKeluar'] + $saldoBayarHutang['totalBayarKeluar']);
        }  

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
                                        <td>'.$unit.'</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td align="center" style="font-size: 10pt"><b>Rekap Laporan (Kas Tunai) per Tanggal '.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir).'</b><br>Tahun Ajaran '.$ta['nmTahunAjaran'].'</td>
                        </tr>
                       
                        <tr>
                            <td>
                                <h3><strong>Penerimaan</strong></h3>
                                    <div class="box-body table-responsive">
                                        <table style="font-size:8pt; font-family: arial; text-align:center" border="0" cellpadding="2" width="99%">
                                            <thead>
                                                <tr>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:25px">No.</th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:60px">Kode Akun</th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:220px">Keterangan</th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:20px"></th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Debit</th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:20px"></th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Kredit</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                               $no = 1;
                                                while ($kas = mysqli_fetch_array($sql_akunKas1)) {
                        
                                                    //tagihan bulanan
                                                    $sqlTagihanBulanan = mysqli_query($koneksi,"SELECT 
                                                              tagihan_bulanan.*,
                                                              SUM(tagihan_bulanan.jumlahTagihan) as totalBulanan,
                                                              jenis_bayar.idPosBayar, 
                                                              pos_bayar.nmPosBayar,
                                                              pos_bayar.kodeAkun
                                                              FROM tagihan_bulanan 
                                                              LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                                              LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                              WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.idAkunKas='$kas[idAkun]' AND (DATE(tagihan_bulanan.tglBayar) BETWEEN '$tgl_mulai' AND '$tgl_akhir') GROUP BY tagihan_bulanan.idJenisBayar");
                                                    while ($tbulan = mysqli_fetch_array($sqlTagihanBulanan)) {
                                                        $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tbulan[kodeAkun]'"));
                                                             
                                                        echo        '<tr>
                                                                      <td>'.$no++.'</td>
                                                                      <td>'.$akun['kodeAkun'].'</td>
                                                                      <td style="text-align:left">'.$tbulan['nmPosBayar'].'</td>
                                                                      <td>Rp.</td>
                                                                      <td>'.rupiah($tbulan['totalBulanan']).'</td>
                                                                      <td></td>
                                                                      <td align="center">-</td>
                                                                    </tr>';
                                                        $subtotal_penerimaan += $tbulan['totalBulanan'];
                                                    }

                                                     //tagihan bebas
                                                    $sqlTagihanBebas = mysqli_query($koneksi,"SELECT 
                                                                                            tagihan_bebas.*, 
                                                                                            tagihan_bebas_bayar.*,
                                                                                            SUM(tagihan_bebas_bayar.jumlahBayar) as totalBebas,                                     
                                                                                            jenis_bayar.idPosBayar, 
                                                                                            pos_bayar.nmPosBayar,
                                                                                            pos_bayar.kodeAkun
                                                                                        FROM tagihan_bebas 
                                                                                        LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas
                                                                                        LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                                                        LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                                        WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.idAkunKas='$kas[idAkun]' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$tgl_mulai' AND '$tgl_akhir')GROUP BY tagihan_bebas.idJenisBayar");
                                                    while ($tbebas = mysqli_fetch_array($sqlTagihanBebas)) {
                                                      $akun = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE idAkun='$tbebas[kodeAkun]'"));
                                                             
                                                        echo        '<tr>
                                                                      <td>'.$no++.'</td>
                                                                      <td>'.$akun['kodeAkun'].'</td>
                                                                      <td style="text-align:left">'.$tbebas['nmPosBayar'].'</td>
                                                                      <td>Rp.</td>
                                                                      <td>'.rupiah($tbebas['totalBebas']).'</td>
                                                                      <td></td>
                                                                      <td align="center">-</td>
                                                                    </tr>';
                                                        $subtotal_penerimaan += $tbebas['totalBebas'];
                                                    }

                                                    //kas masuk
                                                    $sqlKas = mysqli_query($koneksi,"SELECT kas.*, SUM(kas.total) as totalKasMasuk FROM kas WHERE idAkunKas='$kas[idAkun]' AND (DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND stdel='0' AND idTahunAjaran='$idTahunAjaran' AND jenis='Masuk' GROUP BY idKodeAkun");
                                                    while ($tkas = mysqli_fetch_array($sqlKas)) {
                                                        if ($tkas['tipe'] != 'Transfer'){
                                                            $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tkas[idKodeAkun]'"));
                                                            $keterangan = $akun['keterangan'];
                                                        }else{
                                                            $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tkas[idAkunKasTujuan]'"));
                                                            $keterangan = $tkas['keterangan'].' dari akun '.$akun['keterangan'];
                                                        }
                                                          
                                                        echo    '<tr>
                                                                    <td>'.$no++.'</td>
                                                                    <td>'.$akun['kodeAkun'].'</td>
                                                                    <td style="text-align:left">'.$keterangan.'</td>
                                                                    <td>Rp.</td>
                                                                    <td>'.rupiah($tkas['totalKasMasuk']).'</td>
                                                                    <td></td>
                                                                    <td align="center">-</td>
                                                                  </tr>';
                                                        $subtotal_penerimaan += $tkas['totalKasMasuk'];
                                                    }
                                                }

                echo                   '</tbody>
                                            <tfoot>
                                                <tr style="background-color: #f0f0f0; font-weight:bold">
                                                    <td colspan="3" style="text-align:left">Jumlah</td>
                                                    <td>Rp.</td>
                                                    <td>'.rupiah($subtotal_penerimaan).'</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                    </table>
                                </div>

                                <h3><strong>Pengeluaran</strong></h3>
                                    <div class="box-body table-responsive">
                                        <table style="font-size:8pt; font-family: arial; text-align:center" border="0" cellpadding="2" width="99%">
                                            <thead>
                                                <tr>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:25px">No.</th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:60px">Kode Akun</th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:220px">Keterangan</th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:20px"></th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Debit</th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:20px"></th>
                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Kredit</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                                $no = 1;
                                                while ($kas = mysqli_fetch_array($sql_akunKas2)) {
                                                //kas Keluar
                                                    $sqlKas = mysqli_query($koneksi,"SELECT kas.*, SUM(kas.total) as totalKasKeluar FROM kas WHERE idAkunKas='$kas[idAkun]' AND (DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND stdel='0' AND idTahunAjaran='$idTahunAjaran' AND jenis='Keluar' GROUP BY idKodeAkun");
                                                    while ($tkas = mysqli_fetch_array($sqlKas)) {
                                                        if ($tkas['tipe'] != 'Transfer'){
                                                            $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tkas[idKodeAkun]'"));
                                                            $keterangan = $akun['keterangan'];
                                                        }else{
                                                            $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tkas[idAkunKasTujuan]'"));
                                                            $keterangan = $tkas['keterangan'].' ke akun '.$akun['keterangan'];
                                                        }
                                                      
                                                        echo    '<tr>
                                                                    <td>'.$no++.'</td>
                                                                    <td>'.$akun['kodeAkun'].'</td>
                                                                    <td style="text-align:left">'.$keterangan.'</td>
                                                                    <td></td>
                                                                    <td align="center">-</td>
                                                                    <td>Rp.</td>
                                                                    <td>'.rupiah($tkas['totalKasKeluar']).'</td>
                                                                  </tr>';
                                                        $subtotal_pengeluaran += $tkas['totalKasKeluar'];
                                                    }

                                                    //bayar hutang
                                                    $sqlHutang = mysqli_query($koneksi,"SELECT hutang_bayar.*,SUM(hutang_bayar.nominal) as totalBayarHutang, hutang_setting_detail.idPegawai, pegawai.namaPegawai,hutang_setting.idPosHutang, hutang_pos.idAkunHutang FROM hutang_bayar LEFT JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang LEFT JOIN pegawai ON hutang_setting_detail.idPegawai=pegawai.idPegawai LEFT JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang LEFT JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.idAkunKas='$kas[idAkun]' AND (DATE(hutang_bayar.tanggalBayar) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND hutang_bayar.stdel='0' AND hutang_setting.idTahunAjaran='$idTahunAjaran' AND hutang_bayar.keterangan='Lunas' GROUP BY hutang_pos.idAkunHutang");
                                                    while ($tHutang = mysqli_fetch_array($sqlHutang)) {
                                                    $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tHutang[idAkunHutang]'"));

                                                        echo    '<tr>
                                                                    <td>'.$no++.'</td>
                                                                    <td>'.$akun['kodeAkun'].'</td>
                                                                    <td style="text-align:left">'.$akun['keterangan'].'</td>
                                                                    <td></td>
                                                                    <td align="center">-</td>
                                                                    <td>Rp.</td>
                                                                    <td>'.rupiah($tHutang['totalBayarHutang']).'</td>
                                                                  </tr>';

                                                        $subtotal_pengeluaran += $tHutang['totalBayarHutang'];
                                                    }

                                                }

                echo'                   </tbody>
                                            <tfoot>
                                                <tr style="background-color: #f0f0f0; font-weight:bold">
                                                    <td colspan="3" style="text-align:left">Jumlah</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Rp.</td>
                                                    <td>'.rupiah($subtotal_pengeluaran).'</td>
                                                </tr>
                                            </tfoot>
                                    </table>
                                </div>';

                    
            echo'       </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td>
                                <table style="font-size:8pt; text-align:center" border="0">
                                    <tr>
                                        <td style="width:215px"></td>
                                        <td></td>
                                        <th style="width:10px"></th>
                                        <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:20px"></th>
                                        <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Debit</th>
                                        <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:20px"></th>
                                        <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Kredit</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td style="font-weight:bold; text-align:left">Sub Total :</td>
                                        <td>Rp.</td>
                                        <td>'.rupiah($subtotal_penerimaan).'</td>
                                        <td>Rp.</td>
                                        <td>'.rupiah($subtotal_pengeluaran).'</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td style="font-weight:bold; text-align:left">Saldo Awal :</td>
                                        <td>Rp.</td>
                                        <td>'.rupiah($saldo_awal).'</td>
                                        <td></td>
                                        <td align="center">-</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td style="font-weight:bold; text-align:left">Total :</td>
                                        <td>Rp.</td>
                                        <td>'.rupiah($subtotal_penerimaan + $saldo_awal).'</td>
                                        <td>Rp.</td>
                                        <td>'.rupiah($saldo_keluar + $subtotal_pengeluaran).'</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td style="font-weight:bold; text-align:left">Saldo Akhir :</td>
                                        <td>Rp.</td>
                                        <td>'.rupiah($subtotal_penerimaan + $saldo_awal - $subtotal_pengeluaran - $saldo_keluar).'</td>
                                        <td></td>
                                        <td align="center">-</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td>
                                <table border="0" style="font-size:8pt">
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="4" align="center">'.$idt['kabupaten'].', '.tgl_raport(date('Y-m-d')).'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="4" align="center">Bendahara</td>
                                    </tr>
                                    <tr><td colspan="7"></td></tr>
                                    <tr><td colspan="7"></td></tr>
                                    <tr><td colspan="7"></td></tr>
                                    <tr><td colspan="7"></td></tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="4" align="center" style="font-weight:bold;">'.$idt['nmBendahara'].'</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="4" align="center">Nip. '.$idt['nipBendahara'].'</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>';

}else{
    include "../../login.php";
}