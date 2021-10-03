<?php if ($_GET[act]==''){ ?> 
  
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
        <h3 class="box-title">Filter Data Hutang</h3>
      </div>
      <div class="box-body">
        <form action="" class="form-horizontal" method="get" accept-charset="utf-8">
          <input type="hidden" name="view" value="<?= $_GET['view']?>">
          <div class="form-group">            
            <label for="" class="col-sm-2 control-label">Periode Hutang</label>
            <div class="col-sm-2">
              <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
              <select class="form-control" name="thn_ajar" id="Ctahunajaran"></select>
              </div>
              <label for="" class="col-sm-2 control-label">Cari Kreditur</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="text" class="form-control" autofocus="" name="noref" id="noref" placeholder="Nomor Kreditur" required="" value="<?= $_GET['noref']?>">
                  <span class="input-group-btn">
                    <button class="btn btn-success" type="submit">Cari</button>
                  </span>
                  <span class="input-group-btn">
                  </span>
                  <span class="input-group-btn">
                  </span>
                  <span class="input-group-btn">
                  </span>
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#dataSantri"><b>Data No. Ref</b></button>
                  </span>
                </div>
              </div>
            </div>
          </form>
        </div>
    </div><!-- /.box -->
  </div>


  <div class="modal fade in" id="dataSantri" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Cari Data Kreditur</h4>
        </div>
        <div class="modal-body">
            <div class="box-body table-responsive">
              <table id="example1" class="table table-hover dataTable no-footer">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>No. Ref</th>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>Hutang</th>
                        <th>Jumlah Angsuran</th>
                        <th>Angsuran</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      if($idUnitUsers != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT hutang_setting_detail.*, hutang_setting.idUnit, pegawai.namaPegawai, jabatan_pegawai.namaJabatan FROM hutang_setting_detail LEFT JOIN pegawai ON hutang_setting_detail.idPegawai = pegawai.idPegawai LEFT JOIN jabatan_pegawai ON hutang_setting_detail.idJabatan = jabatan_pegawai.idJabatan LEFT JOIN hutang_setting ON hutang_setting_detail.idSettingHutang = hutang_setting.idSettingHutang WHERE hutang_setting_detail.stdel='0' AND hutang_setting.idUnit='$idUnitUsers' ORDER BY hutang_setting_detail.noRefrensi ASC");
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT hutang_setting_detail.*, hutang_setting.idUnit, pegawai.namaPegawai, jabatan_pegawai.namaJabatan FROM hutang_setting_detail LEFT JOIN pegawai ON hutang_setting_detail.idPegawai = pegawai.idPegawai LEFT JOIN jabatan_pegawai ON hutang_setting_detail.idJabatan = jabatan_pegawai.idJabatan LEFT JOIN hutang_setting ON hutang_setting_detail.idSettingHutang = hutang_setting.idSettingHutang WHERE hutang_setting_detail.stdel='0' ORDER BY hutang_setting_detail.noRefrensi ASC");
                      }
                      
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        echo "<tr>
                              <td>$no</td>
                              <td>".$r['noRefrensi']."</td>
                              <td>".$r['namaPegawai']."</td>
                              <td>".$r['namaJabatan']."</td>
                              <td>".buatRp($r['nominal'])."</td>
                              <td>".$r['jumlahCicil']." Kali</td>
                              <td>".buatRp($r['angsuran'])."</td>
                              <td>
                                <center><button type='button' data-dismiss='modal' class='btn btn-primary btn-xs' onclick=\"ambil_data('$r[noRefrensi]')\">Pilih</button></center>
                              </td>
                            </tr>";
                      $no++;
                      }
                      

                  ?>
                    </tbody>
              </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
          </div>
        </div>
      </div>
  </div>
