<?php if ($_GET[act]==''){ ?> 
    <div class="col-xs-12">  
        <div class="box box-success">
            <div class="box-header">
              <a class='pull-left btn btn-success btn-sm' href='index.php?view=<?= $_GET["view"] ?>&act=tambah'>Tambah</a>
            </div>
            <div class="box-body">
               	<?php 
                  if ($_SESSION['notif'] == 'csukses'){
                    echo '<script>toastr["success"]("Data berhasil disimpan.","Sukses!")</script>';
                  }elseif ($_SESSION['notif'] == 'usukses'){
                    echo '<script>toastr["success"]("Data berhasil diupdate.","Sukses!")</script>';
                  }elseif ($_SESSION['notif'] == 'dsukses'){
                    echo '<script>toastr["success"]("Data berhasil dihapus.","Sukses!")</script>';
                  }elseif($_SESSION['notif'] == 'nonaktifkan'){
                    echo '<script>toastr["success"]("Unit berhasil dinonaktifkan.","Sukses!")</script>';
                  }elseif($_SESSION['notif'] == 'aktifkan'){
                    echo '<script>toastr["success"]("Unit berhasil diaktifkan.","Sukses!")</script>';
                  }elseif($_SESSION['notif'] == 'gagalnonaktifkan'){
                    echo '<script>toastr["error"]("Gagal menonaktifkan unit.","Gagal!")</script>';
                  }elseif($_SESSION['notif'] == 'gagalaktifkan'){
                    echo '<script>toastr["error"]("Gagal mengaktikan unit.","Gagal!")</script>';
                  }elseif($_SESSION['notif'] == 'gagal'){
                    echo '<script>toastr["error"]("Data gagal diproses.","Gagal!")</script>';
                  }
                  unset($_SESSION['notif']);
                ?>
              <div class="table-responsive">
                <table id="example1" class="table table-hover dataTable no-footer">
        					<thead>
        					  	<tr>
        						  	<th>No</th>
        						  	<th>Nama Unit Sekolah</th>
                        <th>Singkatan</th>
                        <th>ID Unit Sekolah</th>
                        <th>Status</th>
        						  	<th>Aksi</th>
        					  	</tr>
        				  	</thead>
        				  	<tbody>
                  	<?php 
                    	$no = 1;
                      $tampil = mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE stdel='0' ORDER BY idUnit ASC");
                    	while($r=mysqli_fetch_array($tampil)){
                        if ($r['status'] == '1'){
                          $status = '<label class="label label-success">Aktif</label>';
                        }else{
                          $status = '<label class="label label-danger">Tidak Aktif</label>';
                        }
                          echo "<tr><td>$no</td>
                              	<td>$r[namaUnit]</td>
                                <td>$r[singkatanUnit]</td>
                                <td>$r[idUnit]</td>
                                <td>$status</td>
                              	<td><center>";
                                   if($r['status'] == '1'){
                                    echo " <a class='btn btn-info btn-xs' data-toggle='tooltip' title='' data-original-title='Non-Aktifkan' href='?view=$_GET[view]&nonaktifkan&id=$r[idUnit]'><span class='fa fa-remove'></span></a>";
                                  }else{
                                    echo " <a class='btn btn-success btn-xs' data-toggle='tooltip' title='' data-original-title='Aktifkan' href='?view=$_GET[view]&aktifkan&id=$r[idUnit]'><span class='fa fa-check'></span></a>";
                                  }

                                    echo " <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idUnit]'><span class='fa fa-edit'></span></a>
                                       <a class='btn btn-danger btn-xs' href='#' data-toggle='modal' data-target='#hapus".$r[idUnit]."'><span class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus'></span></a>
                                  </center></td>";
                          echo "</tr>";

                          echo '<div class="modal fade" id="hapus'.$r[idUnit].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <form action="?view='.$_GET[view].'&hapus&id='.$r[idUnit].'" method="POST" role="form">
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
                          $query = mysqli_query($koneksi,"UPDATE unit_sekolah SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idUnit='$_GET[id]'");
                          if($query){
                            $_SESSION['notif'] = 'dsukses';
                          }else{
                            $_SESSION['notif'] = 'gagal';
                          }
                          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                        }

                        if (isset($_GET[nonaktifkan])){
                          $query = mysqli_query($koneksi,"UPDATE unit_sekolah SET status='0', uby='$idUsers', udate='$waktu_sekarang' WHERE idUnit='$_GET[id]'");
                          if($query){
                            $_SESSION['notif'] = 'nonaktifkan';
                          }else{
                            $_SESSION['notif'] = 'gagalnonaktifkan';
                          }
                          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                        }

                        if (isset($_GET[aktifkan])){
                          $query = mysqli_query($koneksi,"UPDATE unit_sekolah SET status='1', uby='$idUsers', udate='$waktu_sekarang' WHERE idUnit='$_GET[id]'");
                          if($query){
                            $_SESSION['notif'] = 'aktifkan';
                          }else{
                            $_SESSION['notif'] = 'gagalaktifkan';
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

<?php }elseif($_GET[act]=='edit'){
    if (isset($_POST[update])){
    	$query = mysqli_query($koneksi,"UPDATE unit_sekolah SET namaUnit='$_POST[namaUnit]', singkatanUnit='$_POST[singkatanUnit]', status='$_POST[status]',namaUnit='$_POST[namaUnit]', uby='$idUsers', udate='$waktu_sekarang' WHERE idUnit = '$_POST[id]'");
      if ($query){
        echo "<script>document.location='index.php?view=$_GET[view]';</script>";
        $_SESSION['notif'] = 'usukses';
      }else{
        echo "<script>document.location='index.php?view=$_GET[view]';</script>";
        $_SESSION['notif'] = 'gagal';
      }
    }
    $edit = mysqli_query($koneksi,"SELECT * FROM unit_sekolah where idUnit='$_GET[id]'");
    $record = mysqli_fetch_array($edit);
?>
   	<form method="post" action="" class="form-horizontal">
	   	<div class="col-md-9">
	      <div class="box box-success">
	        <div class="box-body">
				    <input type="hidden" name="id" value="<?php echo $record['idUnit']; ?>" >
            <label>Nama Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
            <input type="text" name="namaUnit" placeholder="Nama Unit Sekolah" class="form-control" value="<?= $record[namaUnit]?>" required>
            <br>
            <label>Singkatan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
            <input type="text" name="singkatanUnit" placeholder="Singkatan Unit Sekolah" class="form-control" value="<?= $record[singkatanUnit]?>" required>
            <br>
            <label>Status</label>
            <div class="radio">
              <label>
                <?php if ($record[status] == '1'){
                  echo ' <input type="radio" name="status" value="1" checked=""> Aktif';
                }else{
                  echo ' <input type="radio" name="status" value="1"> Aktif';
                } ?>
              </label>
              &nbsp;&nbsp;&nbsp;
                <label>
                  <?php if ($record[status] == '0'){
                    echo '<input type="radio" name="status" value="0" checked=""> Tidak Aktif';
                  }else{
                    echo '<input type="radio" name="status" value="0"> Tidak Aktif';
                  } ?>
                </label>
            </div>
            <br>
            <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
	        </div>
	      </div>
	    </div>

	    <div class="col-md-3">
	      <div class="box box-success">
	        <div class="box-body">
				<input type="submit" name="update" value="Simpan" class="btn btn-block btn-success">
				<a href="index.php?view=<?= $_GET["view"] ?>" class="btn btn-block btn-danger">Batal</a>			
	        </div>
	      </div>
	    </div>
   	</form>


<?php }elseif($_GET[act]=='tambah'){
    if (isset($_POST[tambah])){
      $query = mysqli_query($koneksi,"INSERT INTO unit_sekolah(namaUnit,singkatanUnit,status,stdel,cby,cdate) VALUES('$_POST[namaUnit]','$_POST[singkatanUnit]','$_POST[status]','0','$idUsers','$waktu_sekarang')");
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
              <label>Nama Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="text" name="namaUnit" placeholder="Nama Unit Sekolah" class="form-control" required>
              <br>
              <label>Singkatan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="text" name="singkatanUnit" placeholder="Singkatan Unit Sekolah" class="form-control" required>
              <br>
              <label>Status</label>
              <div class="radio">
                <label><input type="radio" name="status" value="1"> Aktif</label>
                &nbsp;&nbsp;&nbsp;
                <label><input type="radio" name="status" value="0" checked=""> Tidak Aktif</label>
              </div>
              
              <br>
              <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
            </div>
          </div>
      </div>

      <div class="col-md-3">
          <div class="box box-success">
            <div class="box-body">
              <button name="tambah" type="submit" value="Simpan" class="btn btn-block btn-success">Simpan</button>
              <a href="index.php?view=<?= $_GET["view"]?>" class="btn btn-block btn-danger">Batal</a>
            </div>
          </div>
      </div>

  </form>
<?php
}
?>