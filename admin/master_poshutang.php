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
                        <th>Kode Akun Hutang</th>
                        <th>Nama Pos Hutang</th>
          						  <th>Keterangan</th>
          						  <th>Aksi</th>
          					  </tr>
          					</thead>
          					<tbody>
                    <?php 
                      if (isset($_GET['unit'])){
                        if ($_GET['unit'] != 'all'){
                          $tampil = mysqli_query($koneksi,"SELECT hutang_pos.*, akun_biaya.kodeAkun, akun_biaya.keterangan as ket_akun FROM hutang_pos LEFT JOIN akun_biaya ON hutang_pos.idAkunHutang = akun_biaya.idAkun WHERE hutang_pos.stdel='0' AND akun_biaya.unitSekolah='$_GET[unit]' ORDER BY hutang_pos.idPosHutang DESC");
                        }else{
                          $tampil = mysqli_query($koneksi,"SELECT hutang_pos.*, akun_biaya.kodeAkun, akun_biaya.Keterangan as ket_akun FROM hutang_pos LEFT JOIN akun_biaya ON hutang_pos.idAkunHutang = akun_biaya.idAkun WHERE hutang_pos.stdel='0' ORDER BY hutang_pos.idPosHutang DESC");
                        }
                      }elseif($idUnitUsers != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT hutang_pos.*, akun_biaya.kodeAkun, akun_biaya.Keterangan as ket_akun FROM hutang_pos LEFT JOIN akun_biaya ON hutang_pos.idAkunHutang = akun_biaya.idAkun WHERE hutang_pos.stdel='0' AND akun_biaya.unitSekolah='$idUnitUsers' ORDER BY hutang_pos.idPosHutang DESC");
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT hutang_pos.*, akun_biaya.kodeAkun, akun_biaya.Keterangan as ket_akun FROM hutang_pos LEFT JOIN akun_biaya ON hutang_pos.idAkunHutang = akun_biaya.idAkun WHERE hutang_pos.stdel='0' ORDER BY hutang_pos.idPosHutang DESC");
                      }
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        echo "<tr><td>$no</td>
                                <td>".$r['kodeAkun'].' - '.$r['ket_akun']."</td>
                                <td>".$r['namaPosHutang']."</td>
                                <td>".$r['keterangan']."</td>
                                <td><center>
                                  <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idPosHutang]'><span class='fa fa-edit'></span></a>
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
    $query = mysqli_query($koneksi,"UPDATE hutang_pos SET idAkunHutang='$_POST[id_akun_hutang]', namaPosHutang='$_POST[nama_pos_hutang]', keterangan='$_POST[keterangan]', uby='$idUsers', udate='$waktu_sekarang' WHERE idPosHutang = '$_POST[id]'");
    
    if ($query){
      $_SESSION['notif'] = 'usukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
  }
  if (isset($_POST[hapus])){
    $cek_data = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM hutang_setting WHERE idPosHutang='$_GET[id]' AND stdel='0'"));
    if ($cek_data == 0){
      $query = mysqli_query($koneksi,"UPDATE hutang_pos SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idPosHutang='$_GET[id]'");
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

  $edit = mysqli_query($koneksi,"SELECT * FROM hutang_pos WHERE idPosHutang='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>
  
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
          <input type="hidden" name="id" value="<?= $record['idPosHutang'] ?>">
          <label>Kode Akun <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="hidden" required="" id="idAkunHutang" value="<?= $record[idAkunHutang] ?>">
          <select name="id_akun_hutang" class="form-control" required id="CakunHutang"></select>  
          <br>
          <label>Nama POS Hutang <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="text" required="" name="nama_pos_hutang" class="form-control" placeholder="Contoh : Hutang Pegawai" value="<?= $record[namaPosHutang] ?>">
          <br>
          <label>Keterangan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="text" required="" name="keterangan" class="form-control" placeholder="Contoh : Hutang Pegawai" value="<?= $record[keterangan] ?>">
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
          <a href='#' data-toggle='modal' data-target='#hapus<?= $record[idPosHutang] ?>' class='btn btn-block btn-danger'>Hapus</a>
        </div>
      </div>
    </div>

  </form>

  
  <div class="modal fade" id="hapus<?= $record[idPosHutang] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act]?>&id=<?= $record[idPosHutang] ?>" method="POST" role="form">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><span class="fa fa-exclamation-triangle"></span> Hapus Data</h4> 
          </div>
          <div class="modal-body">
            Apakah anda ingin menghapus data ini?
          </div>
          <div class="modal-footer">
            <button type="submit" name="hapus" class="btn btn-danger pull-right"><span class="fa fa-check"></span> Hapus</button>
            <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-times"></span> Batal</button>
          </div>
        </div>
      </div>
    </form>
  </div>


<?php }elseif($_GET[act]=='tambah'){

  if (isset($_POST[tambah])){
    $query = mysqli_query($koneksi,"INSERT INTO hutang_pos(idAkunHutang,namaPosHutang,keterangan,stdel,cby,cdate) VALUES('$_POST[id_akun_hutang]','$_POST[nama_pos_hutang]','$_POST[keterangan]','0','$idUsers','$waktu_sekarang')");
    
    if ($query){
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      $_SESSION['notif'] = 'csukses';
    }else{
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      $_SESSION['notif'] = 'gagal';
    }  
  }

?>
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
          <label>Kode Akun <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <select name="id_akun_hutang" class="form-control" required id="CakunHutang"></select>  
          <br>
          <label>Nama POS Hutang <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="text" required="" name="nama_pos_hutang" class="form-control" placeholder="Contoh : Hutang Pegawai">
          <br>
          <label>Keterangan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="text" required="" name="keterangan" class="form-control" placeholder="Contoh : Hutang Pegawai">
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
<?php
}
?>

