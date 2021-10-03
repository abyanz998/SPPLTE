<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success">
              	<div class="box-header">
              		<a class='pull-left btn btn-success btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=tambah'>Tambah</a>
              	</div>
                <div class="box-body">
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
						  <th>Judul</th>
						  <th>Tanggal</th>
						  <th>Status</th>
						  <th>Aksi</th>
					  </tr>
				  </thead>
				  <tbody>
                  <?php 
                    $tampil = mysqli_query($koneksi,"SELECT * FROM informasi WHERE stdel='0' ORDER BY idInformasi DESC");
                    $no = 1;
                    while($r=mysqli_fetch_array($tampil)){
                    	if ($r['publikasiInformasi'] == 0 ){
                    		$status = "Draft";
                    	}else{
                    		$status = "Terbit";
                    	}
						echo "<tr><td>$no</td>
                              <td>$r[judulInformasi]</td>
                              <td>".tgl_raport($r['tanggalInformasi'])."</td>
                              <td>$status</td>
                              <td><center>
                                <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idInformasi]'><span class='fa fa-edit'></span></a>
                                <a class='btn btn-danger btn-xs' href='#' data-toggle='modal' data-target='#hapus".$r[idInformasi]."'><span class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus'></span></a>

                              </center></td>";
                            echo "</tr>";


                	        echo '<div class="modal fade" id="hapus'.$r[idInformasi].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<form action="?view='.$_GET[view].'&hapus&id='.$r[idInformasi].'" method="POST" role="form">
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
                          mysqli_query($koneksi,"UPDATE informasi SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' where idInformasi='$_GET[id]'");
                          $_SESSION['notif'] = 'dsukses';
                          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                      }

                  ?>
                    </tbody>

                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>

