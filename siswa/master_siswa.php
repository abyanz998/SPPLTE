<?php 
  if ($_GET[act]==''){
         $edit = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.idSiswa='$idSiswa' AND siswa.stdel='0'");
    $record = mysqli_fetch_array($edit);
    if($record['fotoSiswa'] == ''){
      $foto = $lokasi_default_fotoSiswa;
    }else{
      $foto = $lokasi_penyimpanan_fotoSiswa.$record['fotoSiswa'];
    }


    if ($_SESSION['notif'] == 'usukses'){
      echo '<script>toastr["success"]("Data berhasil diupdate.","Sukses!")</script>';
    }elseif($_SESSION['notif'] == 'gagal'){
      echo '<script>toastr["error"]("Data gagal diproses.","Gagal!")</script>';
    }
    //reset password selain admin
    elseif($_SESSION['notif'] == 'resetsukses'){
      echo '<script>toastr["success"]("Reset password berhasil.","Sukses!")</script>';
    }elseif($_SESSION['notif'] == 'resetgagal'){
      echo '<script>toastr["error"]("Reset password gagal.","Gagal!")</script>';
    }
    unset($_SESSION['notif']);
    
?>
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-12">
          <div class="box box-success">
            <div class="box-body">
              <div class="col-md-12 col-sm-12 col-xs-12 pull-left">
              <br>
              <div class="row">
                <div class="col-md-2">
                  <img src="<?= $foto ?>" class="img-responsive avatar">
                </div>
                <div class="col-md-10">
                  <table class="table table-hover">
                    <tbody>
                      <tr>
                        <td width="300px">NIS Siswa</td>
                        <td width="20px">:</td>
                        <td><?= $record['nisSiswa'] ?></td>
                      </tr>
                      <tr>
                        <td>Nama lengkap</td>
                        <td>:</td>
                        <td><strong><?= strtoupper($record['nmSiswa']) ?></strong></td>
                      </tr>
                      <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td><?php if ($record['jkSiswa']=='L') { echo 'Laki-laki'; } else { echo 'Perempuan'; } ?></td>
                      </tr>
                      <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td><?= $record['nmKelas'] ?></td>
                      </tr>
                      <tr>
                        <td>Kamar</td>
                        <td>:</td>
                        <td><?= $record['namaKamar'] ?></td>
                      </tr>
                      <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td><?= $record['tempatLahirSiswa'].', '.tgl_raport($record['tglLahirSiswa']) ?></td>
                      </tr>
                      <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= $record['alamatSiswa'] ?></td>
                      </tr>
                      <tr>
                        <td>Nama Ibu Kandung</td>
                        <td>:</td>
                        <td><?= $record['nmIbu'] ?></td>
                      </tr>
                      <tr>
                        <td>Nama Ayah Kandung</td>
                        <td>:</td>
                        <td><?= $record['nmAyah'] ?></td>
                      </tr>
                      <tr>
                        <td>No. Handphone Orang Tua</td>
                        <td>:</td>
                        <td><?= $record['noHpOrtu'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-10" >
                  <div class="pull-left">
                    <a class='btn btn-success' data-toggle='modal' href='#cetak<?= $idSiswa ?>'><i class="fa fa-print"></i> Cetak Kartu</a>
                  </div>
                  <div class="pull-right">
                    <a class='btn btn-warning' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=<?=$_GET[view]?>&act=edit'><span class='fa fa-edit'></span> Edit</a>
                     <a class='btn btn-danger' data-toggle='tooltip' title='' data-original-title='Reset Password' href='?view=<?=$_GET[view]?>&act=reset password'><span class='fa fa-unlock'></span> Reset Password</a>
                  </div>

                </div>

                <div class="modal fade in" id="cetak<?= $idSiswa ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                        <h4 class="modal-title">Cetak Kartu Siswa</h4></div><div class="modal-body">
                      </div>
                      <div class="modal-body">
                        <object data="siswa/laporan/kartu_siswa.php?id=<?= $idSiswa ?>" width="100%" height="300px"></object>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
            </div>
            </div>
          </div>
      </div>

  </form>
<?php }elseif($_GET[act]=='edit'){
    if (isset($_POST[update])){

      if(($_POST['nisSiswa'] != '') && ($_POST['nmSiswa'] != ''))
        {
           
          $lokasi_file = $_FILES['fotoSiswa']['tmp_name'];
          $nama_file_foto   = $_FILES['fotoSiswa']['name'];
         
          if (!empty($lokasi_file)){
            UploadFoto($lokasi_penyimpanan_fotoSiswa,$lokasi_file,$nama_file_foto);
            $query = mysqli_query($koneksi,"UPDATE siswa SET nmSiswa='$_POST[nmSiswa]', jkSiswa='$_POST[jkSiswa]', tempatLahirSiswa='$_POST[tempatLahirSiswa]', tglLahirSiswa='$_POST[tglLahirSiswa]', alamatSiswa='$_POST[alamatSiswa]', fotoSiswa='$nama_file_foto', nmIbu='$_POST[nmIbu]', nmAyah='$_POST[nmAyah]', noHpOrtu='$_POST[noHpOrtu]', uby='$idSiswa', udate='$waktu_sekarang' WHERE idSiswa='$idSiswa'");

          }else{
            $query = mysqli_query($koneksi,"UPDATE siswa SET nmSiswa='$_POST[nmSiswa]', jkSiswa='$_POST[jkSiswa]', tempatLahirSiswa='$_POST[tempatLahirSiswa]', tglLahirSiswa='$_POST[tglLahirSiswa]', alamatSiswa='$_POST[alamatSiswa]', nmIbu='$_POST[nmIbu]', nmAyah='$_POST[nmAyah]', noHpOrtu='$_POST[noHpOrtu]', uby='$idSiswa', udate='$waktu_sekarang' WHERE idSiswa='$idSiswa'");
          }

          if ($query){
            $_SESSION['notif'] = 'usukses';
            echo "<script>document.location='index-siswa.php?view=$_GET[view]';</script>";
          }else{
            $_SESSION['notif'] = 'gagal';
            echo "<script>document.location='index-siswa.php?view=$_GET[view]';</script>";
          }
      }
  	}
  	$edit = mysqli_query($koneksi,"SELECT siswa.*,kelas_siswa.nmKelas,kamar.namaKamar FROM siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE idSiswa='$idSiswa'");
  	$record = mysqli_fetch_array($edit);
?>
   	<form method="POST" action="" class="form-horizontal" enctype="multipart/form-data">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Data Pribadi</a></li>
                <li><a href="#tab_2" data-toggle="tab">Data Pesantren</a></li>
                <li><a href="#tab_3" data-toggle="tab">Data Keluarga</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <?php
                    if (isset($_POST[update])){
                      if ($_POST['nmSiswa'] == ''){ 
                        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Nama lengkap wajib diisi
                          </div>";
                      }
                      if($_POST['nisSiswa'] == ''){
                         echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian NIS wajib diisi
                          </div>";
                      }
                      if($_POST['unitSiswa'] == ''){
                         echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Unit sekolah wajib diisi
                          </div>";
                      }
                      if($_POST['kelasSiswa'] == ''){
                         echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Kelas wajib diisi
                          </div>";
                      }
                    }
                  ?>
                  <input name="id" type="hidden" class="form-control" placeholder="Nama lengkap" value="<?= $record['idSiswa'] ?>">
                  <label>Nama lengkap <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <input name="nmSiswa" type="text" class="form-control" placeholder="Nama lengkap" value="<?= $record['nmSiswa'] ?>">
                  <br>
                  <label>Jenis Kelamin</label>
                  <div class="radio">
                    <label>
                      <?php 
                        if ($record['jkSiswa'] == 'L'){
                          echo '<input type="radio" name="jkSiswa" value="L" checked> Laki-laki';
                        }else{
                          echo '<input type="radio" name="jkSiswa" value="L"> Laki-laki';
                        }
                      ?>
                    </label>&nbsp;&nbsp;
                    <label>
                      <?php
                        if ($record['jkSiswa'] == 'P'){
                          echo '<input type="radio" name="jkSiswa" value="P" checked> Perempuan';
                        }else{
                          echo '<input type="radio" name="jkSiswa" value="P"> Perempuan';
                        }
                      ?>
                    </label>
                  </div>
                  <br>
                  <label>Tempat Lahir</label>
                  <input name="tempatLahirSiswa" type="text" class="form-control" placeholder="Tempat Lahir" value="<?= $record['tempatLahirSiswa'] ?>">
                  <br>
                  <label>Tanggal Lahir </label>
                  <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input class="form-control" type="text" name="tglLahirSiswa" readonly="readonly" placeholder="Tanggal" value="<?php if($record[tglLahirSiswa] == '0000-00-00') {echo ''; } else { echo $record[tglLahirSiswa]; } ?>">
                  </div>
                  <br>
                  <label>Alamat</label>
                  <textarea class="form-control" name="alamatSiswa" placeholder="Alamat Tempat Tinggal"><?= $record['alamatSiswa'] ?></textarea>
                </div>

                <div class="tab-pane" id="tab_2">
                  <label>NIS <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <input name="nisSiswa" type="text" class="form-control" placeholder="NIS Siswa" value="<?= $record['nisSiswa'] ?>" readonly>
                  <br> 
                  <label>Kelas <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <input type="hidden" id="idKelas" value="<?= $record['kelasSiswa'] ?>">
                  <input name="kelas_siswa" type="text" class="form-control" placeholder="Kelas Siswa" value="<?= $record['nmKelas'] ?>" readonly>
                  <br> 
                  <input type="hidden" id="idKamar" value="<?= $record['kamarSiswa'] ?>">
                  <label>Kamar <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <input name="kamar_siswa" type="text" class="form-control" placeholder="Kamar Siswa" value="<?= $record['namaKamar'] ?>" readonly>              
                </div>

                <div class="tab-pane" id="tab_3">    
                  <label>Nama Ibu Kandung</label>
                  <input name="nmIbu" type="text" class="form-control" placeholder="Nama Ibu" value="<?= $record['nmIbu']?>">
                  <br>   
                  <label>Nama Ayah Kandung</label>
                    <input name="nmAyah" type="text" class="form-control" placeholder="Nama Ayah" value="<?= $record['nmAyah']?>">
                  <br>
                  <label>No. Handphone Orang Tua <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <input name="noHpOrtu" type="text" class="form-control" placeholder="No Handphone Orang Tua" value="<?= $record['noHpOrtu']?>">    
                </div>
              </div>
            </div>
            <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
          <div class="box box-success">
            <div class="box-body">
              <label>Foto</label>
              <a href="#" class="thumbnail">
                <img src="<?= $foto_siswa ?>" id="target" alt="Choose image to upload">
              </a>
            <input type="file" id="fotoSiswa" name="fotoSiswa">
            <br>
            <button name="update" type="submit" value="Simpan" class="btn btn-block btn-success">Simpan</button>
            <a href="index-siswa.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
          </div>
        </div>
      </div>

  </form>  

<?php }elseif($_GET[act]=='reset password'){ ?>
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
          <div class="box box-success">
            <div class="box-body">
              <?php
                if (isset($_POST[reset])){
                  $pass_lama = md5($_POST['password_lama']);
                  $pass_baru = md5($_POST['password_baru']);
                  $cek_password = mysqli_query($koneksi, "SELECT * FROM siswa WHERE idSiswa='$idSiswa' AND password='$pass_lama'");
                  $hitungUsers = mysqli_num_rows($cek_password);
                  if ($hitungUsers < 1){
                     echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Password lama salah..
                          </div>";
                  }
                  if (strlen($_POST['password_baru']) <= 5){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Panjang karakter password baru harus 6 karakter..
                          </div>";
                  }
                  if(strlen($_POST['konfirmasi_password_baru']) <= 5){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Panjang karakter konfirmasi password baru harus 6 karakter..
                          </div>";
                  }
                  if($_POST['password_baru'] != $_POST['konfirmasi_password_baru']){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Password dan konfirmasi password baru tidak sama.
                          </div>";
                  }
                  if (($hitungUsers > 0) && (strlen($_POST['password_baru']) > 5) && (strlen($_POST['konfirmasi_password_baru']) > 5) && ($_POST['password_baru'] == $_POST['konfirmasi_password_baru'])) {
                    $query = mysqli_query($koneksi, "UPDATE siswa SET password='$pass_baru', uby='$idSiswa', udate='$waktu_sekarang' WHERE idSiswa='$idSiswa'");
                    if ($query){
                      $_SESSION['notif'] = 'resetsukses';
                      echo "<script>document.location='index-siswa.php?view=$_GET[view]';</script>";
                    }else{
                      $_SESSION['notif'] = 'resetgagal';
                      echo "<script>document.location='index-siswa.php?view=$_GET[view]';</script>";
                    }
                  }
                }
              ?>
              <input type="hidden" name="idUsers" value="<?php echo $_GET[id]; ?>" >
              <label>Password Lama<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="password" name="password_lama" placeholder="Password" class="form-control" required>
              <br>
              <label>Password Baru<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="password" name="password_baru" placeholder="Password" class="form-control" required>
              <br>
              <label>Konfirmasi Password Baru<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="password" name="konfirmasi_password_baru" placeholder="Konfirmasi Password" class="form-control" required>
              <br>
              <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
            </div>
          </div>
      </div>

      <div class="col-md-3">
          <div class="box box-success">
            <div class="box-body">
              <button type="submit" name="reset" value="Simpan" class="btn btn-block btn-success">Simpan</button>
              <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
            </div>
          </div>
      </div>

  </form>
<?php } ?>

<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#target').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#fotoSiswa").change(function() {
    readURL(this);
  });
</script>