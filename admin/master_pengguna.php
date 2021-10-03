<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success">
                <div class="box-header">
                  <a class='pull-left btn btn-success btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=tambah'><i class="fa fa-plus"></i> Tambah</a>
                  <a href="index.php?view=<?= $_GET[view] ?>&act=role" class="btn btn-sm btn-danger" style="margin-left: 5px"><i class="fa fa-cogs"></i> Role</a>
                </div><!-- /.box-header -->
                <div class="box-body">
               <div class="table-responsive">
                
                <?php 
                  if ($_SESSION['notif'] == 'csukses'){
                    echo '<script>toastr["success"]("Data berhasil disimpan.","Sukses!")</script>';
                  }elseif ($_SESSION['notif'] == 'usukses'){
                    echo '<script>toastr["success"]("Data berhasil diupdate.","Sukses!")</script>';
                  }elseif ($_SESSION['notif'] == 'dsukses'){
                    echo '<script>toastr["success"]("Data berhasil dihapus.","Sukses!")</script>';
                  }elseif($_SESSION['notif'] == 'gagal'){
                    echo '<script>toastr["error"]("Data gagal diproses.","Gagal!")</script>';
                  }
                  //ubah password admin
                  elseif($_SESSION['notif'] == 'resetsuksesadmin'){
                    echo '<script>toastr["success"]("Ubah password berhasil.","Sukses!")</script>';
                  }elseif($_SESSION['notif'] == 'resetgagaladmin'){
                    echo '<script>toastr["error"]("Ubah password gagal.","Gagal!")</script>';
                  }
                  //reset password selain admin
                  elseif($_SESSION['notif'] == 'resetsukses'){
                    echo '<script>toastr["success"]("Reset password berhasil.","Sukses!")</script>';
                  }elseif($_SESSION['notif'] == 'resetgagal'){
                    echo '<script>toastr["error"]("Reset password gagal.","Gagal!")</script>';
                  }

                  unset($_SESSION['notif']);
                ?>
				
                  <table id="example1" class="table table-hover dataTable no-footer">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>Hak Akses</th>
                        <th>Unit Sekolah</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                    $tampil = mysqli_query($koneksi, "SELECT users.*, 
                                            users_level.idUsersLevel,
                                            users_level.namaUsersLevel,
                                            unit_sekolah.idUnit,
                                            unit_sekolah.singkatanUnit
                                           FROM users
            					                     LEFT JOIN users_level ON users.level = users_level.idUsersLevel
                                           LEFT JOIN unit_sekolah ON users.unit = unit_sekolah.idUnit 
            					                     WHERE users.stdel='0' ORDER BY idUsers ASC");
                    $no = 1;
                    while($r=mysqli_fetch_array($tampil)){
                    echo "<tr><td>$no</td>
                              <td>$r[email]</td>
                              <td>$r[nama_lengkap]</td>
                              <td>$r[namaUsersLevel]</td>
                              <td>";
                              if ($r[unit] == '0'){
                                echo 'Semua Unit Sekolah';
                              }else{
                                echo $r[singkatanUnit];
                              }
                        echo "</td>
                              <td><center>
                                <a class='btn btn-info btn-xs' data-toggle='tooltip' title='' data-original-title='Lihat' href='?view=$_GET[view]&act=detail&id=$r[idUsers]'><span class='fa fa-eye'></span></a>";

                              if ($r[idUsersLevel] != 1){
                                echo " <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Reset Password' href='?view=$_GET[view]&act=reset&id=$r[idUsers]'><span class='fa fa-lock'></span></a>
                                 <a class='btn btn-danger btn-xs' href='#' data-toggle='modal' data-target='#hapus".$r[idUsers]."'><span class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus'></span></a>";
                              }else{
                                echo " <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Ubah Password' href='?view=$_GET[view]&act=reset&id=$r[idUsers]'><span class='fa fa-rotate-left'></span></a>";
                              }
                          echo "</center></td>";
                        echo "</tr>";

                        echo '<div class="modal fade" id="hapus'.$r[idUsers].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <form action="?view='.$_GET[view].'&hapus&id='.$r[idUsers].'" method="POST" role="form">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                                        <h4 class="modal-title" id="myModalLabel"><span class="fa fa-exclamation-triangle"></span> Hapus Data</h4>
                                      </div>
                                      <div class="modal-body">
                                        Apakah anda ingin menghapus data ini?
                                      </div>
                                      <div class="modal-footer">
                                        <button type="submit" name="hapus" class="btn btn-danger pull-right"><span class="fa fa-check"></span> Hapus</button>
                                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
                                      </div>
                                    </div>
                                  </div>
                                </form>
                              </div>';
                        $no++;
                      }
                      if (isset($_GET[hapus])){
                          $query = mysqli_query($koneksi, "UPDATE users SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idUsers='$_GET[id]'");
                          if($query){
                            $_SESSION['notif'] = 'dsukses';
                          }else{
                            $_SESSION['notif'] = 'gagal';
                          }
                          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                      }

                  ?>
                    </tbody>
                  </table>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
<?php 
}elseif($_GET[act]=='edit'){
  if (isset($_POST[update])){
    $passs = md5($_POST[password]); 
    $lokasi_file = $_FILES['fotoUsers']['tmp_name'];
    $nama_file   = $_FILES['fotoUsers']['name'];

    if ($_POST['unit'] == 'all'){
      $unit = '0';
    }else{
      $unit = $_POST['unit'];
    }

    if ($_GET[id] == '1') {
       if (!empty($lokasi_file)){
        UploadGambar($$lokasi_foto_pengguna,$lokasi_file,$nama_file);
        $query = mysqli_query($koneksi, "UPDATE users SET email='$_POST[email]', nama_lengkap='$_POST[nama_lengkap]', deskripsi='$_POST[deskripsi]', foto='$nama_file', uby='$idUsers', udate='$waktu_sekarang' WHERE idUsers='$_POST[id]'");
      }else{
        $query = mysqli_query($koneksi, "UPDATE users SET email='$_POST[email]', nama_lengkap='$_POST[nama_lengkap]', deskripsi='$_POST[deskripsi]', uby='$idUsers', udate='$waktu_sekarang' WHERE idUsers='$_POST[id]'");
      }
    }else{
      if (!empty($lokasi_file)){
        UploadGambar($$lokasi_foto_pengguna,$lokasi_file,$nama_file);
        $query = mysqli_query($koneksi, "UPDATE users SET email='$_POST[email]', nama_lengkap='$_POST[nama_lengkap]', deskripsi='$_POST[deskripsi]', foto='$nama_file', level='$_POST[level]', unit='$unit', uby='$idUsers', udate='$waktu_sekarang' WHERE idUsers='$_POST[id]'");
      }else{
        $query = mysqli_query($koneksi, "UPDATE users SET email='$_POST[email]', nama_lengkap='$_POST[nama_lengkap]', deskripsi='$_POST[deskripsi]', level='$_POST[level]', unit='$unit', uby='$idUsers', udate='$waktu_sekarang' WHERE idUsers='$_POST[id]'");
      }
    }
                    
    if ($query){
      $_SESSION['notif'] = 'usukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
  }

  $edit = mysqli_query($koneksi, "SELECT * FROM users where idUsers='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
  if ($record['foto'] == ''){
    $fotoPengguna = $lokasi_default_fotoPengguna;
  }else{
    $fotoPengguna = $lokasi_foto_pengguna.$record['foto'];
  }
?>
  <form method="POST" action="" class="form-horizontal"  enctype="multipart/form-data">

    <div class="col-md-9">
          <div class="box box-success">
            <div class="box-body">
          
              <input type="hidden" name="id" value="<?= $record['idUsers'] ?>">
              <label>Email <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="email" name="email" placeholder="Email" class="form-control" required value="<?= $record['email'] ?>">
              <br>
              <label>Nama Lengkap <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control" required value="<?= $record['nama_lengkap'] ?>">
              <br>
              <label>Deskripsi</label>
              <textarea name="deskripsi" placeholder="Deskripsi" class="form-control"><?= $record['deskripsi'] ?></textarea>
              <?php if ($_GET[id]!='1') { ?>
                <br>
                <label>Hak Akses <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                <input type="hidden" id="idLevel" value="<?= $record[level] ?>">
                <select name="level" class="form-control" required id="Chakakses"></select>
                <br>
                <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                <input type="hidden" id="idUnit" value="<?= $record[unit] ?>">
                <input type="hidden" id="tipe_unit" value="pencarian">
                <select name="unit" class="form-control" required id="Cunit"></select>
              <?php } ?>
              <br>
              <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
            </div>
          </div>
      </div>

      <div class="col-md-3">
          <div class="box box-success">
            <div class="box-body">
              <label>Foto</label>
              <a href="#" class="thumbnail">
                <img id="target" alt="Choose image to upload" src="<?= $fotoPengguna ?>">
              </a>
              <input type="file" id="foto" name="fotoUsers">
              <br>
              <button name="update" type="submit" value="Simpan" class="btn btn-block btn-success">Simpan</button>
              <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
            </div>
          </div>
      </div>

  </form>

<?php }elseif($_GET[act]=='tambah'){ ?>
  <form method="POST" action="" class="form-horizontal"  enctype="multipart/form-data">

    <div class="col-md-9">
          <div class="box box-success">
            <div class="box-body">
              <?php
                if (isset($_POST[tambah])){
                  $cek_email = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$_POST[email]'");
                  $hitungUsers = mysqli_num_rows($cek_email);
                  if ($hitungUsers > 0){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Email harus unik.
                          </div>";
                  }
                  if (strlen($_POST['password']) <= 5){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Panjang karakter password baru harus 6 karakter..
                          </div>";
                  }
                  if(strlen($_POST['konfirmasi_password']) <= 5){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Panjang karakter konfirmasi password baru harus 6 karakter..
                          </div>";
                  }
                  if($_POST['password'] != $_POST['konfirmasi_password']){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Password dan konfirmasi password baru tidak sama..
                          </div>";
                  }
                  if (($hitungUsers == 0) && (strlen($_POST['password']) > 5) && (strlen($_POST['konfirmasi_password']) > 5) && ($_POST['password'] == $_POST['konfirmasi_password'])) {

                    $passs = md5($_POST[password]); 
                    $lokasi_file = $_FILES['fotoUsers']['tmp_name'];
                    $nama_file   = $_FILES['fotoUsers']['name'];

                    if ($_POST['unit'] == 'all'){
                      $unit = '0';
                    }else{
                      $unit = $_POST['unit'];
                    }

                    if (!empty($lokasi_file)){
                      UploadGambar($$lokasi_foto_pengguna,$lokasi_file,$nama_file);
                      $query = mysqli_query($koneksi, "INSERT INTO users(nama_lengkap,email,password,deskripsi,foto,level,unit,stdel,cby,cdate) VALUES('$_POST[nama_lengkap]','$_POST[email]','$passs','$_POST[deskripsi]','$nama_file','$_POST[level]','$unit','0','$idUsers','$waktu_sekarang')");
                    }else{
                      $query = mysqli_query($koneksi, "INSERT INTO users(nama_lengkap,email,password,deskripsi,level,unit,stdel,cby,cdate) VALUES('$_POST[nama_lengkap]','$_POST[email]','$passs','$_POST[deskripsi]','$_POST[level]','$unit','0','$idUsers','$waktu_sekarang')");
                    }
                    
                    if ($query){
                      $_SESSION['notif'] = 'csukses';
                      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                    }else{
                      $_SESSION['notif'] = 'gagal';
                      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                    }

                  }

                }
              ?>
              <label>Email <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="email" name="email" placeholder="Email" class="form-control" required value="<?= $_POST[email] ?>">
              <br>
              <label>Nama Lengkap <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" class="form-control" required value="<?= $_POST[nama_lengkap] ?>">
              <br>
              <label>Password <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="password" name="password" placeholder="Password" class="form-control" required value="<?= $_POST[password] ?>">
              <br>
              <label>Konfirmasi Password <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Password" class="form-control" required value="<?= $_POST[konfirmasi_password] ?>">
              <br>
              <label>Deskripsi</label>
              <textarea name="deskripsi" placeholder="Deskripsi" class="form-control"><?= $_POST['deskripsi'] ?></textarea>
              <br>
              <label>Hak Akses <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="hidden" id="idLevel" value="<?= $_POST[level] ?>" >
              <select name="level" class="form-control" required id="Chakakses"></select>
              <br>
              <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="hidden" id="idUnit" value="<?= $_POST[unit] ?>">
              <input type="hidden" id="tipe_unit" value="pencarian">
              <select name="unit" class="form-control" id="Cunit" required></select>
              <br>
              <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
            </div>
          </div>
      </div>

      <div class="col-md-3">
          <div class="box box-success">
            <div class="box-body">
              <label>Foto</label>
              <a href="#" class="thumbnail">
                <img id="target" alt="Choose image to upload" src="<?= $lokasi_default_fotoPengguna ?>">
              </a>
              <input type="file" id="foto" name="fotoUsers">
              <br>
              <button name="tambah" type="submit" value="Simpan" class="btn btn-block btn-success">Simpan</button>
              <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
            </div>
          </div>
      </div>

  </form>
<?php }elseif($_GET[act]=='detail'){ 


    $lihat = mysqli_query($koneksi, "SELECT users.*, users_level.idUsersLevel, users_level.namaUsersLevel FROM users
                          LEFT JOIN users_level ON users.level = users_level.idUsersLevel
                          WHERE idUsers='$_GET[id]'");
    $record = mysqli_fetch_array($lihat);
    if ($record['foto'] == ''){ 
      $foto_users = $lokasi_default_fotoPengguna; 
    } else { 
      $foto_users = $lokasi_foto_pengguna.$idt_user['foto']; 
    }
?>

      <div class="col-md-4">
        <!-- Profile Image -->
        <div class="box box-success">
          <div class="box-body box-profile">
            <img src="<?= $foto_users ?>" class="profile-user-img img-responsive img-circle">
            
            <h3 class="profile-username text-center"><?= $record[nama_lengkap] ?></h3>

            <p class="text-muted text-center"><?= $record[namaUsersLevel] ?></p>
            <br>
                                      
            <a href="?view=<?= $_GET[view] ?>&act=reset&id=<?= $record[idUsers] ?>" class="btn btn-success btn-block"><b>Ubah Password</b></a>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>

      <div class="col-md-8">
        <!-- About Me Box -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">About Me</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <strong><i class="fa fa-book margin-r-5"></i> Nama Lengkap</strong>
            <p class="text-muted"><?= $record['nama_lengkap']?></p>

            <hr>

            <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
            <p class="text-muted"><?= $record['email']?></p>

            <hr>

            <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>
            <p><?= $record['deskripsi']?></p>

            <a href="?view=<?= $_GET[view] ?>&act=edit&id=<?= $record[idUsers] ?>" class="btn btn-warning"><b>Edit</b></a>
            <a href="?view=<?= $_GET[view] ?>" class="btn btn-danger"><b>Kembali</b></a>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>

<!-- RESET PASSWORD KHUSUS ADMIN -->
<?php }elseif(($_GET[act]=='reset') && ($_GET[id]=='1')){ ?>

<form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
          <div class="box box-success">
            <div class="box-body">
              <?php
                if (isset($_POST[reset])){
                  $pass_lama = md5($_POST['password_lama']);
                  $pass_baru = md5($_POST['password_baru']);
                  $cek_password = mysqli_query($koneksi, "SELECT * FROM users WHERE idUsers='$_GET[id]' AND password='$pass_lama'");
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
                    $query = mysqli_query($koneksi, "UPDATE users SET password='$pass_baru', uby='$idUsers', udate='$waktu_sekarang' WHERE idUsers='$_POST[idUsers]'");
                    if ($query){
                      $_SESSION['notif'] = 'resetsuksesadmin';
                      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                    }else{
                      $_SESSION['notif'] = 'resetgagaladmin';
                      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
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

<!-- RESET PASSWORD SELAIN ADMIN -->
<?php }elseif(($_GET[act]=='reset') && ($_GET[id]!='1')){ ?>

<form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
          <div class="box box-success">
            <div class="box-body">
              <?php
                if (isset($_POST[reset])){
                  $passs = md5($_POST['password_baru']); 
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
                            <span aria-hidden='true'>×</span></button> <strong>Gagal!</strong> - Password dan konfirmasi password baru tidak sama..
                          </div>";
                  }
                  if ((strlen($_POST['password_baru']) > 5) && (strlen($_POST['konfirmasi_password_baru']) > 5) && ($_POST['password_baru'] == $_POST['konfirmasi_password_baru'])) {
                    $query = mysqli_query($koneksi, "UPDATE users SET password='$passs', uby='$idUsers', udate='$waktu_sekarang' WHERE idUsers='$_POST[idUsers]'");
                    if ($query){
                      $_SESSION['notif'] = 'resetsukses';
                      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                    }else{
                      $_SESSION['notif'] = 'resetgagal';
                      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                    }
                  }
                }
              ?>
              <input type="hidden" name="idUsers" value="<?php echo $_GET[id]; ?>" >
              <label>Password Baru<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="password" name="password_baru" placeholder="Password Baru" class="form-control" required>
              <br>
              <label>Konfirmasi Password Baru<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="password" name="konfirmasi_password_baru" placeholder="Konfirmasi Password Baru" class="form-control" required>
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
<?php } 
  //APABILA ROLE DIPILIH  
  elseif($_GET[act]=='role'){ 
    
?>
  
  <form method="POST" action="" class="form-horizontal">

     <div class="col-md-4">
          <div class="box box-success">
            <div class="box-body">
              <label>Hak Akses <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <select name="role_HakAkses" id="Chakakses" class="form-control" required onchange="loadData()">
              
              </select>

              <br>
              <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Kembali</a>
            </div>
          </div>
      </div>

    <div class="col-md-8">
          <div class="box box-success">
            <div class="box-header with-border">
            <h3 class="box-title">Hak Akses</h3>
          </div>
            <div class="box-body">
              <div id="tabel"></div>   
            </div>
          </div>
      </div>

  </form>

<?php } ?>

<script type="text/javascript">
    function loadData(){
        var role_id = $("#Chakakses").val();
        $.ajax({
            type:'GET',
            url :'admin/role/detail_role.php',
            data:'role_id='+role_id,
            success:function(html){
                $("#tabel").html(html);
            }
        })
    }
    
    function addRule(id_modul){
        var role_id = $("#Chakakses").val();
        $.ajax({
            type:'GET',
            url :'admin/role/add_role.php',
            data:'role_id='+role_id+'&menu_id='+id_modul,
            success:function(html){
              if(html == 'tambahOK'){
                toastr["success"]("Berhasil menambahkan role.","Sukses!");
              }else if(html == 'hapusOK'){
                toastr["warning"]("Berhasil menghapus role.","Sukses!");
              }else{
                toastr["error"]("Role gagal diproses.","Gagal!");
              }
            }
        })
    }
</script>