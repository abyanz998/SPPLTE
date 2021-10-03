<?php if ($_GET[act]==''){ 
	$edit = mysqli_query($koneksi,"SELECT jenis_bayar.*, unit_sekolah.singkatanUnit, pos_bayar.nmPosBayar, tahun_ajaran.nmTahunAjaran FROM jenis_bayar LEFT JOIN unit_sekolah ON jenis_bayar.idUnit = unit_sekolah.idUnit LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE jenis_bayar.stdel='0' AND jenis_bayar.idJenisBayar='$_GET[id]' ORDER BY jenis_bayar.idJenisBayar DESC");
  	$record = mysqli_fetch_array($edit);
?> 


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
            <div class="col-xs-12"> 
			  <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Tarif - <?= $record['nmPosBayar'].' - T.A '.$record['nmTahunAjaran'] ?></h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<form action="index.php?view=<?= $_GET[view] ?>&id=<?= $_GET[id] ?>" class="form-horizontal" method="GET" accept-charset="utf-8">
			            <div class="form-group"> 
			              <input type="hidden" name="view" value="<?= $_GET[view]; ?>" >      
						  <input type="hidden" name="id" value="<?= $_GET[id]; ?>" >

			              <label for="" class="col-sm-1 control-label">Tahun</label>
			              <div class="col-sm-2">
			                <input type="text" class="form-control" value="<?= $record['nmTahunAjaran'] ?>" readonly="">
			              </div>
			              <label for="" class="col-sm-1 control-label">Kelas</label>
			              <div class="col-sm-2">
			                <select class="form-control" name="kelas">
			                  <?php
			                    if ($_GET['kelas'] == 'all'){
			                      echo '<option value="all" selected>- Semua Kelas  -</option>';
			                    }else{
			                      echo '<option value="all">- Semua Kelas  -</option>';
			                    }
			                    $query = mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idUnit='$record[idUnit]' AND stdel='0' ORDER BY idKelas ASC");
			                    while ($q = mysqli_fetch_array($query)) {
			                      if ($_GET['kelas'] == $q['idKelas']){
			                        echo '<option value="'.$q['idKelas'].'" selected>'.$q['nmKelas'].'</option>';
			                      }else{
			                        echo '<option value="'.$q['idKelas'].'">'.$q['nmKelas'].'</option>';
			                      }
			                    }
			                  ?>          
			                </select>
			              </div>
			              <div class="col-sm-2">
			                <button type="submit" name="cari" class="btn btn-success">Cari / Tampilkan</button>
			              </div>
			            </div>
			          </form>
					<hr>
					<label for="" class="col-sm-2">Setting Tarif</label>
					<div class="col-sm-10">
						<a class="btn btn-primary btn-sm" href="index.php?view=<?= $_GET[view]?>&act=tambah berdasarkan kelas&id=<?= $_GET[id]?>"><span class="glyphicon glyphicon-plus"></span> Berdasarkan Kelas</a>

			            <a class="btn btn-info btn-sm" href="index.php?view=<?= $_GET[view]?>&act=tambah berdasarkan siswa&id=<?= $_GET[id]?>"><span class="glyphicon glyphicon-plus"></span> Berdasarkan Siswa</a>
			            
			            <a class="btn btn-danger btn-sm" href="index.php?view=jenis bayar"><span class="glyphicon glyphicon-repeat"></span> Kembali</a>
					</div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
				<?php
					if(isset($_GET['cari'])){
						if ($_GET['kelas'] != 'all'){
							$sqlBebas= mysqli_query($koneksi, "SELECT
												tagihan_bebas.*,
												siswa.nisSiswa,
												siswa.nisnSiswa,
												siswa.nmSiswa,
												siswa.kamarSiswa,
												kelas_siswa.nmKelas,
												kamar.namaKamar
											FROM
												tagihan_bebas
											INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
											INNER JOIN kelas_siswa ON tagihan_bebas.idKelas = kelas_siswa.idKelas
											LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar
											WHERE tagihan_bebas.idJenisBayar='$_GET[id]'
												AND tagihan_bebas.idKelas='$_GET[kelas]' GROUP BY siswa.idSiswa");
						}else{
							$sqlBebas= mysqli_query($koneksi, "SELECT
												tagihan_bebas.*,
												siswa.nisSiswa,
												siswa.nisnSiswa,
												siswa.nmSiswa,
												siswa.kamarSiswa,
												kelas_siswa.nmKelas,
												kamar.namaKamar
											FROM
												tagihan_bebas
											INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
											INNER JOIN kelas_siswa ON tagihan_bebas.idKelas = kelas_siswa.idKelas
											LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar
											WHERE tagihan_bebas.idJenisBayar='$_GET[id]' GROUP BY siswa.idSiswa");
						}
						
					?>
					<div class="box box-success">
						<div class="box-body table-responsive">
						  	<div class="table-responsive">
								<table id="example1" class="table table-hover dataTable no-footer">
									<thead>
										<tr>
											<th>No</th>
							                <th>NIS</th>
							                <th>Nama</th>
							                <th>Kelas</th>
							                <th>Kamar</th>
							                <th>Tagihan</th>
							                <th>Aksi</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$no=1;
											while($rt=mysqli_fetch_array($sqlBebas)){
												if ($rt['kamarSiswa'] == 0){
													$nmKamar = 'Tidak Ada';
												}else{
													$nmKamar= $rt['namaKamar'];
												}
												echo "<tr>
													<td>$no</td>
													<td>$rt[nisSiswa]</td>
													<td>$rt[nmSiswa]</td>
													<td>$rt[nmKelas]</td>
													<td>$nmKamar</td>
													<td>".buatRp($rt['totalTagihan'])."</td>
													<td style='text-align:center'>
														<a href='index.php?view=$_GET[view]&act=edit&id=$_GET[id]&tagihan=$rt[idTagihanBebas]' class='btn btn-xs btn-warning' data-toggle='tooltip' title='' data-original-title='Ubah Tarif'><i class='fa fa-edit'></i></a>
														<a href='#delModal".$rt['idTagihanBebas']."' data-toggle='modal' class='btn btn-xs btn-danger'><i class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus Tarif'></i></a>
													</td>
												</tr>";
												$no++;

												echo ' <div class="modal fade" id="delModal'.$rt['idTagihanBebas'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
															<form action="?view='.$_GET['view'].'&id='.$_GET['id'].'&kelas='.$_GET['kelas'].'&cari&hapus" method="POST" role="form">
														        <div class="modal-dialog" role="document">
																	<div class="modal-content">
														                <div class="modal-header">
																		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
															                <h4 class="modal-title" id="myModalLabel"><span class="fa fa-exclamation-triangle"></span> Hapus Data</h4> 
																		</div>
															            <div class="modal-body">
															            	<input type="hidden" name="idTagihanBebas" value="'.$rt['idTagihanBebas'].'">
																			Apakah anda ingin menghapus Tagihan dengan NIS '.$rt[nisSiswa].' Nama '.$rt[nmSiswa].'?
																		</div>
																		<div class="modal-footer">
																			<button type="submit" name="hapus" class="btn btn-danger pull-right"><span class="fa fa-check"></span> Hapus</button>
																			<button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
															            </div>
																	</div>
															    </div>
															</form>
														</div>';
											}

											if(isset($_GET['hapus'])){ 
												mysqli_query($koneksi,"DELETE FROM tagihan_bebas WHERE idTagihanBebas='$_POST[idTagihanBebas]'");
												$_SESSION['notif'] = 'dsukses';
												echo "<script>document.location='?view=$_GET[view]&id=$_GET[id]&kelas=$_GET[kelas]&cari=';</script>";
											}
										?>
									</tbody>
								</table>
							</div><!-- /.box-body -->
						</div>
						<div class="box-footer">
							
						</div>
					  </div><!-- /.box -->
					<?php
						}
					?>


            </div>

<?php
}elseif ($_GET['act'] == 'tambah berdasarkan kelas'){

	$edit = mysqli_query($koneksi,"SELECT jenis_bayar.*, unit_sekolah.singkatanUnit, pos_bayar.nmPosBayar, tahun_ajaran.nmTahunAjaran FROM jenis_bayar LEFT JOIN unit_sekolah ON jenis_bayar.idUnit = unit_sekolah.idUnit LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE jenis_bayar.stdel='0' AND jenis_bayar.idJenisBayar='$_GET[id]' ORDER BY jenis_bayar.idJenisBayar DESC");
  	$record = mysqli_fetch_array($edit);

  	if (isset($_POST['simpan_tagihan_perkelas'])){
  		$query_siswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE kelasSiswa='$_POST[id_kelas]' AND stdel='0' AND statusSiswa='Aktif'");
  		while ($siswa = mysqli_fetch_array($query_siswa)) {
  			$cek_tagihan_siswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tagihan_bebas WHERE idJenisBayar='$_POST[id_jenisbayar]' AND idSiswa='$siswa[idSiswa]' AND statusBayar='0' AND idKelas='$_POST[id_kelas]'"));
  			if ($cek_tagihan_siswa == 0){
  				$query = mysqli_query($koneksi, "INSERT INTO tagihan_bebas(idJenisBayar,idSiswa,idKelas,totalTagihan,statusBayar,TglTagihan) VALUES ('$_POST[id_jenisbayar]','$siswa[idSiswa]','$_POST[id_kelas]','$_POST[tagihan_bebas]','0','$waktu_sekarang')");
  			}else{
  				$query = mysqli_query($koneksi, "UPDATE tagihan_bebas SET totalTagihan='$_POST[tagihan_bebas]', tglUpdate='$waktu_sekarang' WHERE idJenisBayar='$_POST[id_jenisbayar]' AND idSiswa='$siswa[idSiswa]' AND idKelas='$_POST[id_kelas]'");
  			}
  		}

  		if ($query){
      		$_SESSION['notif'] = 'csukses';
	      	echo "<script>document.location='index.php?view=$_GET[view]&id=$_GET[id]';</script>";
	    }else{
	      	$_SESSION['notif'] = 'gagal';
	      	echo "<script>document.location='index.php?view=$_GET[view]&id=$_GET[id]';</script>";
	    }
  	}

?>
	
			<div class="box-body">
				<form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act] ?>&id=<?= $_GET[id] ?>" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				
					<div class="col-md-6">
						<div class="box box-danger">
							<div class="box-header">
								<h3 class="box-title">Informasi Pembayaran</h3>
							</div>
							<div class="box-body">
								<div class="form-group">
									<label for="" class="col-sm-4 control-label">Jenis Bayar</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?= $record['nmPosBayar'].' - T.A '.$record['nmTahunAjaran'] ?>" readonly="">
									</div>
								</div>
								<div class="form-group">						
									<label for="" class="col-sm-4 control-label">Tahun Ajaran</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?= $record['nmTahunAjaran'] ?>" readonly="">
									</div>
								</div>
								<div class="form-group">						
									<label for="" class="col-sm-4 control-label">Tipe Bayar</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?= $record['tipeBayar'] ?>" readonly="">
									</div>
								</div>						  

							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="box box-success">
							<div class="box-header">
								<h3 class="box-title">Tarif Tagihan Per Kelas</h3>
							</div>
							<div class="box-body table-responsive">

								<table class="table">
									<tbody>
										<tr>
											<td><strong>Kelas</strong></td>
											<td>
												<select name="id_kelas" class="form-control">
													<option disabled selected >- Pilih Kelas -</option>
													<?php
									                    $query = mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idUnit='$record[idUnit]' AND stdel='0' ORDER BY idKelas ASC");
									                    while ($q = mysqli_fetch_array($query)) {
									                      if ($_POST['kelas'] == $q['idKelas']){
									                        echo '<option value="'.$q['idKelas'].'" selected>'.$q['nmKelas'].'</option>';
									                      }else{
									                        echo '<option value="'.$q['idKelas'].'">'.$q['nmKelas'].'</option>';
									                      }
									                    }
									                ?>          
												</select>
											</td>
										</tr>
										<tr>
											<td><strong>Tarif (Rp.)</strong></td>
											<td>
												<input type="hidden" name="id_jenisbayar" class="form-control" value="<?= $_GET[id]?>">
												<input autofocus="" type="text" required="" name="tagihan_bebas" placeholder="Masukan Tarif" class="form-control">
											</td>
										</tr>


									</tbody>
								</table>
							</div>
							<div class="box-footer">
								<button type="submit" name="simpan_tagihan_perkelas" class="btn btn-success">Simpan</button>
								<a href="index.php?view=<?= $_GET[view] ?>&id=<?= $_GET[id] ?>" class="btn btn-danger">Batal</a>
							</div>
						</div>
					</div>		

				</form>			
			</div>

<?php
}elseif ($_GET['act'] == 'tambah berdasarkan siswa'){ 
	$edit = mysqli_query($koneksi,"SELECT jenis_bayar.*, unit_sekolah.singkatanUnit, pos_bayar.nmPosBayar, tahun_ajaran.nmTahunAjaran FROM jenis_bayar LEFT JOIN unit_sekolah ON jenis_bayar.idUnit = unit_sekolah.idUnit LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE jenis_bayar.stdel='0' AND jenis_bayar.idJenisBayar='$_GET[id]' ORDER BY jenis_bayar.idJenisBayar DESC");
  	$record = mysqli_fetch_array($edit);

  	if (isset($_POST['simpan_tagihan_persiswa'])){

  		$cek_tagihan_siswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tagihan_bebas WHERE idJenisBayar='$_POST[id_jenisbayar]' AND idSiswa='$_POST[id_siswa]' AND statusBayar='0' AND idKelas='$_POST[id_kelas]'"));
  		if ($cek_tagihan_siswa == 0){
  			$query = mysqli_query($koneksi, "INSERT INTO tagihan_bebas(idJenisBayar,idSiswa,idKelas,totalTagihan,statusBayar,TglTagihan) VALUES ('$_POST[id_jenisbayar]','$_POST[id_siswa]','$_POST[id_kelas]','$_POST[tagihan_bebas]','0','$waktu_sekarang')");
  		}else{
 			$query = mysqli_query($koneksi, "UPDATE tagihan_bebas SET totalTagihan='$_POST[tagihan_bebas]', tglUpdate='$waktu_sekarang' WHERE idJenisBayar='$_POST[id_jenisbayar]' AND idSiswa='$_POST[id_siswa]' AND idKelas='$_POST[id_kelas]'");
  		}

  		if ($query){
      		$_SESSION['notif'] = 'csukses';
	      	echo "<script>document.location='index.php?view=$_GET[view]&id=$_GET[id]';</script>";
	    }else{
	      	$_SESSION['notif'] = 'gagal';
	      	echo "<script>document.location='index.php?view=$_GET[view]&id=$_GET[id]';</script>";
	    }
  	}

?>
		<div class="box-body">
			<form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act] ?>&id=<?= $_GET[id] ?>" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					
				<div class="col-md-6">
					<div class="box box-danger">
						<div class="box-header">
							<h3 class="box-title">Informasi Pembayaran</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Jenis Bayar</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?= $record['nmPosBayar'].' - T.A '.$record['nmTahunAjaran'] ?>" readonly="">
								</div>
							</div>
							<div class="form-group">						
								<label for="" class="col-sm-4 control-label">Tahun Ajaran</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?= $record['nmTahunAjaran'] ?>" readonly="">
								</div>
							</div>
							<div class="form-group">						
								<label for="" class="col-sm-4 control-label">Tipe Bayar</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?= $record['tipeBayar'] ?>" readonly="">
								</div>
							</div>	
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="box box-success">
						<div class="box-header">
							<h3 class="box-title">Tarif Tagihan Per Siswa</h3>
						</div>
						<div class="box-body table-responsive">
							<table class="table">
								<tbody>
									<tr>
										<td><strong>Kelas</strong></td>
										<td>
											<select name="id_kelas" id="kelas" class="form-control">
												<option disabled selected >- Pilih Kelas -</option>
												<?php
									                $query = mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idUnit='$record[idUnit]' AND stdel='0' ORDER BY idKelas ASC");
									                while ($q = mysqli_fetch_array($query)) {
									                    if ($_POST['kelas'] == $q['idKelas']){
									                    	echo '<option value="'.$q['idKelas'].'" selected>'.$q['nmKelas'].'</option>';
									                    }else{
									                        echo '<option value="'.$q['idKelas'].'">'.$q['nmKelas'].'</option>';
									                    }
									                }
									            ?>          
											</select>
											</td>
										</tr>
										<tr>
											<td><strong>Nama Siswa</strong></td>
											<td> 
												<select name="id_siswa" class="form-control" id="Csiswa">
													<option disabled="" selected="">- Pilih Siswa -</option>
												</select>
											</td>
										</tr>
										<tr>
											<td><strong>Tarif (Rp.)</strong></td>
											<input type="hidden" name="id_jenisbayar" class="form-control" value="<?= $_GET[id]?>">
											<td><input autofocus="" type="text" name="tagihan_bebas" placeholder="Masukan Tarif" required="" class="form-control">
											</td>
										</tr>


									</tbody>
								</table>
							</div>
							<div class="box-footer">
								<button type="submit" name="simpan_tagihan_persiswa" class="btn btn-success">Simpan</button>
								<a href="index.php?view=<?= $_GET[view] ?>&id=<?= $_GET[id] ?>" class="btn btn-danger">Batal</a>
							</div>
						</div>
					</div>					
					</form>				
				</div>


<?php } elseif ($_GET['act'] == 'edit'){ 
	
	$edit = mysqli_query($koneksi,"SELECT jenis_bayar.*, unit_sekolah.singkatanUnit, pos_bayar.nmPosBayar, tahun_ajaran.nmTahunAjaran FROM jenis_bayar LEFT JOIN unit_sekolah ON jenis_bayar.idUnit = unit_sekolah.idUnit LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE jenis_bayar.stdel='0' AND jenis_bayar.idJenisBayar='$_GET[id]' ORDER BY jenis_bayar.idJenisBayar DESC");
	$record = mysqli_fetch_array($edit);

	$tagihan_bebas = mysqli_query($koneksi,"SELECT tagihan_bebas.*, siswa.idSiswa, siswa.nmSiswa, kelas_siswa.idKelas, kelas_siswa.nmKelas  FROM tagihan_bebas LEFT JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa LEFT JOIN kelas_siswa ON tagihan_bebas.idKelas = kelas_siswa.idKelas WHERE tagihan_bebas.idTagihanBebas='$_GET[tagihan]'");
  	$TagBebas = mysqli_fetch_array($tagihan_bebas);


  	if (isset($_POST['update_tagihan_persiswa'])){

 		$query = mysqli_query($koneksi, "UPDATE tagihan_bebas SET totalTagihan='$_POST[tagihan_bebas]', tglUpdate='$waktu_sekarang' WHERE idTagihanBebas='$_POST[id_tagihan_bebas]'");
  		

  		if ($query){
      		$_SESSION['notif'] = 'usukses';
	      	echo "<script>document.location='index.php?view=$_GET[view]&id=$_GET[id]';</script>";
	    }else{
	      	$_SESSION['notif'] = 'gagal';
	      	echo "<script>document.location='index.php?view=$_GET[view]&id=$_GET[id]';</script>";
	    }
  	}

?>
		<div class="box-body">
			<form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act] ?>&id=<?= $_GET[id] ?>" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
					
				<div class="col-md-6">
					<div class="box box-danger">
						<div class="box-header">
							<h3 class="box-title">Informasi Pembayaran</h3>
						</div>
						<div class="box-body">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Jenis Bayar</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?= $record['nmPosBayar'].' - T.A '.$record['nmTahunAjaran'] ?>" readonly="">
								</div>
							</div>
							<div class="form-group">						
								<label for="" class="col-sm-4 control-label">Tahun Ajaran</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?= $record['nmTahunAjaran'] ?>" readonly="">
								</div>
							</div>
							<div class="form-group">						
								<label for="" class="col-sm-4 control-label">Tipe Bayar</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" value="<?= $record['tipeBayar'] ?>" readonly="">
								</div>
							</div>	
						</div>
					</div>
				</div>
				
				<input type="hidden" name="id_tagihan_bebas" value="<?= $TagBebas[idTagihanBebas] ?>" readonly class="form-control"></td>

				<div class="col-md-6">
					<div class="box box-success">
						<div class="box-header">
							<h3 class="box-title">Tarif Tagihan Per Siswa</h3>
						</div>
						<div class="box-body table-responsive">
							<table class="table">
								<tbody>
									<tr>
										<td><strong>Nama Siswa</strong></td>
										<td><input type="text" value="<?= $TagBebas[nmSiswa] ?>" readonly class="form-control"></td>
									</tr>
									<tr>
										<td><strong>Kelas</strong></td>
										<td><input type="text" value="<?= $TagBebas[nmKelas] ?>" readonly class="form-control"></td>
									</tr>
									<tr>
										<td><strong>Tarif (Rp.)</strong></td>
										<td><input autofocus="" type="text" name="tagihan_bebas" placeholder="Masukan Tarif" required="" class="form-control" value="<?= $TagBebas[totalTagihan] ?>">
										</td>
									</tr>


									</tbody>
								</table>
							</div>
							<div class="box-footer">
								<button type="submit" name="update_tagihan_persiswa" class="btn btn-success">Update Tarif</button>
								<a href="index.php?view=<?= $_GET[view] ?>&id=<?= $_GET[id] ?>" class="btn btn-danger">Batal</a>
							</div>
						</div>
					</div>					
					</form>				
				</div>


<?php
	
}
?>
<script type="text/javascript">
	 //combo bertingkat siswa dan kelas
      $("#kelas").change(function(){
        var idSiswa = $("#idSiswa").val();
        var idKelas = $("#kelas").val();
        $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_siswa.php",
                  data: {idSiswa: idSiswa, idKelas: idKelas},
                  cache: false,
                  success: function(msg){
                    $("#Csiswa").html(msg);
                  }
            });
      });
</script>