<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/rupiah.php";
    include "../../config/library.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/variabel_default.php";
    require_once('../../plugins/tcpdf/tcpdf.php');

     if (isset($_SESSION['idUsers'])){
        $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
        
        $bulan1 = $_GET['bulan1'];
        $bulan2 = $_GET['bulan2'];
        $idTahunAjaran = $_GET['thn_ajar'];
        $idUnit = $_GET['unit'];

        $bln1=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM bulan WHERE urutan='$bulan1'"));
        $bln2=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM bulan WHERE urutan='$bulan2'"));
        $thn_ajar=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));

        if ($_GET['unit'] !='all'){
          $unit_sekolah = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$idUnit'"));
          $unit=$unit_sekolah['singkatanUnit'];
        }else{
          $unit = 'Semua Unit';
        }
        

            //konfigurasi TCPDF
            $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->setMargins(5,5,5,5);
            //menambahkan halaman
            $pdf->AddPage();
            //setting title
            $pdf->SetTitle('Laporan Neraca '.$unit.' per Bulan '.$bln1['nmBulan'].' Sampai '.$bln2['nmBulan'].' Tahun Ajaran '.$thn_ajar['nmTahunAjaran']);
            //isi pdf
            $html ='<table border="0" cellpadding="2px">
                        <tr>
                            <td style="font-weight: bold; font-size: 14pt">'.$idt['nmSekolah'].'</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</td>
                        </tr>
                        <tr>
                            <td><hr style="height:1px"></td>
                        </tr>
                        
                    </table><br>';
            $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');

            $html = '<table style="font-size: 8pt" cellpadding="2" border="0">
                        <tr>
                            <td style=" font-size: 8pt">
                                <table align="left">
                                    <tr>
                                        <td width="70px">Unit Sekolah</td>
                                        <td width="15px">:</td>
                                        <td>'.$unit.'</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td align="center" style="font-size: 8pt"><b>Laporan Neraca per Bulan '.$bln1['nmBulan'].' Sampai '.$bln2['nmBulan'].'</b><br>Tahun Ajaran '.$thn_ajar['nmTahunAjaran'].'</td>
                        </tr>
                        <tr><td></td></tr>
                        <tr style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">
                            <td width="49.5%" align="center" style="border-top:0.5px solid black; border-bottom:0.5px solid black;">AKTIVA</td>
                            <td width="49.5%" align="center" style="border-top:0.5px solid black; border-bottom:0.5px solid black;">PASSIVA</td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td width="49.5%">
                                <table border="0" cellpadding="2">
                                    <tbody>
                                        <tr>
                                            <th colspan="3" style="font-weight:bold; border-bottom:0.5px solid black;">KAS</th>
                                        </tr>';
                                            $subtotal_kas = 0;
                                            if ($idUnit == 'all'){
                                                $akun_biaya_KAS = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Kas%' ORDER BY kodeAkun ASC");
                                            }else{
                                                $akun_biaya_KAS = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$idUnit' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Kas%' ORDER BY kodeAkun ASC");
                                            }
                                            while ($kas = mysqli_fetch_array($akun_biaya_KAS)) {
                                                $saldo_kas = 0;
                                                $TBulananBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalBayar, bulan.urutan, jenis_bayar.idTahunAjaran FROM tagihan_bulanan INNER JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bulanan.idAkunKas='$kas[idAkun]' AND tagihan_bulanan.statusBayar='1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                                                $TBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*, SUM(tagihan_bebas_bayar.jumlahBayar) as totalBayar, jenis_bayar.idTahunAjaran FROM tagihan_bebas INNER JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas=tagihan_bebas_bayar.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bebas_bayar.idAkunKas='$kas[idAkun]' AND tagihan_bebas.statusBayar!='0' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                                                $TKasMasuk = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalMasuk FROM kas WHERE stdel='0' AND jenis='Masuk' AND idAkunKas='$kas[idAkun]' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) >= '$bulan1' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) <= '$bulan2' AND idTahunAjaran='$idTahunAjaran'"));

                                                $TKasKeluar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalKeluar FROM kas WHERE stdel='0' AND jenis='Keluar' AND idAkunKas='$kas[idAkun]' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) >= '$bulan1' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) <= '$bulan2' AND idTahunAjaran='$idTahunAjaran'"));

                                                $ThutangBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(hutang_bayar.nominal) as totalBayar FROM hutang_bayar INNER JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.stdel='0' AND hutang_bayar.idAkunKas='$kas[idAkun]' AND hutang_bayar.keterangan='Lunas' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) >= '$bulan1' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) <= '$bulan2' AND hutang_setting.idTahunAjaran='$idTahunAjaran'"));

                                                $saldo_kas = $TBulananBayar['totalBayar'] + $TBebasBayar['totalBayar'] + $TKasMasuk['totalMasuk'] - $TKasKeluar['totalKeluar'] - $ThutangBayar['totalBayar'];
                                                $html.= '<tr>
                                                            <td>'.$kas['kodeAkun'].'</td>
                                                            <td>'.$kas['keterangan'].'</td>
                                                            <td align="right">'.buatRp($saldo_kas).'</td>
                                                         </tr>';
                                                $subtotal_kas += $saldo_kas;
                                            }
                                $html.='<tr style="background-color: #dee0e3;">
                                          <td colspan="2"  align="left"><strong>Subtotal Kas</strong></td>
                                          <td align="right">'.buatRp($subtotal_kas).'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width="49.5%">
                                <table border="0" cellpadding="2">
                                    <tbody>
                                        <tr>
                                            <th colspan="3" style="font-weight:bold; border-bottom:0.5px solid black;">HUTANG</th>
                                        </tr>';
                                            $subtotal_Hutang = 0;
                                            if ($idUnit == 'all'){
                                                $akun_hutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%2-2%' AND keterangan LIKE '%hutang%' ORDER BY kodeAkun ASC");
                                            }else{
                                                $akun_hutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$idUnit' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%2-2%' AND keterangan LIKE '%hutang%' ORDER BY kodeAkun ASC");
                                            }
                                            while ($Ahutang = mysqli_fetch_array($akun_hutang)) {
                                                $total = 0;
                                                $Thutang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(hutang_setting_detail.nominal) as totalHutang, hutang_setting.idTahunAjaran, hutang_setting.idUnit, hutang_pos.idAkunHutang FROM hutang_setting_detail INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_setting_detail.stdel='0' AND hutang_setting.idTahunAjaran='$idTahunAjaran' AND hutang_pos.idAkunHutang='$Ahutang[idAkun]'"));
                                            
                                                $ThutangBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT  SUM(hutang_bayar.nominal) as totalBayarHutang FROM hutang_bayar INNER JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.stdel='0' AND hutang_pos.idAkunHutang='$Ahutang[idAkun]' AND hutang_bayar.keterangan='Lunas' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) >= '$bulan1' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) <= '$bulan2'  AND hutang_setting.idTahunAjaran='$idTahunAjaran'"));
                                                $total = $Thutang['totalHutang'] - $ThutangBayar['totalBayarHutang'];
                                                $html.= '<tr>
                                                            <td>'.$Ahutang['kodeAkun'].'</td>
                                                            <td>'.$Ahutang['keterangan'].'</td>
                                                            <td align="right">'.buatRp($total).'</td>
                                                         </tr>';
                                                $subtotal_Hutang += $total;
                                            }
                                
                                $html.='<tr style="background-color: #dee0e3;">
                                          <td colspan="2" align="left"><strong>Subtotal Hutang</strong></td>
                                          <td align="right">'.buatRp($subtotal_Hutang).'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td width="49.5%">
                                <table border="0" cellpadding="2">
                                    <tbody>
                                        <tr>
                                            <th colspan="3" style="font-weight:bold; border-bottom:0.5px solid black;">PIUTANG</th>
                                        </tr>';
                                            $subtotal_piutang = 0;
                                            if ($idUnit == 'all'){
                                                $akun_piutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Piutang%' ORDER BY kodeAkun ASC");
                                            }else{
                                                $akun_piutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$idUnit' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Piutang%' ORDER BY kodeAkun ASC");
                                            }
                                            while ($piutang = mysqli_fetch_array($akun_piutang)) {
                                                $saldo_piutang = 0;
                                                $TBulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalTagihan, jenis_bayar.idPosBayar FROM tagihan_bulanan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));
                                                $TBulananBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalBayar, jenis_bayar.idPosBayar FROM tagihan_bulanan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                                                $TBebas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bebas.totalTagihan) as totalTagihan, jenis_bayar.idPosBayar FROM tagihan_bebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                                                $TBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*, SUM(tagihan_bebas_bayar.jumlahBayar) as totalBayar, jenis_bayar.idPosBayar FROM tagihan_bebas INNER JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas=tagihan_bebas_bayar.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                                                $saldo_piutang = ($TBulanan['totalTagihan'] - $TBulananBayar['totalBayar']) + ($TBebas['totalTagihan'] - $TBebasBayar['totalBayar']);
                                                $html.= '<tr>
                                                            <td>'.$piutang['kodeAkun'].'</td>
                                                            <td>'.$piutang['keterangan'].'</td>
                                                            <td align="right">'.buatRp($saldo_piutang).'</td>
                                                         </tr>';
                                                $subtotal_piutang += $saldo_piutang;
                                            }
                                $html.='<tr style="background-color: #dee0e3;">
                                          <td colspan="2"  align="left"><strong>Subtotal Piutang</strong></td>
                                          <td align="right">'.buatRp($subtotal_piutang).'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width="49.5%">
                                <table border="0" cellpadding="2">
                                    <tbody>
                                        <tr>
                                            <th colspan="3" style="font-weight:bold; border-bottom:0.5px solid black;">MODAL</th>
                                        </tr>';
                                            $subtotal_modal = 0;
                                            if ($idUnit == 'all'){
                                                $akun_modal = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%3-3%' AND keterangan LIKE '%Modal%' ORDER BY kodeAkun ASC");
                                            }else{
                                                $akun_modal = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$idUnit' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%3-3%' AND keterangan LIKE '%Modal%' ORDER BY kodeAkun ASC");
                                            }
                                            while ($modal = mysqli_fetch_array($akun_modal)) {

                                                $saldo_modal = 0;
                                                //hitung untuk kas
                                                $akun_biaya_KAS = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$modal[unitSekolah]' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Kas%' ORDER BY kodeAkun ASC");
                                                $saldo_kas = 0;
                                                while ($kas = mysqli_fetch_array($akun_biaya_KAS)) {
                                                    $TBulananBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalBayar, bulan.urutan, jenis_bayar.idTahunAjaran FROM tagihan_bulanan INNER JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bulanan.idAkunKas='$kas[idAkun]' AND tagihan_bulanan.statusBayar='1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                                                    $TBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*, SUM(tagihan_bebas_bayar.jumlahBayar) as totalBayar, jenis_bayar.idTahunAjaran FROM tagihan_bebas INNER JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas=tagihan_bebas_bayar.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bebas_bayar.idAkunKas='$kas[idAkun]' AND tagihan_bebas.statusBayar!='0' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                                                    $TKasMasuk = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalMasuk FROM kas WHERE stdel='0' AND jenis='Masuk' AND idAkunKas='$kas[idAkun]' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) >= '$bulan1' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) <= '$bulan2' AND idTahunAjaran='$idTahunAjaran'"));

                                                    $TKasKeluar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalKeluar FROM kas WHERE stdel='0' AND jenis='Keluar' AND idAkunKas='$kas[idAkun]' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) >= '$bulan1' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) <= '$bulan2' AND idTahunAjaran='$idTahunAjaran'"));

                                                    $ThutangBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(hutang_bayar.nominal) as totalBayar FROM hutang_bayar INNER JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.stdel='0' AND hutang_bayar.idAkunKas='$kas[idAkun]' AND hutang_bayar.keterangan='Lunas' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) >= '$bulan1' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) <= '$bulan2' AND hutang_setting.idTahunAjaran='$idTahunAjaran'"));

                                                    $saldo_kas += $TBulananBayar['totalBayar'] + $TBebasBayar['totalBayar'] + $TKasMasuk['totalMasuk'] - $TKasKeluar['totalKeluar'] - $ThutangBayar['totalBayar'];
                                                }

                                                //hitung piutang
                                                $akun_piutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$modal[unitSekolah]' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Piutang%' ORDER BY kodeAkun ASC");
                                                $saldo_piutang = 0;
                                                while ($piutang = mysqli_fetch_array($akun_piutang)) {
                                                    $TBulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalTagihan, jenis_bayar.idPosBayar FROM tagihan_bulanan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));
                                                    $TBulananBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalBayar, jenis_bayar.idPosBayar FROM tagihan_bulanan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                                                    $TBebas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bebas.totalTagihan) as totalTagihan, jenis_bayar.idPosBayar FROM tagihan_bebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                                                    $TBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*, SUM(tagihan_bebas_bayar.jumlahBayar) as totalBayar, jenis_bayar.idPosBayar FROM tagihan_bebas INNER JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas=tagihan_bebas_bayar.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                                                    $saldo_piutang += ($TBulanan['totalTagihan'] - $TBulananBayar['totalBayar']) + ($TBebas['totalTagihan'] - $TBebasBayar['totalBayar']);
                                                }

                                                //hitung Hutang
                                                $akun_hutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$modal[unitSekolah]' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%2-2%' AND keterangan LIKE '%hutang%' ORDER BY kodeAkun ASC");
                                                $total_hutang = 0;
                                                while ($Ahutang = mysqli_fetch_array($akun_hutang)) {
                                                    $Thutang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(hutang_setting_detail.nominal) as totalHutang, hutang_setting.idTahunAjaran, hutang_setting.idUnit, hutang_pos.idAkunHutang FROM hutang_setting_detail INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_setting_detail.stdel='0' AND hutang_setting.idTahunAjaran='$idTahunAjaran' AND hutang_pos.idAkunHutang='$Ahutang[idAkun]'"));
                                                    $ThutangBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT  SUM(hutang_bayar.nominal) as totalBayarHutang FROM hutang_bayar INNER JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.stdel='0' AND hutang_pos.idAkunHutang='$Ahutang[idAkun]' AND hutang_bayar.keterangan='Lunas' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) >= '$bulan1' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) <= '$bulan2'  AND hutang_setting.idTahunAjaran='$idTahunAjaran'"));
                                                    
                                                    $total_hutang += $Thutang['totalHutang'] - $ThutangBayar['totalBayarHutang'];
                                                }

                                                $saldo_modal = $saldo_kas + $saldo_piutang - $total_hutang;
                                                $html.= '<tr>
                                                            <td>'.$modal['kodeAkun'].'</td>
                                                            <td>'.$modal['keterangan'].'</td>
                                                            <td align="right">'.buatRp($saldo_modal).'</td>
                                                         </tr>';
                                                $subtotal_modal += $saldo_modal;
                                            }

                                $html.='<tr style="background-color: #dee0e3;">
                                          <td colspan="2" align="left"><strong>Subtotal Modal</strong></td>
                                          <td align="right">'.buatRp($subtotal_modal).'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td>
                                <table class="table table-responsive" style="white-space: nowrap;" cellpadding="2">
                                    <tbody>
                                        <tr style="background-color: #bac0cc;">
                                            <td align="left"><strong>Total Aktiva</strong></td>
                                            <td align="right"><strong>'.buatRp($subtotal_kas + $subtotal_piutang).'</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="table table-responsive" style="white-space: nowrap;" cellpadding="2">
                                    <tbody>
                                        <tr style="background-color: #bac0cc;">
                                            <td align="left"><strong>Total Passiva</strong></td>
                                            <td align="right"><strong>'.buatRp($subtotal_Hutang + $subtotal_modal).'</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td>
                                <table border="0" style="font-size:8pt">
                                    <tr>
                                        <td width="388px"></td>
                                        <td width="120px" align="center">'.$idt['kabupaten'].', '.tgl_raport(date('Y-m-d')).'</td>
                                        <td width="20px"></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td align="center">Bendahara</td>
                                        <td></td>
                                    </tr>
                                    <tr><td colspan="3"></td></tr>
                                    <tr><td colspan="3"></td></tr>
                                    <tr><td colspan="3"></td></tr>
                                    <tr><td colspan="3"></td></tr>
                                    <tr>
                                        <td></td>
                                        <td align="center" style="font-weight:bold;">'.$idt['nmBendahara'].'</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td align="center">Nip. '.$idt['nipBendahara'].'</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>';
            $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');


        $file ='Rekap Laporan Neraca '.$unit.' per Bulan '.$bln1['nmBulan'].' Sampai '.$bln2['nmBulan'].' Tahun Ajaran '.$thn_ajar['nmTahunAjaran'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }

?>