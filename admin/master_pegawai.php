<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success">
                <div class="box-header with-border">
                  <a class='btn btn-success btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=tambah'><span class='fa fa-plus'></span> Tambah</a>
                  &nbsp;<a class='btn btn-primary btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=import'><span class='fa fa-upload'></span> Upload Data</a>
                  &nbsp;<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#cetakPegawai"><i class="fa fa-print"></i> Cetak</button>
                  <br><br>

                   <!-- MODAL CETAK -->
                  <div class="modal fade in" id="cetakPegawai" role="dialog">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">×</button>
                          <h4 class="modal-title">Pilih Kelas</h4>
                        </div>
                        <form action="admin/laporan/data_pegawai.php" method="get" target="_blank">
                          <div class="modal-body">
                            <label>Unit Sekolah</label>
                            <input type="hidden" id="tipe_unit_cetak" value="pencarian">
                            <select name="unit" id="Cunit_buttonCetak" class="form-control" required></select>
                            <br>
                            <label>Jabatan</label>
                            <input type="hidden" id="tipe_jabatan_cetak" value="pencarian">
                            <select name="jabatan" id="Cjabatan_buttonCetak" class="form-control" required>
                                <option value="">- Pilih Jabatan -</option>
                            </select>
                            <br>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-pdf-o"></i> Cetak</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <form action="" class="form-horizontal" method="get" accept-charset="utf-8">
                    <div class="box-body table-responsive">
                    <table>
                      <tbody>
                        <tr>
                          <td>     
                            <input type="hidden" name="view" value="<?= $_GET[view] ?>">
                            <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                            <input type="hidden" id="tipe_unit" value="pencarian">
                            <select style="width: 200px;" id="Cunit" name="unit" class="form-control" required=""></select>
                          </td>
                          <td>
                            &nbsp;&nbsp;
                          </td>
                          <td>
                            <input type="hidden" id="idJabatan" value="<?= $_GET[jabatan] ?>">
                            <select style="width: 200px;" id="Cjabatan" name="jabatan" class="form-control" required="">
                              <option disabled selected>- Pilih Jabatan Pegawai -</option>
                            </select>
                          </td><td>
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
                    }elseif($_SESSION['notif'] == 'resetsukses'){
                      echo '<script>toastr["success"]("Reset password berhasil.","Sukses!")</script>';
                    }elseif($_SESSION['notif'] == 'resetgagal'){
                      echo '<script>toastr["error"]("Reset password gagal.","Gagal!")</script>';
                    }elseif($_SESSION['notif'] == 'importsukses'){
                      echo '<script>toastr["success"]("Import data berhasil.","Sukses!")</script>';
                    }elseif($_SESSION['notif'] == 'importgagal'){
                      echo '<script>toastr["error"]("Import data gagal.","Gagal!")</script>';
                    }
                    unset($_SESSION['notif']);
                  ?>
                  <table id="table_checkbox" class="table table-hover dataTable no-footer display">
          					<thead>
          					  <tr>
                        <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
          						  <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
          						  <th>Unit Sekolah</th>
                        <th>Jabatan</th>
                        <th>Status Kepegawaian</th>
                        <th>No. Telpon/Hp</th>
                        <th>Status</th>
          						  <th>Aksi</th>
          					  </tr>
          					</thead>
          					<tbody>
                    <?php 
                      if (isset($_GET['unit'])){
                        if (($_GET['unit'] != 'all') && ($_GET['jabatan'] != 'all')){
                          $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' AND pegawai.unitPegawai='$_GET[unit]' AND pegawai.jabatanPegawai='$_GET[jabatan]' ORDER BY pegawai.idPegawai DESC");
                        }else{
                          $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' ORDER BY pegawai.idPegawai DESC");
                        }
                      }elseif($_SESSION['unit'] != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' AND pegawai.unitPegawai='$_SESSION[unit]' ORDER BY pegawai.idPegawai DESC");
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0'  ORDER BY pegawai.idPegawai DESC");
                      }
                      
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        if ($r['statusPegawai'] == 'Aktif'){
                          $status = '<label class="label label-success">Aktif</label>';
                        }else{
                          $status = '<label class="label label-danger">Tidak Aktif</label>';
                        }
                        if ($r['jbt_stdel'] == '1'){
                          $nama_jabatan = '';
                        }else{
                          $nama_jabatan = $r['namaJabatan'];
                        }
                        echo "<tr>
                                <td></td>
                                <td>$no</td>
                                <td>$r[nipPegawai]</td>
                                <td>$r[namaPegawai]</td>
                                <td>$r[singkatanUnit]</td>
                                <td>$nama_jabatan</td>
                                <td>$r[statusKepegawaian]</td>
                                <td>$r[noHpPegawai]</td>
                                <td>$status</td>
                                <td><center>
                                  <a class='btn btn-danger btn-xs' data-toggle='tooltip' title='' data-original-title='Reset Password' href='?view=$_GET[view]&act=reset password&id=$r[idPegawai]'><span class='fa fa-unlock'></span></a>
                                  <a class='btn btn-info btn-xs' data-toggle='tooltip' title='' data-original-title='Lihat' href='?view=$_GET[view]&act=detail&id=$r[idPegawai]'><span class='fa fa-eye'></span></a>
                                  <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idPegawai]'><span class='fa fa-edit'></span></a>
                                  <a class='btn btn-success btn-xs' data-toggle='modal' href='#cetak".$r['idPegawai']."'><span class='fa fa-print' data-toggle='tooltip' title='' data-original-title='Cetak Kartu' ></span></a>
                                  
                                </center></td>";
                        echo "</tr>";
                        echo '<div class="modal fade in" id="cetak'.$r['idPegawai'].'">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                      <h4 class="modal-title">Cetak Kartu Pegawai</h4></div><div class="modal-body">
                                    </div>
                                    <div class="modal-body">
                                      <object data="admin/laporan/kartu_pegawai.php?id='.$r['idPegawai'].'" width="100%" height="300px"></object>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                              </div>';
                        $no++;
                      }
                      

                      ?>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>

