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
        
        $saldo_awal = 0;
        $saldo_keluar = 0;
        $subtotal_penerimaan = 0;
        $subtotal_pengeluaran = 0;
        
        if ($idUnit=='all'){
            $sql_akunKas = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Bank%' AND stdel='0' AND jenisAkun='Sub Menu 2' ORDER BY idAkun ASC");
            $sql_akunKas1 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Bank%' AND stdel='0' AND jenisAkun='Sub Menu 2' ORDER BY idAkun ASC");
            $sql_akunKas2 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Bank%' AND stdel='0' AND jenisAkun='Sub Menu 2' ORDER BY idAkun ASC");
        }else{
            $sql_akunKas = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Bank%'  AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnit' ORDER BY idAkun ASC");
            $sql_akunKas1 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Bank%'  AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnit' ORDER BY idAkun ASC");
            $sql_akunKas2 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Bank%'  AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnit' ORDER BY idAkun ASC");
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

            //konfigurasi TCPDF
            $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->setMargins(5,5,5,5);
            //menambahkan halaman
            $pdf->AddPage();
            //setting title
            $pdf->SetTitle('Laporan Per Jenis Anggaran Kas Bank per Tanggal '.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir).'</b><br>Tahun Ajaran '.$ta['nmTahunAjaran']);
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

            $html = '<table style="font-size: 8pt" cellpadding="1" border="0">
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
                            <td align="center" style="font-size: 8pt"><b>Laporan per Jenis Anggaran Kas Bank per Tanggal '.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir).'</b><br>Tahun Ajaran '.$ta['nmTahunAjaran'].'</td>
                        </tr>
                       
                        <tr>
                            <td>

                                <h3><strong>Penerimaan</strong></h3>
                                    <div class="box-body table-responsive">';
                                        while ($kas = mysqli_fetch_array($sql_akunKas1)) {
                                            //tagihan bulanan
                                            $sqlBulanan = mysqli_query($koneksi,"SELECT 
                                                              tagihan_bulanan.*,
                                                              jenis_bayar.idPosBayar, 
                                                              pos_bayar.nmPosBayar,
                                                              pos_bayar.kodeAkun,
                                                              akun_biaya.kodeAkun as kodeAkunBiaya,
                                                              akun_biaya.keterangan
                                                              FROM tagihan_bulanan 
                                                              LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                                              LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                              LEFT JOIN akun_biaya ON pos_bayar.kodeAkun = akun_biaya.idAkun
                                                              WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.idAkunKas='$kas[idAkun]' AND (DATE(tagihan_bulanan.tglBayar) BETWEEN '$tgl_mulai' AND '$tgl_akhir') GROUP BY tagihan_bulanan.idJenisBayar");
                                            while ($bulanan = mysqli_fetch_array($sqlBulanan)) {
                                                $html .='<h4><strong>'.$bulanan['kodeAkunBiaya'].' - '.$bulanan['nmPosBayar'].'</strong></h4>';
                                                $html .= '<table style="font-size:8pt; font-family: arial; text-align:center" border="0" cellpadding="3" width="99%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:25px">No.</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:50px">Tanggal</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:120px">Keterangan</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:60px">NIS</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Nama</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:58px">Kelas</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:70px">Penerimaan</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:70px">Pengeluaran</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                                                                $no = 1;
                                                                $total = 0;
                                                                $sqlTagihanBulanan = mysqli_query($koneksi,"SELECT 
                                                                      tagihan_bulanan.*,
                                                                      siswa.*,
                                                                      kelas_siswa.nmKelas,
                                                                      jenis_bayar.idPosBayar, 
                                                                      tahun_ajaran.nmTahunAjaran,
                                                                      pos_bayar.nmPosBayar,
                                                                      pos_bayar.kodeAkun,
                                                                      bulan.nmBulan,
                                                                      bulan.urutan
                                                                      FROM tagihan_bulanan 
                                                                      LEFT JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa
                                                                      LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas
                                                                      LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                                                      LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                      LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                      LEFT JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                                                      WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.idAkunKas='$kas[idAkun]' AND (DATE(tagihan_bulanan.tglBayar) BETWEEN '$tgl_mulai' AND '$tgl_akhir')");
                                                                    
                                                                    while ($tbulan = mysqli_fetch_array($sqlTagihanBulanan)) {
                                                                      $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tbulan[kodeAkun]'"));
                                                                      $pisah_TA = explode('/', $tbulan['nmTahunAjaran']);
                                                                      if ($tbulan['urutan'] <= 6){
                                                                        $nmBulan = $tbulan['nmBulan'].' '.$pisah_TA[0];
                                                                      }else{
                                                                        $nmBulan = $tbulan['nmBulan'].' '.$pisah_TA[1];
                                                                      }
                                                                      $html .= '<tr>
                                                                              <td>'.$no++.'</td>
                                                                              <td>'.tgl_miring($tbulan['tglBayar']).'</td>
                                                                              <td style="text-align:left">'.$tbulan['nmPosBayar'].' - T.A '.$tbulan['nmTahunAjaran'].' - ('.$nmBulan.')</td>
                                                                              <td>'.$tbulan['nisSiswa'].'</td>
                                                                              <td>'.$tbulan['nmSiswa'].'</td>
                                                                              <td>'.$tbulan['nmKelas'].'</td>
                                                                              <td style="text-align:left">'.buatRp($tbulan['jumlahTagihan']).'</td>
                                                                              <td>-</td>
                                                                            </tr>';
                                                                      $total += $tbulan['jumlahTagihan'];
                                                                      $subtotal_penerimaan += $tbulan['jumlahTagihan'];
                                                                    }


                                                $html .= '  </tbody>
                                                            <tfoot>
                                                                <tr style="background-color: #f0f0f0; font-weight:bold">
                                                                    <td colspan="6" style="text-align:center">Total</td>
                                                                    <td style="text-align:left">'.buatRp($total).'</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr><td colspan="8"></td></tr>
                                                            </tfoot>
                                                          </table>';


                                            }

                                            //tagihan bebas
                                            $sqlBebas = mysqli_query($koneksi,"SELECT 
                                                              tagihan_bebas.*,
                                                              tagihan_bebas_bayar.*,
                                                              jenis_bayar.idPosBayar, 
                                                              pos_bayar.nmPosBayar,
                                                              pos_bayar.kodeAkun,
                                                              akun_biaya.kodeAkun as kodeAkunBiaya,
                                                              akun_biaya.keterangan
                                                              FROM tagihan_bebas 
                                                              LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas
                                                              LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                              LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                              LEFT JOIN akun_biaya ON pos_bayar.kodeAkun = akun_biaya.idAkun
                                                              WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.idAkunKas='$kas[idAkun]' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$tgl_mulai' AND '$tgl_akhir') GROUP BY tagihan_bebas.idJenisBayar");
                                            while ($bebas = mysqli_fetch_array($sqlBebas)) {
                                                $html .='<h4><strong>'.$bebas['kodeAkunBiaya'].' - '.$bebas['nmPosBayar'].'</strong></h4>';
                                                $html .= '<table style="font-size:8pt; font-family: arial; text-align:center" border="0" cellpadding="3" width="99%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:25px">No.</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:50px">Tanggal</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:120px">Keterangan</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:60px">NIS</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Nama</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:58px">Kelas</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:70px">Penerimaan</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:70px">Pengeluaran</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                                                                $no = 1;
                                                                $total = 0;
                                                                $sqlTagihanBebas = mysqli_query($koneksi,"SELECT 
                                                                    tagihan_bebas.*, 
                                                                    tagihan_bebas_bayar.*, 
                                                                    siswa.*,
                                                                    kelas_siswa.nmKelas,
                                                                    jenis_bayar.idPosBayar, 
                                                                    tahun_ajaran.nmTahunAjaran,
                                                                    pos_bayar.nmPosBayar,
                                                                    pos_bayar.kodeAkun
                                                                   FROM tagihan_bebas 
                                                                   LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas
                                                                   LEFT JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
                                                                   LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas
                                                                   LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                                   LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                   LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                   WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.idAkunKas='$kas[idAkun]' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND tagihan_bebas.idJenisBayar='$bebas[idJenisBayar]'");
                                                                while ($tbebas = mysqli_fetch_array($sqlTagihanBebas)) {
                                                                  $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tbebas[kodeAkun]'"));
                                                                  $html.= '<tr>
                                                                          <td>'.$no++.'</td>
                                                                          <td>'.tgl_miring($tbebas['tglBayar']).'</td>
                                                                          <td style="text-align:left">'.$tbebas['nmPosBayar'].' - T.A '.$tbebas['nmTahunAjaran'].'</td>
                                                                          <td>'.$tbebas['nisSiswa'].'</td>
                                                                          <td>'.$tbebas['nmSiswa'].'</td>
                                                                          <td>'.$tbebas['nmKelas'].'</td>
                                                                          <td style="text-align:left">'.buatRp($tbebas['jumlahBayar']).'</td>
                                                                          <td>-</td>
                                                                        </tr>';
                                                                  $total += $tbebas['jumlahBayar'];
                                                                  $subtotal_penerimaan += $tbebas['jumlahBayar'];
                                                                }
                                                $html .= '  </tbody>
                                                            <tfoot>
                                                                <tr style="background-color: #f0f0f0; font-weight:bold">
                                                                    <td colspan="6" style="text-align:center">Total</td>
                                                                    <td style="text-align:left">'.buatRp($total).'</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr><td colspan="8"></td></tr>
                                                            </tfoot>
                                                          </table>';

                                            }

                                            //kas masuk
                                            $sqlkasmasuk = mysqli_query($koneksi,"SELECT kas.*,
                                                              akun_biaya.kodeAkun as kodeAkunBiaya,
                                                              akun_biaya.keterangan
                                                              FROM kas 
                                                              LEFT JOIN akun_biaya ON kas.idKodeAkun = akun_biaya.idAkun
                                                              LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                                              WHERE kas.idTahunAjaran='$idTahunAjaran' AND kas.jenis='Masuk' AND kas.idAkunKas='$kas[idAkun]' AND (DATE(kas.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND kas.stdel='0' GROUP BY akun_biaya.idAkun");
                                            while ($masuk = mysqli_fetch_array($sqlkasmasuk)) {
                                                if ($masuk['tipe'] != 'Transfer'){
                                                     $html .='<h4><strong>'.$masuk['kodeAkunBiaya'].' - '.$masuk['keterangan'].'</strong></h4>';
                                                }else{
                                                    $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$masuk[idAkunKas]'"));
                                                     $html .='<h4><strong>'.$akun['kodeAkun'].' - '.$akun['keterangan'].'</strong></h4>';
                                                }

                                               
                                                $html .= '<table style="font-size:8pt; font-family: arial; text-align:center" border="0" cellpadding="3" width="99%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:25px">No.</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:50px">Tanggal</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:120px">Keterangan</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:60px">NIS</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Nama</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:58px">Kelas</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:70px">Penerimaan</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:70px">Pengeluaran</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                                                                $no = 1;
                                                                $total = 0;
                                                                $sqlKas = mysqli_query($koneksi,"SELECT * FROM kas WHERE (idKodeAkun='$masuk[idKodeAkun]' OR  idAkunKasTujuan='$masuk[idAkunKasTujuan]') AND (DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND stdel='0' AND idTahunAjaran='$idTahunAjaran' AND idAkunKas='$kas[idAkun]'");
                                                                while ($tkas = mysqli_fetch_array($sqlKas)) {
                                                                  if ($tkas['tipe'] != 'Transfer'){
                                                                    $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tkas[idKodeAkun]'"));
                                                                    $keterangan = $tkas['keterangan'];
                                                                  }else{
                                                                    $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tkas[idAkunKasTujuan]'"));
                                                                    $keterangan = $tkas['keterangan'].' dari akun '.$akun['keterangan'];
                                                                  }
                                                                 
                                                                    $html .= '<tr>
                                                                            <td>'.$no++.'</td>
                                                                            <td>'.tgl_miring($tkas['tanggal']).'</td>
                                                                            <td style="text-align:left">'.$keterangan.'</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td style="text-align:left">'.buatRp($tkas['total']).'</td>
                                                                            <td>-</td>
                                                                          </tr>';
                                                                    $total += $tkas['total'];
                                                                    $subtotal_penerimaan += $tkas['total'];
                                                                  
                                                                }

                                                $html .= '  </tbody>
                                                            <tfoot>
                                                                <tr style="background-color: #f0f0f0; font-weight:bold">
                                                                    <td colspan="6" style="text-align:center">Total</td>
                                                                    <td style="text-align:left">'.buatRp($total).'</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr><td colspan="8"></td></tr>
                                                            </tfoot>
                                                          </table>';


                                            }
                                         }
  
                $html .=     '</div>
                                <h3><strong>Pengeluaran</strong></h3>
                                 <div class="box-body table-responsive">';
                                 while ($kas = mysqli_fetch_array($sql_akunKas2)) {
                                 //kas keluar
                                 $sqlkaskeluar = mysqli_query($koneksi,"SELECT kas.*,
                                                              akun_biaya.kodeAkun as kodeAkunBiaya,
                                                              akun_biaya.keterangan
                                                              FROM kas 
                                                              LEFT JOIN akun_biaya ON kas.idKodeAkun = akun_biaya.idAkun
                                                              LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                                              WHERE kas.idTahunAjaran='$idTahunAjaran' AND kas.jenis='Keluar' AND kas.idAkunKas='$kas[idAkun]' AND (DATE(kas.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND kas.stdel='0' GROUP BY akun_biaya.idAkun");
                                while ($keluar = mysqli_fetch_array($sqlkaskeluar)) {
                                    if ($keluar['tipe'] != 'Transfer'){
                                         $html .='<h4><strong>'.$keluar['kodeAkunBiaya'].' - '.$keluar['keterangan'].'</strong></h4>';
                                    }else{
                                        $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$keluar[idAkunKasTujuan]'"));
                                         $html .='<h4><strong>'.$akun['kodeAkun'].' - '.$akun['keterangan'].'</strong></h4>';
                                    }

                                    $html .= '<table style="font-size:8pt; font-family: arial; text-align:center" border="0" cellpadding="3" width="99%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:25px">No.</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:50px">Tanggal</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:120px">Keterangan</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:60px">NIS</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Nama</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:58px">Kelas</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:70px">Penerimaan</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:70px">Pengeluaran</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                                                                $no = 1;
                                                                $total = 0;
                                                               $sqlKas1 = mysqli_query($koneksi,"SELECT * FROM kas WHERE (idKodeAkun='$keluar[idKodeAkun]' OR  idAkunKasTujuan='$keluar[idAkunKasTujuan]') AND (DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND stdel='0' AND idTahunAjaran='$idTahunAjaran' AND idAkunKas='$kas[idAkun]'");
                                                                while ($tkas = mysqli_fetch_array($sqlKas1)) {
                                                                    if($tkas['tipe']=='Transfer'){
                                                                        $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tkas[idAkunKasTujuan]'"));
                                                                        $keterangan = $tkas['keterangan'].' ke akun '.$akun['keterangan'];
                                                                    }elseif($tkas['tipe']=='Gaji'){
                                                                        $keterangan = $tkas['tipe'].' '.$tkas['keterangan'];
                                                                    }else{
                                                                        $keterangan = $tkas['keterangan'];
                                                                    }

                                                                 
                                                                    $html .= '<tr>
                                                                            <td>'.$no++.'</td>
                                                                            <td>'.tgl_miring($tkas['tanggal']).'</td>
                                                                            <td style="text-align:left">'.$keterangan.'</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td>-</td>
                                                                            <td style="text-align:left">'.buatRp($tkas['total']).'</td>
                                                                          </tr>';
                                                                    $total += $tkas['total'];
                                                                    $subtotal_pengeluaran += $tkas['total'];
                                                                  
                                                                }

                                                $html .= '  </tbody>
                                                            <tfoot>
                                                                <tr style="background-color: #f0f0f0; font-weight:bold">
                                                                    <td colspan="6" style="text-align:center">Total</td>
                                                                    <td></td>
                                                                    <td style="text-align:left">'.buatRp($total).'</td>
                                                                </tr>
                                                                <tr><td colspan="8"></td></tr>
                                                            </tfoot>
                                                          </table>';

                                        }

                                        //hutang
                                            $sql_hutang = mysqli_query($koneksi,"SELECT hutang_bayar.*, hutang_setting_detail.idPegawai, pegawai.namaPegawai,hutang_setting.idPosHutang, hutang_pos.idAkunHutang FROM hutang_bayar LEFT JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang LEFT JOIN pegawai ON hutang_setting_detail.idPegawai=pegawai.idPegawai LEFT JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang LEFT JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.idAkunKas='$kas[idAkun]' AND (DATE(hutang_bayar.tanggalBayar) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND hutang_bayar.stdel='0' AND hutang_setting.idTahunAjaran='$idTahunAjaran' AND hutang_bayar.keterangan='Lunas' GROUP BY hutang_pos.idAkunHutang");

                                            while ($hutang = mysqli_fetch_array($sql_hutang)) {
                                                $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$hutang[idAkunHutang]'"));
                                                $html .='<h4><strong>'.$akun['kodeAkun'].' - '.$akun['keterangan'].'</strong></h4>';
                                               
                                                $html .= '<table style="font-size:8pt; font-family: arial; text-align:center" border="0" cellpadding="3" width="99%">
                                                            <thead>
                                                                <tr>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:25px">No.</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:50px">Tanggal</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:120px">Keterangan</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:60px">NIS</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Nama</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:58px">Kelas</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:70px">Penerimaan</th>
                                                                    <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:70px">Pengeluaran</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>';
                                                                $no = 1;
                                                                $total = 0;
                                                                $sqlHutang = mysqli_query($koneksi,"SELECT hutang_bayar.*, hutang_setting_detail.idPegawai, pegawai.namaPegawai,hutang_setting.idPosHutang, hutang_pos.idAkunHutang FROM hutang_bayar LEFT JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang LEFT JOIN pegawai ON hutang_setting_detail.idPegawai=pegawai.idPegawai LEFT JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang LEFT JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.idAkunKas='$kas[idAkun]' AND (DATE(hutang_bayar.tanggalBayar) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND hutang_bayar.stdel='0' AND hutang_setting.idTahunAjaran='$idTahunAjaran' AND hutang_bayar.keterangan='Lunas'");
                                                                while ($tHutang = mysqli_fetch_array($sqlHutang)) {
                                                                  $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tHutang[idAkunHutang]'"));
                                                                  $html .=  '<tr>
                                                                          <td>'.$no++.'</td>
                                                                          <td>'.tgl_miring($tHutang['tanggalBayar']).'</td>
                                                                          <td style="text-align:left">'.$tHutang['namaPegawai'].' - '.$tHutang['cicilan'].'</td>
                                                                          <td>-</td>
                                                                          <td>-</td>
                                                                          <td>-</td>
                                                                          <td>-</td>
                                                                          <td style="text-align:left">'.buatRp($tHutang['nominal']).'</td>
                                                                        </tr>';
                                                                    $total += $tHutang['nominal'];
                                                                    $subtotal_pengeluaran += $tHutang['nominal'];
                                                                }

                                                $html .= '  </tbody>
                                                            <tfoot>
                                                                <tr style="background-color: #f0f0f0; font-weight:bold">
                                                                    <td colspan="6" style="text-align:center">Total</td>
                                                                    <td></td>
                                                                    <td style="text-align:left">'.buatRp($total).'</td>
                                                                </tr>
                                                                <tr><td colspan="8"></td></tr>
                                                            </tfoot>
                                                          </table>';


                                            }
                                    
                                    }
                               
                                
            $html .='           </div>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td>
                                <table style="font-size:8pt; text-align:center" border="0">
                                    <tr>
                                        <td style="width:70px"></td>
                                        <th style="width:10px"></th>
                                        <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Debit</th>
                                        <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black; width:100px">Kredit</th>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; text-align:left">Sub Total</td>
                                        <td>:</td>
                                        <td>'.buatRp($subtotal_penerimaan).'</td>
                                        <td>'.buatRp($subtotal_pengeluaran).'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; text-align:left">Saldo Awal</td>
                                        <td>:</td>
                                        <td>'.buatRp($saldo_awal).'</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; text-align:left">Total</td>
                                        <td>:</td>
                                        <td>'.buatRp($subtotal_penerimaan + $saldo_awal).'</td>
                                        <td>'.buatRp($saldo_keluar + $subtotal_pengeluaran).'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold; text-align:left">Saldo Akhir</td>
                                        <td>:</td>
                                        <td>'.buatRp($subtotal_penerimaan + $saldo_awal - $subtotal_pengeluaran - $saldo_keluar).'</td>
                                        <td>-</td>
                                    </tr>
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


        $file ='Rekap Laporan Kas Bank per Jenis Anggaran per Tanggal '.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir).'</b><br>Tahun Ajaran '.$ta['nmTahunAjaran'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }

?>