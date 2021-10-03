<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success">
                <div class="box-header with-border">
                  <a class='pull-left btn btn-success btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=tambah'>Tambah</a>
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
                        <th>Nama Pajak</th>
          						  <th>Besaran Pajak</th>
          						  <th>Aksi</th>
          					  </tr>
          					</thead>
          					<tbody>
                    <?php 
                      $tampil = mysqli_query($koneksi,"SELECT * FROM pajak WHERE stdel='0' ORDER BY idPajak DESC");
                      
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        echo "<tr><td>$no</td>
                                <td>".$r['nmPajak']."</td>
                                <td>".$r['besaranPajak']." %</td>
                                <td><center>
                                  <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idPajak]'><span class='fa fa-edit'></span></a>
                                  <a class='btn btn-danger btn-xs' href='#' data-toggle='modal' data-target='#hapus".$r[idPajak]."'><span class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus'></span></a>
                                </center></td>";
                        echo "</tr>";

                        echo '<div class="modal fade" id="hapus'.$r[idPajak].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <form action="?view='.$_GET[view].'&hapus&id='.$r[idPajak].'" method="POST" role="form">
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
                          $query = mysqli_query($koneksi,"UPDATE pajak SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idPajak='$_GET[id]'");
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
    $query = mysqli_query($koneksi,"UPDATE pajak SET nmPajak='$_POST[nama_pajak]', besaranPajak='$_POST[besaran_pajak]', uby='$idUsers', udate='$waktu_sekarang' WHERE idPajak = '$_POST[id]'");
    
    if ($query){
      $_SESSION['notif'] = 'usukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
  }
  $edit = mysqli_query($koneksi,"SELECT * FROM pajak WHERE idPajak='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>
  
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
          <input type="hidden" name="id" value="<?= $record['idPajak'] ?>">
          <label>Nama Pajak</label>
          <input type="text" required="" name="nama_pajak" class="form-control" placeholder="Contoh : Sekolah Dasar Putra" value="<?= $record['nmPajak'] ?>">
          <br>
          <label>Besaran Pajak</label>
          <input type="text" required="" name="besaran_pajak" class="form-control" placeholder="NB : Jika koma gunakan Titik Contoh: 2.5" value="<?= $record['besaranPajak'] ?>">
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
    $nm_pajak = $_POST['nama_pajak'];
    $bsr_pajak = $_POST['besaran_pajak'];
    for ($i=0; $i < count($nm_pajak) ; $i++) { 
      $query = mysqli_query($koneksi,"INSERT INTO pajak(nmPajak,besaranPajak,stdel,cby,cdate) VALUES('$nm_pajak[$i]','$bsr_pajak[$i]','0','$idUsers','$waktu_sekarang')");
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
          <div id="detail_pajak">
            <p>
              <label>Nama Pajak</label>
              <input type="text" required="" name="nama_pajak[]" class="form-control" placeholder="Contoh : Sekolah Dasar Putra">
              <br>
              <label>Besaran Pajak</label>
              <input type="text" required="" name="besaran_pajak[]" class="form-control" placeholder="NB : Jika koma gunakan Titik Contoh: 2.5">
            </p>
          </div>
          <br>
          <a href="#" class="btn btn-xs btn-success" id="add_pajak"><i class="fa fa-plus"></i><b> Tambah Baris</b></a>
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
      var scntDiv = $('#detail_pajak');
      var i = $('#detail_pajak p').size() + 1;

      $("#add_pajak").click(function() {
        $('<p><label>Nama Pajak</label><input type="text" required="" name="nama_pajak[]" class="form-control" placeholder="Contoh : Sekolah Dasar Putra"><br><label>Besaran Pajak</label><input type="text" required="" name="besaran_pajak[]" class="form-control" placeholder="NB : Jika koma gunakan Titik Contoh: 2.5"><a href="#" class="btn btn-xs btn-danger remove_pajak">Hapus Baris</a></p>').appendTo(scntDiv);
        i++;
        return false;
      });

      $(document).on("click", ".remove_pajak", function() {
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