<?php }elseif($_GET[act]=='detail'){ 

  $edit = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE idPegawai = '$_GET[id]'");
  $record = mysqli_fetch_array($edit);


  if (isset($_GET['hapus'])){
    $query = mysqli_query($koneksi,"UPDATE pegawai SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idPegawai='$_GET[id]'");
    if($query){
      $_SESSION['notif'] = 'dsukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }  
  }



  if ($_SESSION['notifdetail'] == 'add_pen_sukses'){
    echo '<script>toastr["success"]("Data Riwayat Pendidikan berhasil disimpan.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'del_pen_sukses'){
    echo '<script>toastr["success"]("Data Riwayat Pendidikan berhasil dihapus.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'add_sem_sukses'){
    echo '<script>toastr["success"]("Data Riwayat Seminar & Pelatihan berhasil disimpan.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'del_sem_sukses'){
    echo '<script>toastr["success"]("Data Riwayat Seminar & Pelatihan berhasil dihapus.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'add_kel_sukses'){
    echo '<script>toastr["success"]("Data Keluarga berhasil disimpan.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'del_kel_sukses'){
    echo '<script>toastr["success"]("Data Keluarga berhasil dihapus.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'add_jab_sukses'){
    echo '<script>toastr["success"]("Data Riwayat Jabatan berhasil disimpan.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'del_jab_sukses'){
    echo '<script>toastr["success"]("Data Riwayat Jabatan berhasil dihapus.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'add_mengajar_sukses'){
    echo '<script>toastr["success"]("Data Riwayat Mengajar berhasil disimpan.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'del_mengajar_sukses'){
    echo '<script>toastr["success"]("Data Riwayat Mengajar berhasil dihapus.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'add_penghargaan_sukses'){
    echo '<script>toastr["success"]("Data Penghargaan berhasil disimpan.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'del_penghargaan_sukses'){
    echo '<script>toastr["success"]("Data Penghargaan berhasil dihapus.","Sukses!")</script>';
  }elseif ($_SESSION['notifdetail'] == 'gagal'){
    echo '<script>toastr["error"]("Data gagal diproses.","Gagal!")</script>';
  }
  unset($_SESSION['notifdetail']);

  if (empty($record['fotoPegawai'])) {  
    $foto_pegawai = $lokasi_default_fotoPegawai; }
  else{
    $foto_pegawai = $lokasi_penyimpanan_fotoPegawai.$record['fotoPegawai']; 
  }
?>
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-6">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-md-12 col-sm-12 col-xs-12 pull-left">
              <br>
              <div class="row">
                <div class="col-md-2">
                  <img src="<?= $foto_pegawai ?>" class="img-responsive avatar">
                </div>
                <div class="col-md-10">
                  <table class="table table-hover">
                    <tbody>
                      <tr>
                        <td>NIP Pegawai</td>
                        <td>:</td>
                        <td><?= $record['nipPegawai'] ?></td>
                      </tr>
                      <tr>
                        <td>Nama lengkap</td>
                        <td>:</td>
                        <td><?= $record['namaPegawai'] ?></td>
                      </tr>
                      <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td><?php if ($record['jkPegawai'] == 'L') { echo 'Laki-laki'; } else if ($record['jkPegawai'] == 'P') { echo 'Perempuan'; } else { echo '-'; }?></td>
                      </tr>
                      <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td><?= $record['tempatLahirPegawai'].', '.tgl_raport($record['tglLahirPegawai']) ?></td>
                      </tr>
                      <tr>
                        <td>Pendidikan Terakhir</td>
                        <td>:</td>
                        <td><?= $record['pendidikanPegawai'] ?></td>
                      </tr>
                      <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= $record['alamatPegawai'] ?></td>
                      </tr>
                      
                      <tr>
                        <td>Unit Sekolah</td>
                        <td>:</td>
                        <td><?= $record['singkatanUnit'] ?></td>
                      </tr>
                      <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td><?= $record['namaJabatan'] ?></td>
                      </tr>
                      <tr>
                        <td>Status Kepegawaian</td>
                        <td>:</td>
                        <td><?= $record['statusKepegawaian'] ?></td>
                      </tr>
                      <tr>
                        <td>No. Handphone</td>
                        <td>:</td>
                        <td><?= $record['noHpPegawai'] ?></td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?= $record['emailPegawai'] ?></td>
                      </tr>
                      <tr>
                        <td>Masa Kerja</td>
                        <td>:</td>
                        <td>
                          <?php
                            $tgl_masuk = $record['tglMasukPegawai'];
                            if ($record['tglKeluarPegawai'] == '0000-00-00'){
                              $tgl_keluar = date('Y-m-d');
                            }else{
                              $tgl_keluar = $record['tglKeluarPegawai'];
                            }

                            echo hitungMasaKerja($tgl_masuk,$tgl_keluar);
                          ?>
                        </td>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td><?= $record['statusPegawai'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <a href="index.php?view=<?= $_GET['view'] ?>" class="btn btn-sm btn-success">
                    <i class="fa fa-arrow-circle-o-left"></i> Kembali
                  </a>
                  <a href="index.php?view=<?= $_GET['view'] ?>&act=edit&id=<?= $record['idPegawai']?>" class="btn btn-sm btn-warning">
                    <i class="fa fa-edit"></i> Edit
                  </a>
                  <a href="#delModal<?= $record['idPegawai'] ?>" data-toggle="modal" class="btn btn-sm btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="" data-original-title="Hapus"></i> Hapus</a>
                </div>
                <div class="pull-right">
                  <a href="admin/laporan/riwayat_hidup_pegawai.php?id=<?= $_GET['id']; ?>" class="btn btn-sm" target="_blank" title="Cetak PDF"><i class="fa fa-print"></i> Cetak PDF</a>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>
        </div>
        <!-- /.row -->
        <div class="modal modal-default fade" id="delModal<?= $record['idPegawai'] ?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                  <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                </div>
                <div class="modal-body">
                  <p>Apakah anda yakin akan menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                  <form action="index.php?view=<?= $_GET[view] ?>&act=detail&hapus&id=<?= $record[idPegawai] ?>" method="post" accept-charset="utf-8">
                  <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                  <button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                  </form>               
                </div>
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
      </div>
                    
      
      <?php
      if (isset($_GET['tambahpendidikan'])){
        $pendidikanMasuk = $_POST['pendidikan_masuk'];
        $pendidikanKeluar = $_POST['pendidikan_keluar'];
        $pendidikanSekolah = $_POST['pendidikan_sekolah'];
        $pendidikanLokasi = $_POST['pendidikan_lokasi'];
        for ($i=0; $i < count($pendidikanMasuk) ; $i++) { 
          $query = mysqli_query($koneksi,"INSERT INTO pegawai_pendidikan(idPegawai,pendidikanMasuk,pendidikanKeluar,pendidikanSekolah,pendidikanLokasi,stdel,cby,cdate) VALUES('$_POST[idPegawai]','$pendidikanMasuk[$i]','$pendidikanKeluar[$i]','$pendidikanSekolah[$i]','$pendidikanLokasi[$i]','0','$idUsers','$waktu_sekarang')");
        }
        if($query){
          $_SESSION['notifdetail'] = 'add_pen_sukses';
        }else{
          $_SESSION['notifdetail'] = 'gagal';
        }
         echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
      }

      if (isset($_GET['hapuspendidikan'])){
        $query = mysqli_query($koneksi,"UPDATE pegawai_pendidikan SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idPendidikan='$_POST[idPendidikan]'");
        if($query){
          $_SESSION['notifdetail'] = 'del_pen_sukses';
        }else{
          $_SESSION['notifdetail'] = 'gagal';
        }
        echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
      }

      ?>

      <div class="col-md-6">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <h3>Riwayat Pendidikan</h3>
              <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addPendidikan<?= $record['idPegawai'] ?>"><i class="fa fa-plus"></i> Tambah</button>
              <table class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Thn Masuk</th>
                          <th>Thn Lulus</th>
                          <th>Sekolah/Universitas</th>
                          <th>Lokasi</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $tampil_pendidikan = mysqli_query($koneksi,"SELECT * FROM pegawai_pendidikan WHERE idPegawai='$record[idPegawai]' AND stdel='0'");
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil_pendidikan)){
                        echo "<tr>
                                <td>$no</td>
                                <td>$r[pendidikanMasuk]</td>
                                <td>$r[pendidikanKeluar]</td>
                                <td>$r[pendidikanSekolah]</td>
                                <td>$r[pendidikanLokasi]</td>
                                <td>
                                  <a href='#delPendidikan".$r['idPendidikan']."' data-toggle='modal' class='btn btn-xs btn-danger'><i class='fa fa-trash' data-toggle='tooltip; title='' data-original-title='Hapus'></i></a>
                                </td>
                              <tr>";
                        echo '<div class="modal modal-default fade" id="delPendidikan'.$r['idPendidikan'].'">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                        <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                                      </div>
                                      <div class="modal-body">
                                        <p>Apakah anda yakin akan menghapus data ini?</p>
                                      </div>
                                      <div class="modal-footer">
                                        <form action="index.php?view='.$_GET['view'].'&act='.$_GET['act'].'&hapuspendidikan&id='.$record['idPegawai'].'" method="post" accept-charset="utf-8">
                                        <input type="hidden" name="idPendidikan" value="'.$r['idPendidikan'].'">
                                        <input type="hidden" name="idPegawai" value="'.$r['idPegawai'].'">
                                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                        <button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                                        </form>               
                                      </div>
                                    </div>
                                    <!-- /.modal-content -->
                                  </div>
                                  <!-- /.modal-dialog -->
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

         <!-- MODAL RIWAYAT PENDIDIKAN-->
        <div class="modal fade in" id="addPendidikan<?= $record['idPegawai'] ?>" role="dialog" >
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Tambah Riwayat Pendidikan</h4>
              </div>
              <form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act] ?>&id=$r[idPegawai]&tambahpendidikan" method="post" accept-charset="utf-8">
              <div class="modal-body">
                <input type="hidden" class="form-control" required="" name="idPegawai" value="<?= $record['idPegawai'] ?>">
                <div id="p_scents_pendidikan">
                  <div class="row">
                  <div class="col-md-3">
                    <label>Tahun Masuk *</label>
                    <input type="text" class="form-control years" required="" name="pendidikan_masuk[]" placeholder="Contoh : 2010">
                  </div>
                  <div class="col-md-3">
                    <label>Tahun Lulus *</label>
                    <input type="text" class="form-control years" required="" name="pendidikan_keluar[]" placeholder="Contoh : 2014">
                  </div>
                  <div class="col-md-3">
                    <label>Sekolah/Universitas *</label>
                    <input type="text" class="form-control" required="" name="pendidikan_sekolah[]" placeholder="Sekolah/Universitas">
                  </div>
                  <div class="col-md-3">
                    <label>Lokasi *</label>
                    <input type="text" required="" name="pendidikan_lokasi[]" class="form-control" placeholder="Contoh : Jakarta">
                  </div>
                  </div>
                </div>
                <h6><a href="#" class="btn btn-xs btn-success" id="addScnt_pendidikan"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>
                <span>*) Wajib Diisi</span>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              </div>
              </form>   
            </div>
          </div>
        </div>


        <?php
          if (isset($_GET['tambahseminar'])){
            $seminarMulai = $_POST['seminar_mulai'];
            $seminarSelesai = $_POST['seminar_selesai'];
            $seminarPenyelenggara = $_POST['seminar_penyelenggara'];
            $seminarLokasi = $_POST['seminar_lokasi'];
            for ($i=0; $i < count($seminarMulai) ; $i++) { 
              $query = mysqli_query($koneksi,"INSERT INTO pegawai_seminar(idPegawai,seminarMulai,seminarSelesai,seminarPenyelenggara,seminarLokasi,stdel,cby,cdate) VALUES('$_POST[idPegawai]','$seminarMulai[$i]','$seminarSelesai[$i]','$seminarPenyelenggara[$i]','$seminarLokasi[$i]','0','$idUsers','$waktu_sekarang')");
            }
            if($query){
              $_SESSION['notifdetail'] = 'add_sem_sukses';
            }else{
              $_SESSION['notifdetail'] = 'gagal';
            }
             echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
          }

          if (isset($_GET['hapusseminar'])){
            $query = mysqli_query($koneksi,"UPDATE pegawai_seminar SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idSeminar='$_POST[idSeminar]'");
            if($query){
              $_SESSION['notifdetail'] = 'del_sem_sukses';
            }else{
              $_SESSION['notifdetail'] = 'gagal';
            }
            echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
          }
        ?>

        <div class="col-md-6">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <h3>Riwayat Seminar &amp; Pelatihan</h3>
              <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addSeminar<?= $record['idPegawai'] ?>"><i class="fa fa-plus"></i> Tambah</button>
              <table class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Mulai</th>
                          <th>Selesai</th>
                          <th>Penyelenggara</th>
                          <th>Lokasi</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $tampil_seminar = mysqli_query($koneksi,"SELECT * FROM pegawai_seminar WHERE idPegawai='$record[idPegawai]' AND stdel='0'");
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil_seminar)){
                        echo "<tr>
                                <td>$no</td>
                                <td>".tgl_indo($r[seminarMulai])."</td>
                                <td>".tgl_indo($r[seminarSelesai])."</td>
                                <td>$r[seminarPenyelenggara]</td>
                                <td>$r[seminarLokasi]</td>
                                <td>
                                  <a href='#delSeminar".$r['idSeminar']."' data-toggle='modal' class='btn btn-xs btn-danger'><i class='fa fa-trash' data-toggle='tooltip; title='' data-original-title='Hapus'></i></a>
                                </td>
                              <tr>";
                        echo '<div class="modal modal-default fade" id="delSeminar'.$r['idSeminar'].'">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                        <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                                      </div>
                                      <div class="modal-body">
                                        <p>Apakah anda yakin akan menghapus data ini?</p>
                                      </div>
                                      <div class="modal-footer">
                                        <form action="index.php?view='.$_GET['view'].'&act='.$_GET['act'].'&hapusseminar&id='.$record['idPegawai'].'" method="post" accept-charset="utf-8">
                                        <input type="hidden" name="idSeminar" value="'.$r['idSeminar'].'">
                                        <input type="hidden" name="idPegawai" value="'.$r['idPegawai'].'">
                                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                        <button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                                        </form>               
                                      </div>
                                    </div>
                                    <!-- /.modal-content -->
                                  </div>
                                  <!-- /.modal-dialog -->
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

        <!-- MODAL RIWAYAT SEMINAR & PELATIHAN -->
        <div class="modal fade in" id="addSeminar<?= $record['idPegawai'] ?>" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Tambah Riwayat Seminar &amp; Pelatihan</h4>
              </div>
              <form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act] ?>&id=$r[idPegawai]&tambahseminar" method="post" accept-charset="utf-8">
              <div class="modal-body">
                <input type="hidden" class="form-control" required="" name="idPegawai" value="<?= $record['idPegawai'] ?>">
                <div id="p_scents_seminar">
                    <div class="row">
                  <div class="col-md-3">
                    <label>Tanggal Mulai *</label>
                      <input class="form-control" required="" type="date" name="seminar_mulai[]" placeholder="YYYY/MM/DD">
                  </div>
                  <div class="col-md-3">
                    <label>Tanggal Selesai *</label>
                      <input class="form-control" required="" type="date" name="seminar_selesai[]" placeholder="Tanggal Selesai">
                  </div>
                  <div class="col-md-3">
                    <label>Penyelenggara *</label>
                    <input type="text" class="form-control" required="" name="seminar_penyelenggara[]" placeholder="Penyelenggara Workshop">
                  </div>
                  <div class="col-md-3">
                    <label>Lokasi *</label>
                    <input type="text" required="" name="seminar_lokasi[]" class="form-control" placeholder="Contoh : Jakarta">
                  </div>
                  </div>
                </div>
                <h6><a href="#" class="btn btn-xs btn-success" id="addScnt_seminar"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>
                <span>*) Wajib Diisi</span>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              </div>
              </form>   </div>
          </div>
        </div>
  </section>


  <?php
          if (isset($_GET['tambahkeluarga'])){
            $keluargaNama = $_POST['keluarga_nama'];
            $keluargaHubungan = $_POST['keluarga_hubungan'];
            $lokasi = $_POST['lokasi'];
            for ($i=0; $i < count($keluargaNama) ; $i++) { 
              $query = mysqli_query($koneksi,"INSERT INTO pegawai_keluarga(idPegawai,keluargaNama,keluargaHubungan,stdel,cby,cdate) VALUES('$_POST[idPegawai]','$keluargaNama[$i]','$keluargaHubungan[$i]','0','$idUsers','$waktu_sekarang')");
            }
            if($query){
              $_SESSION['notifdetail'] = 'add_kel_sukses';
            }else{
              $_SESSION['notifdetail'] = 'gagal';
            }
             echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
          }

          if (isset($_GET['hapuskeluarga'])){
            $query = mysqli_query($koneksi,"UPDATE pegawai_keluarga SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idKeluarga='$_POST[idKeluarga]'");
            if($query){
              $_SESSION['notifdetail'] = 'del_kel_sukses';
            }else{
              $_SESSION['notifdetail'] = 'gagal';
            }
            echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
          }
        ?>

  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-6">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <h3>Data Keluarga</h3>
              <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addKeluarga<?= $record['idPegawai'] ?>"><i class="fa fa-plus"></i> Tambah</button>
              <table class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Hubungan</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $tampil_keluarga = mysqli_query($koneksi,"SELECT * FROM pegawai_keluarga WHERE idPegawai='$record[idPegawai]' AND stdel='0'");
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil_keluarga)){
                        echo "<tr>
                                <td>$no</td>
                                <td>$r[keluargaNama]</td>
                                <td>$r[keluargaHubungan]</td>
                                <td>
                                  <a href='#delKeluarga".$r['idKeluarga']."' data-toggle='modal' class='btn btn-xs btn-danger'><i class='fa fa-trash' data-toggle='tooltip; title='' data-original-title='Hapus'></i></a>
                                </td>
                              <tr>";
                        echo '<div class="modal modal-default fade" id="delKeluarga'.$r['idKeluarga'].'">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                        <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                                      </div>
                                      <div class="modal-body">
                                        <p>Apakah anda yakin akan menghapus data ini?</p>
                                      </div>
                                      <div class="modal-footer">
                                        <form action="index.php?view='.$_GET['view'].'&act='.$_GET['act'].'&hapuskeluarga&id='.$record['idPegawai'].'" method="post" accept-charset="utf-8">
                                        <input type="hidden" name="idKeluarga" value="'.$r['idKeluarga'].'">
                                        <input type="hidden" name="idPegawai" value="'.$r['idPegawai'].'">
                                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                        <button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                                        </form>               
                                      </div>
                                    </div>
                                    <!-- /.modal-content -->
                                  </div>
                                  <!-- /.modal-dialog -->
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
         <!-- MODAL DATA KELUARGA -->
        <div class="modal fade in" id="addKeluarga<?= $record['idPegawai'] ?>" role="dialog">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Tambah Data Keluarga</h4>
              </div>
              <form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act] ?>&id=$r[idPegawai]&tambahkeluarga" method="post" accept-charset="utf-8">
              <div class="modal-body">
                <input type="hidden" class="form-control" required="" name="idPegawai" value="<?= $record['idPegawai'] ?>">
                <div id="p_scents_keluarga">
                    <div class="row">
                  <div class="col-md-6">
                    <label>Nama Anggota Keluarga *</label>
                      <input class="form-control" required="" type="text" name="keluarga_nama[]" placeholder="Masukkan Nama Anggota Kelurga">
                  </div>
                  <div class="col-md-4">
                    <label>Hubungan *</label>
                      <select class="form-control" required="" name="keluarga_hubungan[]">
                          <option value="">-Pilih Hubungan-</option>
                          <option value="Istri">Istri</option>
                          <option value="Suami">Suami</option>
                          <option value="Anak">Anak</option>
                          <option value="Ayah">Ayah</option>
                          <option value="Ibu">Ibu</option>
                          <option value="Lainnya">Lainnya</option>
                        </select>
                  </div>
                  </div>
                </div>
                <h6><a href="#" class="btn btn-xs btn-success" id="addScnt_keluarga"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>
                <span>*) Wajib Diisi</span>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
              </div>
              </form>   
            </div>
          </div>
        </div>

        <?php
          if (isset($_GET['tambahjabatan'])){
            $jabatanMulai = $_POST['jabatan_mulai'];
            $jabatanSelesai = $_POST['jabatan_selesai'];
            $jabatanKeterangan = $_POST['jabatan_keterangan'];
            for ($i=0; $i < count($jabatanMulai) ; $i++) { 
              $query = mysqli_query($koneksi,"INSERT INTO pegawai_jabatan(idPegawai,jabatanMulai,jabatanSelesai,jabatanKeterangan,stdel,cby,cdate) VALUES('$_POST[idPegawai]','$jabatanMulai[$i]','$jabatanSelesai[$i]','$jabatanKeterangan[$i]','0','$idUsers','$waktu_sekarang')");
            }
            if($query){
              $_SESSION['notifdetail'] = 'add_jab_sukses';
            }else{
              $_SESSION['notifdetail'] = 'gagal';
            }
             echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
          }

          if (isset($_GET['hapusjabatan'])){
            $query = mysqli_query($koneksi,"UPDATE pegawai_jabatan SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idPegawaiJabatan='$_POST[idPegawaiJabatan]'");
            if($query){
              $_SESSION['notifdetail'] = 'del_jab_sukses';
            }else{
              $_SESSION['notifdetail'] = 'gagal';
            }
            echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
          }
        ?>


        <div class="col-md-6">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <h3>Riwayat Jabatan</h3>
              <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addJabatan<?= $record['idPegawai'] ?>"><i class="fa fa-plus"></i> Tambah</button>
              <table class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Tahun Mulai</th>
                          <th>Tahun Selesai</th>
                          <th>Keterangan</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $tampil_jabatan = mysqli_query($koneksi,"SELECT * FROM pegawai_jabatan WHERE idPegawai='$record[idPegawai]' AND stdel='0'");
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil_jabatan)){
                        echo "<tr>
                                <td>$no</td>
                                <td>$r[jabatanMulai]</td>
                                <td>$r[jabatanSelesai]</td>
                                <td>$r[jabatanKeterangan]</td>
                                <td>
                                  <a href='#delJabatan".$r['idPegawaiJabatan']."' data-toggle='modal' class='btn btn-xs btn-danger'><i class='fa fa-trash' data-toggle='tooltip; title='' data-original-title='Hapus'></i></a>
                                </td>
                              <tr>";
                        echo '<div class="modal modal-default fade" id="delJabatan'.$r['idPegawaiJabatan'].'">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                        <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                                      </div>
                                      <div class="modal-body">
                                        <p>Apakah anda yakin akan menghapus data ini?</p>
                                      </div>
                                      <div class="modal-footer">
                                        <form action="index.php?view='.$_GET['view'].'&act='.$_GET['act'].'&hapusjabatan&id='.$record['idPegawai'].'" method="post" accept-charset="utf-8">
                                        <input type="hidden" name="idPegawaiJabatan" value="'.$r['idPegawaiJabatan'].'">
                                        <input type="hidden" name="idPegawai" value="'.$r['idPegawai'].'">
                                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                        <button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                                        </form>               
                                      </div>
                                    </div>
                                    <!-- /.modal-content -->
                                  </div>
                                  <!-- /.modal-dialog -->
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

         <!-- MODAL RIWAYAT JABATAN -->
        <div class="modal fade in" id="addJabatan<?= $record['idPegawai'] ?>" role="dialog">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h4 class="modal-title">Tambah Riwayat Jabatan</h4>
            </div>
              <form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act] ?>&id=$r[idPegawai]&tambahjabatan" method="post" accept-charset="utf-8">
            <div class="modal-body">
              <input type="hidden" class="form-control" required="" name="idPegawai" value="<?= $record['idPegawai'] ?>">
              <div id="p_scents_jabatan">
                  <div class="row">
                <div class="col-md-4">
                  <label>Tahun Mulai *</label>
                    <input class="form-control" required="" type="date" name="jabatan_mulai[]" placeholder="Masukkan Tahun Mulai">
                </div>
                <div class="col-md-4">
                  <label>Tahun Selesai *</label>
                    <input class="form-control" required="" type="date" name="jabatan_selesai[]" placeholder="Masukkan Tahun Selesai">
                </div>
                <div class="col-md-4">
                  <label>Keterangan *</label>
                    <input class="form-control" required="" type="text" name="jabatan_keterangan[]" placeholder="Masukkan Keterangan">
                </div>
                </div>
              </div>
              <h6><a href="#" class="btn btn-xs btn-success" id="addScnt_jabatan"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>
              <span>*) Wajib Diisi</span>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Simpan</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>   </div>
        </div>
      </div>
  </section>

  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">

      <?php
          if (isset($_GET['tambahmengajar'])){
            $mengajarMulai = $_POST['mengajar_mulai'];
            $mengajarSelesai = $_POST['mengajar_selesai'];
            $mengajarMP = $_POST['mengajar_MP'];
            $mengajarKeterangan = $_POST['mengajar_keterangan'];
            for ($i=0; $i < count($mengajarMulai) ; $i++) { 
              $query = mysqli_query($koneksi,"INSERT INTO pegawai_mengajar(idPegawai,mengajarMulai,mengajarSelesai,mengajarMP,mengajarKeterangan,stdel,cby,cdate) VALUES('$_POST[idPegawai]','$mengajarMulai[$i]','$mengajarSelesai[$i]','$mengajarMP[$i]','$mengajarKeterangan[$i]','0','$idUsers','$waktu_sekarang')");
            }
            if($query){
              $_SESSION['notifdetail'] = 'add_mengajar_sukses';
            }else{
              $_SESSION['notifdetail'] = 'gagal';
            }
             echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
          }

          if (isset($_GET['hapusmengajar'])){
            $query = mysqli_query($koneksi,"UPDATE pegawai_mengajar SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idMengajar='$_POST[idMengajar]'");
            if($query){
              $_SESSION['notifdetail'] = 'del_mengajar_sukses';
            }else{
              $_SESSION['notifdetail'] = 'gagal';
            }
            echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
          }
        ?>

      <div class="col-md-6">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <h3>Riwayat Mengajar</h3>
              <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addMengajar<?= $record['idPegawai'] ?>"><i class="fa fa-plus"></i> Tambah</button>
              <table class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Tahun Mulai</th>
                          <th>Tahun Selesai</th>
                          <th>Mata Pelajaran</th>
                          <th>Keterangan</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                      $tampil_mengajar = mysqli_query($koneksi,"SELECT * FROM pegawai_mengajar WHERE idPegawai='$record[idPegawai]' AND stdel='0'");
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil_mengajar)){
                        echo "<tr>
                                <td>$no</td>
                                <td>$r[mengajarMulai]</td>
                                <td>$r[mengajarSelesai]</td>
                                <td>$r[mengajarMP]</td>
                                <td>$r[mengajarKeterangan]</td>
                                <td>
                                  <a href='#delMengajar".$r['idMengajar']."' data-toggle='modal' class='btn btn-xs btn-danger'><i class='fa fa-trash' data-toggle='tooltip; title='' data-original-title='Hapus'></i></a>
                                </td>
                              <tr>";
                        echo '<div class="modal modal-default fade" id="delMengajar'.$r['idMengajar'].'">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                        <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                                      </div>
                                      <div class="modal-body">
                                        <p>Apakah anda yakin akan menghapus data ini?</p>
                                      </div>
                                      <div class="modal-footer">
                                        <form action="index.php?view='.$_GET['view'].'&act='.$_GET['act'].'&hapusmengajar&id='.$record['idPegawai'].'" method="post" accept-charset="utf-8">
                                        <input type="hidden" name="idMengajar" value="'.$r['idMengajar'].'">
                                        <input type="hidden" name="idPegawai" value="'.$r['idPegawai'].'">
                                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                        <button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                                        </form>               
                                      </div>
                                    </div>
                                    <!-- /.modal-content -->
                                  </div>
                                  <!-- /.modal-dialog -->
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

       <!-- MODAL RIWAYAT MENGAJAR -->
      <div class="modal fade" id="addMengajar<?= $record['idPegawai'] ?>" role="dialog" style="display: none;">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h4 class="modal-title">Tambah Riwayat Mengajar</h4>
            </div>
            <form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act] ?>&id=$r[idPegawai]&tambahmengajar" method="post" accept-charset="utf-8">
            <div class="modal-body">
              <input type="hidden" class="form-control" required="" name="idPegawai" value="<?= $record['idPegawai'] ?>">
              <div id="p_scents_mengajar">
                  <div class="row">
                <div class="col-md-3">
                  <label>Tahun Mulai *</label>
                    <input class="form-control" required="" type="date" name="mengajar_mulai[]" placeholder="Masukkan Tahun Mulai">
                </div>
                <div class="col-md-3">
                  <label>Tahun Selesai *</label>
                    <input class="form-control" required="" type="date" name="mengajar_selesai[]" placeholder="Masukkan Tahun Selesai">
                </div>
                <div class="col-md-3">
                  <label>Mata Pelajaran *</label>
                    <input class="form-control" required="" type="text" name="mengajar_MP[]" placeholder="Masukkan Mata Pelajaran">
                </div>
                <div class="col-md-3">
                  <label>Keterangan *</label>
                    <input class="form-control" required="" type="text" name="mengajar_keterangan[]" placeholder="Masukkan Keterangan">
                </div>
                </div>
              </div>
              <h6><a href="#" class="btn btn-xs btn-success" id="addScnt_mengajar"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>
              <span>*) Wajib Diisi</span>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success">Simpan</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>   
          </div>
        </div>
      </div>
  

        <?php
          if (isset($_GET['tambahpenghargaan'])){
            $penghargaanTahun = $_POST['penghargaan_tahun'];
            $penghargaanNama = $_POST['penghargaan_nama'];
            for ($i=0; $i < count($penghargaanTahun) ; $i++) { 
              $query = mysqli_query($koneksi,"INSERT INTO pegawai_penghargaan(idPegawai,penghargaanTahun,penghargaanNama,stdel,cby,cdate) VALUES('$_POST[idPegawai]','$penghargaanTahun[$i]','$penghargaanNama[$i]','0','$idUsers','$waktu_sekarang')");
            }
            if($query){
              $_SESSION['notifdetail'] = 'add_penghargaan_sukses';
            }else{
              $_SESSION['notifdetail'] = 'gagal';
            }
             echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
          }

          if (isset($_GET['hapuspenghargaan'])){
            $query = mysqli_query($koneksi,"UPDATE pegawai_penghargaan SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idPenghargaan='$_POST[idPenghargaan]'");
            if($query){
              $_SESSION['notifdetail'] = 'del_penghargaan_sukses';
            }else{
              $_SESSION['notifdetail'] = 'gagal';
            }
            echo "<script>document.location='index.php?view=$_GET[view]&act=$_GET[act]&id=$_POST[idPegawai]';</script>";
          }
        ?>
        <div class="col-md-6">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <h3>Penghargaan</h3>
              <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addPenghargaan<?= $record['idPegawai'] ?>"><i class="fa fa-plus"></i> Tambah</button>
              <table class="table table-bordered table-hover">
                  <thead>
                      <tr>
                          <th>No</th>
                          <th>Tahun</th>
                          <th>Keterangan</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>                 
                    <?php
                      $tampil_penghargaan = mysqli_query($koneksi,"SELECT * FROM pegawai_penghargaan WHERE idPegawai='$record[idPegawai]' AND stdel='0'");
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil_penghargaan)){
                        echo "<tr>
                                <td>$no</td>
                                <td>$r[penghargaanTahun]</td>
                                <td>$r[penghargaanNama]</td>
                                <td>
                                  <a href='#delPenghargaan".$r['idPenghargaan']."' data-toggle='modal' class='btn btn-xs btn-danger'><i class='fa fa-trash' data-toggle='tooltip; title='' data-original-title='Hapus'></i></a>
                                </td>
                              <tr>";
                        echo '<div class="modal modal-default fade" id="delPenghargaan'.$r['idPenghargaan'].'">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                        <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                                      </div>
                                      <div class="modal-body">
                                        <p>Apakah anda yakin akan menghapus data ini?</p>
                                      </div>
                                      <div class="modal-footer">
                                        <form action="index.php?view='.$_GET['view'].'&act='.$_GET['act'].'&hapuspenghargaan&id='.$record['idPegawai'].'" method="post" accept-charset="utf-8">
                                        <input type="hidden" name="idPenghargaan" value="'.$r['idPenghargaan'].'">
                                        <input type="hidden" name="idPegawai" value="'.$r['idPegawai'].'">
                                        <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                        <button type="submit" class="btn btn-danger"><span class="fa fa-check"></span> Hapus</button>
                                        </form>               
                                      </div>
                                    </div>
                                    <!-- /.modal-content -->
                                  </div>
                                  <!-- /.modal-dialog -->
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

        <div class="modal fade in" id="addPenghargaan<?= $record['idPegawai'] ?>" role="dialog">
          <div class="modal-dialog modal-md">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Tambah Data Penghargaan</h4>
              </div>
              <form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act] ?>&id=$r[idPegawai]&tambahpenghargaan" method="post" accept-charset="utf-8">
              <div class="modal-body">
                <input type="hidden" class="form-control" required="" name="idPegawai" value="<?= $record['idPegawai'] ?>">
                <div id="p_scents_penghargaan">
                    <div class="row">
                  <div class="col-md-4">
                    <label>Tahun *</label>
                      <input class="form-control years" required="" type="text" name="penghargaan_tahun[]" placeholder="Masukkan Tahun">
                  </div>
                  <div class="col-md-6">
                    <label>Nama Penghargaan *</label>
                      <input class="form-control" required="" type="text" name="penghargaan_nama[]" placeholder="Masukkan Nama Penghargaan">
                  </div>
                  </div>
                </div>
                <h6><a href="#" class="btn btn-xs btn-success" id="addScnt_penghargaan"><i class="fa fa-plus"></i><b> Tambah Baris</b></a></h6>
                <span>*) Wajib Diisi</span>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
              </form>   </div>
          </div>
        </div>
    </div>
  </section>



