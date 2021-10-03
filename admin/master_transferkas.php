<?php if ($_GET[act]==''){ ?> 
  
  <?php
    //notif
    if ($_SESSION['notif'] == 'csukses'){
      echo '<script>toastr["success"]("Proses transfer berhasil.","Sukses!")</script>';
    }elseif ($_SESSION['notif'] == 'dsukses'){
      echo '<script>toastr["success"]("Data transfer dihapus.","Sukses!")</script>';
    }elseif($_SESSION['notif'] == 'gagal'){
      echo '<script>toastr["error"]("Data gagal diproses.","Gagal!")</script>';
    }unset($_SESSION['notif']);

  ?>

      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Filter Data Akun</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="form-group">
              <form action="" class="form-horizontal" method="get" accept-charset="utf-8">
                <input type="hidden" name="view" value="<?= $_GET[view] ?>">
                <div class="row">
                  <div class="col-md-6">
                    <label class="col-sm-3 control-label">Unit Pesantren</label>
                    <div class="col-sm-5">
                      <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                      <select class="form-control" name="unit" id="Cunit" required></select>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <label for="" class="col-sm-3 control-label">Akun Kas</label>
                      <div class="col-sm-6">
                        <input type="hidden" id="idAkunKas" value="<?= $_GET[akun] ?>">
                        <input type="hidden" id="idUnitPegawai" value="<?= $_GET[unit] ?>">
                        <select class="form-control" name="akun" id="Cakunkas" required>
                          <option>- Pilih Akun Kas</option>
                        </select>
                      </div>
                      <span class="input-group-btn">
                        <button class="btn btn-success" type="submit">Cari</button>
                      </span>
                  </div>
                </div>
              </form>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div>

      <?php if (isset($_GET['unit']) && isset($_GET['akun'])) {  

        $unit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$_GET[unit]'"));
        $akun = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE idAkun='$_GET[akun]'"));

        //transfer
        if (isset($_POST['simpan_transfer'])){
          $query = mysqli_query($koneksi,"INSERT INTO kas(jenis,tipe,tanggal,idUnitSekolah,noRefrensi,idAkunKas,idAkunKasTujuan,idTahunAjaran, keterangan,total,stdel,cby,cdate) VALUES ('Keluar','Transfer','$_POST[tanggal]','$_POST[id_unit]','$_POST[noref]','$_POST[id_akun_kas]','$_POST[id_akun_kas_tujuan]','$_POST[id_tahun_ajaran]','Transfer Kas','$_POST[total_transfer]','0','$idUsers','$waktu_sekarang')");
          $query1 = mysqli_query($koneksi,"INSERT INTO kas(jenis,tipe,tanggal,idUnitSekolah,noRefrensi,idAkunKas,idAkunKasTujuan,idTahunAjaran, keterangan,total,stdel,cby,cdate) VALUES ('Masuk','Transfer','$_POST[tanggal]','$_POST[id_unit]','$_POST[noref]','$_POST[id_akun_kas_tujuan]','$_POST[id_akun_kas]','$_POST[id_tahun_ajaran]','Terima Transfer Kas','$_POST[total_transfer]','0','$idUsers','$waktu_sekarang')");
          if ($query & $query1){
            $_SESSION['notif'] = 'csukses';
            echo "<script>document.location='index.php?view=$_GET[view]&unit=$_GET[unit]&akun=$_GET[akun]';</script>";
          }else{
            $_SESSION['notif'] = 'gagal';
            echo "<script>document.location='index.php?view=$_GET[view]&unit=$_GET[unit]&akun=$_GET[akun]';</script>";
          }
        }
      ?>

        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Informasi Akun</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-9">
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <td>Unit Pesantren</td>
                      <td>:</td>
                      <td><?= $unit['singkatanUnit']; ?></td> 
                    </tr>
                    <tr>
                      <td>Nama Akun</td>
                      <td>:</td>
                      <td><?= $akun['keterangan'] ?></td> 
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Riwayat Transaksi</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="box-body">
              <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#addDebit"><i class="fa fa-plus"></i> Transfer</button>
            </div>
            <div class="box-body table-responsive">
              <table class="table table-bordered" style="white-space: nowrap;">
                <thead>
                  <tr class="info">
                    <th>No.</th>
                    <th>No. Ref</th>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                      $tampil = mysqli_query($koneksi,"SELECT * FROM kas WHERE stdel='0' AND tipe='Transfer' AND idAkunKas='$_GET[akun]' ORDER BY idKas DESC");
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){ 
                        $ket_akun = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE akun_biaya.idAkun='$r[idAkunKasTujuan]'"));
                        if ($r['jenis'] == 'Masuk'){
                          $keterangan = $r['keterangan'].' dari akun '.$ket_akun['keterangan'];
                          $aksi = "";
                        }else{
                          $keterangan = $r['keterangan'].' ke akun '.$ket_akun['keterangan'];
                          $aksi = "<a class='btn btn-danger btn-xs' href='#' data-toggle='modal' data-target='#hapus".$r[idKas]."'><span class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus'></span></a>";
                        }
                        

                        echo "<tr><td>".$no++."</td>
                                <td>".$r['noRefrensi']."</td>
                                <td>".date('d/m/Y',strtotime($r['tanggal']))."</td>
                                <td>".buatRp($r['total'])."</td>
                                <td>".$keterangan."</td>
                                <td>".$aksi."</td>";

                         echo '<div class="modal fade" id="hapus'.$r[idKas].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <form action="" method="POST" role="form">
                                            <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel"><span class="fa fa-exclamation-triangle"></span> Hapus Data</h4> 
                                              </div>
                                              <div class="modal-body">
                                                <input type="hidden" name="id_kas" value="'.$r[idKas].'">
                                                Apakah anda ingin menghapus data ini?
                                              </div>
                                              <div class="modal-footer">
                                                <button type="submit" name="hapus" class="btn btn-danger pull-right"><span class="fa fa-check"></span> Hapus</button>
                                                  <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
                                              </div>
                                          </div>
                                      </div>
                                    </form>
                                  </div>';
                        echo "<tr>";
                      } 

                      if (isset($_POST['hapus'])){
                          $id_lanjut = $_POST['id_kas'] + 1;
                          $query = mysqli_query($koneksi,"UPDATE kas SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idKas='$_POST[id_kas]'");
                          $query1 = mysqli_query($koneksi,"UPDATE kas SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idKas='$id_lanjut'");
                          
                          if($query && $query1){
                            $_SESSION['notif'] = 'dsukses';
                          }else{
                            $_SESSION['notif'] = 'gagal';
                          }
                          echo "<script>document.location='index.php?view=$_GET[view]&unit=$_GET[unit]&akun=$_GET[akun]';</script>";
                        }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>


    <div class="modal fade" id="addDebit" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title">Transfer Kas</h4>
          </div>
          <div class="modal-body">
            <form action="" method="post" accept-charset="utf-8">
              <input type="hidden" class="form-control" name="id_akun_kas" value="<?= $akun['idAkun']?>">
              <input type="hidden" class="form-control" name="id_unit" value="<?= $akun['unitSekolah']?>">
              <input type="hidden" class="form-control" name="noref" id="noref">
              <input type="hidden" class="form-control" name="id_tahun_ajaran" value="<?= $ta['idTahunAjaran']?>">
          
              <div class="form-group">
                <label>Tanggal</label>
                <div class="input-group date datepicker" data-date="" data-date-format="yyyy-mm-dd">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input class="form-control" required="" type="text" name="tanggal" value="<?= $tanggal_sekarang ?>" placeholder="Tanggal Setor" readonly="">
                </div>
              </div>
            
              <div class="form-group">
                <label>Akun Tujuan</label>
                <select class="form-control" name="id_akun_kas_tujuan" id="Cakunkastujuan">
                </select>
              </div>
              <div class="form-group">
                <label>Nominal</label>
                <input type="text" class="form-control" required="" name="total_transfer" placeholder="Jumlah Setoran">
              </div>
            
            </div>
            <div class="modal-footer">
              <button type="submit" name="simpan_transfer" class="btn btn-info">Transfer</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>

      <?php } ?>
<?php 
}
?>

<script type="text/javascript">
  $(document).ready(function(){
    var id_unit    = $("#idUnit").val();
              
    $.ajax({ 
      url: 'admin/kas/cari_noref.php',
      type: 'POST', 
      data: {
              'tipe' : 'Keluar',
              'id_unit' : id_unit,
      },
      cache: false,    
      success: function(msg) {
        $("#noref").val(msg);
      },
      error: function(msg){
        toastr["error"]("msg","Gagal!"); 
      }
    });
  });
</script>