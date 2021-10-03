<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success">
                <div class="box-header">
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
                        <th>Nama Unit Pos</th>
                        <th>Unit Sekolah</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                      if (isset($_GET['unit'])){
                        if ($_GET['unit'] != 'all'){
                          $tampil = mysqli_query($koneksi,"SELECT unit_pos.*, unit_sekolah.singkatanUnit FROM unit_pos LEFT JOIN unit_sekolah ON unit_pos.unitSekolah = unit_sekolah.idUnit WHERE unit_pos.stdel='0' AND unit_pos.unitSekolah='$_GET[unit]' ORDER BY unit_pos.idUnitPos ASC");
                        }else{
                          $tampil = mysqli_query($koneksi,"SELECT unit_pos.*, unit_sekolah.singkatanUnit FROM unit_pos LEFT JOIN unit_sekolah ON unit_pos.unitSekolah = unit_sekolah.idUnit WHERE unit_pos.stdel='0' ORDER BY unit_pos.idUnitPos ASC");
                        }
                      }elseif($idUnitUsers != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT unit_pos.*, unit_sekolah.singkatanUnit FROM unit_pos LEFT JOIN unit_sekolah ON unit_pos.unitSekolah = unit_sekolah.idUnit WHERE unit_pos.stdel='0' AND unit_pos.unitSekolah='$idUnitUsers' ORDER BY unit_pos.idUnitPos ASC");
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT unit_pos.*, unit_sekolah.singkatanUnit FROM unit_pos LEFT JOIN unit_sekolah ON unit_pos.unitSekolah = unit_sekolah.idUnit WHERE unit_pos.stdel='0' ORDER BY unit_pos.idUnitPos ASC");
                      }
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        echo "<tr><td>$no</td>
                                <td>".$r['nmUnitPos']."</td>
                                <td>".$r['singkatanUnit']."</td>
                                <td><center>
                                  <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idUnitPos]'><span class='fa fa-edit'></span></a>
                                  <a class='btn btn-danger btn-xs' href='#' data-toggle='modal' data-target='#hapus".$r[idUnitPos]."'><span class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus'></span></a>
                                </center></td>";
                        echo "</tr>";

                        echo '<div class="modal fade" id="hapus'.$r[idUnitPos].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <form action="?view='.$_GET[view].'&hapus&id='.$r[idUnitPos].'" method="POST" role="form">
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
                          $query = mysqli_query($koneksi,"UPDATE unit_pos SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idUnitPos='$_GET[id]'");
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
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
<?php 
}elseif($_GET[act]=='edit'){
  if (isset($_POST[update])){ 
    $query = mysqli_query($koneksi,"UPDATE unit_pos SET nmUnitPos='$_POST[nama_unit_pos]', unitSekolah='$_POST[unit_sekolah]', uby='$idUsers', udate='$waktu_sekarang' WHERE idUnitPos = '$_POST[id]'");
    
    if ($query){
      $_SESSION['notif'] = 'usukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
  }
  $edit = mysqli_query($koneksi,"SELECT * FROM unit_pos WHERE idUnitPos='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>
  
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
          <input type="hidden" required="" name="id" value="<?= $record['idUnitPos'] ?>">
          <label>Nama Unit Pos</label>
              <input type="text" required="" name="nama_unit_pos" class="form-control" placeholder="Contoh : X (A)" value="<?= $record['nmUnitPos'] ?>">
              <br>
              <label>Unit Sekolah</label>
              <select name="unit_sekolah" class="form-control" required="">
                <option disabled="" selected="">- Pilih Unit Sekolah -</option>
                <?php
                  if ($idUnitUsers == '0'){
                    $query = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' ORDER BY idUnit ASC");
                  }else{
                    $query = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$idUnitUsers' AND status='1' AND stdel='0' ORDER BY idUnit ASC");
                  }
                  while ($q = mysqli_fetch_array($query)) {
                    if ($record['unitSekolah'] == $q['idUnit']){
                        echo '<option value="'.$q['idUnit'].'" selected>'.$q['singkatanUnit'].'</option>';
                    }else{
                        echo '<option value="'.$q['idUnit'].'">'.$q['singkatanUnit'].'</option>';
                    }
                  }
                ?>
              </select>
            <br>
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
    $nama_unit_pos = $_POST['nama_unit_pos'];
    $unit_sekolah = $_POST['unit_sekolah'];
    for ($i=0; $i < count($nama_unit_pos) ; $i++) { 
      $query = mysqli_query($koneksi,"INSERT INTO unit_pos(nmUnitPos,unitSekolah,stdel,cby,cdate) VALUES('$nama_unit_pos[$i]','$unit_sekolah[$i]','0','$idUsers','$waktu_sekarang')");
    }
    if ($query){
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      $_SESSION['notif'] = 'csukses';
    }else{
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      $_SESSION['notif'] = 'gagal';
    }  
  }

?>
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
          <div id="detail_unit_pos">
            <p>
              <label>Nama Unit Pos</label>
              <input type="text" required="" name="nama_unit_pos[]" class="form-control" placeholder="Contoh : X (A)">
              <br>
              <label>Unit Sekolah</label>
              <select name="unit_sekolah[]" class="form-control" required="">
                <option disabled="" selected="">- Pilih Unit Sekolah -</option>
                <?php
                  if ($idUnitUsers == '0'){
                    $query = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' ORDER BY idUnit ASC");
                  }else{
                    $query = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$idUnitUsers' AND status='1' AND stdel='0' ORDER BY idUnit ASC");
                  }
                  while ($q = mysqli_fetch_array($query)) {
                    echo '<option value="'.$q['idUnit'].'">'.$q['singkatanUnit'].'</option>';
                  }
                ?>
              </select>
            </p>
          </div>
          <br>
          <a href="#" class="btn btn-xs btn-success" id="add_unit_pos"><i class="fa fa-plus"></i><b> Tambah Baris</b></a>
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
      var scntDiv = $('#detail_unit_pos');
      var i = $('#detail_unit_pos p').size() + 1;

      $("#add_unit_pos").click(function() {
        $('<p><label>Nama Unit Pos</label><input type="text" required="" name="nama_unit_pos[]" class="form-control" placeholder="Contoh : X (A)"><br><label>Unit Sekolah</label><select name="unit_sekolah[]" class="form-control" required=""><option disabled="" selected="">- Pilih Unit Sekolah -</option><?php if ($idUnitUsers == '0'){ $query = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0' ORDER BY idUnit ASC"); }else{ $query = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$idUnitUsers' AND status='1' AND stdel='0' ORDER BY idUnit ASC"); } while ($q = mysqli_fetch_array($query)) { echo '<option value="'.$q['idUnit'].'">'.$q['singkatanUnit'].'</option>'; } ?> </select><a href="#" class="btn btn-xs btn-danger remove_unit_pos">Hapus Baris</a></p>').appendTo(scntDiv);
        i++;
        return false;
      });

      $(document).on("click", ".remove_unit_pos", function() {
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