<?php }elseif($_GET[act]=='edit'){
  if (isset($_POST[update])){ 
    
    $lokasi_file = $_FILES['foto']['tmp_name'];
    $nama_file   = $_FILES['foto']['name'];

    if((!empty($_POST['nipPegawai'])) && (!empty($_POST['namaPegawai'])) && (!empty($_POST['unitPegawai'])) && (!empty($_POST['jabatanPegawai'])) && (!empty($_POST['statusKepegawaian'])))
      {
        if ($_POST['tglLahirPegawai'] ==''){$tglLahirPegawai='0000-00-00';}else{ $tglLahirPegawai=$_POST['tglLahirPegawai'];}
        if ($_POST['tglMasukPegawai'] ==''){$tglMasukPegawai='0000-00-00';}else{ $tglMasukPegawai=$_POST['tglMasukPegawai'];}
        if ($_POST['tglKeluarPegawai'] ==''){$tglKeluarPegawai='0000-00-00';}else{ $tglKeluarPegawai=$_POST['tglKeluarPegawai'];}
        if (!empty($lokasi_file)){
          UploadGambar($lokasi_penyimpanan_fotoPegawai,$lokasi_file,$nama_file);
          $query = mysqli_query($koneksi, "UPDATE pegawai SET nipPegawai='$_POST[nipPegawai]',namaPegawai='$_POST[namaPegawai]',jkPegawai='$_POST[jkPegawai]',tempatLahirPegawai='$_POST[tempatLahirPegawai]',tglLahirPegawai='$tglLahirPegawai',pendidikanPegawai='$_POST[pendidikanPegawai]',unitPegawai='$_POST[unitPegawai]',jabatanPegawai='$_POST[jabatanPegawai]',statusKepegawaian='$_POST[statusKepegawaian]',alamatPegawai='$_POST[alamatPegawai]',noHpPegawai='$_POST[noHpPegawai]',emailPegawai='$_POST[emailPegawai]',tglMasukPegawai='$tglMasukPegawai',tglKeluarPegawai='$tglKeluarPegawai',statusPegawai='$_POST[statusPegawai]',fotoPegawai='$nama_file',uby='$idUsers',udate='$waktu_sekarang' WHERE idPegawai='$_POST[id]'");
        }else{
          $query = mysqli_query($koneksi, "UPDATE pegawai SET nipPegawai='$_POST[nipPegawai]',namaPegawai='$_POST[namaPegawai]',jkPegawai='$_POST[jkPegawai]',tempatLahirPegawai='$_POST[tempatLahirPegawai]',tglLahirPegawai='$tglLahirPegawai',pendidikanPegawai='$_POST[pendidikanPegawai]',unitPegawai='$_POST[unitPegawai]',jabatanPegawai='$_POST[jabatanPegawai]',statusKepegawaian='$_POST[statusKepegawaian]',alamatPegawai='$_POST[alamatPegawai]',noHpPegawai='$_POST[noHpPegawai]',emailPegawai='$_POST[emailPegawai]',tglMasukPegawai='$tglMasukPegawai',tglKeluarPegawai='$tglKeluarPegawai',statusPegawai='$_POST[statusPegawai]',uby='$idUsers',udate='$waktu_sekarang' WHERE idPegawai='$_POST[id]'");
        }

        if ($query){
          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
          $_SESSION['notif'] = 'usukses';
        }else{
          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
          $_SESSION['notif'] = 'gagal';
        }  
      }

  }
  $edit = mysqli_query($koneksi,"SELECT * FROM pegawai WHERE idPegawai='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
  if (empty($record['fotoPegawai'])) {  
    $foto_pegawai = $lokasi_default_fotoPegawai; }
  else{
    $foto_pegawai = $lokasi_penyimpanan_fotoPegawai.$record['fotoPegawai']; 
  }
?>
  
 <form method="POST" action="" class="form-horizontal"  enctype="multipart/form-data">

      <div class="col-md-9">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body">
            <?php
              if (isset($_POST['update'])){
                if(empty($_POST['nipPegawai'])){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian NIP wajib diisi
                          </div>";
                }
                if(empty($_POST['namaPegawai'])){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Nama Lengkap wajib diisi
                          </div>";
                }
                if(empty($_POST['unitPegawai'])){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Unit Sekolah wajib diisi
                          </div>";
                }
                if(empty($_POST['jabatanPegawai'])){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Jabatan Pegawai wajib diisi
                          </div>";
                }
                if(empty($_POST['statusKepegawaian'])){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Status Kepegawaian wajib diisi
                          </div>";
                }
                if($_POST['passwordPegawai'] != $_POST['konfirmasiPassword']){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Password dan konfirmasi password baru tidak sama
                          </div>";
                }
              }
            ?>
            <input name="id" type="hidden" value="<?= $record['idPegawai'] ?>">
            <label>NIP <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
            <input name="nipPegawai" type="text" class="form-control" placeholder="NIP Pegawai" value="<?= $record['nipPegawai'] ?>">
            <br>
            <label>Nama lengkap <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
            <input name="namaPegawai" type="text" class="form-control" value="<?= $record['namaPegawai'] ?>" placeholder="Nama lengkap">
            <br>
            <label>Jenis Kelamin</label>
              <div class="radio">
                <label>
                  <?php
                    if ($record['jkPegawai'] == 'L'){
                      echo '<input type="radio" name="jkPegawai" value="L" checked> Laki-laki';
                    }else{
                      echo '<input type="radio" name="jkPegawai" value="L"> Laki-laki';
                    }
                  ?>
                </label>
                &nbsp;&nbsp;
                <label>
                  <?php
                    if ($record['jkPegawai'] == 'P'){
                      echo '<input type="radio" name="jkPegawai" value="P" checked> Perempuan';
                    }else{
                      echo '<input type="radio" name="jkPegawai" value="P"> Perempuan';
                    }
                  ?>                     
                </label>
              </div>
              <br>
              <label>Tempat Lahir</label>
              <input name="tempatLahirPegawai" type="text" class="form-control" value="<?= $record['tempatLahirPegawai'] ?>" placeholder="Tempat Lahir">
              <br>
              <label>Tanggal Lahir </label>
              <div class="input-group date date-picker " data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control" type="text" name="tglLahirPegawai" readonly="readonly" placeholder="Tanggal" value="<?php if($record[tglLahirPegawai] == '0000-00-00') {echo ''; } else { echo $record[tglLahirPegawai]; } ?>">
              </div>
              <br>
              <label>Pendidikan Terakhir <small data-toggle="tooltip" title="" data-original-title="Wajib diisi"></small></label>
              <input type="hidden" value="<?= $record['pendidikanPegawai'] ?>" id="idPendidikan">
              <select name="pendidikanPegawai" id="Cpendidikan" class="form-control"></select>
              <br>
              <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="hidden" value="<?= $record['unitPegawai'] ?>" id="idUnit">
              <select name="unitPegawai" class="form-control" id="Cunit"></select>
              <br>
              <label>Jabatan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="hidden" value="<?= $record['jabatanPegawai'] ?>" id="idJabatan">
              <select name="jabatanPegawai" class="form-control" id="Cjabatan">
                <option value="" disabled selected> - Pilih Jabatan Pegawai - </option>
              </select>
              <br>
              <label>Status Kepegawaian <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="hidden" value="<?= $record['statusKepegawaian'] ?>" id="idKepegawaian">
              <select name="statusKepegawaian" id="Ckepegawaian" class="form-control"></select>
              <br>
              <label>Alamat</label>
              <textarea class="form-control" name="alamatPegawai" placeholder="Alamat Tempat Tinggal"><?= $record['alamatPegawai']?></textarea>
              <br>
              <label>Telpon/HP <small data-toggle="tooltip" title="" data-original-title="Wajib diisi"></small></label>
              <input name="noHpPegawai" type="text" class="form-control" value="<?= $record[noHpPegawai]?>" placeholder="Telpon/HP Pegawai">
              <br>
              <label>Email <small data-toggle="tooltip" title="" data-original-title="Wajib diisi"></small></label>
              <input name="emailPegawai" type="email" class="form-control" placeholder="Email Pegawai" value="<?= $record[emailPegawai] ?>">
              <br>
              <label>Tanggal Masuk </label>
              <div class="input-group date date-picker " data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control" type="text" name="tglMasukPegawai" readonly="readonly" placeholder="Tanggal Masuk" value="<?php if($record[tglMasukPegawai] == '0000-00-00') {echo ''; } else { echo $record[tglMasukPegawai]; } ?>">
              </div>
              <br>
              <label>Tanggal Keluar <small>Kosongi jika masih aktif</small></label>
              <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control" type="text" name="tglKeluarPegawai" readonly="readonly" placeholder="Tanggal Keluar" value="<?php if($record[tglKeluarPegawai] == '0000-00-00') {echo ''; } else { echo $record[tglKeluarPegawai]; } ?>">
              </div>
              <br>
            <p class="text-muted">*) Kolom wajib diisi.</p>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-3">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body">
          
              <label>Status</label>
              <div class="radio">
                <label>
                  <?php 
                    if($record['statusPegawai'] == 'Aktif'){
                      echo '<input type="radio" name="statusPegawai" value="Aktif" checked> Aktif';
                    }else{
                      echo '<input type="radio" name="statusPegawai" value="Aktif"> Aktif';
                    }
                  ?>
                </label>
              </div>
              <div class="radio">
                <label>
                   <?php 
                    if($record['statusPegawai'] == 'Tidak Aktif'){
                      echo '<input type="radio" name="statusPegawai" value="Tidak Aktif" checked=""> Tidak Aktif';
                    }else{
                      echo '<input type="radio" name="statusPegawai" value="Tidak Aktif"> Tidak Aktif';
                    }
                  ?>
                </label>
              </div>
            <br>
            <label>Foto</label>
            <a href="#" class="thumbnail">
              <img src="<?= $foto_pegawai ?>" id="target" alt="Choose image to upload">
            </a>
            <input type="file" id="foto" name="foto">
            <br>
            <button type="submit" name="update" class="btn btn-block btn-success">Simpan</button>
            <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
                      </div>
          <!-- /.box-body -->
        </div>
      </div>
  </form>

<?php }elseif($_GET[act]=='tambah'){

  if (isset($_POST['tambah'])){
    $cek_nip = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE nipPegawai='$_POST[nipPegawai]'");
    $hitung = mysqli_num_rows($cek_nip);

    $lokasi_file = $_FILES['foto']['tmp_name'];
    $nama_file   = $_FILES['foto']['name'];

    if (empty($_POST['passwordPegawai'])){
      $passwordPegawai = md5($password_default);
    }else{
      $passwordPegawai = md5($_POST['passwordPegawai']);
    }
    
    if(($hitung == 0) && (!empty($_POST['nipPegawai'])) && (!empty($_POST['namaPegawai'])) && (!empty($_POST['unitPegawai'])) && (!empty($_POST['jabatanPegawai'])) && (!empty($_POST['statusKepegawaian'])) && ($_POST['passwordPegawai'] == $_POST['konfirmasiPassword']))
      {
        if ($_POST['tglLahirPegawai'] ==''){$tglLahirPegawai='0000-00-00';}else{ $tglLahirPegawai=$_POST['tglLahirPegawai'];}
        if ($_POST['tglMasukPegawai'] ==''){$tglMasukPegawai='0000-00-00';}else{ $tglMasukPegawai=$_POST['tglMasukPegawai'];}
        if ($_POST['tglKeluarPegawai'] ==''){$tglKeluarPegawai='0000-00-00';}else{ $tglKeluarPegawai=$_POST['tglKeluarPegawai'];}
        if (!empty($lokasi_file)){
          UploadGambar($lokasi_penyimpanan_fotoPegawai,$lokasi_file,$nama_file);
          $query = mysqli_query($koneksi,"INSERT INTO pegawai(nipPegawai,namaPegawai,jkPegawai,tempatLahirPegawai,tglLahirPegawai,pendidikanPegawai,unitPegawai,jabatanPegawai,statusKepegawaian,alamatPegawai,passwordPegawai,noHpPegawai,emailPegawai,tglMasukPegawai,tglKeluarPegawai,statusPegawai,fotoPegawai,stdel,cby,cdate) VALUES ('$_POST[nipPegawai]','$_POST[namaPegawai]','$_POST[jkPegawai]','$_POST[tempatLahirPegawai]','$tglLahirPegawai','$_POST[pendidikanPegawai]','$_POST[unitPegawai]','$_POST[jabatanPegawai]','$_POST[statusKepegawaian]','$_POST[alamatPegawai]','$passwordPegawai','$_POST[noHpPegawai]','$_POST[emailPegawai]','$tglMasukPegawai','$tglKeluarPegawai','$_POST[statusPegawai]','$nama_file','0','$idUsers','$waktu_sekarang')");
        }else{
          $query = mysqli_query($koneksi,"INSERT INTO pegawai(nipPegawai,namaPegawai,jkPegawai,tempatLahirPegawai,tglLahirPegawai,pendidikanPegawai,unitPegawai,jabatanPegawai,statusKepegawaian,alamatPegawai,passwordPegawai,noHpPegawai,emailPegawai,tglMasukPegawai,tglKeluarPegawai,statusPegawai,stdel,cby,cdate) VALUES ('$_POST[nipPegawai]','$_POST[namaPegawai]','$_POST[jkPegawai]','$_POST[tempatLahirPegawai]','$tglLahirPegawai','$_POST[pendidikanPegawai]','$_POST[unitPegawai]','$_POST[jabatanPegawai]','$_POST[statusKepegawaian]','$_POST[alamatPegawai]','$passwordPegawai','$_POST[noHpPegawai]','$_POST[emailPegawai]','$tglMasukPegawai','$tglKeluarPegawai','$_POST[statusPegawai]','0','$idUsers','$waktu_sekarang')");
        }

        if ($query){
          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
          $_SESSION['notif'] = 'csukses';
        }else{
          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
          $_SESSION['notif'] = 'gagal';
        }  
      }

  }

?>
  <form method="POST" action="" class="form-horizontal"  enctype="multipart/form-data">

      <div class="col-md-9">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body">
            <?php
              if (isset($_POST['tambah'])){
                
                if ($hitung > 0){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Nik tersebut telah terdaftar.
                          </div>";
                }
                if(empty($_POST['nipPegawai'])){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian NIP wajib diisi
                          </div>";
                }
                if(empty($_POST['namaPegawai'])){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Nama Lengkap wajib diisi
                          </div>";
                }
                if(empty($_POST['unitPegawai'])){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Unit Sekolah wajib diisi
                          </div>";
                }
                if(empty($_POST['jabatanPegawai'])){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Jabatan Pegawai wajib diisi
                          </div>";
                }
                if(empty($_POST['statusKepegawaian'])){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Status Kepegawaian wajib diisi
                          </div>";
                }
                if($_POST['passwordPegawai'] != $_POST['konfirmasiPassword']){
                  echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Password dan konfirmasi password baru tidak sama
                          </div>";
                }
              }
            ?>
            <label>NIP <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
            <input name="nipPegawai" type="text" class="form-control" placeholder="NIP Pegawai" value="<?= $_POST['nipPegawai'] ?>">
            <br>
            <label>Nama lengkap <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
            <input name="namaPegawai" type="text" class="form-control" value="<?= $_POST['namaPegawai'] ?>" placeholder="Nama lengkap">
            <br>
            <label>Jenis Kelamin</label>
              <div class="radio">
                <label>
                  <?php
                    if ($_POST['jkPegawai'] == 'L'){
                      echo '<input type="radio" name="jkPegawai" value="L" checked> Laki-laki';
                    }else{
                      echo '<input type="radio" name="jkPegawai" value="L"> Laki-laki';
                    }
                  ?>
                </label>
                &nbsp;&nbsp;
                <label>
                  <?php
                    if ($_POST['jkPegawai'] == 'P'){
                      echo '<input type="radio" name="jkPegawai" value="P" checked> Perempuan';
                    }else{
                      echo '<input type="radio" name="jkPegawai" value="P"> Perempuan';
                    }
                  ?>                     
                </label>
              </div>
              <br>
              <label>Tempat Lahir</label>
              <input name="tempatLahirPegawai" type="text" class="form-control" value="<?= $_POST['tempatLahirPegawai'] ?>" placeholder="Tempat Lahir">
              <br>
              <label>Tanggal Lahir </label>
              <div class="input-group date date-picker " data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control" type="text" name="tglLahirPegawai" readonly="readonly" placeholder="Tanggal" value="<?php if($_POST[tglLahirPegawai] == '0000-00-00') {echo ''; } else { echo $_POST[tglLahirPegawai]; } ?>">
              </div>
              <br>
              <label>Pendidikan Terakhir <small data-toggle="tooltip" title="" data-original-title="Wajib diisi"></small></label>
              <input type="hidden" id="idPendidikan" value="<?= $_POST['pendidikanPegawai']?>">
              <select name="pendidikanPegawai" id="Cpendidikan" class="form-control"></select>
              <br>
              <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="hidden" id="idUnit" value="<?= $_POST['unitPegawai']?>">
              <select name="unitPegawai" class="form-control" id="Cunit"></select>
              <br>
              <label>Jabatan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="hidden" id="idJabatan" value="<?= $_POST['jabatanPegawai']?>">
              <select name="jabatanPegawai" class="form-control" id="Cjabatan">
                <option value="" disabled selected> - Pilih Jabatan Pegawai - </option>
              </select>
              <br>
              <label>Status Kepegawaian <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="hidden" id="idKepegawaian" value="<?= $_POST['statusKepegawaian']?>">
              <select name="statusKepegawaian" id="Ckepegawaian" class="form-control"></select>
              <br>
              <label>Alamat</label>
              <textarea class="form-control" name="alamatPegawai" placeholder="Alamat Tempat Tinggal"><?= $_POST['alamatPegawai']?></textarea>
              <br>
              <label>Password <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">Defaul :  <font color="red">123456</font></small></label>
              <input name="passwordPegawai" type="password" class="form-control" placeholder="Password" value="<?= $_POST[passwordPegawai]?>">
              <br>
              <label>Konfirmasi Password <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">Kosongi jika password kosong</small></label>
              <input name="konfirmasiPassword" type="password" class="form-control" placeholder="Konfirmasi Password" value="<?= $_POST[konfirmasiPassword]?>">
              <br>
              <label>Telpon/HP <small data-toggle="tooltip" title="" data-original-title="Wajib diisi"></small></label>
              <input name="noHpPegawai" type="text" class="form-control" value="<?= $_POST[noHpPegawai]?>" placeholder="Telpon/HP Pegawai">
              <br>
              <label>Email <small data-toggle="tooltip" title="" data-original-title="Wajib diisi"></small></label>
              <input name="emailPegawai" type="email" class="form-control" placeholder="Email Pegawai" value="<?= $_POST[emailPegawai] ?>">
              <br>
              <label>Tanggal Masuk </label>
              <div class="input-group date date-picker " data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control" type="text" name="tglMasukPegawai" readonly="readonly" placeholder="Tanggal Masuk" value="<?php if($_POST[tglMasukPegawai] == '0000-00-00') {echo ''; } else { echo $_POST[tglMasukPegawai]; } ?>">
              </div>
              <br>
              <label>Tanggal Keluar <small>Kosongi jika masih aktif</small></label>
              <div class="input-group date date-picker " data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control" type="text" name="tglKeluarPegawai" readonly="readonly" placeholder="Tanggal Keluar" value="<?php if($_POST[tglKeluarPegawai] == '0000-00-00') {echo ''; } else { echo $_POST[tglKeluarPegawai]; } ?>">
              </div>
              <br>
            <p class="text-muted">*) Kolom wajib diisi.</p>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
      <div class="col-md-3">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body">
          
              <label>Status</label>
              <div class="radio">
                <label>
                  <?php 
                    if($_POST['statusPegawai'] == 'Aktif'){
                      echo '<input type="radio" name="statusPegawai" value="Aktif" checked> Aktif';
                    }else{
                      echo '<input type="radio" name="statusPegawai" value="Aktif"> Aktif';
                    }
                  ?>
                </label>
              </div>
              <div class="radio">
                <label>
                   <?php 
                    if($_POST['statusPegawai'] == 'Tidak Aktif'){
                      echo '<input type="radio" name="statusPegawai" value="Tidak Aktif" checked=""> Tidak Aktif';
                    }else{
                      echo '<input type="radio" name="statusPegawai" value="Tidak Aktif" checked> Tidak Aktif';
                    }
                  ?>
                </label>
              </div>
            <br>
            <label>Foto</label>
            <a href="#" class="thumbnail">
              <img src="<?= $lokasi_default_fotoPegawai ?>" id="target" alt="Choose image to upload">
            </a>
            <input type="file" id="foto" name="foto">
            <br>
            <button type="submit" name="tambah" class="btn btn-block btn-success">Simpan</button>
            <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
                      </div>
          <!-- /.box-body -->
        </div>
      </div>
  </form>
