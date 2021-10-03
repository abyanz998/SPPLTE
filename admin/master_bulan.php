<?php if ($_GET[act]==''){ ?> 
    <div class="col-xs-12">  
        <div class="box box-success">
            <div class="box-body">
               	<?php 
                  	if ($_SESSION['notif'] == 'sukses'){
                      echo '<script>toastr["success"]("Data berhasil diupdate.","Sukses!")</script>';
                  	}elseif($_SESSION['notif'] == 'gagal'){
                    	echo '<script>toastr["error"]("Data gagal diupdate.","Gagal!")</script>';
                  	}
                    unset($_SESSION['notif']);
                ?>
                <table id="example6" class="table table-hover dataTable no-footer">
        					<thead>
        					  	<tr>
        						  	<th>No</th>
        						  	<th>Nama Bulan</th>
        						  	<th>Aksi</th>
        					  	</tr>
        				  	</thead>
        				  	<tbody>
                  	<?php 
                    	$tampil = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
                    	$no = 1;
                    	while($r=mysqli_fetch_array($tampil)){
                        echo "<tr><td>$no</td>
                              	<td>$r[nmBulan]</td>
                              	<td><center>
                                	<a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idBulan]'><span class='fa fa-edit'></span></a>
                              	</center></td>";
                        echo "</tr>";
							          $no++;
                      }
                  	?>
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>

<?php }elseif($_GET[act]=='edit'){
    if (isset($_POST[update])){
    	
    	$query = mysqli_query($koneksi,"UPDATE bulan SET nmBulan='$_POST[nmBulan]', uby='$idUsers', udate='$waktu_sekarang' WHERE idBulan = '$_POST[id]'");
 
        if ($query){
          $_SESSION['notif'] = 'sukses';
          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
        }else{
          $_SESSION['notif'] = 'gagal';
          echo "<script>document.location='index.php?view=$_GET[view]&gagal';</script>";
        }
    }
    $edit = mysqli_query($koneksi,"SELECT * FROM bulan where idBulan='$_GET[id]'");
    $record = mysqli_fetch_array($edit);
?>
   	<form method="post" action="" class="form-horizontal">
	   	<div class="col-md-9">
	      <div class="box box-success">
	        <div class="box-body">
				<input type="hidden" name="id" value="<?php echo $record['idBulan']; ?>" >
				<label>Nama Bulan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
				<input type="text" name="nmBulan"  maxlength="9" class="form-control" value="<?php echo $record['nmBulan']; ?>" required>
				<br>
				<p class="text-muted">*) Kolom wajib diisi.</p>
	        </div>
	      </div>
	    </div>

	    <div class="col-md-3">
	      <div class="box box-success">
	        <div class="box-body">
				<input type="submit" name="update" value="Simpan" class="btn btn-block btn-success">
				<a href="index.php?view=<?= $_GET[view] ?>" class="btn btn-block btn-danger">Batal</a>			
	        </div>
	      </div>
	    </div>
   	</form>
<?php } ?>