<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success">
                <div class="box-header with-border">
                  <a class='pull-left btn btn-success btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=tambah'>Tambah</a>
                  <br><br>
                  <form action="" class="form-horizontal" method="GET" accept-charset="utf-8">
                    <div class="box-body table-responsive">
                      <table>
                        <tbody>
                          <tr>
                            <td>     
                              <input type="hidden" name="view" value="<?= $_GET[view] ?>">
                              <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                              <input type="hidden" id="tipe_unit" value="pencarian">
                              <select style="width: 200px;" id="Cunit" name="unit" class="form-control" required></select>
                          </td>
                          <td>
                            &nbsp;&nbsp;
                          </td>
                          <td>
                            <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Cari</button>    
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </form>
                </div><!-- /.box-header -->
                <div class="box-body">
                <div class="table-responsive">
                  <?php 
                    if ($_SESSION['notif'] == 'csukses'){
                      echo '<script>toastr["success"]("Data berhasil disimpan.","Sukses!")</script>';
                    }elseif ($_SESSION['notif'] == 'usukses'){
                      echo '<script>toastr["success"]("Data berhasil diupdate.","Sukses!")</script>';
                    }elseif ($_SESSION['notif'] == 'dsukses'){
                      echo '<script>toastr["success"]("Data berhasil dihapus.","Sukses!")</script>';
                    }elseif($_SESSION['notif'] == 'gagal'){
                      echo '<script>toastr["error"]("Data gagal diproses.","Gagal!")</script>';
                    }elseif($_SESSION['notif'] == 'gagalhapus'){
                      echo '<script>toastr["error"]("Data gagal dihapus.","Gagal!")</script>';
                    }
                    unset($_SESSION['notif']);
                  ?>
                  <table id="example1" class="table table-hover dataTable no-footer">
          					<thead>
          					  <tr>
          						  <th>No</th>
                        <th>Pos Hutang</th>
                        <th>Nama Hutang</th>
          						  <th>Tahun</th>
                        <th>Jumlah Hutang</th>
          						  <th>Aksi</th>
          					  </tr>
          					</thead>
          					<tbody>
                    <?php 
                      if (isset($_GET['unit'])){
                        if ($_GET['unit'] != 'all'){
                          $tampil = mysqli_query($koneksi,"SELECT hutang_setting.*, hutang_pos.namaPosHutang, tahun_ajaran.nmTahunAjaran FROM hutang_setting LEFT JOIN hutang_pos ON hutang_setting.idPosHutang = hutang_pos.idPosHutang LEFT JOIN tahun_ajaran ON hutang_setting.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE hutang_setting.stdel='0' AND hutang_setting.idUnit='$_GET[unit]' ORDER BY hutang_setting.idSettingHutang DESC");
                        }else{
                          $tampil = mysqli_query($koneksi,"SELECT hutang_setting.*, hutang_pos.namaPosHutang, tahun_ajaran.nmTahunAjaran FROM hutang_setting LEFT JOIN hutang_pos ON hutang_setting.idPosHutang = hutang_pos.idPosHutang LEFT JOIN tahun_ajaran ON hutang_setting.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE hutang_setting.stdel='0' ORDER BY hutang_setting.idSettingHutang DESC");
                        }
                      }elseif($idUnitUsers != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT hutang_setting.*, hutang_pos.namaPosHutang, tahun_ajaran.nmTahunAjaran FROM hutang_setting LEFT JOIN hutang_pos ON hutang_setting.idPosHutang = hutang_pos.idPosHutang LEFT JOIN tahun_ajaran ON hutang_setting.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE hutang_setting.stdel='0' AND hutang_setting.idUnit='$idUnitUsers' ORDER BY hutang_setting.idSettingHutang DESC");
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT hutang_setting.*, hutang_pos.namaPosHutang, tahun_ajaran.nmTahunAjaran FROM hutang_setting LEFT JOIN hutang_pos ON hutang_setting.idPosHutang = hutang_pos.idPosHutang LEFT JOIN tahun_ajaran ON hutang_setting.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE hutang_setting.stdel='0' ORDER BY hutang_setting.idSettingHutang DESC");
                      }
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        echo "<tr><td>$no</td>
                                <td>".$r['namaPosHutang']."</td>
                                <td>".$r['namaPosHutang']." - T.A ".$r[nmTahunAjaran]."</td>
                                <td>".$r['nmTahunAjaran']."</td>
                                <td>
                                  <a data-toggle='tooltip' data-placement='top' title='' class='btn btn-primary btn-xs' href='?view=$_GET[view]&act=detail&id=$r[idSettingHutang]' data-original-title='Ubah'>Setting Jumlah Hutang</a>
                                </td>
                                <td><center>
                                  <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idSettingHutang]'><span class='fa fa-edit'></span></a>
                                </center></td>";
                        echo "</tr>";

                        
                        $no++;
                      }
                      ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
