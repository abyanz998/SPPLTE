<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success">
                <div class="box-header">
                  <div class="box-header">
				    
		                <div class="row">
		                    <form action="" method="get" accept-charset="utf-8">
		                    	<input type="hidden" name="view" value="<?= $_GET[view] ?>">
							<div class="col-md-2">  
								<div class="form-group">
									<div class="input-group date datepicker" data-date="" data-date-format="yyyy-mm-dd">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										<input class="form-control" type="text" name="dari" id="dari_tanggal" readonly="readonly" placeholder="Dari" value="<?= $_GET[dari] ?>">
									</div>
								</div>
							</div>
							<div class="col-md-2">  
								<div class="form-group">
									<div class="input-group date datepicker" data-date="" data-date-format="yyyy-mm-dd">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										<input class="form-control" type="text" name="sampai" id="sampai_tanggal" readonly="readonly" placeholder="Sampai" value="<?= $_GET[sampai] ?>">	
									</div>
								</div>
							</div>
							<div class="col-md-3">  
								<div class="form-group">
									<input type="hidden" id="idModul" value="<?= $_GET[modul] ?>">
									<select class="form-control" name="modul" id="Cmodul">
									</select>
								</div>
							</div>
							<div class="col-md-2">  
								<div class="form-group">
								    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Cari</button>
								</div>
							</div>
						</form>
		            </div>

				</div>

                <div class="box-body">
                  <table id="example1" class="table table-hover dataTable no-footer">
					<thead>
					  <tr>
						  <th>No</th>
						  <th>Tanggal</th>
						  <th>Modul</th>
						  <th>Aksi</th>
						  <th>Info</th>
						  <th>Penulis</th>
						  <th>Browser</th>
						  <th>OS</th>
						  <th>Ip Adress</th>
					  </tr>
				  </thead>
				  <tbody>
                  <?php 
                  	if ($idUnitUsers == '0'){
	                  	if(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all'){
	                    	$tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_transaksi.modul='$_GET[modul]' ORDER BY log_transaksi.idTransaksi DESC");
	                  	}elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all'){
	                    	$tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') ORDER BY log_transaksi.idTransaksi DESC");
	                  	}elseif(empty($_GET[modul])){
	                  		$tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) ='$tanggal_sekarang') ORDER BY log_transaksi.idTransaksi DESC");

	                  	}else{
	                  		if ($_GET[modul] == 'all'){
	                  			$tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers ORDER BY log_transaksi.idTransaksi DESC");
	                  		}else{
	                  			$tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE log_transaksi.modul='$_GET[modul]' ORDER BY log_transaksi.idTransaksi DESC");
	                  		}
	                  	}
	                }else{
	                	if(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all'){
	                    	$tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_transaksi.modul='$_GET[modul]' AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
	                  	}elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all'){
	                    	$tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
	                  	}elseif(empty($_GET[modul])){
	                  		$tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE (DATE(log_transaksi.tanggal) ='$tanggal_sekarang') AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");

	                  	}else{
	                  		if ($_GET[modul] == 'all'){
	                  			$tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
	                  		}else{
	                  			$tampil = mysqli_query($koneksi, "SELECT log_transaksi.*, users.nama_lengkap FROM log_transaksi LEFT JOIN users ON log_transaksi.penulis = users.idUsers WHERE log_transaksi.modul='$_GET[modul]' AND users.unit='$idUnitUsers' ORDER BY log_transaksi.idTransaksi DESC");
	                  		}
	                  	}
	                }
                    $no = 1;
                    while($r=mysqli_fetch_array($tampil)){
						echo "<tr>
								<td>$no</td>
                              	<td>$r[tanggal]</td>
                              	<td>$r[modul]</td>
                              	<td>$r[aksi]</td>
                              	<td>$r[info]</td>
                              	<td>$r[nama_lengkap]</td>
                              	<td>$r[browser]</td>
                              	<td>$r[os]</td>
                              	<td>$r[ip_address]</td>                              	
                              </tr>";
                        
                   		$no++;
                      }
                  	?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
<?php } ?>