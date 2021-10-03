<?php
$tahun=$ta['idTahunAjaran'];
$jenis='';
$kelas='';
?>
<div class="col-xs-6">
	<div class="box box-info box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Rekap Per Hari</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="cetak_rekapitulasi_harian.php" role="form" target="_blank">
				<div class="form-group">
					<label for="">Tahun Ajaran</label>
					<select id="tahun" name="tahun" class="form-control" required>
						<?php
						$sqltahun = mysql_query("SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran ASC");
						while($t=mysql_fetch_array($sqltahun)){										
							$selected = ($t['idTahunAjaran'] == $tahun) ? ' selected="selected"' : "";
							echo "<option value=".$t['idTahunAjaran']." ".$selected.">".$t['nmTahunAjaran']."</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="">Jenis Pembayaran</label>
					<select id="jenisBayar" name="jenisBayar" class="form-control" required>
						<?php
						echo "<option value='all'>- Semua Jenis Bayar -</option>";
						$sqlJB = mysql_query("SELECT * FROM jenis_bayar WHERE idTahunAjaran='$tahun' ORDER BY idJenisBayar ASC");
						while($jb=mysql_fetch_array($sqlJB)){
							$selected = ($jb['idJenisBayar'] == $jenis) ? ' selected="selected"' : "";
							echo "<option value=".$jb['idJenisBayar']." ".$selected.">".$jb['nmJenisBayar']."</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="">Dari Tanggal</label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="tgl1" value="<?php echo date('Y-m-d'); ?>" class="form-control pull-right date-picker">
					</div>
				</div>
				<div class="form-group">
					<label for="">Sampai Tanggal</label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" name="tgl2" value="<?php echo date('Y-m-d'); ?>" class="form-control pull-right date-picker">
					</div>
				</div>
				<div class="form-group">
					<label for="">Opsi/Cara Pembayaran</label>
					<select name="caraBayar" class="form-control">
						<option value="">Semua</option>
						<option value="Tunai">Tunai</option>
						<option value="Transfer">Transfer</option>
					</select>
				</div>
				<div class="form-group">
					<label for=""></label>
					<input type="submit" value="Cetak Laporan" class="btn btn-success pull-right">
				</div>
			</form>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>
<div class="col-xs-6">
	<div class="box box-warning box-solid">
		<div class="box-header with-border">
			<h3 class="box-title"><span class="fa fa-file-text-o"></span> Rekap Per Bulan</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="cetak_rekapitulasi_perperiode.php" role="form" target="_blank">
				<div class="form-group">
					<label for="">Tahun Ajaran</label>
					<select id="tahun1" name="tahun" class="form-control" required>
						<?php
						$sqltahun = mysql_query("SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran ASC");
						while($t=mysql_fetch_array($sqltahun)){										
							$selected = ($t['idTahunAjaran'] == $tahun) ? ' selected="selected"' : "";
							echo "<option value=".$t['idTahunAjaran']." ".$selected.">".$t['nmTahunAjaran']."</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="">Jenis Pembayaran</label>
					<select id="jenisBayar1" name="jenisBayar" class="form-control" required>
						<?php
						echo "<option value='all'>- Semua Jenis Bayar -</option>";
						$sqlJB = mysql_query("SELECT * FROM jenis_bayar WHERE idTahunAjaran='$tahun' ORDER BY idJenisBayar ASC");
						while($jb=mysql_fetch_array($sqlJB)){
							$selected = ($jb['idJenisBayar'] == $jenis) ? ' selected="selected"' : "";
							echo "<option value=".$jb['idJenisBayar']." ".$selected.">".$jb['nmJenisBayar']."</option>";
						}
						?>
					</select>
				</div>
				<!--<div class="form-group">
					<label for="">Dari Bulan</label>
					<input type="text" name="bulan1" placeholder="Pilih Bulan dan Tahun" class="form-control date-picker-rekap" readonly>
				</div>
				<div class="form-group">
					<label for="">Sampai Bulan</label>
					<input type="text" name="bulan2" placeholder="Pilih Bulan dan Tahun" class="form-control date-picker-rekap" readonly>
				</div>-->
				<div class="form-group">
					<div class="row">
						<div class="col-md-12"><label for="">Dari Bulan</label></div>
						<div class="col-md-8">
							<select id="bulan" name="bulan1" class="form-control" required>
								<?php
								$sqlBulan = mysql_query("SELECT * FROM bulan ORDER BY urutan ASC");
								while($b=mysql_fetch_array($sqlBulan)){										
									echo "<option value=".$b['idBulan'].">".$b['nmBulan']."</option>";
								}
								?>
							</select>
						</div>
						<div class="col-md-4">
							<select id="tahun1" name="tahun1" class="form-control" required>
								<option value="<?php echo date('Y'); ?>" selected><?php echo date('Y'); ?></option>
								<?php
								for($i=2015;$i<date('Y')+3;$i++){
									echo "<option value='$i'>$i</option>";
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12"><label for="">Sampai Bulan</label></div>
						<div class="col-md-8">
							<select id="bulan" name="bulan2" class="form-control" required>
								<?php
								$sqlBulan = mysql_query("SELECT * FROM bulan ORDER BY urutan ASC");
								while($b=mysql_fetch_array($sqlBulan)){										
									echo "<option value=".$b['idBulan'].">".$b['nmBulan']."</option>";
								}
								?>
							</select>
						</div>
						<div class="col-md-4">
							<select id="tahun2" name="tahun2" class="form-control" required>
								<option value="<?php echo date('Y')+1; ?>" selected><?php echo date('Y')+1; ?></option>
								<?php
								for($i=2015;$i<date('Y')+3;$i++){
									echo "<option value='$i'>$i</option>";
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="">Opsi/Cara Pembayaran</label>
					<select name="caraBayar" class="form-control">
						<option value="">Semua</option>
						<option value="Tunai">Tunai</option>
						<option value="Transfer">Transfer</option>
					</select>
				</div>
				<div class="form-group">
					<label for=""></label>
					<input type="submit" value="Cetak Laporan" class="btn btn-primary pull-right">
				</div>
			</form>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>