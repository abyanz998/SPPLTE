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
										<input class="form-control" type="text" name="dari" id="dari_tanggal" placeholder="Dari" value="<?= $_GET[dari] ?>" required="">
									</div>
								</div>
							</div>
							<div class="col-md-2">  
								<div class="form-group">
									<div class="input-group date datepicker" data-date="" data-date-format="yyyy-mm-dd">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
										<input class="form-control" type="text" name="sampai" id="sampai_tanggal" placeholder="Sampai" value="<?= $_GET[sampai] ?>" required="">	
									</div>
								</div>
							</div>
							<div class="col-md-3">  
								<div class="form-group" style="margin-top: 5px">
									<input type="hidden" id="idModul" value="<?= $_GET[modul] ?>">
									<select class="form-control" name="modul" id="Cmodul" required="">
									</select>
								</div>
							</div>
							<div class="col-md-3">  
								<div class="form-group" style="margin-top: 5px">
									<input type="hidden" id="idUsers" value="<?= $_GET[users] ?>">
									<input type="hidden" id="tipe_users" value="semuaUsers">
									<select class="form-control" name="users" id="Cusers" required="">
									</select>
								</div>
							</div>
							<div class="col-md-2">  
								<div class="form-group" style="margin-top: 5px">
								    <button type="submit" class="btn btn-success" ><i class="fa fa-search"></i> Cari</button>
								</div>
							</div>
						</form>
		            	</div>
					</div>
				</div>
	        </div>
	    </div>
<?php } ?>

