<?php

if ($_SESSION['notif'] == 'sukses'){
	echo '<script>toastr["success"]("Data berhasil diupdate.","Sukses!")</script>';
}elseif($_SESSION['notif'] == 'gagal'){
	echo '<script>toastr["error"]("Data gagal diupdate.","Gagal!")</script>';
}
unset($_SESSION['notif']);

//proses update
if (isset($_POST['update'])){
	
	$lokasi_file_kiri = $_FILES['flogokiri']['tmp_name'];
  	$nama_file_kiri   = $_FILES['flogokiri']['name'];
    $nmAplikasi = addslashes($_POST[nmAplikasi]);
    $singkatanAplikasi = addslashes($_POST[singkatanAplikasi]);
    $nmSekolah = addslashes($_POST[nmSekolah]);
    $alamat = addslashes($_POST[alamat]);
  	// Apabila ada gambar yang diupload
  	if (!empty($lokasi_file_kiri)){
		UploadLogoKiri($nama_file_kiri);
		$query = mysqli_query($koneksi,"UPDATE identitas SET 
												nmAplikasi='$nmAplikasi',
												singkatanAplikasi='$singkatanAplikasi',
												nmSekolah='$nmSekolah',
												alamat='$alamat',
												kecamatan='$_POST[kecamatan]',
												kabupaten='$_POST[kabupaten]',
												propinsi='$_POST[propinsi]',
												nipKepsek='$_POST[nipKepsek]',
												nmKepsek='$_POST[nmKepsek]',
												nipKaTU='$_POST[nipKaTU]',
												nmKaTU='$_POST[nmKaTU]',
												nipBendahara='$_POST[nipBendahara]',
												nmBendahara='$_POST[nmBendahara]',
												noTelp='$_POST[noTelp]',
												logo_kiri='$nama_file_kiri',
												uby='$idUsers',
												udate='$waktu_sekarang'
									WHERE npsn = '$_POST[npsn]'");
	}else{
		$query = mysqli_query($koneksi,"UPDATE identitas SET 
												nmAplikasi='$nmAplikasi',
												singkatanAplikasi='$singkatanAplikasi',
												nmSekolah='$nmSekolah',
												alamat='$alamat',
												kecamatan='$_POST[kecamatan]',
												kabupaten='$_POST[kabupaten]',
												propinsi='$_POST[propinsi]',
												nipKepsek='$_POST[nipKepsek]',
												nmKepsek='$_POST[nmKepsek]',
												nipKaTU='$_POST[nipKaTU]',
												nmKaTU='$_POST[nmKaTU]',
												nipBendahara='$_POST[nipBendahara]',
												nmBendahara='$_POST[nmBendahara]',
												noTelp='$_POST[noTelp]',
												uby='$idUsers',
												udate='$waktu_sekarang'
									WHERE npsn = '$_POST[npsn]'");
	}

	if ($query){
	  	$_SESSION['notif'] = 'sukses';
        echo "<script>document.location='index.php?view=$_GET[view]';</script>";
	}else{
		$_SESSION['notif'] = 'gagal';
        echo "<script>document.location='index.php?view=$_GET[view]';</script>";
	}
}
$edit = mysqli_query($koneksi,"SELECT * FROM identitas where npsn='10700295'");
$record = mysqli_fetch_array($edit);


?>

<form method="post" action="" class="form-horizontal" enctype="multipart/form-data">

	<div class="col-md-8">
	  <div class="box box-success box-solid">
		<div class="box-header with-border">
		  <h3 class="box-title"> Identitas Sekolah</h3>
		</div><!-- /.box-header -->
		<div class="box-body">

			<input type="hidden" name="npsn" value="<?php echo $record['npsn']; ?>" >
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Nama Aplikasi</label>
				<div class="col-sm-6">
					<input type="text" name="nmAplikasi" class="form-control" value="<?php echo $record['nmAplikasi']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Singkatan Aplikasi</label>
				<div class="col-sm-4">
					<input type="text" name="singkatanAplikasi" class="form-control" value="<?php echo $record['singkatanAplikasi']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Nama Sekolah</label>
				<div class="col-sm-4">
					<input type="text" name="nmSekolah" class="form-control" value="<?php echo $record['nmSekolah']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Alamat Sekolah</label>
				<div class="col-sm-6">
					<input type="text" name="alamat" class="form-control" value="<?php echo $record['alamat']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Nama Kecamatan</label>
				<div class="col-sm-6">
					<input type="text" name="kecamatan" class="form-control" value="<?php echo $record['kecamatan']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Nama Kota/Kab</label>
				<div class="col-sm-6">
					<input type="text" name="kabupaten" class="form-control" value="<?php echo $record['kabupaten']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Nama Propinsi</label>
				<div class="col-sm-6">
					<input type="text" name="propinsi" class="form-control" value="<?php echo $record['propinsi']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">NIP Kepsek</label>
				<div class="col-sm-4">
					<input type="text" name="nipKepsek" class="form-control" value="<?php echo $record['nipKepsek']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Nama Kepsek</label>
				<div class="col-sm-5">
					<input type="text" name="nmKepsek" class="form-control" value="<?php echo $record['nmKepsek']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">NIP Ka. TU</label>
				<div class="col-sm-4">
					<input type="text" name="nipKaTU" class="form-control" value="<?php echo $record['nipKaTU']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Nama Ka. TU</label>
				<div class="col-sm-5">
					<input type="text" name="nmKaTU" class="form-control" value="<?php echo $record['nmKaTU']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">NIP Bendahara</label>
				<div class="col-sm-4">
					<input type="text" name="nipBendahara" class="form-control" value="<?php echo $record['nipBendahara']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Nama Bendahara</label>
				<div class="col-sm-5">
					<input type="text" name="nmBendahara" class="form-control" value="<?php echo $record['nmBendahara']; ?>" required>
				</div>
			</div>
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">Nomor Telepon</label>
				<div class="col-sm-4">
					<input type="text" name="noTelp" class="form-control" value="<?php echo $record['noTelp']; ?>" required>
				</div>
			</div>
		</div>
	  </div>
	</div>

	<div class="col-md-4">
	  	<div class="box box-warning box-solid">
			<div class="box-header with-border">
			  <h3 class="box-title"> Logo Sekolah</h3>
			</div><!-- /.box-header -->
			<div class="box-body text-center">
				<img id="target" src="./gambar/logo/<?php echo $record['logo_kiri']; ?>" width="160px">
				<br><br>
				<center><input type="file" id="foto" name="flogokiri" ></center>
			</div>
		</div>
	</div>

	<div class="col-md-4">
	  	<div class="box box-dafault">
			<div class="box-body text-center">
				<input type="submit" name="update" value="Simpan" class="btn btn-block btn-success">		
			</div>
		</div>
	</div>

</form>