<?php 
}elseif($_GET[act]=='edit'){
  if (isset($_POST[update])){ 
    $query = mysqli_query($koneksi,"UPDATE hutang_setting SET idUnit='$_POST[id_unit]', idPosHutang='$_POST[id_pos_hutang]', idTahunAjaran='$_POST[id_tahun_ajaran]', uby='$idUsers', udate='$waktu_sekarang' WHERE idSettingHutang = '$_POST[id]' AND stdel='0'");
    
    if ($query){
      $_SESSION['notif'] = 'usukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
  }
  if (isset($_POST[hapus])){
    $cek_data = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM hutang_setting_detail WHERE idSettingHutang='$_POST[id_setting_hutang]' AND stdel='0'"));
    if ($cek_data == 0){
      $query = mysqli_query($koneksi,"UPDATE hutang_setting SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idSettingHutang='$_POST[id_setting_hutang]'");
      if($query){
        $_SESSION['notif'] = 'dsukses';
        echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      }else{
        $_SESSION['notif'] = 'gagal';
        echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      }
    }else{
      $_SESSION['notif'] = 'gagalhapus';
        echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
    
  }

  $edit = mysqli_query($koneksi,"SELECT * FROM hutang_setting WHERE idSettingHutang='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>

  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
          <input type="hidden" name="id" value="<?= $record['idSettingHutang'] ?>">
           <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
           <input type="hidden" id="idUnit" value="<?= $record['idUnit'] ?>">
          <select name="id_unit" class="form-control" required id="Cunit"></select>  
          <br>
          <label>Pos Hutang <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="hidden" id="idPosHutang" value="<?= $record['idPosHutang'] ?>">
          <select name="id_pos_hutang" class="form-control" required id="Cposhutang">
            <option disabled="" selected="">- Pilih Pos Hutang -</option>
          </select>  
          <br>
          <label>Tahun Ajaran <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="hidden" id="idTahunAjaran" value="<?= $record['idTahunAjaran'] ?>">
          <select name="id_tahun_ajaran" class="form-control" required id="Ctahunajaran2"></select> 
          <br>
          <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="box box-success">
        <div class="box-body">
          <button name="update" type="submit" value="Simpan" class="btn btn-block btn-success">Simpan</button>
          <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-default">Batal</a>
          <a href='#' data-toggle='modal' data-target='#hapus<?= $record[idSettingHutang] ?>' class='btn btn-block btn-danger'>Hapus</a>
        </div>
      </div>
    </div>

  </form>

  
  <div class="modal fade" id="hapus<?= $record[idSettingHutang] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act]?>" method="POST" role="form">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><span class="fa fa-exclamation-triangle"></span> Hapus Data</h4> 
          </div>
          <div class="modal-body">
            <input type="hidden" name="id_setting_hutang" value="<?= $record[idSettingHutang] ?>">
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



<?php }elseif($_GET[act]=='tambah'){

  if (isset($_POST[tambah])){
    $query = mysqli_query($koneksi,"INSERT INTO hutang_setting(idUnit,idPosHutang,idTahunAjaran,stdel,cby,cdate) VALUES('$_POST[id_unit]','$_POST[id_pos_hutang]','$_POST[id_tahun_ajaran]','0','$idUsers','$waktu_sekarang')");
    
    if ($query){
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      $_SESSION['notif_detail'] = 'csukses';
    }else{
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      $_SESSION['notif_detail'] = 'gagal';
    }  
  }

?>
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
          <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <select name="id_unit" class="form-control" required id="Cunit"></select>  
          <br>
          <label>Pos Hutang <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <select name="id_pos_hutang" class="form-control" required id="Cposhutang">
            <option disabled="" selected="">- Pilih Pos Hutang -</option>
          </select>  
          <br>
          <label>Tahun Ajaran <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <select name="id_tahun_ajaran" class="form-control" required id="Ctahunajaran2"></select> 
          <br>
          <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="box box-success">
        <div class="box-body">
          <button name="tambah" type="submit" value="Simpan" class="btn btn-block btn-success">Simpan</button>
          <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
        </div>
      </div>
    </div>

  </form>


<?php }elseif($_GET[act]=='detail'){ 

  $edit = mysqli_query($koneksi,"SELECT hutang_setting.*, hutang_pos.namaPosHutang, tahun_ajaran.nmTahunAjaran FROM hutang_setting LEFT JOIN hutang_pos ON hutang_setting.idPosHutang = hutang_pos.idPosHutang LEFT JOIN tahun_ajaran ON hutang_setting.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE idSettingHutang='$_GET[id]'");
  $record = mysqli_fetch_array($edit);


?>

 <?php 
    if ($_SESSION['notif_detail'] == 'sukses_detail'){
      echo '<script>toastr["success"]("Data debitur hutang berhasil disimpan.","Sukses!")</script>';
    }elseif ($_SESSION['notif_detail'] == 'gagal_detail'){
      echo '<script>toastr["error"]("Data debitur hutang gagal disimpan.","Gagal!")</script>';
    }elseif ($_SESSION['notif_detail'] == 'sukses_update'){
      echo '<script>toastr["success"]("Data debitur hutang berhasil diupdate.","Sukses!")</script>';
    }elseif($_SESSION['notif_detail'] == 'gagal_update'){
      echo '<script>toastr["error"]("Data debitur hutang gagal diupdate.","Gagal!")</script>';
    }elseif ($_SESSION['notif_detail'] == 'sukses_delete'){
      echo '<script>toastr["success"]("Data debitur hutang berhasil dihapus.","Sukses!")</script>';
    }elseif($_SESSION['notif_detail'] == 'gagal_delete'){
      echo '<script>toastr["error"]("Data debitur hutang gagal dihapus.","Gagal!")</script>';
    }
    unset($_SESSION['notif_detail']);
  ?>


  <div class="col-xs-12"> 
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Jumlah - <?= $record['namaPosHutang'].' - '.$record['nmTahunAjaran'] ?></h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="form-group">            
              <label for="" class="col-sm-1 control-label">Tahun</label>
              <div class="col-sm-2">
                <input type="text" class="form-control" value="<?= $record['nmTahunAjaran'] ?>" readonly="">
              </div>
              <label for="" class="col-sm-1">Setting Hutang</label>
                  <div class="col-sm-2">
                    <a class="btn btn-primary btn-sm" href="?view=<?= $_GET[view] ?>&act=tambah detail&id=<?= $record[idSettingHutang] ?>"><span class="glyphicon glyphicon-plus"></span> Kepada Kreditur</a>
                  </div>
                  
                  <div class="col-sm-1">
                    <a class="btn btn-default btn-sm" href="index.php?view=<?= $_GET[view] ?>"><span class="glyphicon glyphicon-repeat"></span> Kembali</a>
                  </div>
            </div>
        </div><!-- /.box-body -->
      </div><!-- /.box -->

        <div class="box box-success">
          <div class="box-body table-responsive">
            <table id="example1" class="table table-hover dataTable no-footer">
              <thead>
                <th>No</th>
                <th>No. Ref</th>
                <th>Nama</th>
                <th>Posisi</th>
                <th>Hutang</th>
                <th>Jumlah Angsuran</th>
                <th>Angsuran</th>
                <th>Aksi</th>
              </thead> 
              <tbody>
                <?php
                  $tampil=mysqli_query($koneksi,"SELECT hutang_setting_detail.*, pegawai.namaPegawai, jabatan_pegawai.namaJabatan FROM hutang_setting_detail LEFT JOIN pegawai ON hutang_setting_detail.idPegawai = pegawai.idPegawai LEFT JOIN jabatan_pegawai ON hutang_setting_detail.idJabatan = jabatan_pegawai.idJabatan WHERE hutang_setting_detail.stdel='0'");
                  $no = 1;
                  while($r=mysqli_fetch_array($tampil)){
                        echo "<tr><td>$no</td>
                                <td>".$r['noRefrensi']."</td>
                                <td>".$r['namaPegawai']."</td>
                                <td>".$r['namaJabatan']."</td>
                                <td>".buatRp($r['nominal'])."</td>
                                <td>".$r['jumlahCicil']." Kali</td>
                                <td>".buatRp($r['angsuran'])."</td>
                                <td><center>
                                  <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit detail&id=$_GET[id]&detail=$r[idDetailHutang]'><span class='fa fa-edit'></span></a>
                                  <a href='#hapus".$r['idDetailHutang']."' data-toggle='modal' class='btn btn-xs btn-danger'><i class='fa fa-trash' data-toggle='tooltip; title='' data-original-title='Hapus'></i></a>
                                </center></td>";
                        echo "</tr>";

                        echo ' <div class="modal fade" id="hapus'.$r['idDetailHutang'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                  <form action="index.php?view='.$_GET[view].'&act='.$_GET[act].'&id='.$_GET[id].'" method="POST" role="form">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                          <h4 class="modal-title" id="myModalLabel"><span class="fa fa-exclamation-triangle"></span> Hapus Data</h4> 
                                        </div>
                                        <div class="modal-body">
                                          <input type="hidden" name="iddetail" value="'.$r['idDetailHutang'].'">
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
                        
                        $no++;
                  }

                  if (isset($_POST[hapus])){
                    $query = mysqli_query($koneksi,"UPDATE hutang_setting_detail SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idDetailHutang='$_POST[iddetail]'");
                    mysqli_query($koneksi,"UPDATE hutang_bayar SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idDetailHutang='$_POST[iddetail]'");
                    if($query){
                      $_SESSION['notif_detail'] = 'sukses_delete';
                      echo "<script>document.location='index.php?view=$_GET[view]&act=detail&id=$_GET[id]';</script>";
                    }else{
                      $_SESSION['notif_detail'] = 'gagal_delete';
                      echo "<script>document.location='index.php?view=$_GET[view]&act=detail&id=$_GET[id]';</script>";
                    }
                  }

                ?>
              </tbody>
            </table>
        </div>
      </div>
    </div>


<?php }elseif($_GET[act]=='tambah detail'){ 

  $edit = mysqli_query($koneksi,"SELECT hutang_setting.*, hutang_pos.namaPosHutang, tahun_ajaran.nmTahunAjaran FROM hutang_setting LEFT JOIN hutang_pos ON hutang_setting.idPosHutang = hutang_pos.idPosHutang LEFT JOIN tahun_ajaran ON hutang_setting.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE idSettingHutang='$_GET[id]'");
  $record = mysqli_fetch_array($edit);

  if (isset($_POST[simpan_hutang])){
    $query = mysqli_query($koneksi,"INSERT INTO hutang_setting_detail(noRefrensi,tanggal,idSettingHutang,idJabatan,idPegawai,nominal,jumlahCicil,angsuran,stdel,cby,cdate) VALUES('$_POST[hutang_noref]','$tanggal_sekarang','$_POST[id_setting_hutang]','$_POST[id_jabatan]','$_POST[id_pegawai]','$_POST[nominal_hutang]','$_POST[cicil]','$_POST[nominal_cicilan]','0','$idUsers','$waktu_sekarang')");
    for ($i=1; $i <= $_POST['cicil']; $i++) { 
      $idDetailHutang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM hutang_setting_detail ORDER BY idDetailHutang DESC LIMIT 1"));
      mysqli_query($koneksi,"INSERT INTO hutang_bayar(idDetailHutang,cicilan,nominal,keterangan,stdel,cby,cdate) VALUES('$idDetailHutang[idDetailHutang]','Cicilan $i','$_POST[nominal_cicilan]','Belum Lunas','0','$idUsers','$waktu_sekarang')");
    }
    if ($query){
      $_SESSION['notif_detail'] = 'sukses_detail';
      echo "<script>document.location='index.php?view=$_GET[view]&act=detail&id=$_GET[id]';</script>";
    }else{
      $_SESSION['notif_detail'] = 'gagal_detail';
      echo "<script>document.location='index.php?view=$_GET[view]&act=detail&id=$_GET[id]';</script>";
    }  
  }

?>

    <div class="box-body">
      <form action="" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
          
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Informasi Hutang</h3>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="" class="col-sm-4 control-label">Jenis Bayar</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" value="<?= $record['namaPosHutang'].' - '.$record['nmTahunAjaran'] ?>" readonly="">
                  </div>
                </div>
                <div class="form-group">            
                  <label for="" class="col-sm-4 control-label">Tahun Ajaran</label>
                  <div class="col-sm-8">
                    <input type="hidden" name="id_tahun_ajaran" class="form-control" value="<?= $record['idTahunAjaran'] ?>" readonly="">
                    <input type="text" class="form-control" value="<?= $record['nmTahunAjaran'] ?>" readonly="">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="box box-success">
              <div class="box-header">
                <h3 class="box-title">Jumlah Hutang</h3>
              </div>
              <div class="box-body table-responsive">
                <input type="hidden" name="id_setting_hutang" value="<?= $_GET[id] ?>">
                <table class="table">
                  <tbody>
                    <tr>
                      <td><strong>No. Ref Hutang</strong></td>
                      <td><input type="text" name="hutang_noref" id="hutang_noref" readonly="" class="form-control" value="<?= noRefHutang($koneksi,'HT'.date(dmy), $tanggal_sekarang, '-2')?>">
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Posisi</strong></td>
                      <td>
                        <input type="hidden" id="idUnit" value="<?= $record[idUnit]?>">
                        <select id="Cjabatan" name="id_jabatan" class="form-control">
                            <option value="">-- Pilih Posisi --</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Nama Kreditur</strong></td>
                      <td>
                        <select name="id_pegawai" id="Cpegawai" class="form-control">
                          <option value="">-- Pilih Kreditur --</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Nominal Hutang (Rp.)</strong></td>
                      <td><input type="text" name="nominal_hutang" id="nominal_hutang" placeholder="Masukan Jumlah Hutang" required="" class="form-control" onkeyup="count_hutang()">
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Dicicil (berapa kali)</strong></td>
                      <td><input type="text" name="cicil" id="cicil" placeholder="Masukan Jumlah Hutang" required="" class="form-control" onkeyup="count_hutang()">
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Nominal per Cicilan (Rp.)</strong></td>
                      <td><input type="text" name="nominal_cicilan" id="nominal_cicilan" placeholder="Masukan Jumlah Hutang" readonly="" class="form-control">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="box-footer">
                <button type="submit" name="simpan_hutang" class="btn btn-success">Simpan</button>
                <a href="index.php?view=<?= $_GET[view] ?>&act=detail&id=<?= $_GET[id] ?>" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </div>          
          </form>       
    </div>


<?php }elseif($_GET[act]=='edit detail'){ 

  $edit = mysqli_query($koneksi,"SELECT hutang_setting.*, hutang_pos.namaPosHutang, tahun_ajaran.nmTahunAjaran FROM hutang_setting LEFT JOIN hutang_pos ON hutang_setting.idPosHutang = hutang_pos.idPosHutang LEFT JOIN tahun_ajaran ON hutang_setting.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE idSettingHutang='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
  $detail_hutang = mysqli_query($koneksi,"SELECT * FROM hutang_setting_detail WHERE idDetailHutang='$_GET[detail]'");
  $detail = mysqli_fetch_array($detail_hutang);

  if (isset($_POST[update_hutang])){
    $query = mysqli_query($koneksi,"UPDATE hutang_setting_detail SET noRefrensi='$_POST[hutang_noref]', tanggal='$tanggal_sekarang', idSettingHutang='$_POST[id_setting_hutang]', idJabatan='$_POST[id_jabatan]', idPegawai='$_POST[id_pegawai]', nominal='$_POST[nominal_hutang]', jumlahCicil='$_POST[cicil]', angsuran='$_POST[nominal_cicilan]', uby='$idUsers', udate='$waktu_sekarang' WHERE idDetailHutang = '$_POST[id_detail_hutang]'");
    
    mysqli_query($koneksi,"DELETE FROM hutang_bayar WHERE idDetailHutang='$_POST[id_detail_hutang]'");
    for ($i=1; $i <= $_POST['cicil']; $i++) { 
      mysqli_query($koneksi,"INSERT INTO hutang_bayar(idDetailHutang,cicilan,nominal,keterangan,stdel,cby,cdate,uby,udate) VALUES('$_POST[id_detail_hutang]','Cicilan $i','$_POST[nominal_cicilan]','Belum Lunas','0','$idUsers','$waktu_sekarang','$idUsers','$waktu_sekarang')");
    }

    if ($query){
      $_SESSION['notif_detail'] = 'sukses_update';
      echo "<script>document.location='index.php?view=$_GET[view]&act=detail&id=$_GET[id]';</script>";
    }else{
      $_SESSION['notif_detail'] = 'gagal_update';
      echo "<script>document.location='index.php?view=$_GET[view]&act=detail&id=$_GET[id]';</script>";
    }  
  }

?>

    <div class="box-body">
      <form action="" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
          
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Informasi Hutang</h3>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="" class="col-sm-4 control-label">Jenis Bayar</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" value="<?= $record['namaPosHutang'].' - '.$record['nmTahunAjaran'] ?>" readonly="">
                  </div>
                </div>
                <div class="form-group">            
                  <label for="" class="col-sm-4 control-label">Tahun Ajaran</label>
                  <div class="col-sm-8">
                    <input type="hidden" name="id_tahun_ajaran" class="form-control" value="<?= $record['idTahunAjaran'] ?>" readonly="">
                    <input type="text" class="form-control" value="<?= $record['nmTahunAjaran'] ?>" readonly="">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="box box-success">
              <div class="box-header">
                <h3 class="box-title">Jumlah Hutang</h3>
              </div>
              <div class="box-body table-responsive">
                <input type="hidden" name="id_setting_hutang" value="<?= $_GET[id] ?>">
                <input type="hidden" name="id_detail_hutang" value="<?= $_GET[detail] ?>">
                <table class="table">
                  <tbody>
                    <tr>
                      <td><strong>No. Ref Hutang</strong></td>
                      <td><input type="text" name="hutang_noref" id="hutang_noref" readonly="" class="form-control" value="<?= $detail[noRefrensi]?>">
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Posisi</strong></td>
                      <td>
                        <input type="hidden" id="idUnit" value="<?= $record[idUnit]?>">
                        <input type="hidden" id="idJabatan" value="<?= $detail[idJabatan]?>">
                        <select id="Cjabatan" name="id_jabatan" class="form-control">
                            <option value="">-- Pilih Posisi --</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Nama Kreditur</strong></td>
                      <td>
                        <input type="hidden" id="idPegawai" value="<?= $detail[idPegawai]?>">
                        <select name="id_pegawai" id="Cpegawai" class="form-control">
                          <option value="">-- Pilih Kreditur --</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Nominal Hutang (Rp.)</strong></td>
                      <td><input type="text" name="nominal_hutang" id="nominal_hutang" placeholder="Masukan Jumlah Hutang" required="" class="form-control" onkeyup="count_hutang()" value="<?= $detail[nominal] ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Dicicil (berapa kali)</strong></td>
                      <td><input type="text" name="cicil" id="cicil" placeholder="Masukan Jumlah Hutang" required="" class="form-control" onkeyup="count_hutang()" value="<?= $detail[jumlahCicil] ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><strong>Nominal per Cicilan (Rp.)</strong></td>
                      <td><input type="text" name="nominal_cicilan" id="nominal_cicilan" placeholder="Masukan Jumlah Hutang" readonly="" class="form-control" value="<?= $detail[angsuran] ?>">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="box-footer">
                <button type="submit" name="update_hutang" class="btn btn-success">Simpan</button>
                <a href="index.php?view=<?= $_GET[view] ?>&act=detail&id=<?= $_GET[id] ?>" class="btn btn-default">Cancel</a>
              </div>
            </div>
          </div>          
          </form>       </div>
<?php
}
?>

<script>

    set_default();
        
    function set_default(){
        
        if($('#nominal_hutang').val() == ''){
            $('#nominal_hutang').val('0');
        }
        
        if($('#cicil').val() == ''){
            $('#cicil').val('0');
        }
        
        if($('#nominal_cicilan').val() == ''){
            $('#nominal_cicilan').val('0');
        }
        
    }
    
    function count_hutang(){
        
        var hutang_bill     = $('#nominal_hutang').val();
        var cicil           = $('#cicil').val();
        
        if(hutang_bill != '' && cicil != ''){
            if(cicil != '0'){
                var hutang_pay_bill = hutang_bill/cicil;
                $('#nominal_cicilan').val(hutang_pay_bill);
            }
        }
    }
    
</script>