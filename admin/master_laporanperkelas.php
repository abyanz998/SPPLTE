<?php if ($_GET[act]==''){ ?> 
  
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <form method="GET">

            <input type="hidden" name="view" value="<?= $_GET[view] ?>">
            <div class="row">
              <div class="col-md-3">
                <label>Tahun Ajaran</label>
                <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
                <select class="form-control" name="thn_ajar" id="Ctahunajaran2" required=""></select>
              </div>
              <div class="col-md-3">
                <label>Unit Sekolah</label>
                <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                <select id="Cunit" name="unit" class="form-control" required=""></select>
              </div>
              <div class="col-md-3">
                <label>Jenis Pembayaran</label>
                <input type="hidden" id="idJenisPembayaran" value="<?= $_GET[jenis] ?>">
                <select name="jenis" id="Cjenispembayaran" class="form-control" required="">
                  <option value="">--Pilih Jenis Pembayaran--</option>
                </select>
              </div>
              <div class="col-md-2">
                <label>Kelas</label>
                <input type="hidden" id="idKelas" value="<?= $_GET[kelas] ?>">
                <input type="hidden" id="tipe_kelas" value="semuaKelas">
                <select id="Ckelas" name="kelas" class="form-control" required=>
                  <option disabled selected>- Pilih Kelas -</option>
                </select>
              </div>
              <div class="col-md-1">
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

<?php if (isset($_GET['thn_ajar']) && isset($_GET['unit']) && isset($_GET['jenis']) && isset($_GET['kelas'])) {  ?>

  <?php
    $idTahunAjaran = $_GET['thn_ajar'];
    $idUnit = $_GET['unit'];
    $idJenisBayar = $_GET['jenis'];
    $idKelas = $_GET['kelas'];

    $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    $jenis_bayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT jenis_bayar.*, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idJenisBayar='$idJenisBayar'"));
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
        <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Pembayaran <?= $jenis_bayar['nmPosBayar'] ?> - T.A <?= $ta['nmTahunAjaran'] ?>  <?= $kelas ?></h3>
      </div>
      <div class="box-body table-responsive">
        <table id="example7" class="table table-hover table-bordered dataTable no-footer text-center" style="white-space: nowrap;">

          <?php
          if ($jenis_bayar['tipeBayar'] == 'Bulanan'){
            if ($idKelas == 'all'){
              $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.* FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' GROUP BY siswa.idSiswa");
            }else{
              $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.* FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' AND siswa.kelasSiswa='$idKelas' GROUP BY siswa.idSiswa");
            }
          }elseif ($jenis_bayar['tipeBayar'] == 'Bebas'){
            if ($idKelas == 'all'){
              $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bebas.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa = tagihan_bebas.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' GROUP BY siswa.idSiswa");
            }else{
              $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bebas.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa = tagihan_bebas.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' AND siswa.kelasSiswa='$idKelas' GROUP BY siswa.idSiswa");
            }
          }

          if ($jenis_bayar['tipeBayar'] == 'Bulanan'){
            echo "<thead>
                    <tr>
                      <th>No</th>
                      <th>NIS</th>
                      <th>Nama</th>";
                      $bulan = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
                      while ($bln = mysqli_fetch_array($bulan)) {
                        echo '<th>'.$bln['nmBulan'].'</th>';
                      }
            echo "  </tr>
                  </thead>
                  <tbody>";
                    $no = 1;
                    while ($siswa = mysqli_fetch_array($sqlSiswa)) {
                      echo "<tr>
                              <td>".$no++."</td>
                              <td>".$siswa['nisSiswa']."</td>
                              <td>".$siswa['nmSiswa']."</td>";
                              $bulan = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
                              while ($bln = mysqli_fetch_array($bulan)) {
                                $tagihanBulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bulanan.*, jenis_bayar.idTahunAjaran FROM tagihan_bulanan LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' AND jenis_bayar.idTahunAjaran='$ta[idTahunAjaran]' AND idBulan='$bln[idBulan]'"));
                                if ($tagihanBulanan['statusBayar'] == '1'){
                                  $keterangan = buatRp($tagihanBulanan['jumlahTagihan']).'<br>'.date('d/m/Y',strtotime($tagihanBulanan['tglBayar']));
                                }else{
                                  $keterangan = '-';
                                }
                                echo '<td>'.$keterangan.'</td>';
                              }
                      echo "</tr>";
                    }

            echo "</tbody>";




          }elseif ($jenis_bayar['tipeBayar'] == 'Bebas'){
            echo "<thead>
                    <tr>
                      <th>No</th>
                      <th>NIS</th>
                      <th>Nama</th>
                      <th>Tagihan</th>
                      <th>Sudah Dibayar</th>
                      <th>Kekurangan</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>";
                    $no = 1;
                    $total_pembayaran_siswa=0;
                    while ($siswa = mysqli_fetch_array($sqlSiswa)) {
                      $tagihanBebas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.idTagihanBebas, SUM(tagihan_bebas.totalTagihan) as totalTagihanBebas, jenis_bayar.idTahunAjaran FROM tagihan_bebas LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' AND jenis_bayar.idTahunAjaran='$ta[idTahunAjaran]'"));
                      $tagihanBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(jumlahBayar) as totalTagihanBebasBayar FROM tagihan_bebas_bayar WHERE idTagihanBebas='$tagihanBebas[idTagihanBebas]' GROUP BY idTagihanBebas"));
                      
                      $sisaTagihanBebas = $tagihanBebas['totalTagihanBebas'] - $tagihanBebasBayar['totalTagihanBebasBayar'];
                      if ($sisaTagihanBebas == 0){
                        $keterangan = 'LUNAS';
                      }else{
                        $keterangan = 'BELUM LUNAS';
                      }

                      echo "<tr>
                              <td>".$no++."</td>
                              <td>".$siswa['nisSiswa']."</td>
                              <td>".$siswa['nmSiswa']."</td>
                              <td>".buatRp($tagihanBebas['totalTagihanBebas'])."</td>
                              <td>".buatRp($tagihanBebasBayar['totalTagihanBebasBayar'])."</td>
                              <td>".buatRp($sisaTagihanBebas)."</td>
                              <td>".$keterangan."</td>
                            </tr>";
                      $total_pembayaran_siswa += $tagihanBebasBayar['totalTagihanBebasBayar'];
                    }
                    echo "</tbody>
                          <tfoot>
                            <tr class='info'>
                              <th colspan='4'>Total Pembayaran Siswa</th>
                              <th>".buatRp($total_pembayaran_siswa)."</th>
                              <th colspan='2'></th>
                            </tr>
                          </tfoot>";
                    
              }
            ?>
        </table>
      </div>         
      <div class="box-footer">
        <a class="btn btn-success" target="_blank" href="admin/excel/export_laporan_perkelas.php?thn_ajar=<?=$idTahunAjaran?>&unit=<?=$idUnit?>&jenis=<?=$idJenisBayar?>&kelas=<?=$idKelas?>&<?=$jenis_bayar['tipeBayar']?>"><i class="fa fa-file-excel-o"></i> Export Excel</a>
        <a class="pull-right btn btn-danger" target="_blank" href="admin/laporan/cetak_laporan_perkelas.php?thn_ajar=<?=$idTahunAjaran?>&unit=<?=$idUnit?>&jenis=<?=$idJenisBayar?>&kelas=<?=$idKelas?>&<?=$jenis_bayar['tipeBayar']?>"><span class="glyphicon glyphicon-print"></span> Cetak PDF</a>
      </div>
    </div>
  </div>


<?php } ?>