<?php
}elseif($_GET[act]=='reset password'){ ?>

<form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
          <div class="box box-success">
            <div class="box-body">
              <?php
                if (isset($_POST[reset])){
                  $password = md5($_POST['password_baru']); 
                  if (strlen($_POST['password_baru']) <= 5){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Password Baru minimal 6 karakter.
                          </div>";
                  }
                  if(strlen($_POST['konfirmasi_password_baru']) <= 5){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Konfirmasi Password Baru minimal 6 karakter.
                          </div>";
                  }
                  if($_POST['password_baru'] != $_POST['konfirmasi_password_baru']){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Password dan Konfirmasi Password baru tidak sama.
                          </div>";
                  }
                  if ((strlen($_POST['password_baru']) > 5) && (strlen($_POST['konfirmasi_password_baru']) > 5) && ($_POST['password_baru'] == $_POST['konfirmasi_password_baru'])) {
                    $query = mysqli_query($koneksi, "UPDATE pegawai SET passwordPegawai='$password', uby='$idUsers', udate='$waktu_sekarang' WHERE idPegawai='$_POST[id]'");
                    if ($query){
                      $_SESSION['notif'] = 'resetsukses';
                      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                    }else{
                      $_SESSION['notif'] = 'resetgagal';
                      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                    }
                  }
                }
              ?>
              <input type="hidden" name="id" value="<?php echo $_GET[id]; ?>" >
              <label>Password Baru<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="password" name="password_baru" placeholder="Password Baru" class="form-control" required>
              <br>
              <label>Konfirmasi Password Baru<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="password" name="konfirmasi_password_baru" placeholder="Konfirmasi Password Baru" class="form-control" required>
              <br>
              <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
            </div>
          </div>
      </div>

      <div class="col-md-3">
          <div class="box box-success">
            <div class="box-body">
              <button type="submit" name="reset" value="Simpan" class="btn btn-block btn-success">Simpan</button>
              <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
            </div>
          </div>
      </div>

  </form>
<?php }elseif($_GET[act]=='import'){ 
  if (isset($_POST['import'])){
    $file = $_FILES['filepegawai']['tmp_name'];
    $load = PHPExcel_IOFactory::load($file);
    $sheets = $load->getActiveSheet()->toArray(null,true,true,true);

    $i = 1;
    foreach ($sheets as $sheet) {
      if ($i > 2) {
        $nipPegawai     = $sheet['A'];
        $namaPegawai    = $sheet['B'];
        $unitPegawai    = $sheet['C'];
        $jabatanPegawai = $sheet['D'];
        $statusKepegawaian = $sheet['E'];
        $passwordPegawai  = md5($password_default);

        if($nipPegawai != "" && $namaPegawai != "" && $unitPegawai != "" && $jabatanPegawai != ""){
          // input data ke database (table data_pegawai)
          $query=mysqli_query($koneksi,"INSERT INTO pegawai(nipPegawai,namaPegawai,unitPegawai,jabatanPegawai,statusPegawai,passwordPegawai,statusKepegawaian,stdel,cby,cdate) VALUES('$nipPegawai','$namaPegawai','$unitPegawai','$jabatanPegawai','Aktif','$passwordPegawai','$statusKepegawaian','0','$idUsers','$waktu_sekarang')");
        }
      }
      $i++;
    }

    if ($query){
      $_SESSION['notif'] = 'importsukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'importgagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }

  }
?>

      <div class="col-xs-12">
        <div class="box">
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <h4>Petunjuk Singkat</h4>
            <p>Penginputan data Pegawai bisa dilakukan dengan mengcopy data dari file Ms. Excel. Format file excel harus sesuai kebutuhan aplikasi. Silahkan download formatnya <a href="admin/excel/template_data_pegawai.php"><span class="label label-success">Disini</span></a>
              <br><br>
              <strong>CATATAN :</strong>
              </p><ol>
                <li>Pengisian jenis data <strong>TANGGAL</strong>  diisi dengan format <strong>YYYY-MM-DD</strong> Contoh <strong>2017-12-21</strong><br> Cara ubah : blok semua tanggal pilih format cell di excel ganti dengan format date pilih yang tahunnya di depan</li>  
              </ol>
            <p></p>
            <hr>
            <div class="col-md-4">
              <form action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                        
              <div class="box-body">
                <div class="form-group">
                  <label>Masukkan File (.xls/.xlsx/.csv)</label>
                  <input type="file" name="filepegawai" required="">
                </div>
                <div class="form-group">
                  <button type="submit" name="import" class="btn btn-success btn-sm btn-flat">Import</button>
                  <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-danger btn-sm btn-flat">Kembali</a>
                </div>
            </div>
            </form>                        
          </div>
          </div>
          <!-- /.box-body -->
        </div>

        <!-- /.box -->
      </div>
    
<?php } ?>

