<?php if ($_GET[act]==''){ ?> 
  
  <div class="col-md-12">  
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Filter Data Kesehataan Santri</h3>
      </div>
      <div class="box-body">
        <form action="" class="form-horizontal" method="get" accept-charset="utf-8">
          <input type="hidden" name="view" value="<?= $_GET['view']?>">
          <div class="form-group">            
            <label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
            <div class="col-sm-2">
              <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
              <select class="form-control" name="thn_ajar" id="Ctahunajaran">

              </select>
              </div>
              <label for="" class="col-sm-2 control-label">Cari Santri</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="text" class="form-control" autofocus="" name="nis" id="student_nis" placeholder="NIS Santri" required="" value="<?= $_GET['nis']?>">
                  <span class="input-group-btn">
                    <button class="btn btn-success" type="submit">Cari</button>
                  </span>
                  <span class="input-group-btn">
                  </span>
                  <span class="input-group-btn">
                  </span>
                  <span class="input-group-btn">
                  </span>
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#dataSantri"><b>Data Santri</b></button>
                  </span>
                </div>
              </div>
            </div>
          </form>
        </div>
    </div><!-- /.box -->
  </div>


  <div class="modal fade in" id="dataSantri" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Cari Data Santri</h4>
        </div>
        <div class="modal-body">
            <div class="box-body table-responsive">
              <table id="example1" class="table table-hover dataTable no-footer">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nis</th>
                        <th>Nama</th>
                        <th>Unit</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      if($idUnitUsers != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$idUnitUsers' ORDER BY siswa.idSiswa DESC");
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' ORDER BY siswa.idSiswa DESC");
                      }
                      
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        echo "<tr>
                              <td>$no</td>
                              <td>$r[nisSiswa]</td>
                              <td>$r[nmSiswa]</td>
                              <td>$r[singkatanUnit]</td>
                              <td>$r[nmKelas]</td>
                              <td>
                                <center><button type='button' data-dismiss='modal' class='btn btn-primary btn-xs' onclick=\"ambil_data('$r[nisSiswa]')\">Pilih</button></center>
                              </td>
                            </tr>";
                      $no++;
                      }
                      

                  ?>
                    </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
  </div>
<?php } ?>

 <script>
    function ambil_data(nisSiswa){
      var nisSiswa = nisSiswa;
      var thAjaran    = $("#Ctahunajaran").val();
            
      window.location.href = 'index.php?view=<?= $_GET[view]?>&thn_ajar='+thAjaran+'&nis='+nisSiswa;
    }
</script>


