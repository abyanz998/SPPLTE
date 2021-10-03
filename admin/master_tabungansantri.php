<?php if ($_GET[act]==''){ ?> 
  
  <div class="col-xs-12">  
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Filter Data <?= ucwords($_GET['view']) ?></h3>
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
                                <center><button type='button' data-dismiss='modal' class='btn btn-primary btn-xs' onclick='ambil_data(".$r['nisSiswa'].")'>Pilih</button></center>
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
if ($_SESSION['notif'] == 'setorsukses'){
  echo '<script>toastr["success"]("Data Setoran berhasil disimpan.","Sukses!")</script>';
}elseif ($_SESSION['notif'] == 'editsetorsukses'){
  echo '<script>toastr["success"]("Data Setoran berhasil diupdate.","Sukses!")</script>';
}elseif ($_SESSION['notif'] == 'hapussetorsukses'){
  echo '<script>toastr["success"]("Data Setoran berhasil dihapus.","Sukses!")</script>';
}elseif($_SESSION['notif'] == 'setorgagal'){
  echo '<script>toastr["error"]("Data Setoran gagal diproses.","Gagal!")</script>';
}elseif ($_SESSION['notif'] == 'tariksukses'){
  echo '<script>toastr["success"]("Data Penarikan berhasil disimpan.","Sukses!")</script>';
}elseif($_SESSION['notif'] == 'edittariksukses'){
  echo '<script>toastr["success"]("Data Penarikan berhasil diupdate.","Sukses!")</script>';
}elseif($_SESSION['notif'] == 'hapustariksukses'){
  echo '<script>toastr["success"]("Data Penarikan berhasil dihapus.","Sukses!")</script>';
}elseif($_SESSION['notif'] == 'tarikgagal'){
  echo '<script>toastr["error"]("Data Penarikan gagal diproses.","Gagal!")</script>';
}unset($_SESSION['notif']);

?> 
<div class="col-md-12">
      
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Informasi Santri</h3>
            <a href="siswa/laporan/buku_tabungan_siswa.php?nis=<?= $siswa[nisSiswa]; ?>&thn_ajar=<?= $_GET[thn_ajar]; ?>" target="_blank" class="btn btn-danger btn-xs pull-right">Cetak Buku Tabungan</a>
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
        
        <div class="row">

          <div class="col-md-5">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Transaksi Terakhir</h3>
              </div><!-- /.box-header -->
              
              <div class="box-body">
                <div class="table-responsive ">
                  <table class="table table-bordered" >
                    <thead>
                      <tr class="info">
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $Qtabungan = mysqli_query($koneksi,"SELECT * FROM tabungan_siswa WHERE stdel='0' AND siswa='$siswa[idSiswa]' AND tahunAjaran='$_GET[thn_ajar]' ORDER BY idTabungan DESC LIMIT 5");
                        while ($tabung = mysqli_fetch_array($Qtabungan)) {
                          echo '<tr>
                                  <td>'.tgl_raport($tabung['tgl']).'</td>
                                  <td>Rp. '.rupiah($tabung['nominal']).'</td>
                                  <td>'.($tabung['kode']).'</td>
                                </tr>';
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          


          <?php
            $total_setor = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as total FROM tabungan_siswa WHERE stdel='0' AND kode='SETORAN' AND siswa='$siswa[idSiswa]' AND tahunAjaran='$_GET[thn_ajar]'"));
            $total_tarik = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as total FROM tabungan_siswa WHERE stdel='0' AND kode='PENARIKAN' AND siswa='$siswa[idSiswa]' AND tahunAjaran='$_GET[thn_ajar]'"));
          ?>
          <div class="col-md-4">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Rekap Tabungan</h3>
              </div>
              <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Total Setoran</label>
                        <input type="text" class="form-control" name="total_setor" id="total_setor" value="<?= 'Rp. '.rupiah($total_setor['total']) ?>" placeholder="Total Setoran" readonly="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Total Penarikan</label>
                        <input type="text" class="form-control" name="total_tarik" id="total_tarik" value="<?= 'Rp. '.rupiah($total_tarik['total']) ?>" placeholder="Total Penarikan" readonly="">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Saldo</label>
                    <input type="text" class="form-control" readonly="" name="saldo" id="saldo" value="<?= 'Rp. '.rupiah($total_setor['total']-$total_tarik['total']) ?>" placeholder="Saldo Tabungan">
                  </div>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Cetak Bukti Transaksi</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                <form action="siswa/laporan/bukti_transaksi_tabungan.php" method="GET" class="view-pdf">
                  <input type="hidden" name="thn_ajar" value="<?= $_GET[thn_ajar] ?>">
                  <input type="hidden" name="nis" value="<?= $_GET[nis] ?>">
                  <div class="form-group">
                    <label>Tanggal Transaksi</label>
                    <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      <input class="form-control" readonly="" required="" type="text" name="tgl" value="<?= date('Y-m-d') ?>">
                    </div>
                  </div>
                  <button class="btn btn-success btn-block" formtarget="_blank" type="submit">Cetak</button>
                </form>
              </div>
            </div>
          </div>
        </div>



        <?php
          if(isset($_GET['setor'])){
            $query = mysqli_query($koneksi,"INSERT INTO tabungan_siswa(siswa,tahunAjaran,tgl,kode,nominal,catatan,stdel,cby,cdate) VALUES ('$_POST[setor_siswa]','$_POST[setor_tahun_ajaran]','$_POST[setor_tgl]','$_POST[setor_kode]','$_POST[setor_nominal]','$_POST[setor_catatan]','0','$idUsers','$waktu_sekarang')");
            if ($query){
              $_SESSION['notif'] = 'setorsukses';
            }else{
              $_SESSION['notif'] = 'setorgagal';
            }
            echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
          }
          if(isset($_GET['editsetor'])){
            $query = mysqli_query($koneksi,"UPDATE tabungan_siswa SET siswa='$_POST[setor_siswa]', tahunAjaran='$_POST[setor_tahun_ajaran]', tgl='$_POST[setor_tgl]', kode='$_POST[setor_kode]', nominal='$_POST[setor_nominal]', catatan='$_POST[setor_catatan]', uby='$idUsers', udate='$waktu_sekarang' WHERE idTabungan ='$_POST[setor_id]'");
            if ($query){
              $_SESSION['notif'] = 'editsetorsukses';
            }else{
              $_SESSION['notif'] = 'setorgagal';
            }
            echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
          }
          if(isset($_GET['hapussetor'])){
            $query = mysqli_query($koneksi,"UPDATE tabungan_siswa SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idTabungan ='$_POST[setor_id]'");
            if ($query){
              $_SESSION['notif'] = 'hapussetorsukses';
            }else{
              $_SESSION['notif'] = 'setorgagal';
            }
            echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
          }
        ?>
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Jenis Transaksi</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Setoran</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Penarikan</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <div class="box-body">
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addSetor"><i class="fa fa-plus"></i> Setor</button>

                    <!-- MODAL SETOR -->
                    <div class="modal fade in" id="addSetor" role="dialog">
                      <form action="index.php?view=<?= $_GET[view] ?>&thn_ajar=<?= $_GET[thn_ajar] ?>&nis=<?= $_GET[nis] ?>&setor" method="post" accept-charset="utf-8">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                              <h4 class="modal-title">Tambah Setoran</h4>
                            </div>
                            <div class="modal-body">
                              <input type="hidden" name="setor_siswa" value="<?= $siswa[idSiswa] ?>"> 
                              <input type="hidden" name="setor_tahun_ajaran" value="<?= $_GET[thn_ajar] ?>"> 
                              <input type="hidden" name="setor_kode" value="SETORAN">
                              <div class="form-group">
                                <label>Tanggal</label>
                                <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                  <input class="form-control" required="" type="text" readonly="" name="setor_tgl" value="<?= date('Y-m-d') ?>" placeholder="Tanggal Setor">
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Jumlah Setoran</label>
                                <input type="text" class="form-control" required="" name="setor_nominal" placeholder="Jumlah Setoran">
                              </div>
                              <div class="form-group">
                                <label>Catatan</label>
                                <input type="text" class="form-control" required="" name="setor_catatan" placeholder="Catatan">
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-info">Setor</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="box-body table-responsive">
                    <table class="table table-bordered" style="white-space: nowrap;">
                      <thead>
                        <tr class="info">
                          <th>No.</th>
                          <th>Tanggal</th>
                          <th>Kode</th>
                          <th>Nominal</th>
                          <th>Catatan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 1;
                          $QSetor = mysqli_query($koneksi,"SELECT * FROM tabungan_siswa WHERE stdel='0' AND kode='SETORAN' AND siswa='$siswa[idSiswa]' AND tahunAjaran='$_GET[thn_ajar]' ORDER BY idTabungan DESC");
                          while ($str = mysqli_fetch_array($QSetor)) {
                            echo '<tr>
                                    <td>'.$no++.'</td>
                                    <td>'.tgl_raport($str['tgl']).'</td>
                                    <td>'.$str['kode'].'</td>
                                    <td>Rp. '.rupiah($str['nominal']).'</td>
                                    <td>'.$str['catatan'].'</td>
                                    <td>
                                      <a href="#editSetor'.$str[idTabungan].'" data-toggle="modal" class="btn btn-xs btn-warning"><i class="fa fa-edit" data-toggle="tooltip" title="" data-original-title="Edit"></i></a>
                                      <a href="#delSetor'.$str[idTabungan].'" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="" data-original-title="Hapus"></i></a>
                                    </td>
                                  </tr>';

                            echo '<div class="modal fade" id="editSetor'.$str[idTabungan].'" role="dialog">
                                    <form action="index.php?view='.$_GET[view].'&thn_ajar='.$_GET[thn_ajar].'&nis='.$_GET[nis].'&editsetor" method="post" accept-charset="utf-8">
                                      <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">Edit Setoran</h4>
                                          </div>
                                          <div class="modal-body">
                                          <input type="hidden" name="setor_id" value="'.$str['idTabungan'].'"> 
                                          <input type="hidden" name="setor_siswa" value="'.$str['siswa'].'"> 
                                          <input type="hidden" name="setor_tahun_ajaran" value="'.$str['tahunAjaran'].'">
                                          <input type="hidden" name="setor_kode" value="SETORAN"> 
                                          <div class="form-group">
                                            <label>Tanggal</label>
                                            <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                              <input class="form-control" required="" type="text" readonly="" name="setor_tgl" value="'.date('Y-m-d',strtotime($str['tgl'])).'" placeholder="Tanggal Setor">
                                            </div>
                                          </div>
                                            <div class="form-group">
                                              <label>Jumlah Setoran</label>
                                              <input type="text" class="form-control" required="" name="setor_nominal" placeholder="Jumlah Setoran" value="'.$str['nominal'].'">
                                            </div>
                                            <div class="form-group">
                                              <label>Catatan</label>
                                              <input type="text" class="form-control" required="" name="setor_catatan" placeholder="Catatan" value="'.$str['catatan'].'">
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="submit" class="btn btn-info">Edit Setoran</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>';

                              echo '<div class="modal modal-default fade" id="delSetor'.$str[idTabungan].'">
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
                                            <form action="index.php?view='.$_GET[view].'&thn_ajar='.$_GET[thn_ajar].'&nis='.$_GET[nis].'&hapussetor" method="post" accept-charset="utf-8">
                                              <input type="hidden" name="setor_id" value="'.$str['idTabungan'].'">
                                              <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                              <button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                                            </form>
                                          </div>
                                        </div>
                                        <!-- /.modal-content -->
                                      </div>
                                      <!-- /.modal-dialog -->
                                    </div>';
                          }
                        ?>       
                      </tbody>
                    </table>
                  </div>
                </div>


                <?php
                  if(isset($_GET['tarik'])){
                    $query = mysqli_query($koneksi,"INSERT INTO tabungan_siswa(siswa,tahunAjaran,tgl,kode,nominal,catatan,stdel,cby,cdate) VALUES ('$_POST[tarik_siswa]','$_POST[tarik_tahun_ajaran]','$_POST[tarik_tgl]','$_POST[tarik_kode]','$_POST[tarik_nominal]','$_POST[tarik_catatan]','0','$idUsers','$waktu_sekarang')");
                    if ($query){
                      $_SESSION['notif'] = 'tariksukses';
                    }else{
                      $_SESSION['notif'] = 'tarikgagal';
                    }
                    echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
                  }
                  if(isset($_GET['edittarik'])){
                    $query = mysqli_query($koneksi,"UPDATE tabungan_siswa SET siswa='$_POST[tarik_siswa]', tahunAjaran='$_POST[tarik_tahun_ajaran]', tgl='$_POST[tarik_tgl]', kode='$_POST[tarik_kode]', nominal='$_POST[tarik_nominal]', catatan='$_POST[tarik_catatan]', uby='$idUsers', udate='$waktu_sekarang' WHERE idTabungan ='$_POST[tarik_id]'");
                    if ($query){
                      $_SESSION['notif'] = 'edittariksukses';
                    }else{
                      $_SESSION['notif'] = 'tarikgagal';
                    }
                    echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
                  }
                  if(isset($_GET['hapustarik'])){
                    $query = mysqli_query($koneksi,"UPDATE tabungan_siswa SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idTabungan ='$_POST[tarik_id]'");
                    if ($query){
                      $_SESSION['notif'] = 'hapustariksukses';
                    }else{
                      $_SESSION['notif'] = 'tarikgagal';
                    }
                    echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
                  }
                ?>
                <div class="tab-pane" id="tab_2">
                  <div class="box-body">
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addTarik"><i class="fa fa-minus"></i> Tarik</button>

                    <div class="modal fade in" id="addTarik" role="dialog">
                      <form action="index.php?view=<?= $_GET[view] ?>&thn_ajar=<?= $_GET[thn_ajar] ?>&nis=<?= $_GET[nis] ?>&tarik" method="post" accept-charset="utf-8">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                              <h4 class="modal-title"> Buat Penarikan</h4>
                            </div>
                            <div class="modal-body">
                            <input type="hidden" name="tarik_siswa" value="<?= $siswa[idSiswa] ?>"> 
                            <input type="hidden" name="tarik_tahun_ajaran" value="<?= $_GET[thn_ajar] ?>">
                            <input type="hidden" name="tarik_kode" value="PENARIKAN"> 
                                    
                            <div class="form-group">
                              <label>Tanggal</label>
                              <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input class="form-control" required="" type="text" name="tarik_tgl" value="<?= date('Y-m-d')?>" placeholder="Tanggal Setor">
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Jumlah Penarikan</label>
                              <input type="text" class="form-control" required="" name="tarik_nominal" placeholder="Jumlah Penarikan">
                            </div>
                            <div class="form-group">
                              <label>Catatan</label>
                              <input type="text" class="form-control" required="" name="tarik_catatan" placeholder="Catatan">
                            </div>
                          </form></div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Tarik</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="box-body table-responsive">
                    <table class="table table-bordered" style="white-space: nowrap;">
                      <thead>
                        <tr class="info">
                          <th>No.</th>
                          <th>Tanggal</th>
                          <th>Kode</th>
                          <th>Nominal</th>
                          <th>Catatan</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no = 1;
                          $QTarik = mysqli_query($koneksi,"SELECT * FROM tabungan_siswa WHERE stdel='0' AND kode='PENARIKAN' AND siswa='$siswa[idSiswa]' AND tahunAjaran='$_GET[thn_ajar]' ORDER BY idTabungan DESC");
                          while ($trk = mysqli_fetch_array($QTarik)) {
                            echo '<tr>
                                    <td>'.$no++.'</td>
                                    <td>'.tgl_raport($trk['tgl']).'</td>
                                    <td>'.$trk['kode'].'</td>
                                    <td>Rp. '.rupiah($trk['nominal']).'</td>
                                    <td>'.$trk['catatan'].'</td>
                                    <td>
                                      <a href="#editTarik'.$trk[idTabungan].'" data-toggle="modal" class="btn btn-xs btn-warning"><i class="fa fa-edit" data-toggle="tooltip" title="" data-original-title="Edit"></i></a>
                                      <a href="#delTarik'.$trk[idTabungan].'" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="" data-original-title="Hapus"></i></a>
                                    </td>
                                  </tr>';

                            echo '<div class="modal fade" id="editTarik'.$trk[idTabungan].'" role="dialog">
                                    <form action="index.php?view='.$_GET[view].'&thn_ajar='.$_GET[thn_ajar].'&nis='.$_GET[nis].'&edittarik" method="post" accept-charset="utf-8">
                                      <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">Edit Penarikan</h4>
                                          </div>
                                          <div class="modal-body">
                                          <input type="hidden" name="tarik_id" value="'.$trk['idTabungan'].'"> 
                                          <input type="hidden" name="tarik_siswa" value="'.$trk['siswa'].'"> 
                                          <input type="hidden" name="tarik_tahun_ajaran" value="'.$trk['tahunAjaran'].'">
                                          <input type="hidden" name="tarik_kode" value="PENARIKAN"> 
                                          <div class="form-group">
                                            <label>Tanggal</label>
                                            <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                              <input class="form-control" required="" type="text" name="tarik_tgl" value="'.date('Y-m-d').'" placeholder="Tanggal Tarik">
                                            </div>
                                          </div>
                                            <div class="form-group">
                                              <label>Jumlah Penarikan</label>
                                              <input type="text" class="form-control" required="" name="tarik_nominal" placeholder="Jumlah Penarikan" value="'.$trk['nominal'].'">
                                            </div>
                                            <div class="form-group">
                                              <label>Catatan</label>
                                              <input type="text" class="form-control" required="" name="tarik_catatan" placeholder="Catatan" value="'.$trk['catatan'].'">
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="submit" class="btn btn-info">Edit Penarikan</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>';

                              echo '<div class="modal modal-default fade" id="delTarik'.$trk[idTabungan].'">
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
                                            <form action="index.php?view='.$_GET[view].'&thn_ajar='.$_GET[thn_ajar].'&nis='.$_GET[nis].'&hapustarik" method="post" accept-charset="utf-8">
                                              <input type="hidden" name="tarik_id" value="'.$trk['idTabungan'].'">
                                              <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                              <button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                                            </form>
                                          </div>
                                        </div>
                                        <!-- /.modal-content -->
                                      </div>
                                      <!-- /.modal-dialog -->
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


<?php } ?>