<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success">
              	<div class="box-header">
              		<a class='pull-left btn btn-success btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=tambah'>Tambah</a>
              		<br><br>
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
	                }elseif($_SESSION['notif'] == 'gagalhapus'){
	                    echo '<script>toastr["error"]("Data gagal dihapus.","Gagal!")</script>';
	                }
                    unset($_SESSION['notif']);
                ?>
							
                  <table id="example1" class="table table-hover dataTable no-footer">
					<thead>
					  <tr>
						  <th>No</th>
						  <th>Kode Akun</th>
						  <th>Akun Piutang</th>
						  <th>Nama Pos</th>
						  <th>Keterangan</th>
						  <th>Aksi</th>
					  </tr>
				  </thead>
				  <tbody>
                  <?php 
                 	if (isset($_GET['unit'])){
                        if ($_GET['unit'] != 'all'){
                          $tampil = mysqli_query($koneksi,"SELECT pos_bayar.*, pos_bayar.kodeAkun as kodeAkunPos, akun_biaya.* FROM pos_bayar LEFT JOIN akun_biaya ON pos_bayar.kodeAkun = akun_biaya.idAkun WHERE pos_bayar.stdel='0' AND akun_biaya.unitSekolah='$_GET[unit]' ORDER BY pos_bayar.idPosBayar DESC");
                        }else{
                          $tampil = mysqli_query($koneksi,"SELECT pos_bayar.*, pos_bayar.kodeAkun as kodeAkunPos, akun_biaya.* FROM pos_bayar LEFT JOIN akun_biaya ON pos_bayar.kodeAkun = akun_biaya.idAkun WHERE pos_bayar.stdel='0' ORDER BY pos_bayar.idPosBayar DESC");
                        }
                    }elseif($_SESSION['unit'] != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT pos_bayar.*,pos_bayar.kodeAkun as kodeAkunPos,akun_biaya.* FROM pos_bayar LEFT JOIN akun_biaya ON pos_bayar.kodeAkun = akun_biaya.idAkun WHERE pos_bayar.stdel='0' AND akun_biaya.unitSekolah='$_SESSION[unit]' ORDER BY pos_bayar.idPosBayar DESC");
                    }else{
                        $tampil = mysqli_query($koneksi,"SELECT pos_bayar.*, pos_bayar.kodeAkun as kodeAkunPos, akun_biaya.* FROM pos_bayar LEFT JOIN akun_biaya ON pos_bayar.kodeAkun = akun_biaya.idAkun WHERE pos_bayar.stdel='0' ORDER BY pos_bayar.idPosBayar DESC");
                    }

                    
                    $no = 1;
                    while($r=mysqli_fetch_array($tampil)){
                    	$kodeAkun = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE akun_biaya.idAkun='$r[kodeAkunPos]'"));
                    	$akunPiutang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE akun_biaya.idAkun='$r[akunPiutang]'"));

						echo "<tr>
								<td>".$no++."</td>
	                            <td>".$kodeAkun['kodeAkun']." - ".$kodeAkun['keterangan']."</td>
	                            <td>".$akunPiutang['kodeAkun']." - ".$akunPiutang['keterangan']."</td>
	                            <td>".$r['nmPosBayar']."</td>
	                            <td>".$r['ketPosBayar']."</td>
	                            <td><center>
	                                <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idPosBayar]'><span class='fa fa-edit'></span></a></center>
	                            </td>
	                         </tr>";
                      }
                
                  ?>
                    </tbody>

                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>

