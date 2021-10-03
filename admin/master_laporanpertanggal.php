<?php if ($_GET[act]==''){ ?> 
  
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <form method="GET">

            <input type="hidden" name="view" value="<?= $_GET[view] ?>">
            <div class="row">
              <div class="col-md-2">
                <label>Tahun Ajaran</label>
                <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
                <select class="form-control" name="thn_ajar" id="Ctahunajaran2" required=""></select>
              </div>
              <div class="col-md-2">
                <label>Unit Sekolah</label>
                <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                <select id="Cunit" name="unit" class="form-control" required></select>
              </div>
              <div class="col-md-2">
                <label>Kelas</label>
                <input type="hidden" id="idKelas" value="<?= $_GET[kelas] ?>">
                <input type="hidden" id="tipe_kelas" value="semuaKelas">
                <select id="Ckelas" name="kelas" class="form-control" required>
                  <option disabled selected>- Pilih Kelas -</option>
                </select>
              </div>
              <div class="col-md-2">
                <label>Dari Tanggal</label>
                <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input class="form-control" type="text" name="tgl_mulai"readonly="readonly" placeholder="Tanggal Awal" value="<?= $_GET['tgl_mulai']?>">
                </div>
              </div>
              <div class="col-md-2">
                <label>Sampai Tanggal</label>
                <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input class="form-control" type="text" name="tgl_akhir"readonly="readonly" placeholder="Sampai Tanggal" value="<?= $_GET['tgl_akhir']?>">
                </div>
              </div>
              <div class="col-md-2">
                <div style="margin-top:25px;">
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

<?php if (isset($_GET['thn_ajar']) && isset($_GET['unit']) && isset($_GET['kelas']) && isset($_GET['tgl_mulai']) && isset($_GET['tgl_akhir'])) {  ?>


  <?php
    $idTahunAjaran = $_GET['thn_ajar'];
    $idUnit = $_GET['unit'];
    $idKelas = $_GET['kelas'];
    $tgl_mulai = $_GET['tgl_mulai'];
    $tgl_akhir = $_GET['tgl_akhir'];

    $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    if ($idKelas !='all'){
      $kls = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));
      $kelas=$kls['nmKelas'];
    }else{
      $kelas = 'Semua Kelas';
    }

  ?>

    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Pembayaran <?= $kelas ?> T.A. <?= $ta['nmTahunAjaran'] ?> Tanggal <?= tgl_miring($tgl_mulai) ?> Sampai <?= tgl_miring($tgl_akhir) ?></h3>
        </div>
        <div class="box-body table-responsive">
          <table class="table">
            <tbody>
              <tr>
                <td>
                <?php 
                  $sql_jenis_bayar = mysqli_query($koneksi,"SELECT jenis_bayar.*, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idUnit='$idUnit' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'");
                  while ($jenis_bayar = mysqli_fetch_array($sql_jenis_bayar)) {
                    echo '<h4><strong>'.$jenis_bayar['nmPosBayar'].' - T.A.'.$ta['nmTahunAjaran'].'</strong></h4>';
                    echo '<div class="box-body table-responsive">
                            <table id="example7" class="table table-hover table-bordered dataTable no-footer text-center" style="white-space: nowrap;">
                              <thead>
                                <tr>
                                  <th>No.</th>
                                  <th>Tanggal</th>
                                  <th>NIS</th>
                                  <th>Nama</th>
                                  <th>Nominal</th>
                                  <th>Keterangan</th>
                                </tr>
                              </thead>
                              <tbody>';

                                $total_pembayaran = 0;

                                if ($jenis_bayar['tipeBayar'] == 'Bulanan'){

                                  if ($idKelas == 'all'){
                                    $sqlBayarBulanan=mysqli_query($koneksi,"SELECT siswa.nisSiswa, siswa.nmSiswa, tagihan_bulanan.*, bulan.nmBulan FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa LEFT JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan WHERE tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.tglBayar BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa.stdel='0' ORDER BY tagihan_bulanan.tglBayar ASC");
                                  }else{
                                    $sqlBayarBulanan=mysqli_query($koneksi,"SELECT siswa.nisSiswa, siswa.nmSiswa, tagihan_bulanan.*, bulan.nmBulan FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa LEFT JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan WHERE tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.tglBayar BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa.stdel='0' AND siswa.kelasSiswa='$idKelas' ORDER BY tagihan_bulanan.tglBayar ASC");
                                  }
                                  $no = 1;
                                  while ($bayarBulanan = mysqli_fetch_array($sqlBayarBulanan)) {
                                    echo '<tr>
                                            <td>'.$no++.'</td>
                                            <td>'.tgl_miring(date('Y-m-d',strtotime($bayarBulanan['tglBayar']))).'</td>
                                            <td>'.$bayarBulanan['nisSiswa'].'</td>
                                            <td>'.$bayarBulanan['nmSiswa'].'</td>
                                            <td>'.buatRp($bayarBulanan['jumlahTagihan']).'</td>
                                            <td>'.$bayarBulanan['nmBulan'].'</td>
                                          </tr>';
                                    $total_pembayaran += $bayarBulanan['jumlahTagihan'];
                                  } 
                                }else{

                                  if ($idKelas == 'all'){
                                    $sqlBayarBebas=mysqli_query($koneksi,"SELECT siswa.nisSiswa, siswa.nmSiswa, tagihan_bebas_bayar.*, tagihan_bebas.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa = tagihan_bebas.idSiswa LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas WHERE tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.tglBayar BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa.stdel='0' ORDER BY tagihan_bebas_bayar.tglBayar ASC");
                                  }else{
                                    $sqlBayarBebas=mysqli_query($koneksi,"SELECT siswa.nisSiswa, siswa.nmSiswa, tagihan_bebas_bayar.*, tagihan_bebas.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa = tagihan_bebas.idSiswa LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas WHERE tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.tglBayar BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa.kelasSiswa='$idKelas' AND siswa.stdel='0' ORDER BY tagihan_bebas_bayar.tglBayar ASC");
                                  }

                                  $no = 1;
                                  while ($bayarBebas = mysqli_fetch_array($sqlBayarBebas)) {
                                    echo '<tr>
                                            <td>'.$no++.'</td>
                                            <td>'.tgl_miring(date('Y-m-d',strtotime($bayarBebas['tglBayar']))).'</td>
                                            <td>'.$bayarBebas['nisSiswa'].'</td>
                                            <td>'.$bayarBebas['nmSiswa'].'</td>
                                            <td>'.buatRp($bayarBebas['jumlahBayar']).'</td>
                                            <td>'.$bayarBebas['ketBebas'].'</td>
                                          </tr>';
                                    $total_pembayaran += $bayarBebas['jumlahBayar'];
                                  } 

                                }

                      echo '    </tbody>
                                <tfoot>
                                  <tr style="background-color: #f0f0f0">
                                    <td colspan="4"><strong>Total Pembayaran</strong></td>
                                    <td>'.buatRp($total_pembayaran).'</td>
                                    <td></td>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>';
                   
                  }
                ?>
                </td>
              </tr>
            </tbody>
         </table>
        </div>
        <div class="box-footer">
          <a class="pull-right btn btn-danger" target="_blank" href="admin/laporan/cetak_laporan_pertanggal.php?thn_ajar=<?= $idTahunAjaran ?>&unit=<?= $idUnit ?>&kelas=<?= $idKelas ?>&tgl_mulai=<?= $tgl_mulai ?>&tgl_akhir=<?= $tgl_akhir ?>"><span class="glyphicon glyphicon-print"></span> Cetak PDF</a>
        </div>
      </div>
    </div>

<?php } ?>
