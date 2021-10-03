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
                              <select style="width: 200px;" id="Cunit" name="unit" class="form-control" required="">           
                              </select>
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
                    }
                    unset($_SESSION['notif']);
                  ?>
                  <table id="example1" class="table table-hover dataTable no-footer">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>POS</th>
                        <th>Nama Pembayaran</th>
                        <th>Tipe</th>
                        <th>Tahun</th>
                        <th>Tarif Pembayaran</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                      if (isset($_GET['unit'])){
                        if ($_GET['unit'] != 'all'){
                          $tampil = mysqli_query($koneksi,"SELECT jenis_bayar.*, pos_bayar.nmPosBayar, tahun_ajaran.nmTahunAjaran FROM jenis_bayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE jenis_bayar.stdel='0' AND jenis_bayar.idUnit='$_GET[unit]' ORDER BY jenis_bayar.idJenisBayar DESC");
                        }else{
                          $tampil = mysqli_query($koneksi,"SELECT jenis_bayar.*, pos_bayar.nmPosBayar, tahun_ajaran.nmTahunAjaran FROM jenis_bayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE jenis_bayar.stdel='0' ORDER BY jenis_bayar.idJenisBayar DESC");
                        }
                      }elseif($idUnitUsers != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT jenis_bayar.*, pos_bayar.nmPosBayar, tahun_ajaran.nmTahunAjaran FROM jenis_bayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE jenis_bayar.stdel='0' AND jenis_bayar.idUnit='$idUnitUsers' ORDER BY jenis_bayar.idJenisBayar DESC");
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT jenis_bayar.*, pos_bayar.nmPosBayar, tahun_ajaran.nmTahunAjaran FROM jenis_bayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran WHERE jenis_bayar.stdel='0' ORDER BY jenis_bayar.idJenisBayar DESC");
                      }
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        if($r['tipeBayar'] == 'Bulanan'){
                          $tipeBayar = "<a data-toggle='tooltip' data-placement='top' title='' class='btn btn-primary btn-xs' href='?view=tarif pembayaran bulanan&id=$r[idJenisBayar]' data-original-title='Ubah'>Setting Tarif Pembayaran</a>";
                        }elseif ($r['tipeBayar'] == 'Bebas'){
                          $tipeBayar = "<a data-toggle='tooltip' data-placement='top' title='' class='btn btn-primary btn-xs' href='?view=tarif pembayaran bebas&id=$r[idJenisBayar]' data-original-title='Ubah'>Setting Tarif Pembayaran</a>";
                        }
                        echo "<tr><td>$no</td>
                                <td>".$r['nmPosBayar']."</td>
                                <td>".$r['nmPosBayar']." - T.A ".$r['nmTahunAjaran']."</td>
                                <td>".$r['tipeBayar']."</td>
                                <td>".$r['nmTahunAjaran']."</td>
                                <td>".$tipeBayar."</td>
                                <td>
                                  <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idJenisBayar]'><span class='fa fa-edit'></span></a>
                                </td>";
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
    $query = mysqli_query($koneksi,"UPDATE jenis_bayar SET idUnit='$_POST[unit_sekolah]', idPosBayar='$_POST[pos_bayar]', idTahunAjaran='$_POST[tahun_ajaran]', tipeBayar='$_POST[tipe_bayar]', uby='$idUsers', udate='$waktu_sekarang' WHERE idJenisBayar = '$_POST[id]'");
    
    if ($query){
      $_SESSION['notif'] = 'usukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
  }
  if (isset($_GET[hapus])){
        mysqli_query($koneksi,"UPDATE jenis_bayar SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' where idJenisBayar='$_GET[id]'");
        $_SESSION['notif'] = 'dsukses';
        echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }

  $edit = mysqli_query($koneksi,"SELECT * FROM jenis_bayar WHERE idJenisBayar='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>
  
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
          <input type="hidden" name="id" value="<?= $record[idJenisBayar] ?>">
          <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="hidden" id="idUnit" value="<?= $record[idUnit] ?>">
          <select name="unit_sekolah" class="form-control" required id="Cunit"></select>
          <br>
          <label>POS<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="hidden" id="idPosBayar" value="<?= $record[idPosBayar] ?>">
          <select name="pos_bayar" class="form-control" required id="Cposbayar">
            <option disabled="" selected="">- Pilih Pos -</option>
          </select>
          <br>
          <label>Tahun Ajaran<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="hidden" id="idTahunAjaran" value="<?= $record[idTahunAjaran] ?>">
          <select name="tahun_ajaran" class="form-control" required id="Ctahunajaran2">
            <option disabled="" selected="">- Pilih Tahun Ajaran -</option>
          </select>
          <br>
          <label>Tipe Bayar<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <input type="hidden" id="idTipeBayar" value="<?= $record[tipeBayar] ?>">
          <select name="tipe_bayar" class="form-control" required id="Ctipebayar">
            <option disabled="" selected="">- Pilih Tipe Bayar -</option>
          </select>
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
          <a href="#delModal<?= $record['idJenisBayar'] ?>" data-toggle="modal" class="btn btn-block btn-danger">Hapus</a>
        </div>
      </div>
    </div>

  </form>

  <div class="modal fade" id="delModal<?= $record['idJenisBayar'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form action="index.php?view=<?= $_GET[view] ?>&act=edit&hapus&id=<?= $record[idJenisBayar] ?>" method="POST" role="form">
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
    $query = mysqli_query($koneksi,"INSERT INTO jenis_bayar(idUnit,idPosBayar,idTahunAjaran,tipeBayar,stdel,cby,cdate) VALUES('$_POST[unit_sekolah]','$_POST[pos_bayar]','$_POST[tahun_ajaran]','$_POST[tipe_bayar]','0','$idUsers','$waktu_sekarang')");
    
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
          <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <select name="unit_sekolah" class="form-control" required id="Cunit"></select>
          <br>
          <label>POS<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <select name="pos_bayar" class="form-control" required id="Cposbayar">
            <option disabled="" selected="">- Pilih Pos -</option>
          </select>
          <br>
          <label>Tahun Ajaran<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <select name="tahun_ajaran" class="form-control" required id="Ctahunajaran2">
            <option disabled="" selected="">- Pilih Tahun Ajaran -</option>
          </select>
          <br>
          <label>Tipe Bayar<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <select name="tipe_bayar" class="form-control" required id="Ctipebayar">
            <option disabled="" selected="">- Pilih Tipe Bayar -</option>
          </select>
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

