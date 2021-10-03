<?php if ($_GET[act] == '') { ?>

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
                <input class="form-control" type="text" name="tgl_mulai" readonly="readonly" placeholder="Tanggal Awal" value="<?= $_GET['tgl_mulai'] ?>">
              </div>
            </div>
            <div class="col-md-2">
              <label></label>
              <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control" type="text" name="tgl_akhir" readonly="readonly" placeholder="Tanggal Awal" value="<?= $_GET['tgl_akhir'] ?>">
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
        <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan per Tanggal <?= date('d/m/Y', strtotime($tgl_mulai)) ?> Sampai <?= date('d/m/Y', strtotime($tgl_akhir)) ?></h3>
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

            if ($idUnit == 'all') {
              $sql_akunKas = mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Bank%' AND stdel='0' AND jenisAkun='Sub Menu 2' ORDER BY idAkun ASC");

              $sql_akunKas = mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Kas Bank%' AND stdel='0' AND jenisAkun='Sub Menu 2' ORDER BY idAkun ASC");
            } else {
              $sql_akunKas = mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE kodeAkun like '%1-1%' AND keterangan like '%Akun Bank%'  AND stdel='0' AND jenisAkun='Sub Menu 1' AND unitSekolah='$idUnit' ORDER BY idAkun ASC");
            }
            while ($kas = mysqli_fetch_array($sql_akunKas)) {
              //SET SALDO AWAL
              $saldo_awal += ($kas['saldo_awal_debit'] - $kas['saldo_awal_kredit']);

              $saldoBulanan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(tagihan_bulanan.jumlahTagihan) as total FROM tagihan_bulanan LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.idAkunKas='$kas[idAkun]' AND (DATE(tagihan_bulanan.tglBayar) < '$tgl_mulai')"));

              $saldoBebas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(tagihan_bebas_bayar.jumlahBayar) as total FROM tagihan_bebas_bayar LEFT JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.idAkunKas='$kas[idAkun]' AND (DATE(tagihan_bebas_bayar.tglBayar) < '$tgl_mulai')"));

              $saldoKasMasuk = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(total) as totalMasuk FROM kas WHERE idAkunKas='$kas[idAkun]' AND (DATE(tanggal) < '$tgl_mulai') AND stdel='0' AND jenis='Masuk' AND idTahunAjaran='$idTahunAjaran'"));

              $saldoKasKeluar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(total) as totalKeluar FROM kas WHERE idAkunKas='$kas[idAkun]' AND (DATE(tanggal) < '$tgl_mulai') AND stdel='0' AND jenis='Keluar' AND idTahunAjaran='$idTahunAjaran'"));

              $saldoBayarHutang = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(nominal) as totalBayarKeluar FROM hutang_bayar WHERE (DATE(tanggalBayar) < '$tgl_mulai') AND stdel='0' AND keterangan='Lunas' AND idAkunKas='$kas[idAkun]'"));

              $saldo_awal += ($saldoBulanan['total'] + $saldoBebas['total'] + $saldoKasMasuk['totalMasuk']);
              $saldo_keluar += ($saldoKasKeluar['totalKeluar'] + $saldoBayarHutang['totalBayarKeluar']);



              //kas keluar & masuk
              $sqlKas = mysqli_query($koneksi, "SELECT * FROM kas 
              LEFT JOIN siswa ON kas.SiswaId = siswa.idSiswa
              WHERE kas.idAkunKas='$kas[idAkun]' AND (DATE(kas.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir')  AND idTahunAjaran='$idTahunAjaran'
              ");
              while ($tkas = mysqli_fetch_array($sqlKas)) {
                if ($tkas['tipe'] != 'Transfer') {
                  $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tkas[idKodeAkun]'"));
                } else {
                  $akun = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idAkun='$tkas[idAkunKasTujuan]'"));
                }

                if ($tkas['jenis'] == 'Masuk') {
                  if ($tkas['tipe'] == 'Transfer') {
                    $keterangan = $tkas['keterangan'];
                  } else {
                    $keterangan = $tkas['keterangan'];
                  }
                  echo '<tr>
                            <td>' . tgl_miring($tkas['tanggal']) . '</td>
                            <td>' . $akun['kodeAkun'] . '</td>
                            <td style="text-align:left">' . $keterangan . '</td>
                            <td>' . $tkas['nisSiswa'] . '</td>
                            <td>' . $tkas['nmSiswa'] . '</td>
                            <td>' . $tkas['kelasSiswa'] . '</td>
                            <td style="text-align:left">' . buatRp($tkas['total']) . '</td>
                            <td>-</td>
                          </tr>';
                  $subtotal_penerimaan += $tkas['total'];
                } elseif ($tkas['jenis'] == 'Keluar') {
                  if ($tkas['tipe'] == 'Transfer') {
                    $keterangan = $tkas['keterangan'] . ' ke akun ' . $akun['keterangan'];
                  } elseif ($tkas['tipe'] == 'Gaji') {
                    $keterangan = $tkas['tipe'] . ' ' . $tkas['keterangan'];
                  } else {
                    $keterangan = $tkas['keterangan'];
                  }
                  echo '<tr>
                            <td>' . tgl_miring($tkas['tanggal']) . '</td>
                            <td>' . $akun['kodeAkun'] . '</td>
                            <td style="text-align:left">' . $keterangan . '</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td style="text-align:left">' . buatRp($tkas['total']) . '</td>
                          </tr>';

                  $subtotal_pengeluaran += $tkas['total'];
                }
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
          <tbody>
            <tr>
              <td>
                <div class="md-6">
                  <a class="btn btn-danger" target="_blank" href="admin/laporan/rekap_laporan_kas_bank_per_jenis_anggaran.php?tgl_mulai=<?= $_GET[tgl_mulai] ?>&tgl_akhir=<?= $_GET[tgl_akhir] ?>&thn_ajar=<?= $_GET[thn_ajar] ?>&unit=<?= $_GET[unit] ?>"><span class="fa fa-file-pdf-o"></span> PDF Per Jenis Anggaran
                  </a>
                  <a class="btn btn-success" target="_blank" href="admin/excel/rekap_laporan_kas_bank_per_jenis_anggaran.php?tgl_mulai=<?= $_GET[tgl_mulai] ?>&tgl_akhir=<?= $_GET[tgl_akhir] ?>&thn_ajar=<?= $_GET[thn_ajar] ?>&unit=<?= $_GET[unit] ?>"><span class="fa fa-file-excel-o"></span> Excel Per Jenis Anggaran
                  </a>
                </div>
              </td>
              <td>
                <div class="pull-right">
                  <a class="btn btn-danger" target="_blank" href="admin/laporan/rekap_laporan_kas_bank.php?tgl_mulai=<?= $_GET[tgl_mulai] ?>&tgl_akhir=<?= $_GET[tgl_akhir] ?>&thn_ajar=<?= $_GET[thn_ajar] ?>&unit=<?= $_GET[unit] ?>"><span class="fa fa-file-pdf-o"></span> PDF Rekap Laporan
                  </a>
                  <a class="btn btn-success" target="_blank" href="admin/excel/rekap_laporan_kas_bank.php?tgl_mulai=<?= $_GET[tgl_mulai] ?>&tgl_akhir=<?= $_GET[tgl_akhir] ?>&thn_ajar=<?= $_GET[thn_ajar] ?>&unit=<?= $_GET[unit] ?>"><span class="fa fa-file-excel-o"></span> Excel Rekap Laporan
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
<?php
} ?>