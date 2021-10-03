	<?php
		if ($_SESSION['notif'] == 'sukseslulus'){
		  echo '<script>toastr["success"]("Data Siswa lulus berhasil diproses.","Sukses!")</script>';
		}elseif($_SESSION['notif'] == 'gagallulus'){
		  echo '<script>toastr["error"]("Data Siswa lulus gagal diproses.","Gagal!")</script>';
		}elseif($_SESSION['notif'] == 'suksesbatal'){
		  echo '<script>toastr["success"]("Data Siswa lulus berhasil dibatalkan.","Sukses!")</script>';
		}elseif($_SESSION['notif'] == 'gagalbatal'){
		  echo '<script>toastr["error"]("Data Siswa lulus gagal dibatalkan.","Gagal!")</script>';
		}unset($_SESSION['notif']);
	?>

	<?php
		if(isset($_GET['proseslulus'])){
			$siswa = $_POST['pilih'];
			for($x = 0; $x < count($siswa); $x++){
				$cek_tagihan_bulanan = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM siswa INNER JOIN tagihan_bulanan ON siswa.idSiswa=tagihan_bulanan.idSiswa WHERE siswa.idSiswa='$siswa[$x]' AND tagihan_bulanan.statusBayar!='1'"));
   				 $cek_tagihan_bebas = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM siswa INNER JOIN tagihan_bebas ON siswa.idSiswa=tagihan_bebas.idSiswa WHERE siswa.idSiswa='$siswa[$x]' AND tagihan_bebas.statusBayar!='1'"));
    			if ($cek_tagihan_bulanan == 0 AND $cek_tagihan_bebas == 0){
    				$query=mysqli_query($koneksi,"UPDATE siswa SET statusSiswa='Tamat' WHERE idSiswa='$siswa[$x]'");
    			}
			}
			if ($query){
				$_SESSION['notif'] = 'sukseslulus';
			}else{
			  	$_SESSION['notif'] = 'gagallulus';
			}
			echo "<script>document.location='index.php?view=$_GET[view]&unit=$_GET[unit]&kelas=$_GET[kelas]';</script>";
		}

		if(isset($_GET['batallulus'])){
			$siswa = $_POST['pilih2'];
			for($x = 0; $x < count($siswa); $x++){
				$query=mysqli_query($koneksi,"UPDATE siswa SET statusSiswa='Aktif' WHERE idSiswa='$siswa[$x]'");
			}
			if ($query){
				$_SESSION['notif'] = 'suksesbatal';
			}else{
			  	$_SESSION['notif'] = 'gagalbatal';
			}
			echo "<script>document.location='index.php?view=$_GET[view]&unit=$_GET[unit]&kelas=$_GET[kelas]';</script>";
		}
	?>	


	<div class="col-md-12">
		<div class="alert alert-danger">
			Warning!... !
			Halaman ini digunakan untuk merubah status siswa menjadi lulus. Pastikan siswa yang di proses adalah siswa kelas akhir.
		</div>
	</div>


	<div class="col-md-5">
		<div class="box">
			<div class="box-body">
				<form action="index.php" method="get" accept-charset="utf-8">
					<div class="form-group">
						<div class="input-group">
						    <input type="hidden" name="view" value="<?= $_GET[view]?>">
							<div class="input-group-addon alert-success">Unit</div>
							<input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
							<select class="form-control" name="unit" id="Cunit"></select>
							<div class="input-group-addon alert-info">Kelas</div>
							<input type="hidden" id="idKelas" value="<?= $_GET[kelas] ?>">
							<select class="form-control" name="kelas" id="Ckelas" onchange="this.form.submit()">
								<option value="">- Pilih Kelas  -</option>
							</select>
						</div>
					</div>
				</form>						
				<form action="index.php?view=<?= $_GET[view] ?>&unit=<?= $_GET[unit] ?>&kelas=<?= $_GET[kelas] ?>&proseslulus" method="post" id="lulus">
					<table class="table table-hover table-bordered table-responsive">
						<thead>
							<tr>
								<th><center><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></center></th> 
								<th>No</th>
								<th>NIS</th>
								<th>Nama</th>
								<th>Status Kelulusan</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no=1;
								$tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]' AND siswa.kelasSiswa='$_GET[kelas]' AND siswa.statusSiswa='Aktif' ORDER BY siswa.idSiswa DESC");
								if ((empty($_GET['unit']) && empty($_GET['kelas'])) || (mysqli_num_rows($tampil) == 0)){
									echo '<tr id="row">
											<td colspan="5" align="center">Data Kosong</td>
										  </tr>';
								}else{
									while ($r = mysqli_fetch_array($tampil)) {
										if ($r['statusSiswa'] == 'Aktif'){
				                          	$statusSiswa = '<center><label class="label label-warning">Belum Lulus</label></center>';
				                        }
										echo '<tr>
												<td><center><input type="checkbox" class="checkbox" name="pilih[]" value="'.$r['idSiswa'].'"></center></td>
												<td>'.$no++.'</td>
												<td>'.$r['nisSiswa'].'</td>
												<td>'.$r['nmSiswa'].'</td>
												<td>'.$statusSiswa.'</td>
											  </tr>';
									}
								}
							?>
						<tbody>
					</table>
				</form>
			</div>
		</div>
	</div>

	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-body">
				<button class="btn btn-success btn-block" onclick="$('#lulus').submit()"><span class="glyphicon glyphicon glyphicon-chevron-right"></span> Proses Lulus</button>
				<br>
				<button class="btn btn-danger btn-block" onclick="$('#kembali').submit();"><span class="glyphicon glyphicon glyphicon-chevron-left"></span> Batal Lulus</button>
			</div>
		</div>
	</div>

	<div class="col-md-5">
		<div class="box">
			<div class="box-body">
				<h4>Data Kelulusan</h4>
					<form action="index.php?view=<?= $_GET[view] ?>&unit=<?= $_GET[unit] ?>&kelas=<?= $_GET[kelas] ?>&batallulus" method="post" id="kembali">
						<table class="table table-hover table-bordered table-responsive">
							<thead>
								<tr>
									<th><center><input type="checkbox" id="selectall2" value="checkbox" name="checkbox"></center></th> 
									<th>No</th>
									<th>NIS</th>
									<th>Nama</th>
									<th>Status Kelulusan</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$no=1;
									$tampil2 = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]' AND siswa.kelasSiswa='$_GET[kelas]' AND siswa.statusSiswa='Tamat' ORDER BY siswa.idSiswa DESC");
									if ((empty($_GET['unit']) && empty($_GET['kelas'])) || (mysqli_num_rows($tampil2) == 0)){
										echo '<tr id="row">
												<td colspan="5" align="center">Data Kosong</td>
											  </tr>';
									}else{
										while ($r = mysqli_fetch_array($tampil2)) {
											if ($r['statusSiswa'] == 'Tamat'){
						                       	$statusSiswa = '<center><label class="label label-success">Lulus</label></center>';
					                        }
											echo '<tr>
													<td><center><input type="checkbox" class="checkbox2" name="pilih2[]" value="'.$r['idSiswa'].'"></center></td>
													<td>'.$no++.'</td>
													<td>'.$r['nisSiswa'].'</td>
													<td>'.$r['nmSiswa'].'</td>
													<td>'.$statusSiswa.'</td>
												  </tr>';
										}
									}
								?>
							</tbody>
						</table>
					</form>
			</div>			
		</div>
	</div>