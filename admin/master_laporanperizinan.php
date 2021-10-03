<?php if ($_GET[act]==''){ ?> 
  
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <form method="GET">

            <input type="hidden" name="view" value="<?= $_GET[view] ?>">
            <div class="row">
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
                <label>Tahun Ajaran</label>
                <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
                <select class="form-control" name="thn_ajar" id="Ctahunajaran2" required=""></select>
              </div>
              <div class="col-md-2">
                <label>Kategori Perizinan</label>
                <select class="form-control" name="kategori" required="">
                  <option disabled selected value=""> - Pilih Kategori -</option>
                  <?php 
                    if ($_GET['kategori'] == 'Pulang Kerumah'){
                      echo '<option value="Pulang Kerumah" selected>Pulang Kerumah</option>';
                    }else{
                      echo '<option value="Pulang Kerumah">Pulang Kerumah</option>';
                    }

                    if ($_GET['kategori'] == 'Keluar Pesantren'){
                      echo '<option value="Keluar Pesantren" selected>Keluar Pesantren</option>';
                    }else{
                      echo '<option value="Keluar Pesantren">Keluar Pesantren</option>';
                    }
                  ?>
                </select>
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
                <label>Kamar</label>
                <input type="hidden" id="idKamar" value="<?= $_GET[kamar] ?>">
                <input type="hidden" id="tipe_kamar" value="semuaKamar">
                <select id="Ckamar" name="kamar" class="form-control" required>
                  <option disabled selected>- Pilih Kelas -</option>
                </select>
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

<?php if (isset($_GET['tgl_mulai']) && isset($_GET['tgl_akhir']) && isset($_GET['thn_ajar'])  && isset($_GET['kategori']) && isset($_GET['unit']) && isset($_GET['kelas']) && isset($_GET['kamar'])) {  ?>

  <?php
    $tgl_mulai = $_GET['tgl_mulai'];
    $tgl_akhir = $_GET['tgl_akhir'];
    $idTahunAjaran = $_GET['thn_ajar'];
    $kategori = $_GET['kategori'];
    $idUnit = $_GET['unit'];
    $idKelas = $_GET['kelas'];
    $idKamar = $_GET['kamar'];

    $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    $unit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$idUnit'"));
    if ($idKelas !='all'){
      $kls = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));
      $kelas='Kelas '.$kls['nmKelas'];
    }else{
      $kelas = 'Semua Kelas';
    }
    if ($idKamar !='all'){
      $kmr = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kamar WHERE idKamar='$idKamar'"));
      $kamar='Kamar '.$kmr['namaKamar'];
    }else{
      $kamar = 'Semua Kamar';
    }

  ?>

    <div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Perizinan <?= $kategori ?> <?= $kelas ?> <?= $kamar ?> T.A. <?= $ta['nmTahunAjaran'] ?> Tanggal <?= tgl_miring($tgl_mulai) ?> Sampai <?= tgl_miring($tgl_akhir) ?></h3>
        </div>
        <div class="box-body table-responsive">

          <?php 
            if ($kategori == 'Pulang Kerumah'){
          ?>
              <table id="example1" class="table table-hover table-bordered dataTable no-footer text-center" style="white-space: nowrap;">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Kamar</th>
                    <th>Penjemput</th>
                    <th>Waktu Izin</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                      
                      if ($idKelas == 'all' && $idKamar == 'all'){
                        $sql_izin = mysqli_query($koneksi,"SELECT izin_pulang.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_pulang LEFT JOIN siswa ON izin_pulang.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_pulang.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_pulang.idTahunAjaran='$idTahunAjaran' AND izin_pulang.stdel='0' AND siswa.unitSiswa='$idUnit' ORDER BY izin_pulang.tanggal ASC");
                      }elseif ($idKelas != 'all' && $idKamar == 'all'){
                        $sql_izin = mysqli_query($koneksi,"SELECT izin_pulang.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_pulang LEFT JOIN siswa ON izin_pulang.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_pulang.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_pulang.idTahunAjaran='$idTahunAjaran' AND izin_pulang.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' ORDER BY izin_pulang.tanggal ASC");
                      }elseif ($idKelas != 'all' && $idKamar == 'all'){
                        $sql_izin = mysqli_query($koneksi,"SELECT izin_pulang.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_pulang LEFT JOIN siswa ON izin_pulang.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_pulang.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_pulang.idTahunAjaran='$idTahunAjaran' AND izin_pulang.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kamarSiswa='$idKamar' ORDER BY izin_pulang.tanggal ASC");
                      }else{
                        $sql_izin = mysqli_query($koneksi,"SELECT izin_pulang.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_pulang LEFT JOIN siswa ON izin_pulang.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_pulang.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_pulang.idTahunAjaran='$idTahunAjaran' AND izin_pulang.stdel='0'  AND siswa.kelasSiswa='$idKelas' AND siswa.unitSiswa='$idUnit' AND siswa.kamarSiswa='$idKamar' ORDER BY izin_pulang.tanggal ASC");
                      }
                      $no=1;
                      while ($izin = mysqli_fetch_array($sql_izin)) {
                       echo '<tr>
                              <td>'.$no++.'</td>
                              <td>'.tgl_miring($izin['tanggal']).'</td>
                              <td>'.$izin['nisSiswa'].'</td>
                              <td>'.$izin['nmSiswa'].'</td>
                              <td>'.$izin['nmKelas'].'</td>
                              <td>'.$izin['namaKamar'].'</td>
                              <td>'.$izin['penjemput'].'</td>
                              <td>'.$izin['waktuIzin'].' Hari</td>
                              <td>'.$izin['keterangan'].'</td>
                            </tr>';
                       
                      }
                    ?>
                </tbody>
              </table>
          <?php
            }elseif ($kategori == 'Keluar Pesantren'){
          ?>       
             <table id="example1" class="table table-hover table-bordered dataTable no-footer text-center" style="white-space: nowrap;">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Kamar</th>
                    <th>Jam Keluar</th>
                    <th>Jam Kembali</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                      
                      if ($idKelas == 'all' && $idKamar == 'all'){
                        $sql_izin = mysqli_query($koneksi,"SELECT izin_keluar.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_keluar LEFT JOIN siswa ON izin_keluar.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_pulang.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_keluar.idTahunAjaran='$idTahunAjaran' AND izin_keluar.stdel='0' AND siswa.unitSiswa='$idUnit' ORDER BY izin_keluar.tanggal ASC");
                      }elseif ($idKelas != 'all' && $idKamar == 'all'){
                        $sql_izin = mysqli_query($koneksi,"SELECT izin_keluar.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_keluar LEFT JOIN siswa ON izin_pulang.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_keluar.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_keluar.idTahunAjaran='$idTahunAjaran' AND izin_keluar.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' ORDER BY izin_keluar.tanggal ASC");
                      }elseif ($idKelas != 'all' && $idKamar == 'all'){
                        $sql_izin = mysqli_query($koneksi,"SELECT izin_keluar.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_keluar LEFT JOIN siswa ON izin_keluar.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_keluar.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_keluar.idTahunAjaran='$idTahunAjaran' AND izin_keluar.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kamarSiswa='$idKamar' ORDER BY izin_keluar.tanggal ASC");
                      }else{
                        $sql_izin = mysqli_query($koneksi,"SELECT izin_keluar.*, siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_keluar LEFT JOIN siswa ON izin_keluar.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE DATE(izin_keluar.tanggal) BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND izin_keluar.idTahunAjaran='$idTahunAjaran' AND izin_keluar.stdel='0'  AND siswa.kelasSiswa='$idKelas' AND siswa.unitSiswa='$idUnit' AND siswa.kamarSiswa='$idKamar' ORDER BY izin_keluar.tanggal ASC");
                      }
                      $no=1;
                      while ($izin = mysqli_fetch_array($sql_izin)) {
                       echo '<tr>
                              <td>'.$no++.'</td>
                              <td>'.tgl_miring($izin['tanggal']).'</td>
                              <td>'.$izin['nisSiswa'].'</td>
                              <td>'.$izin['nmSiswa'].'</td>
                              <td>'.$izin['nmKelas'].'</td>
                              <td>'.$izin['namaKamar'].'</td>
                              <td>'.$izin['penjemput'].'</td>
                              <td>'.$izin['waktuIzin'].' Hari</td>
                              <td>'.$izin['keterangan'].'</td>
                            </tr>';
                       
                      }
                    ?>
                </tbody>
              </table>
          <?php
            }
          ?>

          
        </div>
        <div class="box-footer">
          <div class="pull-right">
            <a class="btn btn-success" target="_blank" href="admin/excel/export_laporan_perizinan.php?tgl_mulai=<?= $_GET[tgl_mulai]?>&tgl_akhir=<?= $_GET[tgl_akhir]?>&thn_ajar=<?= $_GET[thn_ajar]?>&kategori=<?= $_GET[kategori]?>&unit=<?= $_GET[unit]?>&kelas=<?= $_GET[kelas]?>&kamar=<?= $_GET[kamar]?>"><span class="fa fa-file-excel-o"></span> Cetak Excel</a>
            
          </div>
        </div>
      </div>
    </div>

<?php } ?>
