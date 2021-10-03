<?php
 include "config/koneksi.php";
  include "config/library.php";
  include "config/fungsi_indotgl.php";
  include "config/excel_reader.php";
  include "config/fungsi_seo.php";
  include "config/fungsi_thumb.php";
  include "config/variabel_default.php";
  include 'apk_login_siswa.php';
  session_start();
  error_reporting(0);
  $idt = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM identitas "));
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $idt[nmAplikasi] ?></title>
    <link rel="shortcut icon" href="<?= $lokasi_penyimpanan_logo.$idt['logo_kiri']?>">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./assets/font-awesome-4.6.3/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="./assets/ionicons/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="plugins/datetimepicker/bootstrap-datetimepicker.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="assets/bootstrap-select/css/bootstrap-select.min.css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <style type="text/css"> .files{ position:absolute; z-index:2; top:0; left:0; filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; opacity:0; background-color:transparent; color:transparent; } </style>
    <script type="text/javascript" src="plugins/jQuery/jquery-1.12.3.min.js"></script>
    <script language="javascript" type="text/javascript">
      var maxAmount = 160;
      function textCounter(textField, showCountField) {
        if (textField.value.length > maxAmount) {
          textField.value = textField.value.substring(0, maxAmount);
        } else {
          showCountField.value = maxAmount - textField.value.length;
        }
      }

    </script>
	<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="plugins/highcharts/js/highcharts.js"></script>
    <script src="plugins/highcharts/js/modules/data.js"></script>
    <script src="plugins/highcharts/js/modules/exporting.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/datetimepicker/bootstrap-datetimepicker.js"></script>
    <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>

    <script src="assets/js/script.js"></script>
    <script src="assets/app.js"></script>

    <script src="assets/bootstrap-select/js/bootstrap-select.min.js"></script>

    <script>
      $('.textarea').wysihtml5();

      $(function () {
		    // datepicker plugin
        $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true,
          format: 'yyyy-mm-dd'
        });

        $("#example1").DataTable();
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });

        $('#example3').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200
        });

        $('#mastersiswa').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200
        });

        $('#example5').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200,
          "order": [[ 5, "desc" ]]
        });
      });

		//$('.datepicker').datepicker();

    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
    });

		$('.datetimepicker').datetimepicker({
			format: 'yyyy-mm-dd hh:ii:ss',
			weekStart: 1,
			todayBtn:  1,
			autoclose: 1
		});

		$(".harusAngka").keypress(function (e) {
			//if the letter is not digit then display error and don't type anything
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				   return false;
			}
		});

    $("#parent").click(function() {
      $(".child").prop("checked", this.checked);
    });

    $('.child').click(function() {
        if ($('.child:checked').length == $('.child').length) {
          $('#parent').prop('checked', true);
        } else {
          $('#parent').prop('checked', false);
        }
    });

		//hitung
		/*
		$('#hitungBayaran').keyup(function(){
			if ($(this).val() > $("#sisa").val()){
				alert('Anda memasukkan nilai melebihi total tagihan!');
				$(this).val($("#sisa").val());
			}
		});
		*/

		$("#allTarif").keypress(function (e) {
			var allTarif = $("#allTarif").val();
			if (e.which == 13) {
				$("#n1").val(allTarif);
				$("#n2").val(allTarif);
				$("#n3").val(allTarif);
				$("#n4").val(allTarif);
				$("#n5").val(allTarif);
				$("#n6").val(allTarif);
				$("#n7").val(allTarif);
				$("#n8").val(allTarif);
				$("#n9").val(allTarif);
				$("#n10").val(allTarif);
				$("#n11").val(allTarif);
				$("#n12").val(allTarif);
			}
		});
		$("#allTarifBebas").keypress(function (e) {
			var allTarif = $("#allTarifBebas").val();
			if (e.which == 13) {
				$(".nTagihan").val(allTarif);
			}
		});
    </script>

	<script type="text/javascript" src="getDataCombo.js"></script>
  </head>
  <font face="Calibri">
