      


      <?php 
        if ($_SESSION['notif'] == 'csukses_sub1'){
          echo '<script>toastr["success"]("Data Sub Akun 1 berhasil disimpan.","Sukses!")</script>';
        }elseif ($_SESSION['notif'] == 'cgagal_sub1'){
          echo '<script>toastr["error"]("Data Sub Akun 1 gagal disimpan.","Gagal!")</script>';
        }elseif ($_SESSION['notif'] == 'usukses_sub1'){
          echo '<script>toastr["success"]("Data Sub Akun 1 berhasil diupdate.","Sukses!")</script>';
        }elseif ($_SESSION['notif'] == 'ugagal_sub1'){
          echo '<script>toastr["error"]("Data Sub Akun 1 gagal diupdate.","Gagal!")</script>';
        }elseif ($_SESSION['notif'] == 'dsukses_sub1'){
          echo '<script>toastr["success"]("Data Sub Akun 1 berhasil dihapus.","Sukses!")</script>';
        }elseif ($_SESSION['notif'] == 'dgagal_sub1'){
          echo '<script>toastr["error"]("Data Sub Akun 1 gagal dihapus.","Gagal!")</script>';
        }elseif ($_SESSION['notif'] == 'csukses_sub2'){
          echo '<script>toastr["success"]("Data Sub Akun 2 berhasil disimpan.","Sukses!")</script>';
        }elseif ($_SESSION['notif'] == 'cgagal_sub2'){
          echo '<script>toastr["error"]("Data Sub Akun 2 gagal disimpan.","Gagal!")</script>';
        }elseif ($_SESSION['notif'] == 'usukses_sub2'){
          echo '<script>toastr["success"]("Data Sub Akun 2 berhasil diupdate.","Sukses!")</script>';
        }elseif ($_SESSION['notif'] == 'ugagal_sub2'){
          echo '<script>toastr["error"]("Data Sub Akun 2 gagal diupdate.","Gagal!")</script>';
        }elseif ($_SESSION['notif'] == 'dsukses_sub2'){
          echo '<script>toastr["success"]("Data Sub Akun 2 berhasil dihapus.","Sukses!")</script>';
        }elseif ($_SESSION['notif'] == 'dgagal_sub2'){
          echo '<script>toastr["error"]("Data Sub Akun 2 gagal dihapus.","Gagal!")</script>';
        }elseif ($_SESSION['notif'] == 'csukses_sub3'){
          echo '<script>toastr["success"]("Data Sub Akun 3 berhasil disimpan.","Sukses!")</script>';
        }elseif ($_SESSION['notif'] == 'cgagal_sub3'){
          echo '<script>toastr["error"]("Data Sub Akun 3 gagal disimpan.","Gagal!")</script>';
        }elseif ($_SESSION['notif'] == 'usukses_sub3'){
          echo '<script>toastr["success"]("Data Sub Akun 3 berhasil diupdate.","Sukses!")</script>';
        }elseif ($_SESSION['notif'] == 'ugagal_sub3'){
          echo '<script>toastr["error"]("Data Sub Akun 3 gagal diupdate.","Gagal!")</script>';
        }elseif ($_SESSION['notif'] == 'dsukses_sub3'){
          echo '<script>toastr["success"]("Data Sub Akun 3 berhasil dihapus.","Sukses!")</script>';
        }elseif ($_SESSION['notif'] == 'dgagal_sub3'){
          echo '<script>toastr["error"]("Data Sub Akun 3 gagal dihapus.","Gagal!")</script>';
        }
        unset($_SESSION['notif']);
      ?>

      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <form action="index.php" class="form-horizontal" method="get" accept-charset="utf-8">
              <div class="box-body table-responsive">
                <table>
                  <tbody>
                    <tr>
                      <td>
                        <input type="hidden" name="view" value="<?= $_GET[view] ?>">
                        <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                        <input type="hidden" id="tipe_unit" value="pencarian">
                        <select style="width: 200px;" id="Cunit" name="unit" class="form-control" required=""> </select>
                      </td>
                      <td>
                          &nbsp;&nbsp;
                      </td>
                      <td>
                      <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>    
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </form>                        
          </div>


          <?php
            if (isset($_POST['simpan_sub1'])){
              $query = mysqli_query($koneksi,"INSERT INTO akun_biaya(idSubAkun,kodeAkun,keterangan,jenisAkun,kategori,unitSekolah,stdel,cby,cdate) VALUES('$_POST[id_sub_akun]','$_POST[kode_akun]','$_POST[keterangan_akun]','$_POST[jenis_akun]','$_POST[kategori_akun]','$_POST[unitSekolah_akun]','0','$idUsers','$waktu_sekarang')");
              if ($query){
                $_SESSION['notif'] = 'csukses_sub1';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }else{
                $_SESSION['notif'] = 'cgagal_sub1';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }
            }elseif (isset($_POST['update_sub1'])){
              $query = mysqli_query($koneksi,"UPDATE akun_biaya SET idSubAkun='$_POST[id_sub_akun]',kodeAkun='$_POST[kode_akun]', keterangan='$_POST[keterangan_akun]', unitSekolah='$_POST[unitSekolah_akun]', uby='$idUsers', udate='$waktu_sekarang' WHERE idAkun='$_POST[id_akun]'");
              if ($query){
                $_SESSION['notif'] = 'usukses_sub1';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }else{
                $_SESSION['notif'] = 'ugagal_sub1';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }
            }elseif (isset($_POST['hapus_sub1'])){
              $query = mysqli_query($koneksi,"UPDATE akun_biaya SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idAkun='$_POST[id_akun]'");
              if ($query){
                $_SESSION['notif'] = 'dsukses_sub1';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }else{
                $_SESSION['notif'] = 'dgagal_sub1';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }
            }if (isset($_POST['simpan_sub2'])){
              $query = mysqli_query($koneksi,"INSERT INTO akun_biaya(idSubAkun,kodeAkun,keterangan,jenisAkun,kategori,unitSekolah,saldo_awal_debit,saldo_awal_kredit,stdel,cby,cdate) VALUES('$_POST[id_sub_akun]','$_POST[kode_akun]','$_POST[keterangan_akun]','$_POST[jenis_akun]','$_POST[kategori_akun]','$_POST[unitSekolah_akun]','0','0','0','$idUsers','$waktu_sekarang')");
              if ($query){
                $_SESSION['notif'] = 'csukses_sub2';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }else{
                $_SESSION['notif'] = 'cgagal_sub2';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }
            }elseif (isset($_POST['update_sub2'])){
              $query = mysqli_query($koneksi,"UPDATE akun_biaya SET idSubAkun='$_POST[id_sub_akun]', kodeAkun='$_POST[kode_akun]', keterangan='$_POST[keterangan_akun]', kategori='$_POST[kategori_akun]', unitSekolah='$_POST[unitSekolah_akun]', uby='$idUsers', udate='$waktu_sekarang' WHERE idAkun='$_POST[id_akun]'");
              if ($query){
                $_SESSION['notif'] = 'usukses_sub2';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }else{
                $_SESSION['notif'] = 'ugagal_sub2';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }
            }elseif (isset($_POST['hapus_sub2'])){
              $query = mysqli_query($koneksi,"UPDATE akun_biaya SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idAkun='$_POST[id_akun]'");
              if ($query){
                $_SESSION['notif'] = 'dsukses_sub2';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }else{
                $_SESSION['notif'] = 'dgagal_sub2';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }
            }if (isset($_POST['simpan_sub3'])){
              $query = mysqli_query($koneksi,"INSERT INTO akun_biaya(idSubAkun,kodeAkun,keterangan,jenisAkun,kategori,unitSekolah,saldo_awal_debit,saldo_awal_kredit,stdel,cby,cdate) VALUES('$_POST[id_sub_akun]','$_POST[kode_akun]','$_POST[keterangan_akun]','$_POST[jenis_akun]','$_POST[kategori_akun]','$_POST[unitSekolah_akun]','0','0','0','$idUsers','$waktu_sekarang')");
              if ($query){
                $_SESSION['notif'] = 'csukses_sub3';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }else{
                $_SESSION['notif'] = 'cgagal_sub3';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }
            }elseif (isset($_POST['update_sub3'])){
              $query = mysqli_query($koneksi,"UPDATE akun_biaya SET idSubAkun='$_POST[id_sub_akun]', kodeAkun='$_POST[kode_akun]', keterangan='$_POST[keterangan_akun]', kategori='$_POST[kategori_akun]', unitSekolah='$_POST[unitSekolah_akun]', uby='$idUsers', udate='$waktu_sekarang' WHERE idAkun='$_POST[id_akun]'");
              if ($query){
                $_SESSION['notif'] = 'usukses_sub3';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }else{
                $_SESSION['notif'] = 'ugagal_sub3';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }
            }elseif (isset($_POST['hapus_sub3'])){
              $query = mysqli_query($koneksi,"UPDATE akun_biaya SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idAkun='$_POST[id_akun]'");
              if ($query){
                $_SESSION['notif'] = 'dsukses_sub3';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }else{
                $_SESSION['notif'] = 'dgagal_sub3';
                echo "<script>document.location='index.php?view=$_GET[view]';</script>";
              }
            }
          ?>


          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <table id="example1" class="table table-hover dataTable no-footer">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Akun</th>
                  <th>Keterangan</th>
                  <th>Jenis Akun</th>
                  <th>Kategori</th>
                  <th>Unit Sekolah</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                  <?php
                    
                    $Q_akun = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE stdel='0' AND jenisAkun='Akun Utama' ORDER BY idAkun ASC");
                    $no = 1;
                    while($Autama=mysqli_fetch_array($Q_akun)){
                      if ($Autama['unitSekolah'] == '0'){
                        $nama_sekolah = 'Semua Unit';
                      }
                      echo '<tr style="font-weight:bold">
                              <td>'.$no++.'</td>
                              <td>'.$Autama['kodeAkun'].'</td>
                              <td>'.$Autama['keterangan'].'</td>
                              <td>'.$Autama['jenisAkun'].'</td>
                              <td>#</td>
                              <td>'.$nama_sekolah.'</td>
                              <td align="left">
                                <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addAccountSub1'.$Autama['idAkun'].'" title="Tambah Sub Akun"><i class="fa fa-plus"></i></button>
                              </td>
                            </tr>';

                            $data_sub1 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idSubAkun='$Autama[idAkun]' AND stdel='0'"));
                            if ($data_sub1 == 0){
                              $query_sub1 = mysqli_query($koneksi, "SELECT max(kodeAkun) as kodeTerbesar FROM akun_biaya WHERE idAkun='$Autama[idAkun]' AND stdel='0'");
                            }else{
                              $query_sub1 = mysqli_query($koneksi, "SELECT max(kodeAkun) as kodeTerbesar FROM akun_biaya WHERE idSubAkun='$Autama[idAkun]' AND stdel='0'");
                            }
                            $kode_sub1 = kode_otomatis($query_sub1, '100');
                            

                      echo '<div class="modal fade in" id="addAccountSub1'.$Autama['idAkun'].'" role="dialog">
                              <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4 class="modal-title">Tambah Sub Akun</h4>
                                  </div>
                                  <form action="index.php?view='.$_GET['view'].'" method="post" accept-charset="utf-8">
                                    <div class="modal-body">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <input type="hidden" readonly="" name="id_sub_akun" class="form-control" value="'.$Autama['idAkun'].'">
                                          <div class="form-group">
                                            <label>Kode Akun</label>
                                            <input type="text" required="" readonly="" name="kode_akun" class="form-control" value="'.$kode_sub1.'">
                                          </div>
                                          <div class="form-group">
                                            <label>Keterangan</label>
                                            <input type="text" required="" name="keterangan_akun" class="form-control" placeholder="Masukkan Keterangan">
                                          </div>
                                          <input type="hidden" required="" name="jenis_akun" class="form-control" value="Sub Menu 1">
                                          <input type="hidden" required="" name="kategori_akun" class="form-control" value="#">
                                          <div class="form-group">
                                            <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                                            <select required="" name="unitSekolah_akun" class="form-control">
                                              <option value="" disabled="" selected="">- Pilih Unit Sekolah -</option>';
                                                if($_SESSION['unit'] != '0'){
                                                  $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' AND idUnit='$_SESSION[unit] ' ORDER BY idUnit ASC");
                                                }else{
                                                  $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' ORDER BY idUnit ASC");
                                                }
                                                while ($q = mysqli_fetch_array($query_unit)) {
                                                  echo '<option value="'.$q['idUnit'].'">'.$q['singkatanUnit'].'</option>';
                                                }
                                echo '      </select>          
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" name="simpan_sub1" class="btn btn-success">Simpan</button>
                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>';

                      if ($_GET['unit'] != 'all'){ 

                          if (isset($_GET['unit'])){
                            $Q_Akun_Sub1 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$Autama[idAkun]' AND akun_biaya.unitSekolah='$_GET[unit]' ORDER BY akun_biaya.idAkun ASC");
                          }elseif($_SESSION['unit'] != '0'){
                            $Q_Akun_Sub1 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$Autama[idAkun]' AND akun_biaya.unitSekolah='$_SESSION[unit]' ORDER BY akun_biaya.idAkun ASC");
                          }else{
                            $Q_Akun_Sub1 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$Autama[idAkun]' ORDER BY akun_biaya.idAkun ASC");
                          }
                          while($aSub1=mysqli_fetch_array($Q_Akun_Sub1)){
                            echo '<tr style="font-weight:bold">
                                    <td>'.$no++.'</td>
                                    <td>'.$aSub1['kodeAkun'].'</td>
                                    <td>'.$aSub1['keterangan'].'</td>
                                    <td>'.$aSub1['jenisAkun'].'</td>
                                    <td>#</td>
                                    <td>'.$aSub1['singkatanUnit'].'</td>
                                    <td align="left">
                                      <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addAccountSub2'.$aSub1['idAkun'].'" title="Tambah Sub Akun"><i class="fa fa-plus"></i></button>
                                      <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editAccountSub1'.$aSub1['idAkun'].'" title="Edit Sub Akun"><i class="fa fa-pencil"></i></button>';
                                        $hitung_sub2 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idSubAkun='$aSub1[idAkun]' AND stdel='0'"));
                                        if ($hitung_sub2 == 0){
                                          echo ' <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteAccountSub1'.$aSub1['idAkun'].'" title="Hapus Sub Akun"><i class="fa fa-trash"></i></button>';
                                        }
                            echo    '</td>
                                  </tr>';

                            echo '<div class="modal fade in" id="editAccountSub1'.$aSub1['idAkun'].'" role="dialog">
                                  <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">×</button>
                                        <h4 class="modal-title">Tambah Sub Akun</h4>
                                      </div>
                                      <form action="index.php?view='.$_GET['view'].'" method="post" accept-charset="utf-8">
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class="col-md-12">
                                              <input type="hidden" required="" name="id_akun" class="form-control" value="'.$aSub1['idAkun'].'">
                                              <input type="hidden" readonly="" name="id_sub_akun" class="form-control" value="'.$aSub1['idSubAkun'].'">
                                              <div class="form-group">
                                                <label>Kode Akun</label>
                                                <input type="text" required="" readonly="" name="kode_akun" class="form-control" value="'.$aSub1['kodeAkun'].'">
                                              </div>
                                              <div class="form-group">
                                                <label>Keterangan</label>
                                                <input type="text" required="" name="keterangan_akun" class="form-control" placeholder="Masukkan Keterangan" value="'.$aSub1['keterangan'].'">
                                              </div>
                                              <div class="form-group">
                                                <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                                                <select required="" name="unitSekolah_akun" class="form-control">';
                                                  echo '<option value="" disabled="" selected="">- Pilih Unit Sekolah -</option>';
                                                 if($_SESSION['unit'] != '0'){
                                                  $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' AND idUnit='$_SESSION[unit] ' ORDER BY idUnit ASC");
                                                }else{
                                                  $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' ORDER BY idUnit ASC");
                                                }
                                                  while ($q = mysqli_fetch_array($query_unit)) {
                                                    if ($aSub1['unitSekolah'] == $q['idUnit']){
                                                        echo '<option value="'.$q['idUnit'].'" selected>'.$q['singkatanUnit'].'</option>';
                                                    }else{
                                                        echo '<option value="'.$q['idUnit'].'">'.$q['singkatanUnit'].'</option>';
                                                    }
                                                  }
                            echo                '</select>          
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="submit" name="update_sub1" class="btn btn-success">Simpan</button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>';

                            echo '<div class="modal fade" id="deleteAccountSub1'.$aSub1['idAkun'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <form action="index.php?view='.$_GET['view'].'" method="POST" role="form">
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
                                                      <input type="hidden" name="id_akun" value="'.$aSub1['idAkun'].'">
                                                      <button type="submit" name="hapus_sub1" class="btn btn-danger pull-right"><span class="fa fa-check"></span> Hapus</button>
                                                      <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </form>
                                            </div>';

                            $data_sub2 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idSubAkun='$aSub1[idAkun]' AND stdel='0'"));
                            if ($data_sub2 == 0){
                              $query_sub2 = mysqli_query($koneksi, "SELECT max(kodeAkun) as kodeTerbesar FROM akun_biaya WHERE idAkun='$aSub1[idAkun]' AND stdel='0'");
                            }else{
                              $query_sub2 = mysqli_query($koneksi, "SELECT max(kodeAkun) as kodeTerbesar FROM akun_biaya WHERE idSubAkun='$aSub1[idAkun]' AND stdel='0'");
                            }

                            $kode_sub2 = kode_otomatis($query_sub2, '1');

                            echo '<div class="modal fade in" id="addAccountSub2'.$aSub1['idAkun'].'" role="dialog">
                                    <div class="modal-dialog modal-md">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">×</button>
                                          <h4 class="modal-title">Tambah Sub Akun</h4>
                                        </div>
                                        <form action="index.php?view='.$_GET['view'].'" method="post" accept-charset="utf-8">
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class="col-md-12">
                                              <input type="hidden" readonly="" name="id_sub_akun" class="form-control" value="'.$aSub1['idAkun'].'">
                                              <div class="form-group">
                                                <label>Kode Akun</label>
                                                <input type="text" required="" readonly="" name="kode_akun" class="form-control" value="'.$kode_sub2.'">
                                              </div>
                                              <div class="form-group">
                                              <label>Keterangan</label>
                                              <input type="text" required="" name="keterangan_akun" class="form-control" placeholder="Masukkan Keterangan">
                                              </div>
                                              <input type="hidden" required="" name="jenis_akun" class="form-control" value="Sub Menu 2">
                                              <div class="form-group">
                                                  </div>
                                                  <div class="form-group">
                                                    <label>Kategori <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                                                    <select required="" name="kategori_akun" class="form-control">
                                                        <option value="" disabled selected>-Pilih Kategori-</option>
                                                        <option value="Pembayaran">Pembayaran</option>
                                                        <option value="Keuangan">Keuangan</option>
                                                    </select>
                                                  </div>
                                              <div class="form-group">
                                                <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                                                <select required="" name="unitSekolah_akun" class="form-control">';
                                                echo '<option value="" disabled="" selected="">- Pilih Unit Sekolah -</option>';
                                                  if($_SESSION['unit'] != '0'){
                                                    $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' AND idUnit='$_SESSION[unit] ' ORDER BY idUnit ASC");
                                                  }else{
                                                    $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' ORDER BY idUnit ASC");
                                                  }
                                                  while ($q = mysqli_fetch_array($query_unit)) {
                                                    echo '<option value="'.$q['idUnit'].'">'.$q['singkatanUnit'].'</option>';  
                                                  }
                              echo              '<select>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="submit" name="simpan_sub2" class="btn btn-success">Simpan</button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>';

                              if (isset($_GET['unit'])){
                                $Q_Akun_Sub2 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub1[idAkun]' AND akun_biaya.unitSekolah='$_GET[unit]' ORDER BY akun_biaya.idAkun ASC");
                              }elseif($_SESSION['unit'] != '0'){
                                $Q_Akun_Sub2 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub1[idAkun]' AND akun_biaya.unitSekolah='$_SESSION[unit]' ORDER BY akun_biaya.idAkun ASC");
                              }else{
                                $Q_Akun_Sub2 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub1[idAkun]' ORDER BY akun_biaya.idAkun ASC");
                              }

                              while($aSub2=mysqli_fetch_array($Q_Akun_Sub2)){
                                echo '<tr>
                                        <td>'.$no++.'</td>
                                        <td>'.$aSub2['kodeAkun'].'</td>
                                        <td>'.$aSub2['keterangan'].'</td>
                                        <td>'.$aSub2['jenisAkun'].'</td>
                                        <td>'.$aSub2['kategori'].'</td>
                                        <td>'.$aSub2['singkatanUnit'].'</td>
                                        <td align="left">
                                          <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addAccountSub3'.$aSub2['idAkun'].'" title="Tambah Sub Akun"><i class="fa fa-plus"></i></button>
                                          <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editAccountSub2'.$aSub2['idAkun'].'" title="Edit Sub Akun"><i class="fa fa-pencil"></i></button>';
                                          $hitung_sub3 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idSubAkun='$aSub2[idAkun]' AND stdel='0'"));
                                          if ($hitung_sub3 == 0){
                                            echo ' <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteAccountSub2'.$aSub2['idAkun'].'" title="Hapus Sub Akun"><i class="fa fa-trash"></i></button>';
                                          }
                                echo    '</td>
                                      </tr>';


                                      echo '<div class="modal fade in" id="editAccountSub2'.$aSub2['idAkun'].'" role="dialog">
                                              <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                    <h4 class="modal-title">Tambah Sub Akun</h4>
                                                  </div>
                                                  <form action="index.php?view='.$_GET['view'].'" method="post" accept-charset="utf-8">
                                                    <div class="modal-body">
                                                      <div class="row">
                                                        <div class="col-md-12">
                                                          <input type="hidden" required="" name="id_akun" class="form-control" value="'.$aSub2['idAkun'].'">
                                                          <input type="hidden" required="" name="id_sub_akun" class="form-control" value="'.$aSub2['idSubAkun'].'">
                                                          <div class="form-group">
                                                            <label>Kode Akun</label>
                                                            <input type="text" required="" readonly="" name="kode_akun" class="form-control" value="'.$aSub2['kodeAkun'].'">
                                                          </div>
                                                          <div class="form-group">
                                                            <label>Keterangan</label>
                                                            <input type="text" required="" name="keterangan_akun" class="form-control" placeholder="Masukkan Keterangan" value="'.$aSub2['keterangan'].'">
                                                          </div>
                                                          <div class="form-group">
                                                            <label>Kategori <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                                                            <select required="" name="kategori_akun" class="form-control">
                                                              <option disabled selected>-Pilih Kategori-</option>';
                                                              if ($aSub2['kategori'] == 'Pembayaran'){
                                                                echo '<option value="Pembayaran" selected>Pembayaran</option>';
                                                              }else{
                                                                echo '<option value="Pembayaran">Pembayaran</option>';
                                                              }
                                                              if ($aSub2['kategori'] == 'Keuangan'){
                                                                echo '<option value="Keuangan" selected>Keuangan</option>';
                                                              }else{
                                                                echo '<option value="Keuangan">Keuangan</option>';
                                                              }
                                      echo                  '</select>
                                                          </div>
                                                          <div class="form-group">
                                                            <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                                                            <select required="" name="unitSekolah_akun" class="form-control">';
                                                              echo '<option value="" disabled="" selected="">- Pilih Unit Sekolah -</option>';
                                                              if($_SESSION['unit'] != '0'){
                                                                $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' AND idUnit='$_SESSION[unit] ' ORDER BY idUnit ASC");
                                                              }else{
                                                                $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' ORDER BY idUnit ASC");
                                                              }
                                                              while ($q = mysqli_fetch_array($query_unit)) {
                                                                if ($aSub2['unitSekolah'] == $q['idUnit']){
                                                                    echo '<option value="'.$q['idUnit'].'" selected>'.$q['singkatanUnit'].'</option>';
                                                                }else{
                                                                    echo '<option value="'.$q['idUnit'].'">'.$q['singkatanUnit'].'</option>';
                                                                }
                                                              }
                                      echo                  '</select>          
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="submit" name="update_sub2" class="btn btn-success">Simpan</button>
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>';

                                      echo '<div class="modal fade" id="deleteAccountSub2'.$aSub2['idAkun'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <form action="index.php?view='.$_GET['view'].'" method="POST" role="form">
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
                                                      <input type="hidden" name="id_akun" value="'.$aSub2['idAkun'].'">
                                                      <button type="submit" name="hapus_sub2" class="btn btn-danger pull-right"><span class="fa fa-check"></span> Hapus</button>
                                                      <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </form>
                                            </div>';


                            $data_sub3 = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM akun_biaya WHERE idSubAkun='$aSub2[idAkun]' AND stdel='0'"));
                            if ($data_sub3 == 0){
                              $query_sub3 = mysqli_query($koneksi, "SELECT max(kodeAkun) as kodeTerbesar FROM akun_biaya WHERE idAkun='$aSub2[idAkun]' AND stdel='0'");
                            }else{
                              $query_sub4 = mysqli_query($koneksi, "SELECT max(kodeAkun) as kodeTerbesar FROM akun_biaya WHERE idSubAkun='$aSub2[idAkun]' AND stdel='0'");
                            }

                            $data = mysqli_fetch_array($query_sub3);
                            $kode = $data['kodeTerbesar'];
                            $pisah = explode('.', $kode);
                            $kode_awal = $pisah[0];
                            $urutan = $pisah[1] + 1;
                                      
                            $kode_sub3 = $kode_awal.'.'.$urutan;

                            echo '<div class="modal fade in" id="addAccountSub3'.$aSub2['idAkun'].'" role="dialog">
                                    <div class="modal-dialog modal-md">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal">×</button>
                                          <h4 class="modal-title">Tambah Sub Akun</h4>
                                        </div>
                                        <form action="index.php?view='.$_GET['view'].'" method="post" accept-charset="utf-8">
                                        <div class="modal-body">
                                          <div class="row">
                                            <div class="col-md-12">
                                              <input type="hidden" readonly="" name="id_sub_akun" class="form-control" value="'.$aSub2['idAkun'].'">
                                              <div class="form-group">
                                                <label>Kode Akun</label>
                                                <input type="text" required="" readonly="" name="kode_akun" class="form-control" value="'.$kode_sub3.'">
                                              </div>
                                              <div class="form-group">
                                              <label>Keterangan</label>
                                              <input type="text" required="" name="keterangan_akun" class="form-control" placeholder="Masukkan Keterangan">
                                              </div>
                                              <input type="hidden" required="" name="jenis_akun" class="form-control" value="Sub Menu 3">
                                              <div class="form-group">
                                                  </div>
                                                  <div class="form-group">
                                                    <label>Kategori <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                                                    <select required="" name="kategori_akun" class="form-control">
                                                        <option value="" disabled selected>-Pilih Kategori-</option>
                                                        <option value="Pembayaran">Pembayaran</option>
                                                        <option value="Keuangan">Keuangan</option>
                                                    </select>
                                                  </div>
                                              <div class="form-group">
                                                <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                                                <select required="" name="unitSekolah_akun" class="form-control">';
                                                echo '<option value="" disabled="" selected="">- Pilih Unit Sekolah -</option>';
                                                  if($_SESSION['unit'] != '0'){
                                                    $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' AND idUnit='$_SESSION[unit] ' ORDER BY idUnit ASC");
                                                  }else{
                                                    $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' ORDER BY idUnit ASC");
                                                  }
                                                  while ($q = mysqli_fetch_array($query_unit)) {
                                                    echo '<option value="'.$q['idUnit'].'">'.$q['singkatanUnit'].'</option>';  
                                                  }
                              echo              '<select>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="submit" name="simpan_sub3" class="btn btn-success">Simpan</button>
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>';

                              if (isset($_GET['unit'])){
                                $Q_Akun_Sub3 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub2[idAkun]' AND akun_biaya.unitSekolah='$_GET[unit]' ORDER BY akun_biaya.idAkun ASC");
                              }elseif($_SESSION['unit'] != '0'){
                                $Q_Akun_Sub3 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub2[idAkun]' AND akun_biaya.unitSekolah='$_SESSION[unit]' ORDER BY akun_biaya.idAkun ASC");
                              }else{
                                $Q_Akun_Sub3 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub2[idAkun]' ORDER BY akun_biaya.idAkun ASC");
                              }
                                        
                                        while($aSub3=mysqli_fetch_array($Q_Akun_Sub3)){
                                          echo '<tr>
                                                  <td>'.$no++.'</td>
                                                  <td>'.$aSub3['kodeAkun'].'</td>
                                                  <td>'.$aSub3['keterangan'].' '.str_replace('-',' ',$aSub3['singkatanUnit']).'</td>
                                                  <td>'.$aSub3['jenisAkun'].'</td>
                                                  <td>'.$aSub3['kategori'].'</td>
                                                  <td>'.$aSub3['singkatanUnit'].'</td>
                                                  <td align="left">
                                                    <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editAccountSub3'.$aSub3['idAkun'].'" title="Edit Sub Akun"><i class="fa fa-pencil"></i></button>
                                                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteAccountSub3'.$aSub3['idAkun'].'" title="Hapus Sub Akun"><i class="fa fa-trash"></i></button>
                                                  </td>
                                                </tr>';
                                          echo '<div class="modal fade in" id="editAccountSub3'.$aSub3['idAkun'].'" role="dialog">
                                              <div class="modal-dialog modal-md">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                                    <h4 class="modal-title">Tambah Sub Akun</h4>
                                                  </div>
                                                  <form action="index.php?view='.$_GET['view'].'" method="post" accept-charset="utf-8">
                                                    <div class="modal-body">
                                                      <div class="row">
                                                        <div class="col-md-12">
                                                          <input type="hidden" required="" name="id_akun" class="form-control" value="'.$aSub3['idAkun'].'">
                                                          <input type="hidden" required="" name="id_sub_akun" class="form-control" value="'.$aSub3['idSubAkun'].'">
                                                          <div class="form-group">
                                                            <label>Kode Akun</label>
                                                            <input type="text" required="" readonly="" name="kode_akun" class="form-control" value="'.$aSub3['kodeAkun'].'">
                                                          </div>
                                                          <div class="form-group">
                                                            <label>Keterangan</label>
                                                            <input type="text" required="" name="keterangan_akun" class="form-control" placeholder="Masukkan Keterangan" value="'.$aSub3['keterangan'].'">
                                                          </div>
                                                          <div class="form-group">
                                                            <label>Kategori <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                                                            <select required="" name="kategori_akun" class="form-control">
                                                              <option disabled selected>-Pilih Kategori-</option>';
                                                              if ($aSub3['kategori'] == 'Pembayaran'){
                                                                echo '<option value="Pembayaran" selected>Pembayaran</option>';
                                                              }else{
                                                                echo '<option value="Pembayaran">Pembayaran</option>';
                                                              }
                                                              if ($aSub3['kategori'] == 'Keuangan'){
                                                                echo '<option value="Keuangan" selected>Keuangan</option>';
                                                              }else{
                                                                echo '<option value="Keuangan">Keuangan</option>';
                                                              }
                                          echo              '</select>
                                                          </div>
                                                          <div class="form-group">
                                                            <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                                                            <select required="" name="unitSekolah_akun" class="form-control">';
                                                              echo '<option value="" disabled="" selected="">- Pilih Unit Sekolah -</option>';
                                                              if($_SESSION['unit'] != '0'){
                                                                $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' AND idUnit='$_SESSION[unit] ' ORDER BY idUnit ASC");
                                                              }else{
                                                                $query_unit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' ORDER BY idUnit ASC");
                                                              }
                                                              while ($q = mysqli_fetch_array($query_unit)) {
                                                                if ($aSub3['unitSekolah'] == $q['idUnit']){
                                                                    echo '<option value="'.$q['idUnit'].'" selected>'.$q['singkatanUnit'].'</option>';
                                                                }else{
                                                                    echo '<option value="'.$q['idUnit'].'">'.$q['singkatanUnit'].'</option>';
                                                                }
                                                              }
                                          echo              '</select>          
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                      <button type="submit" name="update_sub3" class="btn btn-success">Simpan</button>
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                  </form>
                                                </div>
                                              </div>
                                            </div>';

                                      echo '<div class="modal fade" id="deleteAccountSub3'.$aSub3['idAkun'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <form action="index.php?view='.$_GET['view'].'" method="POST" role="form">
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
                                                      <input type="hidden" name="id_akun" value="'.$aSub3['idAkun'].'">
                                                      <button type="submit" name="hapus_sub3" class="btn btn-danger pull-right"><span class="fa fa-check"></span> Hapus</button>
                                                      <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </form>
                                            </div>';
                                        }
                                  }
                            }
                         } 
                    }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    