<?php if (isset($_GET['thn_ajar']) && isset($_GET['nis'])) { 


$siswa = mysqli_fetch_array(mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas WHERE siswa.nisSiswa='$_GET[nis]'"));
$thn = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$_GET[thn_ajar]'"));

if (empty($siswa['fotoSiswa'])){
  $fotoSiswa = $lokasi_default_fotoSiswa;
}else{
  $fotoSiswa = $lokasi_penyimpanan_fotoSiswa.$siswa['fotoSiswa'];
}

//notif
if ($_SESSION['notif'] == 'csukses'){
  echo '<script>toastr["success"]("Data berhasil disimpan.","Sukses!")</script>';
}elseif ($_SESSION['notif'] == 'dsukses'){
  echo '<script>toastr["success"]("Data berhasil dihapus.","Sukses!")</script>';
}elseif($_SESSION['notif'] == 'gagal'){
  echo '<script>toastr["error"]("Data gagal diproses.","Gagal!")</script>';
}unset($_SESSION['notif']);

?> 
<div class="col-md-12">
      
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Informasi Santri</h3>
            <a href="siswa/laporan/buku_kesehatan.php?nis=<?= $siswa[nisSiswa]; ?>&thn_ajar=<?= $_GET[thn_ajar]; ?>" target="_blank" class="btn btn-danger btn-xs pull-right">Cetak Buku Kesehatan</a>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="col-md-9">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <td width="200">Tahun Ajaran</td><td width="4">:</td>
                      <td><strong><?= $thn['nmTahunAjaran'] ?><strong></strong></strong></td> 
                    </tr>
                  <tr>
                    <td>NIS</td>
                    <td>:</td>
                    <td><?= $siswa['nisSiswa'] ?></td> 
                  </tr>
                  <tr>
                    <td>Nama Santri</td>
                    <td>:</td>
                    <td><?= $siswa['nmSiswa'] ?></td> 
                  </tr>
                  <tr>
                    <td>Unit Sekolah</td>
                    <td>:</td>
                    <td><?= $siswa['singkatanUnit'] ?></td> 
                  </tr>
                  <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td><?= $siswa['nmKelas'] ?></td> 
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-3">
              <img src="<?= $fotoSiswa ?>" class="img-thumbnail img-responsive">
            </div>
          </div>
        </div>
        
        <!-- List Tagihan Bulanan --> 
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Kesehatan Santri</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Tambah Riwayat Kesehatan Santri</a></li>
                <li><a href="#tab_2" data-toggle="tab">Riwayat Kesehatan Santri</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <div class="box-body">
                    <div class="row">    
                      <?php
                        //simpan
                          if (isset($_POST['tambah'])){
                            $query = mysqli_query($koneksi,"INSERT INTO siswa_kesehatan(siswa,tahunAjaran,tanggal,nmSakit,obat,keterangan,stdel,cby,cdate) VALUES ('$_POST[kesehatan_id_siswa]','$_POST[kesehatan_periode]','$_POST[kesehatan_tanggal]','$_POST[kesehatan_sakit]','$_POST[kesehatan_obat]','$_POST[kesehatan_keterangan_sakit]','0','$idUsers','$waktu_sekarang')");
                            if ($query){
                              $_SESSION['notif'] = 'csukses';
                              echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
                            }else{
                              $_SESSION['notif'] = 'gagal';
                              echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
                            }
                          }
                      ?>

                      <form action="index.php?view=<?= $_GET[view] ?>&thn_ajar=<?= $_GET[thn_ajar]?>&nis=<?= $_GET[nis]?>" method="post" accept-charset="utf-8">
                        <input type="hidden" name="kesehatan_periode" value="<?= $_GET['thn_ajar']?>">
                        <input type="hidden" name="kesehatan_id_siswa" value="<?= $siswa['idSiswa']?>"> 
                                        
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label>Tanggal</label>
                                  <div class="input-group date date-picker " data-date="" data-date-format="yyyy-mm-dd">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input class="form-control md-3" required="" type="text" name="kesehatan_tanggal" placeholder="Tanggal Sakit" value="<?= $tanggal_sekarang ?>">
                                  </div>
                                </div>
                              </div>
                              
                              <div class="col-md-3">
                            <div class="form-group">
                              <label>Sakit</label>
                              <input type="text" class="form-control" required="" name="kesehatan_sakit" placeholder="Sakit yang Diderita Santri">
                            </div>
                            </div>
                            
                              <div class="col-md-6">
                            <div class="form-group">
                              <label>Obat</label>
                              <input type="text" class="form-control" required="" name="kesehatan_obat" placeholder="Obat yang Diberikan">
                            </div>
                              </div>
                            
                              <div class="col-md-12">
                            <div class="form-group">
                              <label>Keterangan Sakit</label>
                              <input type="text" class="form-control" required="" name="kesehatan_keterangan_sakit" placeholder="Keterangan Sakit yang Diderita Santri">
                            </div>
                              </div>
                            
                              <div class="col-md-6">
                                <button type="submit" name="tambah" class="btn btn-success">Simpan</button>
                                <button type="reset" class="btn btn-default">Kosongkan</button>
                            </div>
                          </form></div>    
                          </div>
                        </div>


                <div class="tab-pane" id="tab_2">
                  <div class="box-body table-responsive">
                    <?php
                    //hapus
                      if (isset($_POST['hapus'])){
                        $query = mysqli_query($koneksi," UPDATE siswa_kesehatan SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idKesehatan='$_POST[idKesehatan]'");
                        if ($query){
                          $_SESSION['notif'] = 'dsukses';
                          echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
                        }else{
                          $_SESSION['notif'] = 'gagal';
                          echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
                        }
                      }
                    ?>
                    <table class="table table-bordered" style="white-space: nowrap;">
                      <thead>
                        <tr class="info">
                          <th>No.</th>
                          <th>Tanggal</th>
                          <th>Sakit</th>
                          <th>Obat</th>
                          <th>Keterangan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $tampil = mysqli_query($koneksi,"SELECT * FROM siswa_kesehatan WHERE siswa = '$siswa[idSiswa]' AND tahunAjaran='$_GET[thn_ajar]' AND stdel='0'");
                          $no = 1;
                          while($r=mysqli_fetch_array($tampil)){
                            echo '<tr>
                                    <td>'.$no++.'</td>
                                    <td>'.$r['tanggal'].'</td>
                                    <td>'.$r['nmSakit'].'</td>
                                    <td>'.$r['obat'].'</td>
                                    <td>'.$r['keterangan'].'</td>
                                    <td>
                                    <a href="siswa/laporan/surat_izin.php?id='.$siswa[idSiswa].'&kesehatan='.$r[idKesehatan].'" target="_blank" data-toggle="modal" class="btn btn-xs btn-default"><i class="fa fa-print" data-toggle="tooltip" title="" data-original-title="Cetak Surat"></i></a>
                                    <a href="#del'.$r['idKesehatan'].'" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="" data-original-title="Hapus"></i></a>
                                    </td>
                                  </tr>';

                           echo '<div class="modal modal-default fade" id="del'.$r['idKesehatan'].'">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">×</span></button>
                                          <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                                        </div>
                                        <div class="modal-body">
                                          <p>Apakah anda yakin akan menghapus data ini?</p>
                                        </div>
                                        <div class="modal-footer">
                                          <form action="index.php?view='.$_GET['view'].'&thn_ajar='.$_GET['thn_ajar'].'&nis='.$_GET['nis'].'" method="post" accept-charset="utf-8">
                                            <input type="hidden" name="idKesehatan" value="'.$r['idKesehatan'].'"> 
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                            <button type="submit" name="hapus" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>';
                          }
                        ?>    
                      </tbody>
                    </table>
                  </div>
                </div>
               
                </div>
                </div>
              </div>
            </div>
          </div>


<?php } ?>