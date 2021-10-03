	<?php
		if ($_SESSION['notif'] == 'sukses'){
		  echo '<script>toastr["success"]("Data Siswa pindah kelas berhasil diproses.","Sukses!")</script>';
		}elseif($_SESSION['notif'] == 'gagal'){
		  echo '<script>toastr["error"]("Data Siswa pindah kelas gagal diproses.","Gagal!")</script>';
		}unset($_SESSION['notif']);
	?>

	<?php
		if(isset($_GET['proses'])){
			$siswa = $_POST['pilih'];

			for($x = 0; $x < count($siswa); $x++){
				$query=mysqli_query($koneksi,"UPDATE siswa SET unitSiswa='$_POST[unit_id]', kelasSiswa='$_POST[kelas_id]' WHERE idSiswa='$siswa[$x]'");
			}
			if ($query){
				$_SESSION['notif'] = 'sukses';
			}else{
			  	$_SESSION['notif'] = 'gagal';
			}
			echo "<script>document.location='index.php?view=$_GET[view]&unit=$_GET[unit]&kelas=$_GET[kelas]';</script>";
		}
	?>	

	<div class="col-md-12">
		<div class="alert alert-danger">
			Warning!... !
			Jika ada siswa yang telah dibuatkan tagihan dan dipindah kelasnya melalui halaman ini, maka tagihan tetap ada di kelas sebelumnya!
		</div>
	</div>

	
	<div class="col-md-9">
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
			</div>					
		
<form action="index.php?view=<?= $_GET[view] ?>&unit=<?= $_GET[unit] ?>&kelas=<?= $_GET[kelas] ?>&proses" method="post"  id="proses">
				<table class="table table-hover table-bordered table-responsive">
					<thead>
						<tr>
							<th><center><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></center></th> 
							<th>No</th>
							<th>NIS</th>
							<th>Nama</th>
							<th>Kelas</th>
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
								echo '<tr>
										<td><center><input type="checkbox" class="checkbox" name="pilih[]" value="'.$r['idSiswa'].'"></center></td>
										<td>'.$no++.'</td>
										<td>'.$r['nisSiswa'].'</td>
										<td>'.$r['nmSiswa'].'</td>
										<td>'.$r['nmKelas'].'</td>
									  </tr>';
							}
						}
						
						?>
					</tbody>
				</table>
			<br>			
		</div>
	</div>

	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-body">
				<select class="form-control" name="unit_id" id="Cunit_id" required="">
					<option value="">- Pilih Unit Sekolah -</option>
				</select>
				<br>
					
				<select class="form-control" name="kelas_id" id="Ckelas_id">
	  				<option value="">- Ke Kelas  -</option>
				</select>
				
				<br>
				<button class="btn btn-success btn-block" name="proses" type="submit">Proses Pindah/Naik Kelas</button>
			</div>
		</div>			
	</div>
</form>
	

<script type="text/javascript">
   $(document).ready(function(){
        var idUnit = '<?= $_GET[unit]?>';
        var idUsers = '<?= $idUsers ?>';
     
        $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_unit.php",
           	data: {idUnit: '', idUsers:idUsers},
            cache: false,
            success: function(msg){
            	$("#Cunit_id").html(msg);
            }
        });
    });

    $("#Cunit_id").change(function(){
        var idUnit = $("#Cunit_id").val();
        var idKelas = '';
        $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_kelas.php",
                  data: {idUnit: idUnit, idKelas: idKelas},
                  cache: false,
                  success: function(msg){
                    $("#Ckelas_id").html(msg);
                  }
            });
      });		
</script>