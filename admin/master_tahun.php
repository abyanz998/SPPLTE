<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success">
                <div class="box-header">
                  <a class='pull-left btn btn-success btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=tambah'>Tambah</a>
                </div><!-- /.box-header -->
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
	                }elseif($_SESSION['notif'] == 'aktifsukses'){
	                    echo '<script>toastr["success"]("Tahun Ajaran berhasil diaktifkan.","Sukses!")</script>';
	                }elseif($_SESSION['notif'] == 'aktifgagal'){
	                    echo '<script>toastr["error"]("Tahun Ajaran gagal diaktifkan","Gagal!")</script>';
	                }
                    unset($_SESSION['notif']);
                ?>
                  <table id="example1" class="table table-hover dataTable no-footer">
					<thead>
					  <tr>
						  <th>No</th>
						  <th>Tahun Ajaran</th>
						  <th>Aktif</th>
						  <th>Aksi</th>
					  </tr>
				  </thead>
				  <tbody>
                  <?php 
                    $tampil = mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE stdel='0' ORDER BY idTahunAjaran DESC");
                    $no = 1;
                    while($r=mysqli_fetch_array($tampil)){
						if($r['status']=='Aktif'){
							$statusTahun = '<label class="label label-success">Aktif</label>';
						}else{
							$statusTahun = '<label class="label label-danger">Tidak Aktif</label>';
						}
						echo "<tr><td>$no</td>
                              <td>$r[nmTahunAjaran]</td>
                              <td>$statusTahun</td>
                              <td><center>";
                              	if ($r['status'] !='Aktif'){
                              		echo " <a class='btn btn-success btn-xs' data-toggle='tooltip' title='' data-original-title='Aktifkan' href='?view=$_GET[view]&act=aktif&id=$r[idTahunAjaran]'><span class='fa fa-check'></span></a>";
                              	}
								echo " <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idTahunAjaran]'><span class='fa fa-edit'></span></a>
                                <a class='btn btn-danger btn-xs' href='#' data-toggle='modal' data-target='#hapus".$r[idTahunAjaran]."'><span class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus'></span></a>
                              </center></td></tr>";
                        
                        echo '<div class="modal fade" id="hapus'.$r[idTahunAjaran].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<form action="?view='.$_GET[view].'&hapus&id='.$r[idTahunAjaran].'" method="POST" role="form">
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
                          mysqli_query($koneksi, "UPDATE tahun_ajaran SET stdel='1', dby='$_SESSION[idUsers]', ddate='$waktu_sekarang' where idTahunAjaran='$_GET[id]'");
                          $_SESSION['notif'] = 'dsukses';
                          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                      }
                  	?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
<?php
}elseif($_GET[act]=='aktif'){
	$query = mysqli_query($koneksi, "UPDATE tahun_ajaran SET status='Aktif' where idTahunAjaran = '$_GET[id]'");
			 mysqli_query($koneksi, "UPDATE tahun_ajaran SET status='Tidak Aktif' where idTahunAjaran != '$_GET[id]'");
	if ($query){
       	$_SESSION['notif'] = 'aktifsukses';
      	echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
       	$_SESSION['notif'] = 'aktifgagal';
       	echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
}elseif($_GET[act]=='edit'){
    if (isset($_POST[update])){

    	$query = mysqli_query($koneksi, "UPDATE tahun_ajaran SET nmTahunAjaran='$_POST[periode_mulai]/$_POST[periode_selesai]', status='$_POST[status]', uby='$_SESSION[idUsers]', udate='$waktu_sekarang' WHERE idTahunAjaran = '$_POST[id]'");
    	if ($_POST['status'] == 'Aktif'){
    		mysqli_query($koneksi, "UPDATE tahun_ajaran SET status='Tidak Aktif' where idTahunAjaran != '$_POST[id]'");
    	}
        
	    if ($query){
	      $_SESSION['notif'] = 'usukses';
	      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
	    }else{
	      $_SESSION['notif'] = 'gagal';
	      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
	    }
    }
    $edit = mysqli_query($koneksi, "SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[id]'");
    $record = mysqli_fetch_array($edit);
    $tahun_ajaran=explode("/",$record['nmTahunAjaran']);
   ?>
   <form method="POST" action="" class="form-horizontal">
		<div class="col-md-9">
      		<div class="box box-success">
      			<div class="box-body">
      				<input type="hidden" name="id" value="<?php echo $record['idTahunAjaran']; ?>" >
					<label>Tahun Ajaran <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<input type="text" name="periode_mulai" readonly="" required="" class="form-control years" onchange="getYear(this.value)" placeholder="Tahun Awal" value="<?= $tahun_ajaran[0] ?>">
						</div>
						<div class="col-sm-6 col-md-6">
							<input type="text" class="form-control" readonly="" name="periode_selesai" id="TahunSelesai" placeholder="Tahun Akhir" value="<?= $tahun_ajaran[1] ?>">
						</div>
					</div>
					<br>
					<label>Keterangan</label>
					<div class="radio">
						<label>
							<?php
								if ($record['status'] == 'Aktif'){
									echo '<input type="radio" name="status" value="Aktif" checked> Aktif';
								}else{
									echo '<input type="radio" name="status" value="Aktif"> Aktif';
								}
							?>
						</label> &nbsp;&nbsp;&nbsp;&nbsp;
						<label>
							<?php
								if ($record['status'] == 'Tidak Aktif'){
									echo '<input type="radio" name="status" value="Tidak Aktif" checked> Tidak Aktif';
								}else{
									echo '<input type="radio" name="status" value="Tidak Aktif"> Tidak Aktif';
								}
							?>
						</label>
					</div>
					<br>
					<p class="text-muted">*) Kolom wajib diisi.</p>
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
      	$query = mysqli_query($koneksi, "INSERT INTO tahun_ajaran(nmTahunAjaran,status,stdel,cby,cdate) VALUES('$_POST[periode_mulai]/$_POST[periode_selesai]','$_POST[status]','0','$_SESSION[idUsers]','$waktu_sekarang')");
      	$ambil_idTerakhir=mysqli_insert_id($koneksi);
	   	if ($_POST['status'] == 'Aktif'){
    		mysqli_query($koneksi, "UPDATE tahun_ajaran SET status='Tidak Aktif' where idTahunAjaran != '$ambil_idTerakhir'");
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
					<label>Tahun Ajaran <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<div class="row">
						<div class="col-sm-6 col-md-6">
							<input type="text" name="periode_mulai" readonly="" required="" class="form-control years" onchange="getYear(this.value)" placeholder="Tahun Awal">
						</div>
						<div class="col-sm-6 col-md-6">
							<input type="text" class="form-control" readonly="" name="periode_selesai" id="TahunSelesai" placeholder="Tahun Akhir">
						</div>
					</div>
					<br>
					<label>Keterangan</label>
					<div class="radio">
						<label>
							<input type="radio" name="status" value="Aktif"> Aktif
						</label> &nbsp;&nbsp;&nbsp;&nbsp;
						<label>
							<input type="radio" name="status" value="Tidak Aktif" checked=""> Tidak Aktif
						</label>
					</div>
					<br>
					<p class="text-muted">*) Kolom wajib diisi.</p>
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
<?php
}
?>

	<script>
		function getYear(value) {
			var tahunSelesai = parseInt(value) + 1;
			$("#TahunSelesai").val(tahunSelesai);
		}
	</script>