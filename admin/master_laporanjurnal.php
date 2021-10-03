<?php if ($_GET[act]==''){ ?> 
  
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <form method="GET">

            <input type="hidden" name="view" value="<?= $_GET[view] ?>">
            <div class="row">
              <div class="col-md-2">
                <label></label>
                <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input class="form-control" type="text" name="tgl_mulai"readonly="readonly" placeholder="Tanggal Awal" value="<?= $_GET['tgl_mulai']?>">
                </div>
              </div>
              <div class="col-md-2">
                <label></label>
                <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input class="form-control" type="text" name="tgl_akhir"readonly="readonly" placeholder="Tanggal Awal" value="<?= $_GET['tgl_akhir']?>">
                </div>
              </div>
              <div class="col-md-3">
                <label></label>
                <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
                <select class="form-control" name="thn_ajar" id="Ctahunajaran2" required=""></select>
              </div>
              <div class="col-md-3">
                <label></label>
                <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                <input type="hidden" id="tipe_unit" value="pencarian">
                <select id="Cunit" name="unit" class="form-control" required=""></select>
              </div>
              <div class="col-md-1">
                <div style="margin-top:20px;">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Cari</button>
                </div>
              </div>
            </div>
            <br>

          </form>
        </div>
      </div>
    </div>
<?php } ?>

