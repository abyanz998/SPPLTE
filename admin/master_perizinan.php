<?php
  //notif
  if ($_SESSION['notif'] == 'csukses'){
    echo '<script>toastr["success"]("Data Perizinan berhasil disimpan.","Sukses!")</script>';
  }elseif ($_SESSION['notif'] == 'dsukses'){
    echo '<script>toastr["success"]("Data Perizinan berhasil dihapus.","Sukses!")</script>';
  }elseif($_SESSION['notif'] == 'gagal'){
    echo '<script>toastr["error"]("Data Perizinan gagal diproses.","Gagal!")</script>';
  }elseif ($_SESSION['notif'] == 'ckelassukses'){
    echo '<script>toastr["success"]("Data Perizinan Per Kelas berhasil disimpan.","Sukses!")</script>';
  }elseif($_SESSION['notif'] == 'kelasgagal'){
    echo '<script>toastr["error"]("Data Perizinan Per Kelas gagal diproses.","Gagal!")</script>';
  }unset($_SESSION['notif']);
?>
<?php if ($_GET[act]==''){ ?> 
  
  <div class="col-md-12">  
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Filter Data Perizinan Santri</h3>
      </div>
      <div class="box-body">
        <form action="" class="form-horizontal" method="get" accept-charset="utf-8">
          <input type="hidden" name="view" value="<?= $_GET['view']?>">
          <div class="form-group">            
            <label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
            <div class="col-sm-2">
              <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
              <select class="form-control" name="thn_ajar" id="Ctahunajaran">

              </select>
              </div>
              <label for="" class="col-sm-2 control-label">Cari Santri</label>
              <div class="col-sm-6">
                <div class="input-group">
                  <input type="text" class="form-control" autofocus="" name="nis" id="student_nis" placeholder="NIS Santri" required="" value="<?= $_GET['nis']?>">
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
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#dataSantri"><b>Data Santri</b></button>
                  </span>
                  <span class="input-group-btn">
                  </span>
                  <span class="input-group-btn">
                    <a class="btn btn-primary" href="index.php?view=<?= $_GET[view]?>&act=tambah berdasarkan kelas"><span class="fa fa-plus"></span> Berdasarkan Kelas</a>
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
          <h4 class="modal-title">Cari Data Santri</h4>
        </div>
        <div class="modal-body">
            <div class="box-body table-responsive">
              <table id="example1" class="table table-hover dataTable no-footer">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nis</th>
                        <th>Nama</th>
                        <th>Unit</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      if($idUnitUsers != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$idUnitUsers' ORDER BY siswa.idSiswa DESC");
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' ORDER BY siswa.idSiswa DESC");
                      }
                      
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        echo "<tr>
                              <td>$no</td>
                              <td>$r[nisSiswa]</td>
                              <td>$r[nmSiswa]</td>
                              <td>$r[singkatanUnit]</td>
                              <td>$r[nmKelas]</td>
                              <td>
                                <center><button type='button' data-dismiss='modal' class='btn btn-primary btn-xs' onclick=\"ambil_data('$r[nisSiswa]')\">Pilih</button></center>
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

 <script>
    function ambil_data(nisSiswa){
      var nisSiswa = nisSiswa;
      var thAjaran    = $("#Ctahunajaran").val();
            
      window.location.href = 'index.php?view=<?= $_GET[view]?>&thn_ajar='+thAjaran+'&nis='+nisSiswa;
    }
</script>


<?php if (isset($_GET['thn_ajar']) && isset($_GET['nis'])) { 


$siswa = mysqli_fetch_array(mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas WHERE siswa.nisSiswa='$_GET[nis]'"));
$thn = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$_GET[thn_ajar]'"));

if (empty($siswa['fotoSiswa'])){
  $fotoSiswa = $lokasi_default_fotoSiswa;
}else{
  $fotoSiswa = $lokasi_penyimpanan_fotoSiswa.$siswa['fotoSiswa'];
}



?> 
<div class="col-md-12">
      
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Informasi Santri</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="col-md-9">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <td width="200">Tahun Ajaran</td><td width="4">:</td>
                      <td><strong><?= $thn['nmTahunAjaran'] ?><strong></strong></strong></td> 
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
                    <td>Unit Sekolah</td>
                    <td>:</td>
                    <td><?= $siswa['singkatanUnit'] ?></td> 
                  </tr>
                  <tr>
                    <td>Kelas</td>
                    <td>:</td>
                    <td><?= $siswa['nmKelas'] ?></td> 
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-3">

              <img src="<?= $fotoSiswa ?>" class="img-thumbnail img-responsive">
            </div>
          </div>
        </div>
        
        <!-- List Tagihan Bulanan --> 
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Perizinan Santri</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Tambah Perizinan</a></li>
                <li><a href="#tab_2" data-toggle="tab">Riwayat Perizinan Santri</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <div class="box-body">
                    <div class="row">    
                      <?php
                        //simpan
                          if (isset($_POST['tambah'])){
                            if ($_POST['perizinan_kategori'] == 'Pulang Kerumah'){
                              $query = mysqli_query($koneksi,"INSERT INTO izin_pulang(tanggal,idSiswa,idTahunAjaran,penjemput,waktuIzin,keterangan,stdel,cby,cdate) VALUES ('$_POST[perizinan_tanggal]','$_POST[perizinan_idsiswa]','$_POST[perizinan_tahunajaran]','$_POST[perizinan_penjemput]','$_POST[perizinan_waktuizin]','$_POST[perizinan_keterangan]','0','$idUsers','$waktu_sekarang')");
                            }elseif ($_POST['perizinan_kategori'] == 'Keluar Pesantren'){
                              $query = mysqli_query($koneksi,"INSERT INTO izin_keluar(tanggal,idSiswa,idTahunAjaran,jamKeluar,jamKembali,keterangan,stdel,cby,cdate) VALUES ('$_POST[perizinan_tanggal]','$_POST[perizinan_idsiswa]','$_POST[perizinan_tahunajaran]','$_POST[perizinan_jamkeluar]','$_POST[perizinan_jamkembali]','$_POST[perizinan_keterangan]','0','$idUsers','$waktu_sekarang')");
                            } 
                            
                            if ($query){
                              $_SESSION['notif'] = 'csukses';
                              echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
                            }else{
                              $_SESSION['notif'] = 'gagal';
                              echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
                            }
                          }
                        //hapus
                        if (isset($_GET['hapus'])){
                          if ($_GET['kategori'] == 'Pulang Kerumah'){
                              $query = mysqli_query($koneksi," UPDATE izin_pulang SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idPulang='$_GET[idPulang]'");
                            }elseif ($_GET['kategori'] == 'Keluar Pesantren'){
                              $query = mysqli_query($koneksi," UPDATE izin_keluar SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idKeluar='$_GET[idKeluar]'");
                            } 
                          
                          if ($query){
                            $_SESSION['notif'] = 'dsukses';
                            echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
                          }else{
                            $_SESSION['notif'] = 'gagal';
                            echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
                          }
                        }
                      ?>

                      <form action="index.php?view=<?= $_GET[view] ?>&thn_ajar=<?= $_GET[thn_ajar]?>&nis=<?= $_GET[nis]?>" method="post" accept-charset="utf-8">
                        <input type="hidden" name="perizinan_tahunajaran" value="<?= $_GET['thn_ajar']?>">
                        <input type="hidden" name="perizinan_idsiswa" value="<?= $siswa['idSiswa']?>"> 
                          <div class="row">          
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Tanggal</label>
                                <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                  <input class="form-control md-3" required="" type="text" name="perizinan_tanggal" placeholder="Tanggal Pelanggaran" value="<?= $tanggal_sekarang ?>">
                                </div>
                              </div>
                            </div>
                            
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Kategori</label>
                                <select name="perizinan_kategori" class="form-control" onchange="get_form_kategori(this.value)" required>
                                  <option disabled selected value=""> - Pilih Kategori -</option>
                                  <option value="Pulang Kerumah">Pulang Kerumah</option>
                                  <option value="Keluar Pesantren">Keluar Pesantren</option>
                                </select>
                              </div>
                            </div>
                            <div id="add_detailKategori"></div>
                          </div>
                        </form>
                      </div>    
                    </div>
                  </div>


                <div class="tab-pane" id="tab_2">
                  <div class="box-body table-responsive">
                    <div class="row">
                      <div class="col-md-3">
                        <label>Filter </label>
                        <select name="filter_kategori" id="filter_kategori" class="form-control" onchange="get_form_tabel(this.value,'<?=$siswa[idSiswa]?>')">
                          <option disabled selected value=""> - Pilih Kategori -</option>
                          <option value="Pulang Kerumah">Pulang Kerumah</option>
                          <option value="Keluar Pesantren">Keluar Pesantren</option>
                        </select>       
                      </div>
                    </div>
                    <br>
                    <div id="detail_tabelperizinan"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

  <?php } ?>
<?php } elseif ($_GET['act'] == 'tambah berdasarkan kelas'){

    if (isset($_POST['simpan_perizinan_perkelas'])){

      if ($_POST['perizinan_kamar'] == 'all'){
        $query_siswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE unitSiswa='$_POST[perizinan_unit]' AND  kelasSiswa='$_POST[perizinan_kelas]' AND stdel='0' AND statusSiswa='Aktif'");
      }else{
        $query_siswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE unitSiswa='$_POST[perizinan_unit]' AND  kelasSiswa='$_POST[perizinan_kelas]' AND kamarSiswa='$_POST[perizinan_kamar]' AND stdel='0' AND statusSiswa='Aktif'");
      }
      
      while ($siswa = mysqli_fetch_array($query_siswa)) {
        if ($_POST['perizinan_kategori'] == 'Pulang Kerumah'){
          $query = mysqli_query($koneksi,"INSERT INTO izin_pulang(tanggal,idSiswa,idTahunAjaran,penjemput,waktuIzin,keterangan,stdel,cby,cdate) VALUES ('$_POST[perizinan_tanggal]','$siswa[idSiswa]','$_POST[perizinan_tahunajaran]','$_POST[perizinan_penjemput]','$_POST[perizinan_waktuizin]','$_POST[perizinan_keterangan]','0','$idUsers','$waktu_sekarang')");
        }elseif ($_POST['perizinan_kategori'] == 'Keluar Pesantren'){
          $query = mysqli_query($koneksi,"INSERT INTO izin_keluar(tanggal,idSiswa,idTahunAjaran,jamKeluar,jamKembali,keterangan,stdel,cby,cdate) VALUES ('$_POST[perizinan_tanggal]','$siswa[idSiswa]','$_POST[perizinan_tahunajaran]','$_POST[perizinan_jamkeluar]','$_POST[perizinan_jamkembali]','$_POST[perizinan_keterangan]','0','$idUsers','$waktu_sekarang')");
        }
      }

      if ($query){
          $_SESSION['notif'] = 'ckelassukses';
          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      }else{
          $_SESSION['notif'] = 'kelasgagal';
          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      }
    }

?>
<div class="box-body">
        <form action="" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        
          <div class="col-md-6">
            <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Perizinan Perkelas</h3>
              </div>
              <div class="box-body">
                <div class="form-group">            
                  <label for="" class="col-sm-4 control-label">Tahun Ajaran</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="perizinan_tahunajaran" id="Ctahunajaran"></select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-4 control-label">Tanggal</label>
                  <div class="col-sm-8">
                    <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      <input class="form-control md-3" required="" type="text" name="perizinan_tanggal" placeholder="Tanggal Pelanggaran" value="<?= $tanggal_sekarang ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">            
                  <label for="" class="col-sm-4 control-label">Unit</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="perizinan_unit" id="Cunit" required></select>
                  </div>
                </div>
                <div class="form-group">            
                  <label for="" class="col-sm-4 control-label">Kelas</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="perizinan_kelas" id="Ckelas" required></select>
                  </div>
                </div> 
                <div class="form-group">            
                  <label for="" class="col-sm-4 control-label">Kamar</label>
                  <div class="col-sm-8">
                    <input type="hidden" id="tipe_kamar" value="semuaKamar">
                    <select class="form-control" name="perizinan_kamar" id="Ckamar" required></select>
                  </div>
                </div>   
                <div class="form-group">            
                  <label for="" class="col-sm-4 control-label">Kategori</label>
                  <div class="col-sm-8">
                    <select name="perizinan_kategori" class="form-control" onchange="get_form_kelas_kategori(this.value)" required>
                      <option disabled selected value=""> - Pilih Kategori -</option>
                      <option value="Pulang Kerumah">Pulang Kerumah</option>
                      <option value="Keluar Pesantren">Keluar Pesantren</option>
                    </select>
                  </div>
                </div> 
                
              </div>
            </div>
          </div>
          
              <div id="detail_izin_perkelas"></div>
           

          <div class="col-md-2">
            <div class="box box-success text-center">
              <div class="box-footer">
                <button type="submit" name="simpan_perizinan_perkelas" class="btn btn-success btn-block">Simpan</button>
                <a href="index.php?view=<?= $_GET[view] ?>" class="btn btn-danger btn-block">Kembali</a>
              </div>
            </div>
          </div>
        </form>     
      </div>

      

<?php } ?>

<script type="text/javascript">
  function get_form_kategori(value){
    $.ajax({
      url: 'admin/form/form_perizinan_kategori.php',
      method:"POST",
      data: {
        kategori : value,
      },
      success: function(msg){
        $("#add_detailKategori").html(msg);
      },
      error: function(msg){
        toastr["error"]("msg","Gagal!");
      }
    });
  }
  function reset_form(){
    $("#add_detailKategori").html('');
  }

  function get_form_tabel(kategori,siswa){
    $.ajax({
      url: 'admin/form/form_tabel_perizinan.php',
      method:"POST",
      data: {
        kategori : kategori,
        idSiswa : siswa,
        view : '<?= $_GET[view] ?>',
        nisSiswa : '<?= $_GET[nis] ?>',
        tahun_ajaran : '<?= $_GET[thn_ajar] ?>',
      },
      success: function(msg){
        $("#detail_tabelperizinan").html(msg);
      },
      error: function(msg){
        toastr["error"]("msg","Gagal!");
      }
    });
  }

  function get_form_kelas_kategori(value){
    $.ajax({
      url: 'admin/form/form_perizinan_kelas_kategori.php',
      method:"POST",
      data: {
        kategori : value,
      },
      success: function(msg){
        $("#detail_izin_perkelas").html(msg);
      },
      error: function(msg){
        toastr["error"]("msg","Gagal!");
      }
    });
  }
</script>