<?php }elseif($_GET[act]=='edit'){
    if (isset($_POST[update])){
  	
  		$query = mysqli_query($koneksi,"UPDATE pos_bayar SET kodeAkun='$_POST[kode_akun]', akunPiutang='$_POST[akun_piutang]', nmPosBayar='$_POST[nama_pos]', ketPosBayar='$_POST[keterangan_pos]', uby='$idUsers', udate='$waktu_sekarang' WHERE idPosBayar='$_POST[id]'");
  		
        if ($query){
        	$_SESSION['notif'] = 'usukses';
          	echo "<script>document.location='index.php?view=$_GET[view]';</script>";
        }else{
        	$_SESSION['notif'] = 'gagal';
          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
        }
    }
    if (isset($_GET[hapus])){
    	$cek_data = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM jenis_bayar WHERE idPosBayar='$_GET[id]'"));
    	if ($cek_data == 0){
    		$query = mysqli_query($koneksi,"UPDATE pos_bayar SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' where idPosBayar='$_GET[id]'");
        	if ($query){
        		$_SESSION['notif'] = 'dsukses';
        		echo "<script>document.location='index.php?view=$_GET[view]';</script>";
        	}else{
        		$_SESSION['notif'] = 'gagal';
        		echo "<script>document.location='index.php?view=$_GET[view]';</script>";
        	}
    	}else{
    		$_SESSION['notif'] = 'gagalhapus';
        	echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    	}
    }

    $edit = mysqli_query($koneksi,"SELECT * FROM pos_bayar where idPosBayar='$_GET[id]'");
    $record = mysqli_fetch_array($edit);
   ?>
   	<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">

  		<div class="col-md-9">
      		<div class="box box-success">
      			<div class="box-body">
      				<input name="id" type="hidden" value="<?= $record['idPosBayar'] ?>">
					<label>Kode Akun <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<input type="hidden" id="idAkunPendapatan" value="<?= $record['kodeAkun'] ?>">
					<select required="" name="kode_akun" id="Cakunpendapatan" class="form-control"></select>
					<br>
					<label>Akun Piutang <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<input type="hidden" id="idAkunPiutang" value="<?= $record['akunPiutang'] ?>">
					<select required="" name="akun_piutang" class="form-control" id="Cakunpiutang"></select>		
					<br>
					<label>Nama POS <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<input name="nama_pos" type="text" class="form-control" placeholder="Contoh : Pos Bayar" value="<?= $record['nmPosBayar'] ?>">
					<br>
					<label>Keterangan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<input name="keterangan_pos" type="text" class="form-control" placeholder="Keterangan Pos Bayar" value="<?= $record['ketPosBayar'] ?>">
					<br>
					<p class="text-muted">*) Kolom wajib diisi.</p>
				</div>
      		</div>
    	</div>

    	<div class="col-md-3">
	      	<div class="box box-success">
	        	<div class="box-body">
					<input type="submit" name="update" value="Simpan" class="btn btn-block btn-success">
					<a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-default">Batal</a>
					<a href="#delModal<?= $record['idPosBayar'] ?>" data-toggle="modal" class="btn btn-block btn-danger">Hapus</a>
	        	</div>
	      	</div>
	    </div>

    </form>

    
    <div class="modal fade" id="delModal<?= $record['idPosBayar'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<form action="index.php?view=<?= $_GET[view] ?>&act=edit&hapus&id=<?= $record[idPosBayar] ?>" method="POST" role="form">
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
	</div>

   
<?php }elseif($_GET[act]=='tambah'){
    if (isset($_POST[tambah])){
  		$query = mysqli_query($koneksi,"INSERT INTO pos_bayar(kodeAkun,akunPiutang,nmPosBayar,ketPosBayar,stdel,cby,cdate) VALUES ('$_POST[kode_akun]','$_POST[akun_piutang]','$_POST[nama_pos]','$_POST[keterangan_pos]','0','$idUsers','$waktu_sekarang')");
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
					<label>Kode Akun <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<input type="hidden" id="idAkunPendapatan" value="<?= $_POST['kode_akun'] ?>">
					<select required="" name="kode_akun" id="Cakunpendapatan" class="form-control"></select>
					<br>
					<label>Akun Piutang <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<input type="hidden" id="idAkunPiutang" value="<?= $_POST['akun_piutang'] ?>">
					<select required="" name="akun_piutang" class="form-control" id="Cakunpiutang"></select>		
					<br>
					<label>Nama POS <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<input name="nama_pos" type="text" class="form-control" placeholder="Contoh : SPP" required="" >
					<br>
					<label>Keterangan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
					<input name="keterangan_pos" type="text" class="form-control" placeholder="Contoh : Sumbangan Pendidikan" required="" >
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