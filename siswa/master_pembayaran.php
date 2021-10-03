<?php $base = $_SERVER['REQUEST_URI']; ?>

<?php if ($_GET[act] == '') { ?>

  <div class="col-md-12">
    <div class="box">
      <!-- /.box-header -->
      <div class="box-body">
        <form action="" class="form-horizontal" method="get" accept-charset="utf-8">
          <input type="hidden" name="view" value="<?= $_GET['view'] ?>">
          <div class="form-group">
            <label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
            <div class="col-sm-2">
              <input type="hidden" id="idTahunAjaran" value="<?= $_GET['thn_ajar'] ?>">
              <select class="form-control" name="thn_ajar" id="Ctahunajaran"></select>
              <input type="hidden" name="siswa" class="form-control" value="<?= $idSiswa ?>">
            </div>

            <div class="col-sm-4">
              <button type="submit" class="btn btn-success"><i class="fa fa-search"> </i> Cari Pembayaran</button>
            </div>
          </div>
        </form>
      </div><!-- /.box-body -->
    </div><!-- /.box -->

    <?php

      $idTahunAjaran = $_GET['thn_ajar'];
      $siswa = $_GET['siswa'];
      $ta = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
      $dsiswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT siswa.*, unit_sekolah.*, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa=unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE idSiswa='$siswa'"));

    ?>
      <div class="row">
        <div class="col-md-6">
          <div class="box box-info box-solid" style="border: 1px solid #2ABB9B !important;">
            <div class="box-header backg with-border">
              <h3 class="box-title">Informasi Siswa</h3>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <td width="200">Tahun Ajaran</td>
                    <td width="4">:</td>
                    <td><strong><?= $ta['nmTahunAjaran'] ?></strong></td>
                  </tr>
                  <tr>
                    <td>NIS</td>
                    <td>:</td>
                    <td><?= $dsiswa['nisSiswa'] ?></td>
                  </tr>
                  <tr>
                    <td>Nama Siswa</td>
                    <td>:</td>
                    <td><?= $dsiswa['nmSiswa'] ?></td>
                  </tr>
                  <tr>
                    <td>Unit</td>
                    <td>:</td>
                    <td><?= $dsiswa['singkatanUnit'] ?></td>
                  </tr>
                  <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td><?= $dsiswa['nmKelas'] ?></td>
                  </tr>
                  <tr>
                    <td>Kamar</td>
                    <td>:</td>
                    <td><?= $dsiswa['namaKamar'] ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><br></td>
                  </tr>
                  <tr>
                    <td colspan="1">
                      <div class="pull-right">
                        <button class="btn btn-default btn-sm" data-toggle="modal" data-target="#listHistory"><i class="fa fa-list"></i> History Pembayaran</button>
                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#listKwitansi"><i class="fa fa-list"></i> Kwitansi Pembayaran</button>
                        <a href="siswa/laporan/tagihan_pembayaran_persiswa.php?thn_ajar=3&nis=26" target="_blank"><button class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i> Download Tagihan</button></a>
                      </div>

                      <div class="modal fade in" id="listHistory" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                              <h4 class="modal-title">History Pembayaran</h4>
                            </div>
                            <div class="modal-body">
                              <div class="box-body table-responsive">
                                <div class="over">
                                  <table id="tabel_histori" class="table table-responsive table-bordered" width="100%" style="white-space: nowrap;">
                                    <thead>
                                      <tr class="info">
                                        <th>Tanggal</th>
                                        <th>No. Ref</th>
                                        <th>Pembayaran</th>
                                        <th>Nominal</th>
                                        <th>Bayar Via</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $tampil_bulanan = mysqli_query($koneksi, "SELECT
                                                                                      tagihan_bulanan.*,
                                                                                      jenis_bayar.idPosBayar,
                                                                                      tahun_ajaran.nmTahunAjaran,
                                                                                      pos_bayar.nmPosBayar,
                                                                                      akun_biaya.keterangan,
                                                                                      unit_sekolah.singkatanUnit,
                                                                                      bulan.nmBulan
                                                                                    FROM tagihan_bulanan
                                                                                    LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                                                                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                                    LEFT JOIN akun_biaya ON tagihan_bulanan.idAkunKas = akun_biaya.idAkun
                                                                                    LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                                                                    LEFT JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                                                                    WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND tagihan_bulanan.statusBayar='1' ORDER BY tagihan_bulanan.idTagihanBulanan DESC");
                                      while ($r = mysqli_fetch_array($tampil_bulanan)) {
                                        $pisah_TA = explode('/', $r['nmTahunAjaran']);
                                        if ($r['urutan'] <= 6) {
                                          $nmBulan = $r['nmBulan'] . ' ' . $pisah_TA[0];
                                        } else {
                                          $nmBulan = $r['nmBulan'] . ' ' . $pisah_TA[1];
                                        }
                                        echo '<tr>
                                                  <td>' . date('d/m/Y', strtotime($r['tglBayar'])) . '</td>
                                                  <td>' . $r['noRefrensi'] . '</td>
                                                  <td>' . $r['nmPosBayar'] . ' - T.A ' . $r['nmTahunAjaran'] . ' - (' . $nmBulan . ')</td>
                                                  <td>' . buatRp($r['jumlahTagihan']) . '</td>
                                                  <td>' . $r['keterangan'] . ' ' . $r['singkatanUnit'] . '</td>
                                                </tr>';
                                      }

                                      $tampil_bebas = mysqli_query($koneksi, "SELECT
                                                                                tagihan_bebas.*,
                                                                                tagihan_bebas_bayar.*,
                                                                                jenis_bayar.idPosBayar,
                                                                                tahun_ajaran.nmTahunAjaran,
                                                                                pos_bayar.nmPosBayar,
                                                                                akun_biaya.keterangan,
                                                                                unit_sekolah.singkatanUnit
                                                                              FROM tagihan_bebas
                                                                              LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas
                                                                              LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                                              LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                              LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                              LEFT JOIN akun_biaya ON tagihan_bebas_bayar.idAkunKas = akun_biaya.idAkun
                                                                              LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                                                              WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' AND tagihan_bebas.statusBayar!='0' ORDER BY tagihan_bebas.idTagihanBebas DESC");
                                      while ($r = mysqli_fetch_array($tampil_bebas)) {
                                        echo '<tr>
                                                  <td>' . date('d/m/Y', strtotime($r['tglBayar'])) . '</td>
                                                  <td>' . $r['noRefrensi'] . '</td>
                                                  <td>' . $r['nmPosBayar'] . ' - T.A ' . $r['nmTahunAjaran'] . '</td>
                                                  <td>' . buatRp($r['jumlahBayar']) . '</td>
                                                   <td>' . $r['keterangan'] . ' ' . $r['singkatanUnit'] . '</td>
                                                </tr>';
                                      }
                                      ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            </div>
                          </div>
                        </div>
                      </div>


                      <div class="modal fade in" id="listKwitansi" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                              <h4 class="modal-title">Kwitansi Pembayaran</h4>
                            </div>
                            <div class="modal-body">
                              <div class="box-body table-responsive">
                                <div class="over">
                                  <table class="table table-hover">
                                    <thead>
                                      <tr>
                                        <th>No. Ref</th>
                                        <th>Tanggal</th>
                                        <th>Total Transaksi</th>
                                        <th>Aksi</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $trx_pembayaran = mysqli_query($koneksi, "SELECT
                                                transaksi_pembayaran.*,
                                                siswa.nisSiswa,
                                                SUM(tagihan_bulanan.jumlahTagihan) as totalBulanan,
                                                SUM(tagihan_bebas_bayar.jumlahBayar) as totalBebas,
                                                tagihan_bulanan.tglBayar as tglBayarBulanan,
                                                tagihan_bebas_bayar.tglBayar as tglBayarBebas
                                             FROM transaksi_pembayaran
                                             LEFT JOIN siswa ON transaksi_pembayaran.idSiswa = siswa.idSiswa
                                             LEFT JOIN tagihan_bulanan ON transaksi_pembayaran.noRefrensi = tagihan_bulanan.noRefrensi
                                             LEFT JOIN tagihan_bebas_bayar ON transaksi_pembayaran.noRefrensi = tagihan_bebas_bayar.noRefrensi
                                             WHERE transaksi_pembayaran.idSiswa='$idSiswa' AND transaksi_pembayaran.idTahunAjaran='$idTahunAjaran' GROUP BY transaksi_pembayaran.noRefrensi");

                                      while ($r = mysqli_fetch_array($trx_pembayaran)) {
                                        if ($r['tglBayarBulanan'] == '0000-00-00 00:00:00' or $r['tglBayarBulanan'] == '') {
                                          $tgl = $r['tglBayarBebas'];
                                        } else {
                                          $tgl = $r['tglBayarBulanan'];
                                        }
                                        echo '<tr>
                                                  <td>' . $r['noRefrensi'] . '</td>
                                                  <td>' . date('d/m/Y', strtotime($tgl)) . '</td>
                                                  <td>' . buatRp($r['totalBulanan'] + $r['totalBebas']) . '</td>
                                                  <td><a href="siswa/laporan/bukti_pembayaran_siswa.php?thn_ajar=' . $idTahunAjaran . '&nis=' . $dsiswa['nisSiswa'] . '&tgl=' . date('Y-m-d', strtotime($tgl)) . '&noref=' . $r['noRefrensi'] . '" class="btn btn-danger btn-xs" target="_blank">Cetak</a></td>
                                                </tr>';
                                      }
                                      ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            </div>
                          </div>
                        </div>
                      </div>


                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <!-- List Tagihan Bulanan -->
          <div class="box box-info box-solid" style="border: 1px solid #2ABB9B !important;">
            <div class="box-header backg with-border">
              <h3 class="box-title">Tagihan Bulanan</h3>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive">
                <form method="post" action="/data.php" id="form">
              <table class="table table-striped table-hover" style="cursor: pointer;">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Pembayaran</th>
                    <th>Total</th>
                    <th>Sudah Dibayar</th>
                    <th>Kekurangan</th>
                    <th>Status</th>
                  </tr>
                </thead>

                <?php
                $sqlListTGB = mysqli_query($koneksi, "SELECT
                                            tagihan_bulanan.*,
                                            sum(tagihan_bulanan.jumlahTagihan) as jmlTagihanBulanan,
                                            jenis_bayar.idPosBayar,
                                            pos_bayar.nmPosBayar,
                                            unit_sekolah.singkatanUnit,
                                            tahun_ajaran.nmTahunAjaran
                                           FROM tagihan_bulanan
                                           INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                           INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                           INNER JOIN unit_sekolah ON jenis_bayar.idUnit = unit_sekolah.idUnit
                                           INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                           WHERE tagihan_bulanan.idSiswa='$dsiswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran' GROUP BY tagihan_bulanan.idJenisBayar");
                $no = 1;

                while ($rtgb = mysqli_fetch_array($sqlListTGB)) {
                  $dtgb = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(jumlahTagihan) as jmlDibayar FROM tagihan_bulanan WHERE idJenisBayar=$rtgb[idJenisBayar] AND idSiswa=$rtgb[idSiswa] AND statusBayar='2'"));
                  if ($dtgb['jmlDibayar'] == 0) {
                    $status = "<label class='label label-danger'>Belum Bayar</label>";
                    $icon = "fa-plus";
                    $btn = "btn-danger";
                    $color = "red";
                    $alt = "Bayar";
                  } elseif ($dtgb['jmlDibayar'] < $rtgb['jmlTagihanBulanan']) {
                    $status = "<label class='label label-warning'>Belum Lengkap</label>";
                    $icon = "fa-plus";
                    $btn = "btn-warning";
                    $color = "red";
                    $alt = "Bayar";
                  } else {
                    $status = "<label class='label label-success'>Lunas</label>";
                    $icon = "fa-search";
                    $btn = "btn-success";
                    $color = "green";
                    $alt = "Detil";
                  }
                  echo "<tbody><tr style='color:$color' data-toggle='collapse' data-target='#demo" . $rtgb['idJenisBayar'] . "'>
                                <td>" . $no++ . "</td>
                                <td>" . $rtgb['nmPosBayar'] . " T.A. " . $ta['nmTahunAjaran'] . "</td>
                                <td>" . buatRp($rtgb['jmlTagihanBulanan']) . "</td>
                                <td>" . buatRp($dtgb['jmlDibayar']) . "</td>
                                <td>" . buatRp($rtgb['jmlTagihanBulanan'] - $dtgb['jmlDibayar']) . "</td>
                                <td>$status</td>
                                </tr></tbody>";


                  echo '<tbody id="demo' . $rtgb['idJenisBayar'] . '" class="collapse">
                                      <tr>
                                        <td colspan="6" align="center" class="info">
                                            <h4>' . $rtgb[nmPosBayar] . ' - T.A ' . $rtgb[nmTahunAjaran] . '</h4>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th>No.</th>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Tagihan</th>
                                        <th colspan="2" style="text-align: center;">Status</th>
                                        <th colspan="2" style="text-align: center;">Action</th>
                                      </tr>';
                  $no = 1;
                  $base = $_SERVER['REQUEST_URI'];
                  $sqltbDetail = mysqli_query($koneksi, "SELECT tagihan_bulanan.*, bulan.nmBulan FROM tagihan_bulanan LEFT JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan WHERE idJenisBayar='$rtgb[idJenisBayar]' AND idSiswa='$dsiswa[idSiswa]' ORDER BY bulan.urutan ASC");


                  while ($tb = mysqli_fetch_array($sqltbDetail)) {
                    $pisah_TA = explode('/', $ta['nmTahunAjaran']);
                    if ($r['urutan'] <= 6) {
                      $tahun = $pisah_TA[0];
                    } else {
                      $tahun = $pisah_TA[1];
                    }
                    if ($tb['statusBayar'] == '2') {
                      $color = "success";
                      $status = 'Lunas';
                      $pay = null;
                    } else if ($tb['statusBayar'] == '1') {
                      $color = "warning";
                      $status = 'Pending';
                      $pay = null;
                    } else {
                      $color = "danger";
                      $status = 'Belum Lunas';
                      $pay = '<input type="checkbox"   value="'.$tb['jumlahTagihan'].'" name="items[]" onchange="checkTotal()">
                              <input type="hidden" name="pay[]" value="' . $tb['idTagihanBulanan'] . '"> ';
                    }
                    echo '<tr class="' . $color . '">
                            <td>' . $no++ . '</td>
                            <td>' . $tb['nmBulan'] . '</td>
                            <td>' . $tahun . '</td>
                            <td>' . buatRp($tb['jumlahTagihan']) . '</td>
                            <td colspan="2" align="center">' . $status . '</td>
                            <td style="text-align: center;">'.$pay.'</td>
                          </tr>';
                  }
                  echo '</tbody>';
                }
                ?>

              </table>
                  Total : <input type="text" class="form-control"  id="total" name="total" value="0"  readonly/>
                  <input type="hidden" value="<?= $dsiswa['idUnit'] ?>" name="unit" id="unit">
                  <br>
                  <button type="submit" class="btn btn-success bay" style="float:right">Pay</button>
              </form>


            </div>
          </div>

          <div class="box box-info box-solid" style="border: 1px solid #2ABB9B !important;">
            <div class="box-header backg with-border">
              <h3 class="box-title">Tagihan Lainnya</h3>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive">
                <form method="post" action="/cs.php" id="frm">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Jenis Pembayaran</th>
                    <th>Total</th>
                    <th>Dibayar</th>
                    <th>Kekurangan</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sqlTagihanBebas = mysqli_query($koneksi, "SELECT
                                          tagihan_bebas.*,
                                          jenis_bayar.idPosBayar,
                                          pos_bayar.nmPosBayar,
                                          unit_sekolah.singkatanUnit
                                        FROM
                                          tagihan_bebas
                                        INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                        INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                        INNER JOIN unit_sekolah ON jenis_bayar.idUnit = unit_sekolah.idUnit
                                        WHERE tagihan_bebas.idSiswa='$dsiswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran' ORDER BY tagihan_bebas.idTagihanBebas ASC");

                  $no = 1;
                  while ($rtb = mysqli_fetch_array($sqlTagihanBebas)) {
                    $dtBayar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(jumlahBayar) as totalDibayar FROM tagihan_bebas_bayar WHERE idTagihanBebas='$rtb[idTagihanBebas]'"));

                    $sisa = $dtInfo['totalTagihan'] - $totalDibayar['totalDibayar'];
                    $sisaRp = buatRp($sisa);

                    if ($rtb['statusBayar'] == '0') {
                      $status = "<label class='label label-danger'>Belum Bayar</label>";
                      $icon = "fa-plus";
                      $btn = "btn-danger";
                      $color = "red";
                      $alt = "Bayar";
                      $btncetak = "disabled";
                       $pa = '<input type="checkbox"  value="'.$rtb['totalTagihan'].'" name="item[]" onchange="checkTot()">
                              <input type="hidden" name="pa[]" value="' . $rtb['idTagihanBebas'] . '"> ';
                    } elseif ($rtb['statusBayar'] == '2') {
                      $status = "<label class='label label-warning'>Pending</label>";
                      $icon = "fa-plus";
                      $btn = "btn-warning";
                      $color = "red";
                      $alt = "Bayar";
                      $btncetak = "";
                        $pa = '<input type="checkbox"  value="'.$rtb['totalTagihan'].'" name="item[]" onchange="checkTot()">
                              <input type="hidden" name="pa[]" value="' . $rtb['idTagihanBebas'] . '"> ';
                    } elseif ($rtb['statusBayar'] == '1') {
                      $status = "<label class='label label-success'>Lunas</label>";
                      $icon = "fa-search";
                      $btn = "btn-success";
                      $color = "green";
                      $alt = "Detil";
                      $btncetak = "";
                      $pa = null;
                    }
                    echo "<tr style='color:$color'>
                            <td>" . $no++ . "</td>
                            <td>" . $rtb['nmPosBayar'] . " T.A. " . $ta['nmTahunAjaran'] . "</td>
                            <td>" . buatRp($rtb['totalTagihan']) . "</td>
                            <td>" . buatRp($dtBayar['totalDibayar']) . "</td>
                            <td>" . buatRp($rtb['totalTagihan'] - $dtBayar['totalDibayar']) . "</td>
                            <td>$status</td>
                            <td>$pa</td>
                          </tr>";
                  }
                  ?>
                </tbody>
              </table>
                       Total : <input type="number" class="form-control"  id="tot" name="tot" min="10000" required/>
                       <input type="hidden" value="<?=$idTahunAjaran?>" name="th" id="th">
                       <input type="hidden" value="<?= $dsiswa['idUnit'] ?>" name="unit" id="unit">
                  <br><button type="submit" class="btn btn-success" style="float:right">Pay</button>
              </form>

            </div>
          </div>
        </div>
      </div>
      <!-- /.box-body -->
    <?php  ?>

  </div>


<?php } ?>


<form id="payment-form" method="post" action="<?= $base ?>">
  <input type="hidden" name="result_type" id="result-type" value=""></div>
  <input type="hidden" name="result_data" id="result-data" value=""></div>
</form>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<SB-Mid-client-oSAJSml0ZKeOvKVd>"></script>

<script type="text/javascript">
  $(document).on("click", ".pay", function(e) {
    e.preventDefault();
    var d = $(this).attr('data-id');
    $(this).attr("disabled", "disabled");

    $.ajax({
      type: "POST",
      url: 'cs.php',
      data: {
        da: d
      },
      cache: false,

      success: function(data) {
        //location = data;

        console.log('token = ' + data);

        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');

        function changeResult(type, data) {

          // location.reload();
          $("#result-type").val(type);
          $("#result-data").val(JSON.stringify(data));
          resultType.innerHTML = type;
          resultData.innerHTML = JSON.stringify(data);
        }

        snap.pay(data, {

          onSuccess: function(result) {
            changeResult('success', result);
            console.log(result.status_message);
            console.log(result);
            $("#payment-form").submit();
          },
          onPending: function(result) {
            changeResult('pending', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          },
          onError: function(result) {
            changeResult('error', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          }
        });
      }
    });

  });




  function checkTotal() {
      var sum = 0;
      var n = $('input[name="items[]"]:checked');

         for (i = 0; i < n.length; i++) {
            if (n[i].checked) {
            sum += parseInt(n[i].value);
            }
        }
    $("#total").val(sum);
}


  function checkTot() {
      var sum = 0;
      var n = $('input[name="item[]"]:checked');

         for (i = 0; i < n.length; i++) {
            if (n[i].checked) {
            sum += parseInt(n[i].value);
            }
        }
    $("#tot").val(sum);
}



  $('#form').submit(function (e) {
  e.preventDefault();
  var n = $("#total").val();
  var formData = new FormData($("#form")[0]);


  if(n != 0)
  {
       $.ajax({
            url: $("#form").attr('action'),
            type: 'post',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {

                console.log('token = ' + data);

                var resultType = document.getElementById('result-type');
                var resultData = document.getElementById('result-data');

                function changeResult(type, data) {

                  // location.reload();
                  $("#result-type").val(type);
                  $("#result-data").val(JSON.stringify(data));
                  resultType.innerHTML = type;
                  resultData.innerHTML = JSON.stringify(data);
                }

                snap.pay(data, {

                  onSuccess: function(result) {
                    changeResult('success', result);
                    console.log(result.status_message);
                    console.log(result);
                    $("#payment-form").submit();
                  },
                  onPending: function(result) {
                    changeResult('pending', result);
                    console.log(result.status_message);
                    $("#payment-form").submit();
                  },
                  onError: function(result) {
                    changeResult('error', result);
                    console.log(result.status_message);
                    $("#payment-form").submit();
                  }
                });
            }
          });

  }
  else
  {
      alert('Silahkan Pilih Bulan Pembayaran');
  }

});


  $('#frm').submit(function (e) {
  e.preventDefault();
  var n = $("#tot").val();
  var formData = new FormData($("#frm")[0]);


  if(n != 0)
  {
       $.ajax({
            url: $("#frm").attr('action'),
            type: 'post',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (data) {

                console.log('token = ' + data);

                var resultType = document.getElementById('result-type');
                var resultData = document.getElementById('result-data');

                function changeResult(type, data) {

                  // location.reload();
                  $("#result-type").val(type);
                  $("#result-data").val(JSON.stringify(data));
                  resultType.innerHTML = type;
                  resultData.innerHTML = JSON.stringify(data);
                }

                snap.pay(data, {

                  onSuccess: function(result) {
                    changeResult('success', result);
                    console.log(result.status_message);
                    console.log(result);
                    $("#payment-form").submit();
                  },
                  onPending: function(result) {
                    changeResult('pending', result);
                    console.log(result.status_message);
                    $("#payment-form").submit();
                  },
                  onError: function(result) {
                    changeResult('error', result);
                    console.log(result.status_message);
                    $("#payment-form").submit();
                  }
                });
            }
          });

  }
  else
  {
      alert('Silahkan Pilih Tagihan Pembayaran');
  }

});



</script>