<?php } ?>

 <script>
    function ambil_data(noRefrensi){
      var noRefrensi    = noRefrensi;
      var thAjaran    = $("#Ctahunajaran").val();
            
      window.location.href = 'index.php?view=<?= $_GET[view]?>&thn_ajar='+thAjaran+'&noref='+noRefrensi;
    }
</script>


<?php if (isset($_GET['thn_ajar']) && isset($_GET['noref'])) { 


$data = mysqli_fetch_array(mysqli_query($koneksi,"SELECT pegawai.*, hutang_setting_detail.*,jabatan_pegawai.namaJabatan, tahun_ajaran.nmTahunAjaran FROM pegawai LEFT JOIN hutang_setting_detail ON pegawai.idPegawai=hutang_setting_detail.idPegawai LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan LEFT JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang LEFT JOIN tahun_ajaran ON hutang_setting.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE hutang_setting_detail.stdel='0' AND hutang_setting_detail.noRefrensi='$_GET[noref]'"));

$thn = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$_GET[thn_ajar]'"));

if (empty($data['fotoPegawai'])){
  $fotoPegawai = $lokasi_default_fotoPegawai;
}else{
  $fotoPegawai = $lokasi_penyimpanan_fotoPegawai.$data['fotoPegawai'];
}

  //ambil total pembayaran cicilan
  $totalTerlunasi = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as totalTerlunasi FROM hutang_bayar WHERE idDetailHutang='$data[idDetailHutang]' AND keterangan='Lunas' AND stdel='0'"));


  if (isset($_POST[simpan_bayar_cicilan])){

    $query = mysqli_query($koneksi,"UPDATE hutang_bayar SET tanggalBayar='$tanggal_sekarang', idAkunKas='$_POST[id_akun_kas]', keterangan='Lunas', uby='$idUsers', udate='$waktu_sekarang' WHERE idBayarHutang='$_POST[id_bayar_hutang]'");

    if ($query){
      $info = 'NIP:'.$data['nipPegawai'].';Title:Input Bayar Hutang Tahun '.$thn['nmTahunAjaran'].' No. Ref '.$data['noRefrensi'].' angsuran '.$_POST['cicilan'].' nominal '.$_POST['nominal_cicilan'];
      mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Pembayaran','Simpan Bayar Hutang','$info','$idUsers','$browser_ok','$user_os','$ip')");
      
      $_SESSION['notif'] = 'csukses';
      echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&noref=$_GET[noref]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&noref=$_GET[noref]';</script>";
    }  
   
  }

  if (isset($_POST[hapus_bayar_cicilan])){
    $query = mysqli_query($koneksi,"UPDATE hutang_bayar SET tanggalBayar=null,idAkunKas=null,keterangan='Belum Lunas', uby='$idUsers', udate='$waktu_sekarang' WHERE idBayarHutang='$_POST[id_bayar_hutang]'");
   
    if ($query){
      $info = 'NIP:'.$data['nipPegawai'].';Title:Hapus Bayar Hutang Tahun '.$thn['nmTahunAjaran'].' No. Ref '.$data['noRefrensi'].' angsuran '.$_POST['cicilan'].' nominal '.$_POST['nominal_cicilan'];
      mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Pembayaran','Hapus Bayar Hutang','$info','$idUsers','$browser_ok','$user_os','$ip')");
      
      $_SESSION['notif'] = 'dsukses';
      echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&noref=$_GET[noref]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&noref=$_GET[noref]';</script>";
    } 
  }
?> 
<div class="col-md-12">
      
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Informasi Kreditur</h3>
            <a href="admin/laporan/buku_pembayaran_hutang.php?noref=<?= $_GET[noref] ?>" target="_blank" class="btn btn-danger btn-xs pull-right">Cetak Buku Hutang</a>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="col-md-9">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <td width="200">Periode Hutang</td><td width="4">:</td>
                    <td><?= $thn['nmTahunAjaran'] ?></td> 
                    <td width="200">Dicicil</td><td width="4">:</td>
                    <td><?= $data['jumlahCicil'] ?> Kali</td> 
                  </tr>
                  <tr>
                    <td>Nama Kreditur</td>
                    <td>:</td>
                    <td><?= $data['namaPegawai'] ?></td> 
                    <td width="200">Nominal per Cicilan</td><td width="4">:</td>
                    <td><?= buatRp($data['angsuran']) ?></td> 
                  </tr>
                  <tr>
                    <td>Posisi</td>
                    <td>:</td>
                    <td><?= $data['namaJabatan'] ?></td> 
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>No. Ref Hutang</td>
                    <td>:</td>
                    <td><?= $data['noRefrensi'] ?></td> 
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>Tanggal Hutang</td>
                    <td>:</td>
                    <td><?= tgl_raport($data['tanggal']) ?></td> 
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td>Nominal Hutang</td>
                    <td>:</td>
                    <td><?= buatRp($data['nominal']) ?></td> 
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-3">
              <img src="<?= $fotoPegawai ?>" class="img-thumbnail img-responsive">
            </div>
          </div>
        </div>
        <div class="row">

          <div class="col-md-5">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Transaksi Terakhir</h3>
              </div><!-- /.box-header -->
              
              <div class="box-body table-responsive">
                  <table class="table table-responsive table-bordered">
                    <thead>
                       <tr class="info">
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $tampil = mysqli_query($koneksi,"SELECT * FROM hutang_bayar WHERE idDetailHutang='$data[idDetailHutang]' AND stdel='0' AND keterangan='Lunas' ORDER BY idBayarHutang DESC LIMIT 5");
                      
                      while($r=mysqli_fetch_array($tampil)){
                        echo "<tr>
                              <td>".date('d/m/Y',strtotime($r['tanggalBayar']))."</td>
                              <td>".buatRp($r['nominal'])."</td>
                              <td>".$r['keterangan']."</td>
                            </tr>";
                      }
                      ?>
                    
                    </tbody>
                  </table>
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Rekap Hutang</h3>
              </div>
              <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Total Hutang</label>
                        <input type="text" class="form-control" name="total_setor" id="total_setor" value="<?= buatRp($data['nominal']) ?>" placeholder="Total Setoran" readonly="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Total Terlunasi</label>
                        <input type="text" class="form-control" name="total_tarik" id="total_tarik" value="<?= buatRp($totalTerlunasi['totalTerlunasi']) ?>" placeholder="Total Penarikan" readonly="">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Belum Lunas</label>
                    <input type="text" class="form-control" readonly="" name="saldo" id="saldo" value="<?= buatRp($data['nominal'] - $totalTerlunasi['totalTerlunasi']) ?>" placeholder="Sisa Hutang">
                  </div>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Cetak Bukti Transaksi</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                <form action="admin/laporan/bukti_pembayaran_hutang.php" method="GET" class="view-pdf">
                  <input type="hidden" name="thn_ajar" value="<?= $_GET[thn_ajar] ?>">
                  <input type="hidden" name="noref" value="<?= $_GET[noref] ?>">
                  <div class="form-group">
                    <label>Tanggal Transaksi</label>
                    <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      <input class="form-control " readonly="" required="" type="text" name="tgl" value="<?= date('Y-m-d') ?>">
                    </div>
                  </div>
                  <button class="btn btn-success btn-block" formtarget="_blank" type="submit">Cetak</button>
                </form>
              </div>
            </div>
          </div>
        </div>      

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Cicil Hutang</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
              
            <div class="row">
              <div class="col-md-3">
                <label>Akun Kas *</label>
                <input type="hidden" id="idUnitPegawai" class="form-control" value="<?= $data[unitPegawai] ?>" readonly="">
                <select name="id_akun_kas" id="Cakunkas" class="form-control" required="">
                  <option value="" disabled="" selected="">- Pilih Akun Kas -</option>          
                </select>                  
              </div>
            </div>
            <br>
            <div class="nav-tabs-custom">
              <div class="tab-content">
                <div class="box-body table-responsive">
                  <table class="table table-responsive table-bordered" id="example" style="white-space: nowrap;">
                    <thead>
                      <tr class="info">
                        <th>No</th>
                        <th>Cicilan</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $tampil = mysqli_query($koneksi,"SELECT hutang_bayar.*, hutang_setting_detail.idPegawai, pegawai.namaPegawai,hutang_setting.idPosHutang, hutang_pos.idAkunHutang FROM hutang_bayar LEFT JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang LEFT JOIN pegawai ON hutang_setting_detail.idPegawai=pegawai.idPegawai LEFT JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang LEFT JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_setting.idTahunAjaran='$_GET[thn_ajar]' AND hutang_bayar.idDetailHutang='$data[idDetailHutang]' AND hutang_bayar.stdel='0'");
                        $no=1;
                        while($r=mysqli_fetch_array($tampil)){
                          echo '<tr>
                                  <td>'.$no.'</td>
                                  <td>'.$r['cicilan'].'</td>
                                  <td>'.buatRp($r['nominal']).'</td>
                                  <td>'.$r['keterangan'].'</td>';
                                  if ($r['keterangan'] == 'Lunas'){
                                    echo '<td><a href="#" data-toggle="modal" data-target="#hapus'.$r['idBayarHutang'].'"><button class="btn btn-sm btn-danger" type="button">Hapus</button></a></td>';
                                  }else{
                                    echo '<td><a href="#" data-toggle="modal" data-target="#bayar'.$r['idBayarHutang'].'" onclick="copy_data('.$no.')"><button class="btn btn-sm btn-success" type="button">Bayar</button></a></td>';
                                  }
                          echo '</tr>';

                          echo '<div class="modal fade" id="bayar'.$r['idBayarHutang'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <form action="" method="POST" role="form">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          <h4 class="modal-title" id="myModalLabel">Tambah Pembayaran Cicilan</h4> 
                                        </div>
                                        <div class="modal-body">
                                          <input type="hidden" name="id_bayar_hutang" class="form-control" value="'.$r['idBayarHutang'].'" readonly="">
                                          <input type="hidden" name="id_akun_kas" id="id_akun_kas'.$no.'" class="form-control" readonly="">
                                          <input type="hidden" name="nominal_cicilan" class="form-control" value="'.$r['nominal'].'" readonly="">
                                          <input type="hidden" name="cicilan" class="form-control" value="'.$r['cicilan'].'" readonly="">
                                          Anda Akan Melakukan Pembayaran Cicilan ini ?
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
                                          <button type="submit" name="simpan_bayar_cicilan" class="btn btn-success pull-right"><span class="fa fa-check"></span> Ya</button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>';

                          echo '<div class="modal fade" id="hapus'.$r['idBayarHutang'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <form action="" method="POST" role="form">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          <h4 class="modal-title" id="myModalLabel">Hapus Pembayaran Cicilan</h4> 
                                        </div>
                                        <div class="modal-body">
                                          <input type="hidden" name="id_bayar_hutang" class="form-control" value="'.$r['idBayarHutang'].'" readonly="">
                                          <input type="hidden" name="nominal_cicilan" class="form-control" value="'.$r['nominal'].'" readonly="">
                                          <input type="hidden" name="cicilan" class="form-control" value="'.$r['cicilan'].'" readonly="">
                                          Anda Akan Menghapus Pembayaran Cicilan ini?
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-success pull-right" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
                                          <button type="submit" name="hapus_bayar_cicilan" class="btn btn-danger pull-right"><span class="fa fa-check"></span> Ya</button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>
                                </div>';
                          $no++;
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

<script type="text/javascript">
  function copy_data(no) {
    var id_akun_kas  = $("#Cakunkas").val();

    $("#id_akun_kas"+no).val(id_akun_kas);
  }
</script>