<script>
  $(function() {
    var scntEdu = $('#p_scents_pendidikan');
    var a = $('#p_scents_pendidikan .row').size() + 1;
    $("#addScnt_pendidikan").click(function() {
      $('<div class="row del"><br><div class="col-md-3"><label>Tahun Masuk *</label><input type="text" class="form-control" required="" name="pendidikan_masuk[]" class="form-control years" placeholder="Contoh : 2010"><a href="#" class="btn btn-xs btn-danger delScnt_pendidikan">Hapus Baris</a></div><div class="col-md-3"><label>Tahun Lulus *</label><input type="text" class="form-control years" required="" name="pendidikan_keluar[]" placeholder="Contoh : 2014"></div><div class="col-md-3"><label>Sekolah/Universitas *</label><input type="text" class="form-control" required="" name="pendidikan_sekolah[]" class="form-control" placeholder="Sekolah/Universitas"></div><div class="col-md-3"><label>Lokasi *</label><input type="text" required="" name="pendidikan_lokasi[]" class="form-control" placeholder="Contoh : Jakarta"></div></div>').appendTo(scntEdu);
      a++;
      return false;
    });

    $(document).on("click", ".delScnt_pendidikan", function() {
      if (a > 2) {
        $(this).parents('.del').remove();
        a--;
      }
      return false;
    });
    
    var scntWork = $('#p_scents_seminar');
    var b = $('#p_scents_seminar .row').size() + 1;
    $("#addScnt_seminar").click(function() {
      $('<div class="row del"><br><div class="col-md-3"><label>Tanggal Mulai *</label><input class="form-control" required="" type="date" name="seminar_mulai[]" placeholder="Tanggal Mulai"><a href="#" class="btn btn-xs btn-danger remScnt_seminar">Hapus Baris</a></div><div class="col-md-3"><label>Tanggal Selesai *</label><input class="form-control" required="" type="date" name="seminar_selesai[]" placeholder="Tanggal Selesai"></div><div class="col-md-3"><label>Penyelenggara *</label><input type="text" class="form-control" required="" name="seminar_penyelenggara[]" placeholder="Penyelenggara Workshop"></div><div class="col-md-3"><label>Lokasi *</label><input type="text" required="" name="seminar_lokasi[]" class="form-control" placeholder="Contoh : Jakarta"></div></div>').appendTo(scntWork);
      b++;
      return false;
    });

    $(document).on("click", ".remScnt_seminar", function() {
      if (b > 2) {
        $(this).parents('.del').remove();
        b--;
      }
      return false;
    });
    
    var scntFam = $('#p_scents_keluarga');
    var c = $('#p_scents_keluarga .row').size() + 1;
    $("#addScnt_keluarga").click(function() {
      $('<div class="row del"><br><div class="col-md-6"><label>Nama Anggota Keluarga *</label><input class="form-control" required="" type="text" name="keluarga_nama[]" placeholder="Masukkan Nama Anggota Kelurga"><a href="#" class="btn btn-xs btn-danger remScnt_keluarga">Hapus Baris</a></div><div class="col-md-4"><label>Hubungan *</label><select class="form-control" required="" name="keluarga_hubungan[]"><option value="">-Pilih Hubungan-</option><option value="Istri">Istri</option><option value="Suami">Suami</option><option value="Anak">Anak</option><option value="Ayah">Ayah</option><option value="Ibu">Ibu</option><option value="Lainnya">Lainnya</option></select></div></div>').appendTo(scntFam);
      c++;
      return false;
    });

    $(document).on("click", ".remScnt_keluarga", function() {
      if (c > 2) {
        $(this).parents('.del').remove();
        c--;
      }
      return false;
    });
    
    var scntPos = $('#p_scents_jabatan');
    var d = $('#p_scents_jabatan .row').size() + 1;
    $("#addScnt_jabatan").click(function() {
      $('<div class="row del"><br><div class="col-md-4"><label>Tahun Mulai *</label><input class="form-control" required="" type="date" name="jabatan_mulai[]" placeholder="Masukkan Tahun Mulai"><a href="#" class="btn btn-xs btn-danger remScnt_jabatan">Hapus Baris</a></div><div class="col-md-4"><label>Tahun Selesai *</label><input class="form-control" required="" type="date" name="jabatan_selesai[]" placeholder="Masukkan Tahun Selesai"></div><div class="col-md-4"><label>Keterangan *</label><input class="form-control" required="" type="text" name="jabatan_keterangan[]" placeholder="Masukkan Keterangan"></div></div>').appendTo(scntPos);
      d++;
      return false;
    });

    $(document).on("click", ".remScnt_jabatan", function() {
      if (d > 2) {
        $(this).parents('.del').remove();
        d--;
      }
      return false;
    });
    
    var scntTeach = $('#p_scents_mengajar');
    var e = $('#p_scents_mengajar .row').size() + 1;
    $("#addScnt_mengajar").click(function() {
      $('<div class="row del"><br><div class="col-md-3"><label>Tahun Mulai *</label><input class="form-control years" required="" type="date" name="mengajar_mulai[]" placeholder="Masukkan Tahun Mulai"><a href="#" class="btn btn-xs btn-danger remScnt_mengajar">Hapus Baris</a></div><div class="col-md-3"><label>Tahun Selesai *</label><input class="form-control" required="" type="date" name="mengajar_selesai[]" placeholder="Masukkan Tahun Selesai"></div><div class="col-md-3"><label>Mata Pelajaran *</label><input class="form-control" required="" type="text" name="mengajar_MP[]" placeholder="Masukkan Mata Pelajaran"></div><div class="col-md-3"><label>Keterangan *</label><input class="form-control" required="" type="text" name="mengajar_keterangan[]" placeholder="Masukkan Keterangan"></div></div>').appendTo(scntTeach);
      e++;
      return false;
    });

    $(document).on("click", ".remScnt_mengajar", function() {
      if (e > 2) {
        $(this).parents('.del').remove();
        e--;
      }
      return false;
    });
    
    var scntAchievement = $('#p_scents_penghargaan');
    var f = $('#p_scents_penghargaan .row').size() + 1;
    $("#addScnt_penghargaan").click(function() {
      $('<div class="row del"><br><div class="col-md-4"><label>Tahun *</label><input class="form-control" required="" type="text" name="penghargaan_tahun[]" placeholder="Masukkan Tahun"><a href="#" class="btn btn-xs btn-danger remScnt_penghargaan">Hapus Baris</a></div><div class="col-md-6"><label>Nama Penghargaan *</label><input class="form-control" required="" type="text" name="penghargaan_nama[]" placeholder="Masukkan Nama Penghargaan"></div></div>').appendTo(scntAchievement);
      f++;
      return false;
    });

    $(document).on("click", ".remScnt_penghargaan", function() {
      if (f > 2) {
        $(this).parents('.del').remove();
        f--;
      }
      return false;
    });
    
  });
