<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success">
                <div class="box-header with-border">
                  <a class='pull-left btn btn-success btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=tambah'>Tambah</a>
                  <br><br>
                  <form action="" class="form-horizontal" method="GET" accept-charset="utf-8">
                    <div class="box-body table-responsive">
                      <table>
                        <tbody>
                          <tr>
                            <td>     
                              <input type="hidden" name="view" value="<?= $_GET[view] ?>">
                              <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                              <input type="hidden" id="tipe_unit" value="pencarian">
                              <select style="width: 200px;" id="Cunit" name="unit" class="form-control" required="">           
                              </select>
                          </td>
                          <td>
                            &nbsp;&nbsp;
                          </td>
                          <td>
                            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Cari</button>    
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </form>
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
                    unset($_SESSION['notif']);
                  ?>
                  <table id="example1" class="table table-hover dataTable no-footer">
          					<thead>
          					  <tr>
          						  <th>No</th>
                        <th>Nama Kelas</th>
          						  <th>ID Kelas</th>
          						  <th>Unit Sekolah</th>
                        <th>ID Unit</th>
          						  <th>Aksi</th>
          					  </tr>
          					</thead>
          					<tbody>
                    <?php 
                      if($idUnitUsers != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT kelas_siswa.*, unit_sekolah.idUnit, unit_sekolah.singkatanUnit FROM kelas_siswa LEFT JOIN unit_sekolah ON kelas_siswa.idUnit = unit_sekolah.idUnit WHERE kelas_siswa.stdel='0' AND kelas_siswa.idUnit='$idUnitUsers' ORDER BY kelas_siswa.idKelas ASC");
                      }elseif (isset($_GET['unit'])){
                        if ($_GET['unit'] != 'all'){
                          $tampil = mysqli_query($koneksi,"SELECT kelas_siswa.*, unit_sekolah.idUnit, unit_sekolah.singkatanUnit FROM kelas_siswa LEFT JOIN unit_sekolah ON kelas_siswa.idUnit = unit_sekolah.idUnit WHERE kelas_siswa.stdel='0' AND kelas_siswa.idUnit='$_GET[unit]' ORDER BY kelas_siswa.idKelas ASC");
                        }else{
                          $tampil = mysqli_query($koneksi,"SELECT kelas_siswa.*, unit_sekolah.idUnit, unit_sekolah.singkatanUnit FROM kelas_siswa LEFT JOIN unit_sekolah ON kelas_siswa.idUnit = unit_sekolah.idUnit WHERE kelas_siswa.stdel='0' ORDER BY kelas_siswa.idKelas ASC");
                        }
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT kelas_siswa.*, unit_sekolah.idUnit, unit_sekolah.singkatanUnit FROM kelas_siswa LEFT JOIN unit_sekolah ON kelas_siswa.idUnit = unit_sekolah.idUnit WHERE kelas_siswa.stdel='0'  ORDER BY kelas_siswa.idKelas ASC");
                      }
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        echo "<tr><td>$no</td>
                                <td>$r[nmKelas]</td>
                                <td>$r[idKelas]</td>
                                <td>$r[singkatanUnit]</td>
                                <td>$r[idUnit]</td>
                                <td><center>
                                  <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idKelas]'><span class='fa fa-edit'></span></a>
                                  <a class='btn btn-danger btn-xs' href='#' data-toggle='modal' data-target='#hapus".$r[idKelas]."'><span class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus'></span></a>

                                </center></td>";
                        echo "</tr>";

                        echo '<div class="modal fade" id="hapus'.$r[idKelas].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <form action="?view='.$_GET[view].'&hapus&id='.$r[idKelas].'" method="POST" role="form">
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
                          $query = mysqli_query($koneksi,"UPDATE kelas_siswa SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idKelas='$_GET[id]'");
                          if($query){
                            $_SESSION['notif'] = 'dsukses';
                            echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                          }else{
                            $_SESSION['notif'] = 'gagal';
                            echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                          }
                          
                      }

                      ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
<?php 
}elseif($_GET[act]=='edit'){
  if (isset($_POST[update])){ 
    $query = mysqli_query($koneksi,"UPDATE kelas_siswa SET nmKelas='$_POST[namaKelas]', idUnit='$_POST[unit]', uby='$idUsers', udate='$waktu_sekarang' WHERE idKelas = '$_POST[id]'");
    
    if ($query){
      $_SESSION['notif'] = 'usukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
  }
  $edit = mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>
  
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
          <input type="hidden" name="id" value="<?= $record['idKelas'] ?>">
          <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="hidden" value="<?= $record['idUnit'] ?>" id="idUnit">
          <select name="unit" class="form-control" required id="Cunit"></select>
          <br>
          <div id="detail_kelas">
            <p>
              <label>Nama Kelas <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="text" required="" name="namaKelas" class="form-control" placeholder="Nama Kelas" value="<?= $record['nmKelas']?>">
            </p>
          </div>
          <br>
          <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="box box-success">
        <div class="box-body">
          <button name="update" type="submit" value="Simpan" class="btn btn-block btn-success">Simpan</button>
          <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
        </div>
      </div>
    </div>

  </form>

<?php }elseif($_GET[act]=='tambah'){

  if (isset($_POST[tambah])){
    $nmKelas = $_POST['namaKelas'];
    for ($i=0; $i < count($nmKelas) ; $i++) { 
      $query = mysqli_query($koneksi,"INSERT INTO kelas_siswa(nmKelas,idUnit,stdel,cby,cdate) VALUES('$nmKelas[$i]','$_POST[unit]','0','$idUsers','$waktu_sekarang')");
    }
    if ($query){
      $_SESSION['notif'] = 'csukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }  
  }

?>
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
          <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <select name="unit" class="form-control" required id="Cunit"></select>
          <br>
          <div id="detail_kelas">
            <p>
              <label>Nama Kelas</label>
              <input type="text" required="" name="namaKelas[]" class="form-control" placeholder="Nama Kelas">
            </p>
          </div>
          <br>
          <a href="#" class="btn btn-xs btn-success" id="add_nama_kelas"><i class="fa fa-plus"></i><b> Tambah Baris</b></a>
          <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="box box-success">
        <div class="box-body">
          <button name="tambah" type="submit" value="Simpan" class="btn btn-block btn-success">Simpan</button>
          <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
        </div>
      </div>
    </div>

  </form>

  <!-- TAMBAH INPUTAN KELAS -->
  <script>
    $(function() {
      var scntDiv = $('#detail_kelas');
      var i = $('#detail_kelas p').size() + 1;

      $("#add_nama_kelas").click(function() {
        $('<p><label>Nama Kelas</label><input required type="text" name="namaKelas[]" class="form-control" placeholder="Nama Kelas"><a href="#" class="btn btn-xs btn-danger remove_nama_kelas">Hapus Baris</a></p>').appendTo(scntDiv);
        i++;
        return false;
      });

      $(document).on("click", ".remove_nama_kelas", function() {
        if (i > 2) {
          $(this).parents('p').remove();
          i--;
        }
        return false;
      });
    });
  </script>

<?php
}
?>