<?php if (isset($_GET['dari']) && isset($_GET['sampai']) && isset($_GET['modul']) && isset($_GET['users'])) {  ?>

	<?php
	    $dari = $_GET['dari'];
	    $sampai = $_GET['sampai'];
	    $modul = $_GET['modul'];
	    $users = $_GET['users'];

	    if ($modul !='all'){
	      $nmModul='Modul '.$modul;
	    }else{
	      $nmModul = 'Semua Modul';
	    }
	    if ($users !='all'){
	      $usr = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM users WHERE idUsers='$_GET[users]'"));
	      $nmKasir='Kasir '.$usr['nama_lengkap'];
	    }else{
	      $nmKasir = 'Semua Kasir';
	    }
  	?>

	<div class="col-md-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Kas Kasir Tanggal <?= tgl_miring($tgl_mulai) ?> Sampai <?= tgl_miring($tgl_akhir) ?> <?= $nmModul ?> <?= $nmKasir ?> </h3>
        </div>
        <div class="box-body table-responsive">
          <table id="example1" class="table table-hover table-bordered dataTable no-footer" style="white-space: nowrap;">
            <thead>
              <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Akun</th>
                <th>Keterangan Akun</th>
                <th>Uraian</th>
                <th>No. Ref</th>
                <th>Masuk</th>
                <th>Keluar</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                  	if ($_SESSION['unit'] == '0'){
                                      if(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] != 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_kasir.*, users.nama_lengkap FROM log_kasir LEFT JOIN users ON log_kasir.penulis = users.idUsers WHERE (DATE(log_kasir.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_kasir.modul='$_GET[modul]' AND log_kasir.penulis='$_GET[users]' ORDER BY log_kasir.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] == 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_kasir.*, users.nama_lengkap FROM log_kasir LEFT JOIN users ON log_kasir.penulis = users.idUsers WHERE (DATE(log_kasir.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') ORDER BY log_kasir.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] == 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_kasir.*, users.nama_lengkap FROM log_kasir LEFT JOIN users ON log_kasir.penulis = users.idUsers WHERE (DATE(log_kasir.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_kasir.modul='$_GET[modul]' ORDER BY log_kasir.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] != 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_kasir.*, users.nama_lengkap FROM log_kasir LEFT JOIN users ON log_kasir.penulis = users.idUsers WHERE (DATE(log_kasir.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_kasir.penulis='$_GET[users]' ORDER BY log_kasir.idTransaksi DESC");
                                      }else{
                                        $query = mysqli_query($koneksi, "SELECT log_kasir.*, users.nama_lengkap FROM log_kasir LEFT JOIN users ON log_kasir.penulis = users.idUsers ORDER BY log_kasir.idTransaksi DESC");
                                      }
                                    }else{
                                      if(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] != 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_kasir.*, users.nama_lengkap FROM log_kasir LEFT JOIN users ON log_kasir.penulis = users.idUsers WHERE (DATE(log_kasir.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_kasir.modul='$_GET[modul]' AND log_kasir.penulis='$_GET[users]' AND users.unit='$idUnitUsers' ORDER BY log_kasir.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] == 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_kasir.*, users.nama_lengkap FROM log_kasir LEFT JOIN users ON log_kasir.penulis = users.idUsers WHERE (DATE(log_kasir.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]')  AND users.unit='$idUnitUsers' ORDER BY log_kasir.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] != 'all' && $_GET[users] == 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_kasir.*, users.nama_lengkap FROM log_kasir LEFT JOIN users ON log_kasir.penulis = users.idUsers WHERE (DATE(log_kasir.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_kasir.modul='$_GET[modul]' AND users.unit='$idUnitUsers' ORDER BY log_kasir.idTransaksi DESC");
                                      }elseif(!empty($_GET[dari]) && !empty($_GET[sampai]) && $_GET[modul] == 'all' && $_GET[users] != 'all'){
                                        $query = mysqli_query($koneksi, "SELECT log_kasir.*, users.nama_lengkap FROM log_kasir LEFT JOIN users ON log_kasir.penulis = users.idUsers WHERE (DATE(log_kasir.tanggal) BETWEEN '$_GET[dari]' AND '$_GET[sampai]') AND log_kasir.penulis='$_GET[users]' AND users.unit='$idUnitUsers' ORDER BY log_kasir.idTransaksi DESC");
                                      }else{
                                        $query = mysqli_query($koneksi, "SELECT log_kasir.*, users.nama_lengkap FROM log_kasir LEFT JOIN users ON log_kasir.penulis = users.idUsers WHERE users.unit='$idUnitUsers' ORDER BY log_kasir.idTransaksi DESC");
                                      }
                                    }
                                    $no = 1;
                                    $total_penerimaan = 0;
                                    $total_pengeluaran = 0;
                                    while($r=mysqli_fetch_array($query)){
                                      if ($r['jenisBayar'] == 'Bulanan'){
                                        $bulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bulanan.*, jenis_bayar.idPosBayar, pos_bayar.kodeAkun, akun_biaya.kodeAkun as kdAKun, akun_biaya.keterangan FROM tagihan_bulanan LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar LEFT JOIN akun_biaya ON pos_bayar.kodeAkun=akun_biaya.idAkun WHERE tagihan_bulanan.idTagihanBulanan='$r[idBayar]'"));
                                        $siswa =  mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM siswa WHERE nisSiswa='$r[nis_nip]'"));
                                        echo '<tr>
                                                <td>'.$no++.'</td>
                                                <td>'.tgl_miring(date('Y-m-d',strtotime($r['tanggal']))).'</td>
                                                <td>'.$bulanan['kdAKun'].'</td>
                                                <td>'.$bulanan['keterangan'].'</td>
                                                <td>'.$siswa['nmSiswa'].' ('.$siswa['nisSiswa'].') '.$r['title'].'</td>
                                                <td>'.$r['noRefrensi'].'</td>';
                                                if ($r['aksi'] == 'Bayar'){
                                                  echo '<td>'.buatRp($r['nominal']).'</td>
                                                        <td align="center">-</td>';
                                                  $total_penerimaan += $r['nominal'];
                                                }elseif ($r['aksi'] == 'Hapus'){
                                                  echo '<td align="center">-</td>
                                                        <td>'.buatRp($r['nominal']).'</td>';
                                                  $total_pengeluaran += $r['nominal'];
                                                }
                                        echo '</tr>';
                                      }elseif ($r['jenisBayar'] == 'Bebas'){
                                        $bebas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*, jenis_bayar.idPosBayar, pos_bayar.kodeAkun, akun_biaya.kodeAkun as kdAKun, akun_biaya.keterangan FROM tagihan_bebas LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar LEFT JOIN akun_biaya ON pos_bayar.kodeAkun=akun_biaya.idAkun WHERE tagihan_bebas.idTagihanBebas='$r[idBayar]'"));
                                        $siswa =  mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM siswa WHERE nisSiswa='$r[nis_nip]'"));
                                        echo '<tr>
                                                <td>'.$no++.'</td>
                                                <td>'.tgl_miring(date('Y-m-d',strtotime($r['tanggal']))).'</td>
                                                <td>'.$bebas['kdAKun'].'</td>
                                                <td>'.$bebas['keterangan'].'</td>
                                                <td>'.$siswa['nmSiswa'].' ('.$siswa['nisSiswa'].') '.$r['title'].'</td>
                                                <td>'.$r['noRefrensi'].'</td>';
                                                if ($r['aksi'] == 'Bayar'){
                                                  echo '<td>'.buatRp($r['nominal']).'</td>
                                                        <td align="center">-</td>';
                                                  $total_penerimaan += $r['nominal'];
                                                }elseif ($r['aksi'] == 'Hapus'){
                                                  echo '<td align="center">-</td>
                                                        <td>'.buatRp($r['nominal']).'</td>';
                                                  $total_pengeluaran += $r['nominal'];
                                                }
                                        echo '</tr>';
                                      }elseif ($r['jenisBayar'] == 'Gaji'){
                                        $gaji = mysqli_fetch_array(mysqli_query($koneksi,"SELECT pegawai_gaji_slip.*, pegawai_gaji.idAKunGaji, akun_biaya.kodeAkun as kdAKun, akun_biaya.keterangan FROM pegawai_gaji_slip LEFT JOIN pegawai_gaji ON pegawai_gaji.idGaji=pegawai_gaji.idGaji LEFT JOIN akun_biaya ON pegawai_gaji.idAKunGaji=akun_biaya.idAkun WHERE pegawai_gaji_slip.idSlipGaji='$r[idBayar]'"));
                                        $pegawai =  mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM pegawai WHERE nipPegawai='$r[nis_nip]'"));
                                        echo '<tr>
                                                <td>'.$no++.'</td>
                                                <td>'.tgl_miring(date('Y-m-d',strtotime($r['tanggal']))).'</td>
                                                <td>'.$gaji['kdAKun'].'</td>
                                                <td>'.$gaji['keterangan'].'</td>
                                                <td>'.$pegawai['namaPegawai'].' ('.$pegawai['nipPegawai'].') '.$r['title'].'</td>
                                                <td>'.$r['noRefrensi'].'</td>';
                                                if ($r['aksi'] == 'Bayar'){
                                                  echo '<td align="center">-</td>
                                                        <td>'.buatRp($r['nominal']).'</td>';
                                                  $total_pengeluaran += $r['nominal'];
                                                }elseif ($r['aksi'] == 'Hapus'){
                                                  echo '<td>'.buatRp($r['nominal']).'</td>
                                                        <td align="center">-</td>';
                                                  $total_penerimaan += $r['nominal'];
                                                }
                                        echo '</tr>';
                                      }elseif ($r['jenisBayar'] == 'Kas' && $r['modul'] == 'Kas Masuk' ){
                                        $kas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT kas.*, akun_biaya.kodeAkun as kdAKun, akun_biaya.keterangan FROM kas LEFT JOIN akun_biaya ON kas.idKodeAkun=akun_biaya.idAkun WHERE kas.idKas='$r[idBayar]'"));
                                        
                                        echo '<tr>
                                                <td>'.$no++.'</td>
                                                <td>'.tgl_miring(date('Y-m-d',strtotime($r['tanggal']))).'</td>
                                                <td>'.$kas['kdAKun'].'</td>
                                                <td>'.$kas['keterangan'].'</td>
                                                <td>'.$r['title'].'</td>
                                                <td>'.$r['noRefrensi'].'</td>';
                                                if ($r['aksi'] == 'Simpan Transaksi'){
                                                  echo '<td>'.buatRp($r['nominal']).'</td>
                                                        <td align="center">-</td>';
                                                  $total_penerimaan += $r['nominal'];
                                                }elseif ($r['aksi'] == 'Hapus Transaksi'){
                                                  echo '<td align="center">-</td>
                                                        <td>'.buatRp($r['nominal']).'</td>';
                                                  $total_pengeluaran += $r['nominal'];
                                                }
                                        echo '</tr>';
                                      }elseif ($r['jenisBayar'] == 'Kas' && $r['modul'] == 'Kas Keluar' ){
                                        $kas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT kas.*, akun_biaya.kodeAkun as kdAKun, akun_biaya.keterangan FROM kas LEFT JOIN akun_biaya ON kas.idKodeAkun=akun_biaya.idAkun WHERE kas.idKas='$r[idBayar]'"));
                                        
                                        echo '<tr>
                                                <td>'.$no++.'</td>
                                                <td>'.tgl_miring(date('Y-m-d',strtotime($r['tanggal']))).'</td>
                                                <td>'.$kas['kdAKun'].'</td>
                                                <td>'.$kas['keterangan'].'</td>
                                                <td>'.$r['title'].'</td>
                                                <td>'.$r['noRefrensi'].'</td>';
                                                if ($r['aksi'] == 'Simpan Transaksi'){
                                                  echo '<td>-</td>
                                                        <td align="center">'.buatRp($r['nominal']).'</td>';
                                                  $total_pengeluaran += $r['nominal'];
                                                }elseif ($r['aksi'] == 'Hapus Transaksi'){
                                                  echo '<td>'.buatRp($r['nominal']).'</td>
                                                        <td align="center">-</td>';
                                                  $total_penerimaan += $r['nominal'];
                                                }
                                        echo '</tr>';
                                      }
                                    
                                    }
                ?>
            </tbody>
            <tfoot>
            	<tr style="background-color: #E2F7FF;">
            		<th colspan="5"></th>
                    <th class="text-right">Sub Total</th>
                    <th><?= buatRp($total_penerimaan) ?></th>
                    <th><?= buatRp($total_pengeluaran) ?></th>
                </tr>
                <tr style="background-color: #F0B2B2;">
	                <th colspan="5"></th>
	                <th class="text-right">Saldo Awal</th>
	                <th colspan="2"><?= buatRp($saldo_awal) ?></th>
                </tr>
                <tr style="background-color: #FFFCBE;">
                	<th colspan="5"></th>
                    <th class="text-right"">Total (Masuk + Keluar)</th>
                    <th colspan="2"><?= buatRp($total_penerimaan - $total_pengeluaran) ?></th>
                </tr>
                <tr style="background-color: #c2d2f6;">
                	<th colspan="5"></th>
                	<th class="text-right">Saldo Akhir</th>
                    <th colspan="2"><?= buatRp($saldo_awal + ($total_penerimaan - $total_pengeluaran)) ?></th>
                </tr>
            </tfoot>
         </table>
        </div>
        <div class="box-footer">
          <div class="pull-right">
            <a class="btn btn-success" target="_blank" href="admin/excel/export_log_kasir.php?dari=<?=$_GET[dari]?>&sampai=<?=$_GET[sampai]?>&modul=<?=$_GET[modul]?>&users=<?=$_GET[users]?>"><span class="fa fa-file-excel-o"></span> Cetak Excel</a>
            
          </div>
        </div>
      </div>
    </div>

<?php } ?>