</script>


<script type="text/javascript">
  $(document).ready(function(){
    var idUsers = '<?= $idUsers ?>';
    
    //unit sekolah
    var idUnitCetak = $('#Cunit_buttonCetak').val();
    var tipe_unit = $('#tipe_unit_cetak').val();
    $.ajax({
      type: 'POST',
      url: "admin/combobox/pilihan_unit.php",
      data: {idUnit: idUnitCetak, idUsers:idUsers, tipe_unit:tipe_unit},
      cache: false,
      success: function(msg){
        $("#Cunit_buttonCetak").html(msg);
      }
    });
  });

    //combo bertingkat unit dan kelas CETAK
    $("#Cunit_buttonCetak").change(function(){
      var idUnit = $("#Cunit_buttonCetak").val();
      var idJabatan = $("#idJabatan").val();
      var tipe_unit = $('#tipe_unit_cetak').val();
      var tipe_jabatan = $('#tipe_jabatan_cetak').val();
      $.ajax({
        type: 'POST',
          url: "admin/combobox/pilihan_jabatan.php",
          data: {idUnit: idUnit, idJabatan: idJabatan, tipe_unit:tipe_unit, tipe_jabatan:tipe_jabatan},
          cache: false,
          success: function(msg){
            $("#Cjabatan_buttonCetak").html(msg);
        }
      });
    });
</script>