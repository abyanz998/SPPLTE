<script type="text/javascript">
	function checkTanggal(tgl1,tgl2) {
        var tanggal1 = document.getElementById("tgl1").value;
        var tanggal2 = document.getElementById("tgl2").value;
        var tglTotime1= Date.parse(tanggal1);
        var tglTotime2= Date.parse(tanggal2);
        if (tgl2 == ''){
        	document.querySelector(tgl2).setCustomValidity("Sampai Tanggal Belum Dimasukkan");
        }else if(tglTotime1 > tglTotime2){
        	document.querySelector(tgl2).setCustomValidity("Sampai Tanggal Tidak Boleh Kurang Dari Mulai Tanggal, Silahkan Pilih Tanggal Lain");
        } else {
          	document.querySelector(tgl2).setCustomValidity("");
        }
    }
</script>
<?php if ($_GET[act]==''){ 
$sqlTahunAktif = mysql_query("SELECT * FROM tahun_ajaran WHERE aktif='Y'");
$tahunaktif=mysql_fetch_array($sqlTahunAktif);
$sqlJenisBayar= mysql_query("SELECT * FROM jenis_bayar WHERE idTahunAjaran='$tahunaktif[idTahunAjaran]' ORDER BY tipeBayar DESC");

?> 
	<div class="col-xs-12">
	  <div class="box box-info box-solid">
		<div class="box-header with-border">
			<!-- tools box -->
			<div class="pull-right box-tools">
				<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
				<i class="fa fa-minus"></i></button>
			</div>
			<!-- /. tools -->
		  <h3 class="box-title">Filter Data Pembayaran Siswa</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<form method="GET" action="" class="form-horizontal">
				<input type="hidden" name="view" value="pembayaran" >
				<div class="form-group">						
					<!--<label for="" class="col-sm-1 control-label">Tahun</label>
					<div class="col-sm-2">
					  <select name="idTahunAjaran" class="form-control">
						<?php
						$sqltahun = mysql_query("SELECT * FROM tahun_ajaran ORDER BY idTahunAjaran DESC");
						while($t=mysql_fetch_array($sqltahun))
						{
							$selected = ($t['idTahunAjaran'] == $tahunaktif['idTahunAjaran']) ? ' selected="selected"' : "";

							echo '<option value="'.$t['idTahunAjaran'].'" '.$selected.'>'.$t['nmTahunAjaran'].'</option>';
						}
						?>
					  </select>
					</div>-->
					<label for="" class="col-sm-2 control-label">NIS/NISN/Nama</label>
					<div class="col-sm-8">
					  	<select name="siswa" data-live-search="true" class="form-control selectpicker">
					  		<option value="">- Cari Siswa -</option>
						    <?php
						    $sqlSiswa = mysql_query("SELECT * FROM view_detil_siswa where unitSiswa='$_SESSION[units]' "); 
						    while ($s=mysql_fetch_array($sqlSiswa))
						    {
						        echo "<option value='$s[idSiswa]'>$s[nisSiswa] - $s[nmSiswa]</option>";
						    }
						    ?>					    
						</select>
					</div>
					<div class="col-sm-2">
						<input type="submit" name="cari" value="Cari Siswa" class="btn btn-success">
					</div>
				</div>
			</form>
		</div><!-- /.box-body -->
	  </div><!-- /.box -->
	</div>
	<?php
	if(isset($_GET['cari'])){
		$siswa = $_GET['siswa'];		
		
		//tagihan bebas
		$sqlTagihanBebas = mysql_query("SELECT
									tagihan_bebas.*,
									jenis_bayar.idPosBayar,
									pos_bayar.nmPosBayar,
									jenis_bayar.idTahunAjaran,
									jenis_bayar.nmJenisBayar,
									jenis_bayar.tipeBayar,
									siswa.nisSiswa,
									siswa.nisnSiswa,
									siswa.nmSiswa,
									siswa.jkSiswa,
									siswa.agamaSiswa,
									siswa.idKelas,
									siswa.statusSiswa,
									tahun_ajaran.nmTahunAjaran,
									kelas_siswa.nmKelas
								FROM
									tagihan_bebas
								INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
								INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
								INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
								INNER JOIN kelas_siswa ON tagihan_bebas.idKelas = kelas_siswa.idKelas
								INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
								WHERE siswa.idSiswa='$siswa' ORDER BY tagihan_bebas.idTagihanBebas ASC");
		//AND jenis_bayar.idTahunAjaran='$_GET[idTahunAjaran]' 
	?>
	<div class="col-xs-12">
		<div class="box box-success box-solid">
			<div class="box-header with-border">
				<!-- tools box -->
				<div class="pull-right box-tools">
				 
					<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
					<i class="fa fa-minus"></i></button>
				</div>
				<!-- /. tools -->
			  <h3 class="box-title">Informasi Siswa</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<?php
					$ta = "<b>Semua Tahun Ajaran<b>";
					$thnAjaran = "Semua Tahun Ajaran";
					
					$tgl=date('Y-m-d');
 			
					$sqlSiswa1=mysql_query("SELECT siswa.*,kelas_siswa.nmKelas FROM siswa
											INNER JOIN kelas_siswa ON siswa.idKelas = kelas_siswa.idKelas
											WHERE siswa.idSiswa='$siswa'");
					$dts=mysql_fetch_array($sqlSiswa1);
				?>
				<table class="table table-striped">
					<tr>
						<td width="200">Tahun Ajaran</td><td width="4">:</td>
						<td><b><?php echo $ta; ?></b></td>
					</tr>
					<tr>
						<td>NIS</td><td>:</td>
						<td><?php echo $dts['nisSiswa']; ?></td>
					</tr>
					<tr>
						<td>NISN</td><td>:</td>
						<td><?php echo $dts['nisnSiswa']; ?></td>
					</tr>
					<tr>
						<td>Nama Siswa</td><td>:</td>
						<td><?php echo $dts['nmSiswa']; ?></td>
					</tr>
					<tr>
						<td>Kelas</td><td>:</td>
						<td><?php echo $dts['nmKelas']; ?></td>
					</tr>
				</table>
			</div>
		</div>
		
	
	  <div class="box box-info box-solid">
		<div class="box-header with-border">
			<!-- tools box -->
			<div class="pull-right box-tools">
				<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
				<i class="fa fa-minus"></i></button>
			</div>
			<!-- /. tools -->
		  <h3 class="box-title">Fitur Kilat</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
		<h5> Fitur ini digunakan untuk mempermudah transaksi</h5>
		<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#ModalCetakSemuaSlip"><span class="fa fa-print"></span> Cetak Semua Slip Pertanggal</button>
		<a class="btn btn-success btn-xs" target="_blank" title="Cetak Slip" href="./slip_bulanan_persiswa_peritem_sekarang.php?tahun=<?php echo $ta; ?>&tgl=<?php echo $tgl ;?>&kelas=<?php echo $dts['idKelas']; ?>&siswa=<?php echo $siswa; ?>"><span class="fa fa-print"></span> Cetak Semua Slip Hari Ini</a>
		
		<?php 
			$TAG_BULAN=array();
			while($dj=mysql_fetch_array($sqlJenisBayar)){
				if($dj['tipeBayar'] == 'bebas'){
					$sqlB=mysql_query("SELECT
							tagihan_bebas_bayar.idTagihanBebasBayar,
							tagihan_bebas_bayar.idTagihanBebas,
							tagihan_bebas_bayar.tglBayar,
							tagihan_bebas_bayar.jumlahBayar,
							tagihan_bebas_bayar.ketBayar,
							tagihan_bebas_bayar.caraBayar,
							tagihan_bebas.idJenisBayar,
							tagihan_bebas.idSiswa,
							tagihan_bebas.idKelas,
							tagihan_bebas.totalTagihan,
							tagihan_bebas.statusBayar
							FROM
								tagihan_bebas_bayar
							INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
							INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
							WHERE tagihan_bebas.idJenisBayar='$dj[idJenisBayar]' AND tagihan_bebas.statusBayar<>'0' AND tagihan_bebas.idSiswa = '$_GET[siswa]' AND (DATE(tagihan_bebas_bayar.tglBayar)) ='$tgl'");

						while($dtb=mysql_fetch_array($sqlB)){
							$TAG_BULAN[] = "*".ucwords(strtolower($dj[nmJenisBayar]))."* sebesar *".buatRp($dtb[jumlahBayar])."*";
						}
				} else if($dj['tipeBayar'] == 'bulanan'){
					$sqlLap = mysql_query("SELECT * FROM view_laporan_bayar_bulanan 
							WHERE idJenisBayar='$dj[idJenisBayar]' AND idTahunAjaran='$tahunaktif[idTahunAjaran]' AND idSiswa='$_GET[siswa]' AND statusBayar='1' AND (DATE(tglBayar)) = '$tgl' ORDER BY urutan ASC");
						while($rt=mysql_fetch_array($sqlLap)){ 
							$TAG_BULAN[] = "*".ucwords(strtolower($dj[nmJenisBayar]))."/".$rt[nmBulan]."* sebesar *".buatRp($rt[jumlahBayar])."*";
						} 
				}
				//total tagihan lainnya
				$totLainya=mysql_fetch_array(mysql_query("SELECT SUM(jumlahBayar) AS totBayar
					FROM tagihan_bebas_bayar
					INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
					INNER JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa 
					WHERE tagihan_bebas.statusBayar<>'0' AND tagihan_bebas.idSiswa = '$_GET[siswa]' AND (DATE(tagihan_bebas_bayar.tglBayar)) ='$tgl'"));
				//total tagihan bulanan
				$totBulanan=mysql_fetch_array(mysql_query("SELECT SUM(jumlahBayar) AS totBayar FROM tagihan_bulanan WHERE idSiswa='$_GET[siswa]' AND statusBayar='1' AND (DATE(tglBayar)) = '$tgl'"));
				$total_pembayaran=buatRp($totLainya['totBayar']+$totBulanan['totBayar']);
			}
				
			for ($i=0; $i < count($TAG_BULAN); $i++) { 
				$textPembayaran=$textPembayaran.' '.$TAG_BULAN[$i].',';
			}

			$page_URL = (@$_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
			$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			$uri_segments = explode('/', $uri_path);
            $link_url = "$page_URL$_SERVER[HTTP_HOST]/".$uri_segments[1].'/slip_bulanan_persiswa_peritem_sekarang.php?tahun='.$thnAjaran.'%26tgl='.$tgl.'%26kelas='.$dts[idKelas].'%26siswa='.$siswa;
          
            $format_tgl = date('d-m-Y', strtotime($tgl));
            $wa_sekolah='http://wa.me/%2B6282358733455';
            $artb=mysql_fetch_array($sqlTagihanBebas);
            
			echo "<a class='btn btn-info btn-xs' title='Kirimkan Notifikasi Pembayaran' href='https://api.whatsapp.com/send?phone=$dts[noHpOrtu]&text=Terima kasih, Pembayaran Sekolah $artb[nmPosBayar] a/n $dts[nmSiswa], kelas $dts[nmKelas], telah kami terima tanggal $format_tgl sejumlah $total_pembayaran. %0A Download Kwitansi : $link_url %0A Nomor WA Sekolah : $wa_sekolah' target='_blank'><span class='fa fa-whatsapp'></span> Kirim Pembayaran Hari Ini</a>";
		?>

		<div id="ModalCetakSemuaSlip" class="modal fade" role="dialog">
				<form method="GET" action="./slip_bulanan_persiswa_peritem.php" class="form-horizontal" target="_blank" title="Cetak Slip">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Filter Data</h4>
							</div>
							<div class="modal-body">
								
					<input type="hidden" name="tahun" value="<?php echo $ta; ?>">
					<input type="hidden" name="siswa" value="<?php echo $siswa; ?>">
								<input type="hidden" name="kelas" value="<?php echo $dts['idKelas']; ?>">

								<table class="table table-striped">
									<thead>
										<tr>
											<th>Mulai</th>
											<th>Sampai</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<div class="input-group date">
												  <div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												  </div>
												  <input type="text" name="tgl1" id="tgl1" class="form-control pull-right date-picker" required="" value">
												</div>
												<!-- /.input group -->
											</td>
											<td>
												<div class="input-group date">
												  <div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												  </div>
												  <input type="text" name="tgl2" id="tgl2" class="form-control pull-right date-picker" required="">
												</div>
												<!-- /.input group -->
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="modal-footer">
								<input type="submit" value="Cetak" class="btn btn-success" onclick="checkTanggal('#tgl1','#tgl2');">
								<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
							</div>
						</div>
					</div>
				</form>
			</div>	</div>
		</div>	</div>	</div>	
		
		<!-- List Tagihan Bulanan -->
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<!-- tools box -->
				<div class="pull-right box-tools">
					<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
						<i class="fa fa-minus"></i></button>
				</div>
			  <h3 class="box-title">Tagihan Bulanan</h3>
			</div><!-- /.box-header -->
			<div class="box-body">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>No.</th>
							<th>Tahun Ajaran</th>
							<th>Pos Bayar</th>
							<th>Jenis Pembayaran</th>
							<th>Total Tagihan</th>
							<th>DiBayar</th>
							<th>Status Bayar</th>
							<th>Bayar</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sqlListTGB = mysql_query("SELECT
								jenis_bayar.idJenisBayar,
								jenis_bayar.nmJenisBayar,
								jenis_bayar.tipeBayar,
								jenis_bayar.idTahunAjaran,
								tahun_ajaran.nmTahunAjaran,
								Sum(tagihan_bulanan.jumlahBayar) AS jmlTagihanBulanan,
								kelas_siswa.nmKelas,
								siswa.idSiswa,
								siswa.nisSiswa,
								siswa.nisnSiswa,
								siswa.nmSiswa,
								jenis_bayar.idPosBayar,
								pos_bayar.nmPosBayar,
								pos_bayar.ketPosBayar
								FROM
								jenis_bayar
								INNER JOIN tagihan_bulanan ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
								INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
								INNER JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa
								INNER JOIN kelas_siswa ON tagihan_bulanan.idKelas = kelas_siswa.idKelas
								INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
								WHERE siswa.idSiswa='$siswa'
								GROUP BY
								jenis_bayar.idJenisBayar");
						//jenis_bayar.idTahunAjaran='$_GET[idTahunAjaran]' AND 
						$no=1;
						while($rtgb=mysql_fetch_array($sqlListTGB)){
							$dtgb=mysql_fetch_array(mysql_query("select sum(jumlahBayar) as jmlDibayar from tagihan_bulanan where idJenisBayar=$rtgb[idJenisBayar] AND idSiswa=$rtgb[idSiswa] AND statusBayar='1'"));
							if($dtgb['jmlDibayar']==0){
								$status="<label class='label label-danger'>Belum Bayar</label>";
								$icon="fa-plus";
								$btn="btn-danger";
								$color="red";
								$alt="Bayar";
							}elseif($dtgb['jmlDibayar'] < $rtgb['jmlTagihanBulanan']){
								$status="<label class='label label-warning'>Belum Lengkap</label>";
								$icon="fa-plus";
								$btn="btn-warning";
								$color="red";
								$alt="Bayar";
							}else{
								$status="<label class='label label-success'>Lunas</label>";
								$icon="fa-search";
								$btn="btn-success";
								$color="green";
								$alt="Detil";
							}
							echo "<tr style='color:$color'>
								<td>$no</td>
								<td>$rtgb[nmTahunAjaran]</td>
								<td>$rtgb[nmPosBayar]</td>
								<td>$rtgb[nmJenisBayar]</td>
								<td>".buatRp($rtgb['jmlTagihanBulanan'])."</td>
								<td>".buatRp($dtgb['jmlDibayar'])."</td>
								<td>$status</td>
								<td width='40' style='text-align:center'>
									<a class='btn $btn btn-xs' title='$alt' href='?view=bayarbulanan&jenis=$rtgb[idJenisBayar]&tahun=$rtgb[idTahunAjaran]&siswa=$rtgb[idSiswa]'><span class='fa $icon'></span> $alt</a>
								</td>
							</tr>";
							$no++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- End List Tagihan Bulanan -->
		
		<!-- List Tagihan Lainnya (Bebas) -->
		<div class="box box-danger box-solid">
		<div class="box-header with-border">
			<!-- tools box -->
			<div class="pull-right box-tools">
				<button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
					<i class="fa fa-minus"></i></button>
				<!--<a class="btn btn-success btn-sm pull-right" style="margin-right: 5px;" target="_blank" title="Cetak Slip" href="./slip_bebas_persiswa.php?tahun=<?php //echo $_GET['idTahunAjaran']; ?>&siswa=<?php //echo $_GET['nisSiswa']; ?>"><span class="fa fa-print"></span> Cetak Semua Status Pembayaran</a>-->
			</div>
			<!-- /. tools -->
		  <h3 class="box-title">Tagihan Lainnya</h3>
		</div><!-- /.box-header -->
		<div class="box-body">
			<?php 
				if (isset($_GET['ok'])){
					$url_sms = 'https://gsm.zenziva.net/api/balance/?userkey=vmezut&passkey=ceabd0a34bde5902f2c8a2da';
					$get_content_sms = file_get_contents($url_sms);
					$json = json_decode($get_content_sms, TRUE);
					$credit_sms = $json['credit'];
					echo "<div class='alert alert-success'><b>SUKSES</b> - SMS ke Orang Tua Berhasil dikirimkan! <b style='float:right'>(Sisa Kuota $credit_sms SMS)</b></div>";
				}elseif (isset($_GET['err'])){
					echo "<div class='alert alert-danger'><b>GAGAL</b> - Notifikasi SMS Gagal Terkirim, Cek Lagi No Tujuan!</div>";
				}
			?>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>Tahun Ajaran</th>
						<th>Pos Bayar</th>
						<th>Jenis Pembayaran</th>
						<th>Total Tagihan</th>
						<th>Dibayar</th>
						<th>Status</th>
						<th>Bayar</th>
						<th class='text-center'>Cetak</th>
						<th>Kirim SMS Tagihan</th>
						<th>Kirim WhatsApp Tagihan</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no=1;
					while($rtb=mysql_fetch_array($sqlTagihanBebas)){
						$qBayar=mysql_query("select sum(jumlahBayar) as totalDibayar from tagihan_bebas_bayar 
												where idTagihanBebas='$rtb[idTagihanBebas]'");
						$dtBayar=mysql_fetch_array($qBayar);
						
						if($rtb['statusBayar']=='0'){
							$status="<label class='label label-danger'>Belum Bayar</label>";
							$icon="fa-plus";
							$btn="btn-danger";
							$color="red";
							$alt="Bayar";
							$btncetak="disabled";
						}elseif($rtb['statusBayar']=='1'){
							$status="<label class='label label-warning'>Belum Lunas</label>";
							$icon="fa-plus";
							$btn="btn-warning";
							$color="red";
							$alt="Bayar";
							$btncetak="";
						}elseif($rtb['statusBayar']=='2'){
							$status="<label class='label label-success'>Lunas</label>";
							$icon="fa-search";
							$btn="btn-success";
							$color="green";
							$alt="Detil";
							$btncetak="";
						}
						echo "<tr style='color:$color'>
							<td>$no</td>
							<td>$rtb[nmTahunAjaran]</td>
							<td>$rtb[nmPosBayar]</td>
							<td>$rtb[nmJenisBayar]</td>
							<td>".buatRp($rtb['totalTagihan'])."</td>
							<td>".buatRp($dtBayar['totalDibayar'])."</td>
							<td>$status</td>
							<td width='40' style='text-align:center'>
								<a class='btn $btn btn-xs' title='$alt' href='?view=angsuran&tagihan=$rtb[idTagihanBebas]' ><span class='fa $icon'></span> $alt</a>
							</td>
							<td class='text-center'>
								<a class='btn btn-success btn-xs $btncetak' target='_blank' title='Cetak Pembayaran' href='./slip_bebas_persiswa.php?tagihan=$rtb[idTagihanBebas]&siswa=$siswa'><span class='fa fa-print'></span> Cetak Pembayaran</a>
								
							</td>
							<td class='text-center'>
							<a class='btn btn-info btn-xs' title='Kirimkan Notifikasi Tagihan' href='index.php?view=pembayaran&siswa=$_GET[siswa]&cari=$_GET[cari]&ket=$rtb[nmJenisBayar]&sms'><span class='fa fa-commenting'></span>Kirim Tagihan</a>
						</td>
						<td class='text-center'>
							<a class='btn btn-info btn-xs' title='Kirimkan Notifikasi Tagihan' href='https://api.whatsapp.com/send?phone=$dts[noHpOrtu]&text=Assalamualaikum, Harap menyelesaikan pembayaran Tagihan $rtb[nmJenisBayar] anak anda *$dts[nmSiswa]* sebesar  *".buatRp($rtb['totalTagihan'])."* , Terima kasih (Keuangan Smk Aswaja). ' target='_blank'><span class='fa fa-commenting'></span>Kirim Tagihan</a>
						</td>
						</tr>";
						$no++;
					}

					if (isset($_GET['sms'])){
						$row = mysql_fetch_array(mysql_query("SELECT * FROM siswa where idSiswa='$_GET[siswa]'"));
						if ($row['noHpOrtu']==''){
							echo "<script>document.location='index.php?view=pembayaran&siswa=$_GET[siswa]&cari=$_GET[cari]&err';</script>";
						}else{
							$userkey = "vmezut";
							$passkey = "ceabd0a34bde5902f2c8a2da";
							$telepon = $row['noHpOrtu'];
							$message = "Assalamualaikum, Harap menyelesaikan pembayaran Tagihan $_GET[ket] anak anda $row[nmSiswa], Terima kasih.";
							$url = "https://gsm.zenziva.net/api/sendsms/";
							$curlHandle = curl_init();
							curl_setopt($curlHandle, CURLOPT_URL, $url);
							curl_setopt($curlHandle, CURLOPT_HEADER, 0);
							curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
							curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
							curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
							curl_setopt($curlHandle, CURLOPT_POST, 1);
							curl_setopt($curlHandle, CURLOPT_POSTFIELDS, array(
								'userkey' => $userkey,
								'passkey' => $passkey,
								'nohp' => $telepon,
								'pesan' => $message
							));
							$results = json_decode(curl_exec($curlHandle), true);
							curl_close($curlHandle);
							echo "<script>document.location='index.php?view=pembayaran&siswa=$_GET[siswa]&cari=$_GET[cari]&ok';</script>";
						}
					}
					?>
				</tbody>
			</table>
		</div>
	  </div>
	</div>
	<?php
		}
	?>
<?php 
}
?>