</html>

	<nav class="navbar navbar-default fixed">
		<div class="navbar-header">
			<div class="row text-left">
				<div class="col-md-3">
					<a class="navbar-brand" href="#">
						<img src="<?= $lokasi_penyimpanan_logo.$idt['logo_kiri'] ?>" style="height: 40px; margin-top: -10px;" class="pull-left">
					</a>
				</div>
				<div class="col-md-9">
					<font size="4"><b><?= $idt['nmSekolah'] ?></b></font>
					<br>
					<font size="2"><?= $idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'] ?><br>Telp. <?= $idt['noTelp'] ?></font>
					<!-- <button type="button" class="btn btn-default navbar-btn pull-right">Sign in</button> -->
				</div>
			</div>
		</div>
	</nav>

	<section class="content">
  		<div class="row">
    		<div class="col-md-12">
      			<div class="box box-success box-solid" style="border: 1px solid #2ABB9B !important;">
        			<div class="box-header backg with-border">
          				<h3 class="box-title">Cek Data Pembayaran Santri</h3>
        			</div><!-- /.box-header -->
        			<div class="box-body">
          				<form action="" class="form-horizontal" method="get" accept-charset="utf-8">
          					<div class="form-group">
          						<label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
          						<div class="col-sm-2">
            						<input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
            						<select class="form-control"  name="thn_ajar" id="Ctahunajaran"></select>
              					</div>
           						<label for="" class="col-sm-2 control-label">Cari Santri</label>
            					<div class="col-sm-2">
              						<input type="text" autofocus="" name="nis" value="<?= $_GET[nis] ?>" class="form-control" required="">
            					</div>
            					<div class="col-sm-4">
              						<button type="submit" class="btn btn-primary"><i class="fa fa-search"> </i> Cari Santri</button>
              						<a href="index.php" class="btn btn-danger">Kembali</a>
            					</div>
          					</div>
        				</form>
      				</div><!-- /.box-body -->
    			</div><!-- /.box -->

    			<script type="text/javascript">
    				var idTahunAjaran = $("#idTahunAjaran").val();
			          $.ajax({
			            type: 'POST',
			            url: "admin/combobox/pilihan_tahunajaran.php",
			            data: {idTahunAjaran : idTahunAjaran},
			            cache: false,
			            success: function(msg){
			              $("#Ctahunajaran").html(msg);
			            }
			        });
    			</script>

    			<?php if (isset($_GET['thn_ajar']) && isset($_GET['nis'])){

    				$idTahunAjaran = $_GET['thn_ajar'];
    				$nis = $_GET['nis'];

    				$ta= mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    				$siswa= mysqli_fetch_array(mysqli_query($koneksi,"SELECT siswa.*,
    																		kelas_siswa.nmKelas,
    																		kamar.namaKamar
    																  FROM siswa
    																  LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas
    																  LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar
    																  WHERE nisSiswa='$nis'"));
    			?>

    				<div class="row">
    					<div class="col-md-6">
        					<div class="box box-success box-solid" style="border: 1px solid #2ABB9B !important;">
          						<div class="box-header backg with-border">
            						<h3 class="box-title">Informasi Santri</h3>
          						</div><!-- /.box-header -->
          						<div class="box-body">
            						<table class="table table-striped">
              							<tbody>
              								<tr>
                  							<td width="200">Tahun Ajaran</td>
                  							<td width="4">:</td>
                                <td><strong><?= $ta['nmTahunAjaran'] ?></strong></td>
                          		</tr>
                          		<tr>
                                <td>NIS</td>
                                <td>:</td>
                          			<td><?= $siswa['nisSiswa'] ?></td>
                          		</tr>
                          		<tr>
                                <td>Nama Santri</td>
                                <td>:</td>
							                  <td><?= $siswa['nmSiswa'] ?></td>
                              </tr>
                              <tr>
                                <td>Kelas</td>
                                <td>:</td>
                                <td><?= $siswa['nmKelas'] ?></td>
                              </tr>
                              <tr>
							                    <td>Kamar</td>
							                    <td>:</td>
							                    <td><?= $siswa['namaKamar'] ?></td>
							                </tr>
                						</tbody>
              						</table>
            					</div>
          					</div>
        				</div>

        				<div class="col-md-6">
          					<!-- List Tagihan Bulanan -->
          					<div class="box box-success box-solid" style="border: 1px solid #2ABB9B !important;">
            					<div class="box-header backg with-border">
              						<h3 class="box-title">Tagihan Bulanan</h3>
            					</div><!-- /.box-header -->
            					<div class="box-body table-responsive">
              						<table class="table table-striped table-hover" style="cursor: pointer;">
                						<thead>
						                  	<tr>
						                    	<th>No.</th>
												<th>Nama Pembayaran</th>
						                    	<th>Total Tagihan</th>
						                    	<th>Sudah Dibayar</th>
						                    	<th>Kekurangan</th>
						                    	<th>Status</th>
						                  	</tr>
						                </thead>

						                	<?php
												$sqlListTGB = mysqli_query($koneksi,"SELECT
																						tagihan_bulanan.*,
																						sum(tagihan_bulanan.jumlahTagihan) as jmlTagihanBulanan,
																						jenis_bayar.idPosBayar,
																						pos_bayar.nmPosBayar,
																						unit_sekolah.singkatanUnit,
																						tahun_ajaran.nmTahunAjaran
																					 FROM tagihan_bulanan
																					 INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
																					 INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
																					 INNER JOIN unit_sekolah ON jenis_bayar.idUnit = unit_sekolah.idUnit
																					 INNER JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
																					 WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran' GROUP BY tagihan_bulanan.idJenisBayar");
													$no=1;
													while($rtgb=mysqli_fetch_array($sqlListTGB)){
														$dtgb=mysqli_fetch_array(mysqli_query($koneksi,"SELECT sum(jumlahTagihan) as jmlDibayar FROM tagihan_bulanan WHERE idJenisBayar=$rtgb[idJenisBayar] AND idSiswa=$rtgb[idSiswa] AND statusBayar='1'"));
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
														echo "<tbody><tr style='color:$color' data-toggle='collapse' data-target='#demo".$rtgb['idJenisBayar']."'>
																<td>".$no++."</td>
																<td>".$rtgb['nmPosBayar']." T.A. ".$ta['nmTahunAjaran']."</td>
																<td>".buatRp($rtgb['jmlTagihanBulanan'])."</td>
																<td>".buatRp($dtgb['jmlDibayar'])."</td>
																<td>".buatRp($rtgb['jmlTagihanBulanan']-$dtgb['jmlDibayar'])."</td>
																<td>$status</td>
															  </tr></tbody>";


															  echo '<tbody id="demo'.$rtgb['idJenisBayar'].'" class="collapse">
															  			<tr>
															  				<td colspan="6" align="center" class="info">
															  					<h4>'.$rtgb[nmPosBayar].' - T.A '.$rtgb[nmTahunAjaran].'</h4>
															  				</td>
															  			</tr>
															  			<tr>
																  			<th>No.</th>
														            <th>Bulan</th>
														            <th>Tahun</th>
												                <th>Tagihan</th>
										                    <th colspan="2" style="text-align: center;">Status</th>
									                    </tr>';
                                      $no = 1;
                                      $sqltbDetail = mysqli_query($koneksi,"SELECT tagihan_bulanan.*, bulan.nmBulan FROM tagihan_bulanan LEFT JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan WHERE idJenisBayar='$rtgb[idJenisBayar]' AND idSiswa='$siswa[idSiswa]' ORDER BY bulan.urutan ASC");
													            while($tb=mysqli_fetch_array($sqltbDetail)){
                                        $pisah_TA = explode('/', $ta['nmTahunAjaran']);
                                        if ($r['urutan'] <= 6){
                                          $tahun = $pisah_TA[0];
                                        }else{
                                          $tahun = $pisah_TA[1];
                                        }
                                        if ($tb['statusBayar'] == '1'){
                                          $color="success";
                                          $status = 'Lunas';
                                        }else{
                                          $color="danger";
                                          $status = 'Belum Lunas';
                                        }
                                        echo '<tr class="'.$color.'">
        														            <td>'.$no++.'</td>
        											                  <td>'.$tb['nmBulan'].'</td>
        										                    <td>'.$tahun.'</td>
        										                    <td>'.buatRp($tb['jumlahTagihan']).'</td>
        														            <td colspan="2" align="center">'.$status.'</td>
        														          </tr>';
                                      }
														    echo '</tbody>';
													}
													?>

                              		</table>
          						</div>
        					</div>

        					<div class="box box-success box-solid" style="border: 1px solid #2ABB9B !important;">
        						<div class="box-header backg with-border">
        							<h3 class="box-title">Tagihan Lainnya</h3>
        						</div><!-- /.box-header -->
        						<div class="box-body table-responsive">
        							<table class="table table-striped table-hover">
        								<thead>
        									<tr>
        										<th>No.</th>
        										<th>Jenis Pembayaran</th>
        										<th>Total Tagihan</th>
        										<th>Dibayar</th>
        										<th>Kekurangan</th>
        										<th>Status</th>
        									</tr>
        								</thead>
        								<tbody>
        									<?php
        										$sqlTagihanBebas = mysqli_query($koneksi, "SELECT
																					tagihan_bebas.*,
																					jenis_bayar.idPosBayar,
																					pos_bayar.nmPosBayar,
																					unit_sekolah.singkatanUnit
																				FROM
																					tagihan_bebas
																				INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
																				INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
																				INNER JOIN unit_sekolah ON jenis_bayar.idUnit = unit_sekolah.idUnit
																				WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran' ORDER BY tagihan_bebas.idTagihanBebas ASC");

        										$no=1;
												while($rtb=mysqli_fetch_array($sqlTagihanBebas)){
													$dtBayar=mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(jumlahBayar) as totalDibayar FROM tagihan_bebas_bayar WHERE idTagihanBebas='$rtb[idTagihanBebas]'"));

													$sisa=$dtInfo['totalTagihan']-$totalDibayar['totalDibayar'];
													$sisaRp=buatRp($sisa);

													if($rtb['statusBayar']=='0'){
														$status="<label class='label label-danger'>Belum Bayar</label>";
														$icon="fa-plus";
														$btn="btn-danger";
														$color="red";
														$alt="Bayar";
														$btncetak="disabled";
													}elseif($rtb['statusBayar']=='2'){
														$status="<label class='label label-warning'>Belum Lunas</label>";
														$icon="fa-plus";
														$btn="btn-warning";
														$color="red";
														$alt="Bayar";
														$btncetak="";
													}elseif($rtb['statusBayar']=='1'){
														$status="<label class='label label-success'>Lunas</label>";
														$icon="fa-search";
														$btn="btn-success";
														$color="green";
														$alt="Detil";
														$btncetak="";
													}
													echo "<tr style='color:$color'>
														<td>".$no++."</td>
														<td>".$rtb['nmPosBayar']." T.A. ".$ta['nmTahunAjaran']."</td>
														<td>".buatRp($rtb['totalTagihan'])."</td>
														<td>".buatRp($dtBayar['totalDibayar'])."</td>
														<td>".buatRp($rtb['totalTagihan']-$dtBayar['totalDibayar'])."</td>
														<td>$status</td>
													</tr>";
												}
        									?>
        								</tbody>
        							</table>
        						</div>
                  			</div>
      					</div>
    				</div>
  				</div>
  			</div>
  		<?php } ?>

    </section><br><br>
    <div class="navbar navbar-default navbar-fixed-bottom">
		<div class="container text-center">
			<p><?php include "footer.php"; ?></p>
		</div>
	</div>