<?php }elseif($_GET[act]=='edit'){
    if (isset($_POST[update])){

    	$isiInformasi = addslashes($_POST['isiInformasi']);
    	$lokasi_file = $_FILES['gambarInformasi']['tmp_name'];
  		$nama_file   = $_FILES['gambarInformasi']['name'];
  		$tmp_name 	 = $_FILES["gambarInformasi"]["tmp_name"];

  		if (!empty($lokasi_file)){
  			UploadGambar($lokasi_foto_informasi,$tmp_name,$nama_file);
  			$query = mysqli_query($koneksi,"UPDATE informasi SET judulInformasi='$_POST[judulInformasi]', isiInformasi='$isiInformasi', tanggalInformasi='$waktu_sekarang', publikasiInformasi='$_POST[publikasiInformasi]', gambarInformasi='$nama_file', uby='$idUsers', udate='$waktu_sekarang' WHERE idInformasi='$_POST[id]'");
  		}else{
  			$query = mysqli_query($koneksi,"UPDATE informasi SET judulInformasi='$_POST[judulInformasi]', isiInformasi='$isiInformasi', tanggalInformasi='$waktu_sekarang', publikasiInformasi='$_POST[publikasiInformasi]', uby='$idUsers', udate='$waktu_sekarang' WHERE idInformasi='$_POST[id]'");
  		}

        if ($query){
        	$_SESSION['notif'] = 'usukses';
          	echo "<script>document.location='index.php?view=$_GET[view]';</script>";
        }else{
        	$_SESSION['notif'] = 'gagal';
          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
        }
    }
    $edit = mysqli_query($koneksi,"SELECT * FROM informasi where idInformasi='$_GET[id]'");
    $record = mysqli_fetch_array($edit);
   ?>
   	<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">

  		<div class="col-md-9">
      		<div class="box box-success">
        		<div class="box-body">
					<input type="hidden" name="id" value="<?php echo $record['idInformasi']; ?>" >
				
					<label>Judul Informasi <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<input name="judulInformasi" placeholder="Judul Informasi" type="text" class="form-control" value="<?= $record[judulInformasi]?>" required>
					<br>
					
					<label>Deskripsi Informasi <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<textarea name="isiInformasi" id="isiInformasi" class="form-control"><?= $record[isiInformasi]?></textarea>
					<br>
					
					<p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
					
					<label for="gambarInformasi">Unggah File Gambar</label>
					<a href="#" class="thumbnail">
						<img id="target" alt="Choose image to upload" src="<?= $lokasi_foto_informasi.$record[gambarInformasi] ?>">
					</a>
					<input type="file" id="foto" name="gambarInformasi">
			      	<br>


				  <div class="form-group">
					<label for="" class="col-sm-2 control-label"></label>
					<div class="col-sm-10">
						
					</div>
				  </div>	
        		</div>
      		</div>
    	</div>

    	<div class="col-md-3">
	      	<div class="box box-success">
	        	<div class="box-body">
					<label>Status Publikasi</label>
					<div class="radio">
						<label>
							<?php if ($record[publikasiInformasi] == 0){
								echo '<input type="radio" name="publikasiInformasi" value="0" checked=""> Draft';
							}else{
								echo '<input type="radio" name="publikasiInformasi" value="0" > Draft';
							}?>
						</label>
					</div>
					<div class="radio">
						<label>
							<?php if ($record[publikasiInformasi] == 1){
								echo '<input type="radio" name="publikasiInformasi" value="1" checked=""> Terbit';
							}else{
								echo '<input type="radio" name="publikasiInformasi" value="1"> Terbit';
							}?>
						</label>
					</div>
					<br>

					
					<input type="submit" name="update" value="Simpan" class="btn btn-block btn-success">
					<a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
	        	</div>
	      	</div>
	    </div>

    </form>
   
<?php }elseif($_GET[act]=='tambah'){
    if (isset($_POST[tambah])){
 
    	$isiInformasi = addslashes($_POST['isiInformasi']);
    	$lokasi_file = $_FILES['gambarInformasi']['tmp_name'];
  		$nama_file   = $_FILES['gambarInformasi']['name'];
  		
  		if (!empty($lokasi_file)){
  			UploadGambar($lokasi_foto_informasi,$lokasi_file,$nama_file);
  			$query = mysqli_query($koneksi,"INSERT INTO informasi(judulInformasi,isiInformasi,tanggalInformasi, publikasiInformasi,gambarInformasi,stdel,cby,cdate) VALUES('$_POST[judulInformasi]','$isiInformasi','$waktu_sekarang','$_POST[publikasiInformasi]','$nama_file','0','$idUsers','$waktu_sekarang')");
  		}else{
  			$query = mysqli_query($koneksi,"INSERT INTO informasi(judulInformasi,isiInformasi,tanggalInformasi, publikasiInformasi,stdel,cby,cdate) VALUES('$_POST[judulInformasi]','$isiInformasi','$waktu_sekarang','$_POST[publikasiInformasi]','0','$idUsers','$waktu_sekarang')");
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
	<form method="POST" action="" class="form-horizontal" enctype="multipart/form-data">

		<div class="col-md-9">
      		<div class="box box-success">
      			<div class="box-body">
        			<label>Judul Informasi <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<input name="judulInformasi" placeholder="Judul Informasi" type="text" class="form-control" value="" required>
					<br>
					<label>Deskripsi Informasi <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<textarea name="isiInformasi" id="isiInformasi" class="form-control"></textarea>
					<br>
					<p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
					
					<label for="gambarInformasi">Unggah File Gambar</label>
					<a href="#" class="thumbnail">
						<img id="target" alt="Choose image to upload">
					</a>
					<input type="file" id="foto" name="gambarInformasi">
			      	<br>
        		</div>
      		</div>
    	</div>

	    <div class="col-md-3">
	      	<div class="box box-success">
	        	<div class="box-body">
					<label>Status Publikasi</label>
					<div class="radio">
						<label>
							<input type="radio" name="publikasiInformasi" value="0" checked=""> Draft
						</label>
					</div>
					<div class="radio">
						<label>
							<input type="radio" name="publikasiInformasi" value="1"> Terbit
						</label>
					</div>
					<br>

				
					<button name="tambah" type="submit" value="Simpan" class="btn btn-block btn-success">Simpan</button>
					<a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
				
	        	</div>
	      	</div>
	    </div>

	</form>
<?php
}
?>

<script src="plugins/tinymce/tinymce.min.js"></script>
<script type='text/javascript'> 
tinymce.init({ 
	selector:'#isiInformasi',
});
</script>