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
							  <div class="table-responsive">
                  <table id="example1" class="table table-hover dataTable no-footer">
          					<thead>
          					  <tr>
          						  <th>No</th>
          						  <th>Nama Kamar</th>
          						  <th>ID Kamar</th>
          						  <th>Aksi</th>
          					  </tr>
          				  </thead>
          				  <tbody>
                  <?php 
                    $tampil = mysqli_query($koneksi,"SELECT * FROM kamar WHERE stdel='0' ORDER BY idKamar ASC");
                    $no = 1;
                    while($r=mysqli_fetch_array($tampil)){
                
						echo "<tr><td>$no</td>
                              <td>$r[namaKamar]</td>
                              <td>$r[idKamar]</td>
                              <td><center>
                                <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idKamar]'><span class='fa fa-edit'></span></a>
                                <a class='btn btn-danger btn-xs' href='#' data-toggle='modal' data-target='#hapus".$r[idKamar]."'><span class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus'></span></a>

                              </center></td>";
                            echo "</tr>";


                	        echo '<div class="modal fade" id="hapus'.$r[idKamar].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<form action="?view='.$_GET[view].'&hapus&id='.$r[idKamar].'" method="POST" role="form">
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
                          mysqli_query($koneksi,"UPDATE kamar SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' where idKamar='$_GET[id]'");
                          $_SESSION['notif'] = 'dsukses';
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
	    $query = mysqli_query($koneksi,"UPDATE kamar SET namaKamar='$_POST[namaKamar]', uby='$idUsers', udate='$waktu_sekarang' WHERE idKamar = '$_POST[id]'");
	    
	    if ($query){
	      $_SESSION['notif'] = 'usukses';
	      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
	    }else{
	      $_SESSION['notif'] = 'gagal';
	      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
	    }
  	}
  	$edit = mysqli_query($koneksi,"SELECT * FROM kamar WHERE idKamar='$_GET[id]'");
  	$record = mysqli_fetch_array($edit);
?>
   	<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">

  		<div class="col-md-9">
      		<div class="box box-success">
        		<div class="box-body">
					<input type="hidden" name="id" value="<?php echo $record['idKamar']; ?>" >
					<label>Nama Kamar <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
			        <input type="text" required="" name="namaKamar" class="form-control" placeholder="Nama Kamar" value="<?= $record['namaKamar']?>">
					<br>
        		</div>
      		</div>
    	</div>

    	<div class="col-md-3">
	      	<div class="box box-success">
	        	<div class="box-body">
					<input type="submit" name="update" value="Simpan" class="btn btn-block btn-success">
					<a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
	        	</div>
	      	</div>
	    </div>

    </form>
   
<?php }elseif($_GET[act]=='tambah'){
    if (isset($_POST[tambah])){

    	$nmKamar = $_POST['namaKamar'];
	    for ($i=0; $i < count($nmKamar) ; $i++) { 
	    	$query = mysqli_query($koneksi,"INSERT INTO kamar(namaKamar,stdel,cby,cdate) VALUES('$nmKamar[$i]','0','$idUsers','$waktu_sekarang')");
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
        			<div id="detail_kamar">
			            <p>
			              <label>Nama Kamar</label>
			              <input type="text" required="" name="namaKamar[]" class="form-control" placeholder="Nama Kamar">
			            </p>
			        </div>
			        <br>
          			<a href="#" class="btn btn-xs btn-success" id="add_nama_kamar"><i class="fa fa-plus"></i><b> Tambah Baris</b></a>
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

	<!-- TAMBAH INPUTAN KAMAR -->
  <script>
    $(function() {
      var scntDiv = $('#detail_kamar');
      var i = $('#detail_kamar p').size() + 1;

      $("#add_nama_kamar").click(function() {
        $('<p><label>Nama Kamar</label><input required type="text" name="namaKamar[]" class="form-control" placeholder="Nama Kamar"><a href="#" class="btn btn-xs btn-danger remove_nama_kamar">Hapus Baris</a></p>').appendTo(scntDiv);
        i++;
        return false;
      });

      $(document).on("click", ".remove_nama_kamar", function() {
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
