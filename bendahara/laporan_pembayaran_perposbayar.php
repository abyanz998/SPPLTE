<?php
if(isset($_GET['tahun'])){
	$ta = mysql_fetch_array(mysql_query("SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[tahun]'"));
	$tahun = $ta['idTahunAjaran'];
	$pos = mysql_fetch_array(mysql_query("SELECT * FROM pos_bayar where idPosBayar='$_GET[pos]'"));
	$posbayar = $pos['idPosBayar'];
}else{
	$tahun=$ta['idTahunAjaran'];
	$jenis='';
	$kelas='';
}
?>
<div class="col-xs-12">
	<div class="box box-info box-solid">
		<div class="box-header with-border">
		  <h3 class="box-title"><span class="fa fa-file-text-o"></span> Filter Data</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="" class="form-horizontal">
				<input type="hidden" name="view" value="lappembayaranperposbayar"/>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Pos Bayar</th>
							<th>Tahun Ajaran</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<select id="pos" name="pos" class="form-control" required>
									<?php
									$sqlPosBayar = mysql_query("SELECT * FROM pos_bayar ORDER BY idPosBayar ASC");
									while($pb=mysql_fetch_array($sqlPosBayar)){		

										$selected = ($pb['idPosBayar'] == $posbayar) ? ' selected="selected"' : "";

										echo "<option value=".$pb['idPosBayar']." ".$selected.">".$pb['nmPosBayar']."</option>";
									}
									?>
								</select>
							</td>
							<td>
								<select id="tahun" name="tahun" class="form-control" required>
									<?php
									$sqltahun = mysql_query("SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran ASC");
									while($t=mysql_fetch_array($sqltahun)){										
										$selected = ($t['idTahunAjaran'] == $tahun) ? ' selected="selected"' : "";
										echo "<option value=".$t['idTahunAjaran']." ".$selected.">".$t['nmTahunAjaran']."</option>";
									}
									?>
								</select>
							</td>
							<td width="100">
								<input type="submit" name="proses" value="Proses" class="btn btn-success pull-right">
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div><!-- /.box-body -->

		<?php
		if(isset($_GET['proses'])){
			$ta = mysql_fetch_array(mysql_query("SELECT * FROM tahun_ajaran where idTahunAjaran='$_GET[tahun]'"));
			$idTahun = $ta['idTahunAjaran'];
			$pos = mysql_fetch_array(mysql_query("SELECT * FROM pos_bayar where idPosBayar='$_GET[pos]'"));
		?>
		  <div class="table-responsive">
			<table border="1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No.</th>
						<th>Pos Bayar</th>
						<th>Jenis Pembayaran</th>
						<th>Jumlah Pembayaran</th>
						<th>Jumlah Tagihan</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no=1;
				$totDibayar = 0;
				$totTagihan = 0;
				$sqlJenisBayar = mysql_query("SELECT * FROM jenis_bayar WHERE idTahunAjaran='$idTahun' AND idPosBayar='$pos[idPosBayar]'");
				while($djb=mysql_fetch_array($sqlJenisBayar)){
					if($djb['tipeBayar']=='bulanan'){
						//menghitung semua tagihan bulanan
						$tgbul 	=	mysql_fetch_array(mysql_query("SELECT
									jenis_bayar.idPosBayar,
									pos_bayar.nmPosBayar,
									Sum(tagihan_bulanan.jumlahBayar) AS TotalSemuaTagihanBulanan
									FROM
									tagihan_bulanan
									INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
									INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
									WHERE tagihan_bulanan.idJenisBayar='$djb[idJenisBayar]'
									GROUP BY
									jenis_bayar.idPosBayar"));
						$semuaTagihan = $tgbul['TotalSemuaTagihanBulanan'];

						$dbayar = mysql_fetch_array(mysql_query("SELECT
									jenis_bayar.idPosBayar,
									pos_bayar.nmPosBayar,
									jenis_bayar.idTahunAjaran,
									tahun_ajaran.nmTahunAjaran,
									jenis_bayar.nmJenisBayar,
									Sum(tagihan_bulanan.jumlahBayar) AS TotalPembayaranPerJenis,
									tagihan_bulanan.statusBayar
									FROM
									tagihan_bulanan
									INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
									INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
									INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
									WHERE tagihan_bulanan.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bulanan.statusBayar='1'
									GROUP BY
									tagihan_bulanan.idJenisBayar"));
						$jBayar 	= $dbayar['TotalPembayaranPerJenis'];
						$tagihan 	= $semuaTagihan - $jBayar;

					}else{
						//menghitung semua tagihan bebas
						$tgb 	= 	mysql_fetch_array(mysql_query("SELECT
										tagihan_bebas.idTagihanBebas,
										jenis_bayar.idPosBayar,
										pos_bayar.nmPosBayar,
										SUM(tagihan_bebas.totalTagihan) As TotalSemuaTagihanBebas
										FROM
										tagihan_bebas
										INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
										INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
										WHERE tagihan_bebas.idJenisBayar='$djb[idJenisBayar]'
										GROUP BY
										jenis_bayar.idPosBayar"));
						$semuaTagihan = $tgb['TotalSemuaTagihanBebas'];

						$dbayar = mysql_fetch_array(mysql_query("SELECT
									tagihan_bebas.idJenisBayar,
									jenis_bayar.nmJenisBayar,
									jenis_bayar.idTahunAjaran,
									tahun_ajaran.nmTahunAjaran,
									tagihan_bebas_bayar.idTagihanBebas,
									Sum(tagihan_bebas_bayar.jumlahBayar) AS TotalPembayaranPerJenis,
									tagihan_bebas_bayar.ketBayar
									FROM
									tagihan_bebas_bayar
									INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
									INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
									INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
									WHERE tagihan_bebas_bayar.idTagihanBebas='$tgb[idTagihanBebas]'
									GROUP BY
									tagihan_bebas_bayar.idTagihanBebas"));
						$jBayar 	= $dbayar['TotalPembayaranPerJenis'];
						$tagihan 	= $semuaTagihan - $jBayar;
					}
					echo "<tr>
							<td align='center'>$no</td>
							<td>$pos[nmPosBayar]</td>
							<td>$djb[nmJenisBayar]</td>
							<td align='right'>".buatRp($jBayar)."</td>
							<td align='right'>".buatRp($tagihan)."</td>
						</tr>";
						$no++;
						$totDibayar += $jBayar;
						$totTagihan += $tagihan;
				}
				?>
				<tr>
					<td></td>
					<td colspan="2">Jumlah Pembayaran</td>
					<td align="right"><b><?php echo buatRp($totDibayar); ?></b></td>
					<td align="right"><b><?php echo buatRp($totTagihan); ?></b></td>
				</tr>
				</tbody>
			</table>

			<div class="box-footer text-center">
				<a class="btn btn-success" target="_blank" href="./excel_laporan_pembayaran_perposbayar.php?pos=<?php echo $_GET['pos']; ?>&tahun=<?php echo $_GET['tahun']; ?>"><span class="fa fa-file-excel-o"></span>  Export ke Excel</a>
				<a class="btn btn-danger" target="_blank" href="./cetak_laporan_pembayaran_perposbayar.php?pos=<?php echo $_GET['pos']; ?>&tahun=<?php echo $_GET['tahun']; ?>"><span class="glyphicon glyphicon-print"></span>  Cetak Laporan </a>
			</div>
		<?php
		}
		?>

	</div><!-- /.box -->

</div>