<?php if (isset($_GET['tgl_mulai']) && isset($_GET['tgl_akhir']) && isset($_GET['thn_ajar']) && isset($_GET['unit'])) {  ?>

  <?php
    $tgl_mulai = $_GET['tgl_mulai'];
    $tgl_akhir = $_GET['tgl_akhir'];
    $idTahunAjaran = $_GET['thn_ajar'];
    $idUnit = $_GET['unit'];
  ?>

  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan per Tanggal <?= date('d/m/Y',strtotime($tgl_mulai)) ?> Sampai <?= date('d/m/Y',strtotime($tgl_akhir)) ?></h3>
      </div>
      <div class="box-body table-responsive">
        <table id="tabel_laporan_keuangan" class="table table-hover table-bordered dataTable no-footer text-center" style="white-space: nowrap;">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>Kode Akun</th>
              <th>Keterangan</th>
              <th>NIS</th>
              <th>Nama Siswa</th>
              <th>Kelas</th>
              <th>Penerimaan</th>
              <th>Pengeluaran</th>
            </tr>
          </thead>
          <tbody>
            <?php

              $saldo_awal = 0;
              $saldo_keluar = 0;
              $subtotal_penerimaan = 0;
              $subtotal_pengeluaran = 0;

              if ($idUnit=='all'){
                $sql_akunKas = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Tunai%' AND stdel='0' AND jenisAkun='Sub Menu 2' ORDER BY idAkun ASC");
              }else{
                $sql_akunKas = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Tunai%'  AND stdel='0' AND jenisAkun='Sub Menu 2' AND unitSekolah='$idUnit' ORDER BY idAkun ASC");
                // $sql_akunKas = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Akun Tunai%'  AND stdel='0' AND jenisAkun='Sub Menu 1' AND unitSekolah='$idUnit' ORDER BY idAkun ASC");
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
                //tagihan bulanan
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
                  echo '<tr>
                          <td>'.tgl_miring($tbulan['tglBayar']).'</td>
                          <td>'.$akun['kodeAkun'].'</td>
                          <td style="text-align:left">'.$tbulan['nmPosBayar'].' - T.A '.$tbulan['nmTahunAjaran'].' - ('.$nmBulan.')</td>
                          <td>'.$tbulan['nisSiswa'].'</td>
                          <td>'.$tbulan['nmSiswa'].'</td>
                          <td>'.$tbulan['nmKelas'].'</td>
                          <td style="text-align:left">'.buatRp($tbulan['jumlahTagihan']).'</td>
                          <td>-</td>
                        </tr>';
                  $subtotal_penerimaan += $tbulan['jumlahTagihan'];
                }

                //tagihan bebas
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
                                                       WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.idAkunKas='$kas[idAkun]' AND (DATE(tagihan_bebas_bayar.tglBayar) BETWEEN '$tgl_mulai' AND '$tgl_akhir')");
                while ($tbebas = mysqli_fetch_array($sqlTagihanBebas)) {
                  $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tbebas[kodeAkun]'"));
                  echo '<tr>
                          <td>'.tgl_miring($tbebas['tglBayar']).'</td>
                          <td>'.$akun['kodeAkun'].'</td>
                          <td style="text-align:left">'.$tbebas['nmPosBayar'].' - T.A '.$tbebas['nmTahunAjaran'].'</td>
                          <td>'.$tbebas['nisSiswa'].'</td>
                          <td>'.$tbebas['nmSiswa'].'</td>
                          <td>'.$tbebas['nmKelas'].'</td>
                          <td style="text-align:left">'.buatRp($tbebas['jumlahBayar']).'</td>
                          <td>-</td>
                        </tr>';
                  $subtotal_penerimaan += $tbebas['jumlahBayar'];
                }

                //kas keluar & masuk
                $sqlKas = mysqli_query($koneksi,"SELECT * FROM kas WHERE idAkunKas='$kas[idAkun]' AND (DATE(tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND stdel='0' AND idTahunAjaran='$idTahunAjaran'");
                while ($tkas = mysqli_fetch_array($sqlKas)) {
                  if ($tkas['tipe'] != 'Transfer'){
                    $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT* FROM akun_biaya WHERE idAkun='$tkas[idKodeAkun]'"));
                  }else{
                    $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tkas[idAkunKasTujuan]'"));
                  }
                  
                  if ($tkas['jenis'] == 'Masuk'){
                    if($tkas['tipe']=='Transfer'){
                      $keterangan = $tkas['keterangan'].' dari akun '.$akun['keterangan'];
                    }else{
                      $keterangan = $tkas['keterangan'];
                    }
                    echo '<tr>
                            <td>'.tgl_miring($tkas['tanggal']).'</td>
                            <td>'.$akun['kodeAkun'].'</td>
                            <td style="text-align:left">'.$keterangan.'</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td style="text-align:left">'.buatRp($tkas['total']).'</td>
                            <td>-</td>
                          </tr>';
                    $subtotal_penerimaan += $tkas['total'];
                  }elseif ($tkas['jenis'] == 'Keluar'){
                    if($tkas['tipe']=='Transfer'){
                      $keterangan = $tkas['keterangan'].' ke akun '.$akun['keterangan'];
                    }elseif($tkas['tipe']=='Gaji'){
                      $keterangan = $tkas['tipe'].' '.$tkas['keterangan'];
                    }else{
                      $keterangan = $tkas['keterangan'];
                    }
                       echo '<tr>
                            <td>'.tgl_miring($tkas['tanggal']).'</td>
                            <td>'.$akun['kodeAkun'].'</td>
                            <td style="text-align:left">'.$keterangan.'</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td style="text-align:left">'.buatRp($tkas['total']).'</td>
                          </tr>';
                            
                    $subtotal_pengeluaran += $tkas['total'];
                  }
                }
                
                //bayar hutang
                $sqlHutang = mysqli_query($koneksi,"SELECT hutang_bayar.*, hutang_setting_detail.idPegawai, pegawai.namaPegawai,hutang_setting.idPosHutang, hutang_pos.idAkunHutang FROM hutang_bayar LEFT JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang LEFT JOIN pegawai ON hutang_setting_detail.idPegawai=pegawai.idPegawai LEFT JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang LEFT JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.idAkunKas='$kas[idAkun]' AND (DATE(hutang_bayar.tanggalBayar) BETWEEN '$tgl_mulai' AND '$tgl_akhir') AND hutang_bayar.stdel='0' AND hutang_setting.idTahunAjaran='$idTahunAjaran' AND hutang_bayar.keterangan='Lunas'");
                while ($tHutang = mysqli_fetch_array($sqlHutang)) {
                  $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tHutang[idAkunHutang]'"));
                  echo '<tr>
                          <td>'.tgl_miring($tHutang['tanggalBayar']).'</td>
                          <td>'.$akun['kodeAkun'].'</td>
                          <td style="text-align:left">Bayar hutang - '.$tHutang['namaPegawai'].' - '.$tHutang['cicilan'].'</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td>-</td>
                          <td style="text-align:left">'.buatRp($tHutang['nominal']).'</td>
                        </tr>';
                    $subtotal_pengeluaran += $tHutang['nominal'];
                }
                
              }
            ?>
          </tbody>
          <tfoot>
            <tr style="background-color: #E2F7FF;">
              <th colspan="6" style="text-align: right;">Sub Total</th>
              <td style="text-align: left;"><?= buatRp($subtotal_penerimaan) ?></td>
              <td style="text-align: left;"><?= buatRp($subtotal_pengeluaran) ?></td>
            </tr>
            <tr style="background-color: #F0B2B2;">
              <th colspan="6" style="text-align: right;">Saldo Awal</th>
              <td style="text-align: left;"><?= buatRp($saldo_awal) ?></td>
              <td>-</td>
            </tr>
            <tr style="background-color: #FFFCBE;">
              <th colspan="6" style="text-align: right;">Total (Sub Total + Saldo Awal)</th>
               <td style="text-align: left;"><?= buatRp($saldo_awal + $subtotal_penerimaan) ?></td>
              <td style="text-align: left;"><?= buatRp($saldo_keluar + $subtotal_pengeluaran) ?></td>
            </tr>
            <tr style="background-color: #c2d2f6;">
              <th colspan="6" style="text-align: right;">Saldo Akhir</th>
              <td style="text-align: left;"><?= buatRp($saldo_awal + $subtotal_penerimaan - ($saldo_keluar + $subtotal_pengeluaran)) ?></td>
              <td>-</td>
            </tr>
          </tfoot>
        </table>
      </div>         
      <div class="box-footer">
              <table class="table">
                      <tbody><tr>
                      <td>
                          <div class="md-6">
                              <a class="btn btn-danger" target="_blank" href="admin/laporan/rekap_laporan_kas_tunai_per_jenis_anggaran.php?tgl_mulai=<?=$_GET[tgl_mulai]?>&tgl_akhir=<?=$_GET[tgl_akhir]?>&thn_ajar=<?=$_GET[thn_ajar]?>&unit=<?=$_GET[unit]?>"><span class="fa fa-file-pdf-o"></span> PDF Per Jenis Anggaran
                              </a>
                              <a class="btn btn-success" target="_blank" href="admin/excel/rekap_laporan_kas_tunai_per_jenis_anggaran.php?tgl_mulai=<?=$_GET[tgl_mulai]?>&tgl_akhir=<?=$_GET[tgl_akhir]?>&thn_ajar=<?=$_GET[thn_ajar]?>&unit=<?=$_GET[unit]?>"><span class="fa fa-file-excel-o"></span> Excel Per Jenis Anggaran
                              </a>
                          </div>
                      </td>
                      <td>
                          <div class="pull-right">
                              <a class="btn btn-danger" target="_blank" href="admin/laporan/rekap_laporan_kas_tunai.php?tgl_mulai=<?=$_GET[tgl_mulai]?>&tgl_akhir=<?=$_GET[tgl_akhir]?>&thn_ajar=<?=$_GET[thn_ajar]?>&unit=<?=$_GET[unit]?>"><span class="fa fa-file-pdf-o"></span> PDF Rekap Laporan
                              </a>
                              <a class="btn btn-success" target="_blank" href="admin/excel/rekap_laporan_kas_tunai.php?tgl_mulai=<?=$_GET[tgl_mulai]?>&tgl_akhir=<?=$_GET[tgl_akhir]?>&thn_ajar=<?=$_GET[thn_ajar]?>&unit=<?=$_GET[unit]?>"><span class="fa fa-file-excel-o"></span> Excel Rekap Laporan
                              </a>
                          </div>
                      </td>
                  </tr>
              </tbody></table>
              </div>
    </div>
  </div>


<?php } ?>
