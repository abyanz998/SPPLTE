<?php 
  if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success table-responsive">
              	<div class="box-header text-left">
              		<a class='btn btn-success btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=tambah'><span class='fa fa-plus'></span> Tambah</a>
                  &nbsp;<a class='btn btn-primary btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=import'><span class='fa fa-upload'></span> Upload Data</a>
                  &nbsp;<a class='btn btn-info btn-sm' href='index.php?view=<?= $_GET[view] ?>&act=update wa ortu'><span class='fa fa-whatsapp'></span> Update No. WA Ortu</a>
                  &nbsp;<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#cetakSiswa"><i class="fa fa-print"></i> Cetak</button>
                  &nbsp;<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#xlsSiswa"><i class="fa fa-file-excel-o"></i> Export Xls</button>
                  
                  <!-- MODAL CETAK -->
                  <div class="modal fade in" id="cetakSiswa" role="dialog">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">×</button>
                          <h4 class="modal-title">Pilih Kelas</h4>
                        </div>
                        <form action="siswa/laporan/data_siswa.php" method="get" target="_blank">
                          <div class="modal-body">
                            <label>Unit Sekolah</label>
                            <select name="unit" id="Cunit_buttonCetak" class="form-control" required></select>
                            <br>
                            <label>Kelas</label>
                            <select name="kelas" id="Ckelas_buttonCetak" class="form-control" required>
                                <option value="">- Pilih Kelas -</option>
                            </select>
                            <br>
                            <label>Kamar</label>
                            <input type="hidden" id="tipe_kamar_cetak" value="semuaKamar">
                            <select name="kamar" id="Ckamar_buttonCetak" class="form-control" required>
                                <option value="">- Pilih Kamar -</option>
                            </select>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-pdf-o"></i> Cetak</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <!-- MODAL EKSPORT EXCEL -->
                  <div class="modal fade in" id="xlsSiswa" role="dialog">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">×</button>
                          <h4 class="modal-title">Pilih Kelas</h4>
                        </div>
                        <form action="admin/excel/export_data_siswa.php" method="get" target="_blank">
                          <div class="modal-body">
                            <label>Unit Sekolah</label>
                            <select name="unit" id="Cunit_buttonExport" class="form-control" required></select>
                            <br>
                            <label>Kelas</label>
                            <input type="hidden" id="tipe_kelas_export" value="semuaKelas">
                            <select name="kelas" id="Ckelas_buttonExport" class="form-control" required>
                                <option value="">- Pilih Kelas -</option>
                            </select>
                            <br>
                            <label>Kamar</label>
                            <input type="hidden" id="tipe_kamar_export" value="semuaKamar">
                            <select name="kamar" id="Ckamar_buttonExport" class="form-control" required>
                                <option value="">- Pilih Kamar-</option>
                            </select>
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-excel-o"></i> Export</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-9"><br>
                      <form action="index.php" class="form-horizontal" method="get" accept-charset="utf-8">
                        <input type="hidden" name="view" value="<?= $_GET['view'] ?>">
                        <table>
                          <tbody>
                            <tr>
                              <td>     
                                <input type="hidden" id="idUnit" value="<?= $_GET['unit'] ?>">
                                <select style="width: 200px;" id="Cunit" name="unit" class="form-control" required>
                                </select>
                              </td>
                              <td>
                                &nbsp;&nbsp;
                              </td>
                              <td>
                                <input type="hidden" id="idKelas" value="<?= $_GET['kelas'] ?>">
                                <input type="hidden" id="tipe_kelas" value="semuaKelas">
                                <select style="width: 200px;" id="Ckelas" name="kelas" class="form-control" required>
                                  <option disabled selected>- Pilih Kelas -</option>
                                </select>
                              </td>
                              <td>
                                &nbsp;&nbsp;
                              </td>
                              <td>
                                <input type="hidden" id="idKamar" value="<?= $_GET['kamar'] ?>">
                                <input type="hidden" id="tipe_kamar" value="semuaKamar">
                                <select style="width: 200px;" id="Ckamar" name="kamar" class="form-control" required>
                                  <option disabled selected>- Pilih Kamar -</option>
                                 </select>
                              </td>
                              <td>
                                &nbsp;&nbsp;
                              </td>
                              <td>
                                <input type="hidden" id="idStatusSiswa" value="<?= $_GET['status'] ?>"> 
                                <select style="width: 200px;" id="Cstatussiswa" name="status" class="form-control"></select>
                              </td>
                              <td>
                                &nbsp;&nbsp;
                              </td>
                              <td>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>    
                              </td>
                            </tr>
                        </tbody>
                      </table>
                    </form>           
                  </div>
                </div>
              </div>

                <div class="box-body">

                <?php 
                  if ($_SESSION['notif'] == 'csukses'){
                    echo '<script>toastr["success"]("Data berhasil disimpan.","Sukses!")</script>';
                	}elseif ($_SESSION['notif'] == 'usukses'){
                  	echo '<script>toastr["success"]("Data berhasil diupdate.","Sukses!")</script>';
	                }elseif ($_SESSION['notif'] == 'dsukses'){
	                   echo '<script>toastr["success"]("Data berhasil dihapus.","Sukses!")</script>';
	                }elseif($_SESSION['notif'] == 'dgagal'){
                    echo '<script>toastr["error"]("Data tidak dapat dihapus.","Gagal!")</script>';
                  }elseif($_SESSION['notif'] == 'gagal'){
	                  echo '<script>toastr["error"]("Data gagal diproses.","Gagal!")</script>';
	                }elseif ($_SESSION['notif'] == 'importsukses'){
                     echo '<script>toastr["success"]("Data berhasil diimport.","Sukses!")</script>';
                  }elseif($_SESSION['notif'] == 'importgagal'){
                    echo '<script>toastr["error"]("Data gagal diimport.","Gagal!")</script>';
                  }elseif ($_SESSION['notif'] == 'uploadwasukses'){
                     echo '<script>toastr["success"]("Data No. Hp Whatsapp Ortu berhasil diproses.","Sukses!")</script>';
                  }elseif($_SESSION['notif'] == 'uploadwagagal'){
                    echo '<script>toastr["error"]("Data No. Hp Whatsapp Ortu gagal diproses.","Gagal!")</script>';
                  }
                  //reset password
                  elseif($_SESSION['notif'] == 'resetsukses'){
                    echo '<script>toastr["success"]("Reset password berhasil.","Sukses!")</script>';
                  }elseif($_SESSION['notif'] == 'resetgagal'){
                    echo '<script>toastr["error"]("Reset password gagal.","Gagal!")</script>';
                  }
                    unset($_SESSION['notif']);
                ?>
					
                  <table id="table_checkbox" class="table table-hover dataTable no-footer">
          					<thead>
          					  <tr>
                        <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
          						  <th>No</th>
          						  <th>Nis</th>
          						  <th>Nama</th>
                        <th>Unit</th>
                        <th>Kelas</th>
                        <th>Kamar</th>
                        <th>WA Ortu</th>
                        <th>Status</th>
          						  <th>Aksi</th>
          					  </tr>
          				  </thead>
          				  <tbody>
                    <?php 
                      $no = 1;
                      if (isset($_GET['unit'])){
                        if (($_GET['kelas'] <> 'all') && ($_GET['kamar'] == 'all')){
                          $tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.unitSiswa='$_GET[unit]' AND siswa.kelasSiswa='$_GET[kelas]' AND siswa.statusSiswa='$_GET[status]' AND siswa.stdel='0' ORDER BY siswa.idSiswa DESC");
                        }elseif (($_GET['kelas'] == 'all') && ($_GET['kamar'] <> 'all')){
                          $tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.unitSiswa='$_GET[unit]' AND siswa.kamarSiswa='$_GET[kamar]' AND siswa.statusSiswa='$_GET[status]' AND siswa.stdel='0' ORDER BY siswa.idSiswa DESC");
                        }elseif (($_GET['kelas'] == 'all') && ($_GET['kamar'] == 'all')){
                           $tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.unitSiswa='$_GET[unit]' AND siswa.statusSiswa='$_GET[status]' AND siswa.stdel='0' ORDER BY siswa.idSiswa DESC");
                        }else{
                          $tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.unitSiswa='$_GET[unit]' AND siswa.kelasSiswa='$_GET[kelas]' AND siswa.kamarSiswa='$_GET[kamar]' AND siswa.statusSiswa='$_GET[status]' AND siswa.stdel='0' ORDER BY siswa.idSiswa DESC");
                        }
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.statusSiswa='Aktif' AND siswa.stdel='0' ORDER BY siswa.idSiswa DESC");
                      }
                      
                      
                      while($r=mysqli_fetch_array($tampil)){
                        if ($r[statusSiswa] == 'Aktif'){
                          $statusSiswa = '<label class="label label-success">Aktif</label>';
                        }else{
                          $statusSiswa = '<label class="label label-danger">Tidak Aktif</label>';
                        }
                        echo "<tr>
                              <td>".$_GET[status]."</td>
                              <td>$no</td>
                              <td>$r[nisSiswa]</td>
                              <td>$r[nmSiswa]</td>
                              <td>$r[singkatanUnit]</td>
                              <td>$r[nmKelas]</td>
                              <td>$r[namaKamar]</td>
                              <td>$r[noHpOrtu]</td>
                              <td>$statusSiswa</td>
                              <td><center>
                                <a class='btn btn-danger btn-xs' data-toggle='tooltip' title='' data-original-title='Reset Password' href='?view=$_GET[view]&act=reset password&id=$r[idSiswa]'><span class='fa fa-unlock'></span></a>
                                <a class='btn btn-info btn-xs' data-toggle='tooltip' title='' data-original-title='Lihat' href='?view=$_GET[view]&act=lihat&id=$r[idSiswa]'><span class='fa fa-eye'></span></a>

                                <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idSiswa]'><span class='fa fa-edit'></span></a>
                                <a class='btn btn-success btn-xs' data-toggle='modal' href='#cetak".$r['idSiswa']."'><span class='fa fa-print' data-toggle='tooltip' title='' data-original-title='Cetak Kartu' ></span></a>
                              </center></td>";
                            echo "</tr>";

                           echo '<div class="modal fade in" id="cetak'.$r['idSiswa'].'">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                                      <h4 class="modal-title">Cetak Kartu Siswa</h4></div><div class="modal-body">
                                    </div>
                                    <div class="modal-body">
                                      <object data="siswa/laporan/kartu_siswa.php?id='.$r['idSiswa'].'" width="100%" height="300px"></object>
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

<?php }elseif($_GET[act]=='edit'){

  	$edit = mysqli_query($koneksi,"SELECT * FROM siswa WHERE idSiswa='$_GET[id]'");
  	$record = mysqli_fetch_array($edit);

    if($record['fotoSiswa'] == ''){
      $foto = $lokasi_default_fotoSiswa;
    }else{
      $foto = $lokasi_penyimpanan_fotoSiswa.$record['fotoSiswa'];
    }

?>
   	<form method="POST" action="" class="form-horizontal" enctype="multipart/form-data">

    <div class="col-md-9">
      <div class="box box-success">
        <div class="box-body">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Data Pribadi</a></li>
                <li><a href="#tab_2" data-toggle="tab">Data Pesantren</a></li>
                <li><a href="#tab_3" data-toggle="tab">Data Keluarga</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <?php
                    if (isset($_POST['update'])){
                      if ($_POST['nmSiswa'] == ''){ 
                        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Nama lengkap wajib diisi
                          </div>";
                      }
                      if($_POST['nisSiswa'] == ''){
                         echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian NIS wajib diisi
                          </div>";
                      }
                      if($_POST['unitSiswa'] == ''){
                         echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Unit sekolah wajib diisi
                          </div>";
                      }
                      if($_POST['kelasSiswa'] == ''){
                         echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Kelas wajib diisi
                          </div>";
                      }
                      if(($_POST['nisSiswa'] <> '') && ($_POST['nmSiswa'] <> '') && ($_POST['unitSiswa'] <> '') && ($_POST['kelasSiswa'] <> ''))
                      {
                      	if($_POST['tglLahirSiswa'] == ''){ $tglLahirSiswa = '0000-00-00'; } else { $tglLahirSiswa=$_POST['tglLahirSiswa']; }
                        if($_POST['kamarSiswa'] == ''){ $kamarSiswa = 0; } else { $kamarSiswa=$_POST['kamarSiswa']; }
                        $lokasi_file = $_FILES['fotoSiswa']['tmp_name'];
                        $nama_file_foto   = $_FILES['fotoSiswa']['name'];
                       
                        if ($lokasi_file <> ''){
                          UploadFoto($lokasi_penyimpanan_fotoSiswa,$lokasi_file,$nama_file_foto);
                          $query = mysqli_query($koneksi,"UPDATE siswa SET nisSiswa='$_POST[nisSiswa]', nisnSiswa='$_POST[nisnSiswa]', nmSiswa='$_POST[nmSiswa]', jkSiswa='$_POST[jkSiswa]', tempatLahirSiswa='$_POST[tempatLahirSiswa]', tglLahirSiswa='$tglLahirSiswa', alamatSiswa='$_POST[alamatSiswa]', fotoSiswa='$nama_file_foto', unitSiswa='$_POST[unitSiswa]', kelasSiswa='$_POST[kelasSiswa]', kamarSiswa='$kamarSiswa', statusSiswa='$_POST[statusSiswa]', nmIbu='$_POST[nmIbu]', nmAyah='$_POST[nmAyah]', noHpOrtu='$_POST[noHpOrtu]', uby='$idUsers', udate='$waktu_sekarang' WHERE idSiswa='$_POST[id]'");

                        }else{
                          $query = mysqli_query($koneksi,"UPDATE siswa SET nisSiswa='$_POST[nisSiswa]', nisnSiswa='$_POST[nisnSiswa]', nmSiswa='$_POST[nmSiswa]', jkSiswa='$_POST[jkSiswa]', tempatLahirSiswa='$_POST[tempatLahirSiswa]', tglLahirSiswa='$tglLahirSiswa', alamatSiswa='$_POST[alamatSiswa]', unitSiswa='$_POST[unitSiswa]', kelasSiswa='$_POST[kelasSiswa]', kamarSiswa='$kamarSiswa', statusSiswa='$_POST[statusSiswa]', nmIbu='$_POST[nmIbu]', nmAyah='$_POST[nmAyah]', noHpOrtu='$_POST[noHpOrtu]', uby='$idUsers', udate='$waktu_sekarang' WHERE idSiswa='$_POST[id]'");
                        }

                        if ($query){
                          $_SESSION['notif'] = 'usukses';
                          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                        }else{
                          $_SESSION['notif'] = 'gagal';
                          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                        }
                      }
                    }
                  ?>
                  <input name="id" type="hidden" class="form-control" placeholder="Nama lengkap" value="<?= $record['idSiswa'] ?>">
                  <label>Nama lengkap <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <input name="nmSiswa" type="text" class="form-control" placeholder="Nama lengkap" value="<?= $record['nmSiswa'] ?>">
                  <br>
                  <label>Jenis Kelamin</label>
                  <div class="radio">
                    <label>
                      <?php 
                        if ($record['jkSiswa'] == 'L'){
                          echo '<input type="radio" name="jkSiswa" value="L" checked> Laki-laki';
                        }else{
                          echo '<input type="radio" name="jkSiswa" value="L"> Laki-laki';
                        }
                      ?>
                    </label>&nbsp;&nbsp;
                    <label>
                      <?php
                        if ($record['jkSiswa'] == 'P'){
                          echo '<input type="radio" name="jkSiswa" value="P" checked> Perempuan';
                        }else{
                          echo '<input type="radio" name="jkSiswa" value="P"> Perempuan';
                        }
                      ?>
                    </label>
                  </div>
                  <br>
                  <label>Tempat Lahir</label>
                  <input name="tempatLahirSiswa" type="text" class="form-control" placeholder="Tempat Lahir" value="<?= $record['tempatLahirSiswa'] ?>">
                  <br>
                  <label>Tanggal Lahir </label>
                  <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input class="form-control" type="text" name="tglLahirSiswa" readonly="readonly" placeholder="Tanggal" value="<?php if($record[tglLahirSiswa] == '0000-00-00') {echo ''; } else { echo $record[tglLahirSiswa]; } ?>">
                  </div>
                  <br>
                  <label>Alamat</label>
                  <textarea class="form-control" name="alamatSiswa" placeholder="Alamat Tempat Tinggal"><?= $record['alamatSiswa'] ?></textarea>
                </div>

                <div class="tab-pane" id="tab_2">
                  <label>NIS <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <input name="nisSiswa" type="text" class="form-control" placeholder="NIS Siswa" value="<?= $record['nisSiswa'] ?>">
                  <br>
                  <label>NISN <small data-toggle="tooltip" title="" data-original-title="Wajib diisi"></small></label>
                  <input name="nisnSiswa" type="text" class="form-control" placeholder="NISN Siswa" value="<?= $record['nisnSiswa'] ?>">
                  <br>
                  <input type="hidden" id="idUnit" value="<?= $record['unitSiswa'] ?>">
                  <label>Unit <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <select name="unitSiswa" id="Cunit" class="form-control"> 
                  </select>
                  <br>
                  <input type="hidden" id="idKelas" value="<?= $record['kelasSiswa'] ?>">
                  <label>Kelas <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <select name="kelasSiswa" id="Ckelas" class="form-control">
                    <option disabled selected> - Pilih Kelas - </option>
                  </select>
                  <br> 
                  <input type="hidden" id="idKamar" value="<?= $record['kamarSiswa'] ?>">
                  <input type="hidden" id="tipe_kamar" value="kamarTidakAda">
                  <label>Kamar</label>
                  <select name="kamarSiswa" class="form-control" id="Ckamar">
                    <option disabled selected> - Pilih Kamar - </option>
                  </select>                
                </div>

                <div class="tab-pane" id="tab_3">    
                  <label>Nama Ibu Kandung</label>
                  <input name="nmIbu" type="text" class="form-control" placeholder="Nama Ibu" value="<?= $record['nmIbu']?>">
                  <br>   
                  <label>Nama Ayah Kandung</label>
                    <input name="nmAyah" type="text" class="form-control" placeholder="Nama Ayah" value="<?= $record['nmAyah']?>">
                  <br>
                  <label>No. Handphone Orang Tua <small data-toggle="tooltip" title="" data-original-title="Wajib diisi"></small></label>
                  <input name="noHpOrtu" type="text" class="form-control" placeholder="No Handphone Orang Tua" value="<?= $record['noHpOrtu']?>">    
                </div>
              </div>
            </div>
            <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
          <div class="box box-success">
            <div class="box-body">
              <label>Status</label>
              <div class="radio">
                <label>
                  <?php 
                    if ($record['statusSiswa'] == 'TIdak Aktif'){
                      echo '<input type="radio" name="statusSiswa" value="Tidak Aktif" checked> Tidak Aktif';
                    }else{
                      echo '<input type="radio" name="statusSiswa" value="Tidak Aktif" checked> Tidak Aktif';
                    }
                  ?>
                </label>
              </div> 
              <div class="radio">
                <label>
                  <?php 
                    if ($record['statusSiswa'] == 'Aktif'){
                      echo '<input type="radio" name="statusSiswa" value="Aktif" checked> Aktif';
                    }else{
                      echo '<input type="radio" name="statusSiswa" value="Aktif"> Aktif';
                    }
                  ?>
                </label>
              </div>
              <div class="radio">
                <label>
                  <?php 
                    if ($record['statusSiswa'] == 'Tamat'){
                      echo '<input type="radio" name="statusSiswa" value="Tamat" checked> Tamat';
                    }else{
                      echo '<input type="radio" name="statusSiswa" value="Tamat"> Tamat';
                    }
                  ?>
                </label>
              </div>
              <div class="radio">
                <label>
                   <?php 
                    if ($record['statusSiswa'] == 'Pindah Pesantren'){
                      echo '<input type="radio" name="statusSiswa" value="Pindah Pesantren" checked> Pindah Pesantren';
                    }else{
                      echo '<input type="radio" name="statusSiswa" value="Pindah Pesantren"> Pindah Pesantren';
                    }
                  ?>
                </label>
              </div>
              <div class="radio">
                <label>
                  <?php 
                    if ($record['statusSiswa'] == 'Drop Out'){
                      echo '<input type="radio" name="statusSiswa" value="Drop Out" checked> Drop Out';
                    }else{
                      echo '<input type="radio" name="statusSiswa" value="Drop Out"> Drop Out';
                    }
                  ?>
                </label>
              </div>
              <br>
              <label>Foto</label>
              <a href="#" class="thumbnail">
                <img src="<?= $foto ?>" id="target" alt="Choose image to upload">
              </a>
            <input type="file" id="fotoSiswa" name="fotoSiswa">
            <br>
            <button name="update" type="submit" value="Simpan" class="btn btn-block btn-success">Simpan</button>
            <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
          </div>
        </div>
      </div>

  </form>   

<?php }elseif($_GET[act]=='tambah'){ ?>
	<form method="POST" action="" class="form-horizontal" enctype="multipart/form-data">

		<div class="col-md-9">
      <div class="box box-success">
  			<div class="box-body">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Data Pribadi</a></li>
                <li><a href="#tab_2" data-toggle="tab">Data Pesantren</a></li>
                <li><a href="#tab_3" data-toggle="tab">Data Keluarga</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                  <?php
                    if (isset($_POST['tambah'])){
                      if ($_POST['nmSiswa'] == ''){ 
                        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Nama lengkap wajib diisi
                          </div>";
                      }
                      if($_POST['nisSiswa'] == ''){
                         echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian NIS wajib diisi
                          </div>";
                      }
                      if($_POST['unitSiswa'] == ''){
                         echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Unit sekolah wajib diisi
                          </div>";
                      }
                      if($_POST['kelasSiswa'] == ''){
                         echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Kelas wajib diisi
                          </div>";
                      }
                      if($_POST['passwordSiswa'] <> $_POST['konfirPasswordSiswa']){
                        echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Password dan Konfirmasi tidak sama
                          </div>";
                      }
                      if(($_POST['nisSiswa'] <> '') && ($_POST['nmSiswa'] <> '') && ($_POST['unitSiswa'] <> '') && ($_POST['kelasSiswa'] <> '') && ($_POST['passwordSiswa'] == $_POST['konfirPasswordSiswa']))
                      {
                        $saldo=0; 
                        $lokasi_file = $_FILES['fotoSiswa']['tmp_name'];
                        $nama_file_foto   = $_FILES['fotoSiswa']['name'];
                        if ($_POST['passwordSiswa'] == ''){
                          $passwordSiswa = md5($password_default);
                        }else{
                          $passwordSiswa = md5($_POST[passwordSiswa]);
                        }
                        
                        if($_POST['tglLahirSiswa'] == ''){ $tglLahirSiswa = '0000-00-00'; } else { $tglLahirSiswa=$_POST['tglLahirSiswa']; }
                        if($_POST['kamarSiswa'] == ''){ $kamarSiswa = 0; } else { $kamarSiswa=$_POST['kamarSiswa']; }
                        
                        if ($lokasi_file <> ''){
                          UploadFoto($lokasi_penyimpanan_fotoSiswa,$lokasi_file,$nama_file_foto);
                          $query = mysqli_query($koneksi,"INSERT INTO siswa(nisSiswa,nisnSiswa,nmSiswa,jkSiswa,tempatLahirSiswa,tglLahirSiswa,alamatSiswa,fotoSiswa,unitSiswa,kelasSiswa,kamarSiswa,statusSiswa,nmIbu,nmAyah,noHpOrtu,password,saldo,stdel,cby,cdate) VALUES ('$_POST[nisSiswa]','$_POST[nisnSiswa]','$_POST[nmSiswa]','$_POST[jkSiswa]','$_POST[tempatLahirSiswa]','$tglLahirSiswa','$_POST[alamatSiswa]','$nama_file_foto','$_POST[unitSiswa]','$_POST[kelasSiswa]','$kamarSiswa','$_POST[statusSiswa]','$_POST[nmIbu]','$_POST[nmAyah]','$_POST[noHpOrtu]','$passwordSiswa','$saldo','0','$idUsers','$waktu_sekarang')");
                        }else{
                          $query = mysqli_query($koneksi,"INSERT INTO siswa(nisSiswa,nisnSiswa,nmSiswa,jkSiswa,tempatLahirSiswa,tglLahirSiswa,alamatSiswa,unitSiswa,kelasSiswa,kamarSiswa, statusSiswa,nmIbu,nmAyah,noHpOrtu,password,saldo,stdel,cby,cdate) VALUES ('$_POST[nisSiswa]','$_POST[nisnSiswa]','$_POST[nmSiswa]','$_POST[jkSiswa]','$_POST[tempatLahirSiswa]','$tglLahirSiswa','$_POST[alamatSiswa]','$_POST[unitSiswa]','$_POST[kelasSiswa]','$kamarSiswa','$_POST[statusSiswa]','$_POST[nmIbu]','$_POST[nmAyah]','$_POST[noHpOrtu]','$passwordSiswa','$saldo','0','$idUsers','$waktu_sekarang')");
                        }

                        if ($query){
                          $_SESSION['notif'] = 'csukses';
                          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                        }else{
                          $_SESSION['notif'] = 'gagal';
                            echo "<script>document.location='index.php?view=$_GET[view]';</script>";
                        }
                      }
                    }
                  ?>

                  <label>Nama lengkap <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <input name="nmSiswa" type="text" class="form-control" placeholder="Nama lengkap" value="<?= $_POST['nmSiswa'] ?>">
                  <br>
                  <label>Jenis Kelamin</label>
                  <div class="radio">
                    <label>
                      <?php 
                        if ($_POST['jkSiswa'] == 'L'){
                          echo '<input type="radio" name="jkSiswa" value="L" checked> Laki-laki';
                        }else{
                          echo '<input type="radio" name="jkSiswa" value="L"> Laki-laki';
                        }
                      ?>
                    </label>&nbsp;&nbsp;
                    <label>
                      <?php
                        if ($_POST['jkSiswa'] == 'P'){
                          echo '<input type="radio" name="jkSiswa" value="P" checked> Perempuan';
                        }else{
                          echo '<input type="radio" name="jkSiswa" value="P"> Perempuan';
                        }
                      ?>
                    </label>
                  </div>
                  <br>
                  <label>Tempat Lahir</label>
                  <input name="tempatLahirSiswa" type="text" class="form-control" placeholder="Tempat Lahir" value="<?= $_POST['tempatLahirSiswa'] ?>">
                  <br>
                  <label>Tanggal Lahir </label>
                  <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    <input class="form-control" type="text" name="tglLahirSiswa" readonly="readonly" placeholder="Tanggal" value="<?php if($_POST[tglLahirSiswa] == '0000-00-00') {echo ''; } else { echo $_POST[tglLahirSiswa]; } ?>">
                  </div>
                  <br>
                  <label>Alamat</label>
                  <textarea class="form-control" name="alamatSiswa" placeholder="Alamat Tempat Tinggal"><?= $_POST['alamatSiswa'] ?></textarea>
                </div>

                <div class="tab-pane" id="tab_2">
                  <label>NIS <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <input name="nisSiswa" type="text" class="form-control" placeholder="NIS Siswa" value="<?= $_POST['nisSiswa'] ?>">
                  <br>                    
                  <label>Password <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">Defaul :  <font color="red"><?= $password_default ?></font></small></label>
                  <input name="passwordSiswa" type="password" class="form-control" placeholder="Password" value="<?= $_POST['passwordSiswa'] ?>">
                  <br>
                  <label>Konfirmasi Password <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">Kosongi jika password kosong</small></label>
                  <input name="konfirPasswordSiswa" type="password" class="form-control" placeholder="Konfirmasi Password" value="<?= $_POST['konfirPasswordSiswa'] ?>">
                  <br>
                  <label>NISN <small data-toggle="tooltip" title="" data-original-title="Wajib diisi"></small></label>
                  <input name="nisnSiswa" type="text" class="form-control" placeholder="NISN Siswa" value="<?= $_POST['nisnSiswa'] ?>">
                  <br>
                  <label>Unit <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <input type="hidden" id="idUnit" value="<?= $_POST['unitSiswa'] ?>">
                  <select name="unitSiswa" id="Cunit" class="form-control">
                  </select>
                  <br>
                  <label>Kelas <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                  <input type="hidden" id="idKelas" value="<?= $_POST['kelasSiswa'] ?>">
                  <select name="kelasSiswa" id="Ckelas" class="form-control">
                    <option disabled selected> - Pilih Kelas - </option>
                  </select>
                  <br> 
                  <label>Kamar</label>
                  <input type="hidden" id="idKamar" value="<?= $_POST['kamarSiswa'] ?>">
                  <input type="hidden" id="tipe_kamar" value="kamarTidakAda">
                  <select name="kamarSiswa" class="form-control" id="Ckamar">
                    <option disabled selected> - Pilih Kamar - </option>
                  </select>                
                </div>

                <div class="tab-pane" id="tab_3">    
                  <label>Nama Ibu Kandung</label>
                  <input name="nmIbu" type="text" class="form-control" placeholder="Nama Ibu" value="<?= $_POST['nmIbu']?>">
                  <br>   
                  <label>Nama Ayah Kandung</label>
                    <input name="nmAyah" type="text" class="form-control" placeholder="Nama Ayah" value="<?= $_POST['nmAyah']?>">
                  <br>
                  <label>No. Handphone Orang Tua <small data-toggle="tooltip" title="" data-original-title="Wajib diisi"></small></label>
                  <input name="noHpOrtu" type="text" class="form-control" placeholder="No Handphone Orang Tua" value="<?= $_POST['noHpOrtu']?>">    
                </div>
              </div>
            </div>
            <p style="color:#9C9C9C;margin-top: 5px"><i>*) Field Wajib Diisi</i></p>
        	</div>
      	</div>
    	</div>

	    <div class="col-md-3">
	      	<div class="box box-success">
	        	<div class="box-body">
              <label>Status</label>
              <div class="radio">
                <label>
                  <?php 
                    if ($_POST['statusSiswa'] == 'TIdak Aktif'){
                      echo '<input type="radio" name="statusSiswa" value="Tidak Aktif" checked> Tidak Aktif';
                    }else{
                      echo '<input type="radio" name="statusSiswa" value="Tidak Aktif" checked> Tidak Aktif';
                    }
                  ?>
                </label>
              </div> 
              <div class="radio">
                <label>
                  <?php 
                    if ($_POST['statusSiswa'] == 'Aktif'){
                      echo '<input type="radio" name="statusSiswa" value="Aktif" checked> Aktif';
                    }else{
                      echo '<input type="radio" name="statusSiswa" value="Aktif"> Aktif';
                    }
                  ?>
                </label>
              </div>
              <div class="radio">
                <label>
                  <?php 
                    if ($_POST['statusSiswa'] == 'Tamat'){
                      echo '<input type="radio" name="statusSiswa" value="Tamat" checked> Tamat';
                    }else{
                      echo '<input type="radio" name="statusSiswa" value="Tamat"> Tamat';
                    }
                  ?>
                </label>
              </div>
              <div class="radio">
                <label>
                   <?php 
                    if ($_POST['statusSiswa'] == 'Pindah Pesantren'){
                      echo '<input type="radio" name="statusSiswa" value="Pindah Pesantren" checked> Pindah Pesantren';
                    }else{
                      echo '<input type="radio" name="statusSiswa" value="Pindah Pesantren"> Pindah Pesantren';
                    }
                  ?>
                </label>
              </div>
              <div class="radio">
                <label>
                  <?php 
                    if ($_POST['statusSiswa'] == 'Drop Out'){
                      echo '<input type="radio" name="statusSiswa" value="Drop Out" checked> Drop Out';
                    }else{
                      echo '<input type="radio" name="statusSiswa" value="Drop Out"> Drop Out';
                    }
                  ?>
                </label>
              </div>
              <br>
              <label>Foto</label>
              <a href="#" class="thumbnail">
                <img src="<?= $lokasi_default_fotoSiswa ?>" id="target" alt="Choose image to upload">
              </a>
            <input type="file" id="fotoSiswa" name="fotoSiswa">
            <br>
            <button name="tambah" type="submit" value="Simpan" class="btn btn-block btn-success">Simpan</button>
            <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
				  </div>
	      </div>
	    </div>

	</form>

<?php }elseif($_GET[act]=='reset password'){ ?>
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
          <div class="box box-success">
            <div class="box-body">
              <?php
                if (isset($_POST['reset'])){
                  $passs = md5($_POST['password_baru']);
                  if (strlen($_POST['password_baru']) <= 5){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Panjang Password setidaknya paling sedikit 6 karakter.
                          </div>";
                  }
                  if(strlen($_POST['konfirmasi_password_baru']) <= 5){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Panjang Konfirmasi Password setidaknya paling sedikit 6 karakter.
                          </div>";
                  }
                  if($_POST['password_baru'] <> $_POST['konfirmasi_password_baru']){
                    echo "<div class='alert alert-danger alert-dismissible fade in' role='alert'> 
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span></button> Bagian Konfirmasi Password tidak sama dengan bagian Password.
                          </div>";
                  }
                  if ((strlen($_POST['password_baru']) > 5) && (strlen($_POST['konfirmasi_password_baru']) > 5) && ($_POST['password_baru'] == $_POST['konfirmasi_password_baru'])) {
                    $query = mysqli_query($koneksi,"UPDATE siswa SET password='$passs', uby='$idUsers', udate='$waktu_sekarang' WHERE idSiswa='$_POST[id]'");
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
              <button type="submit" name="reset" value="Simpan" class="btn btn-block btn-success">Simpan Data</button>
              <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
            </div>
          </div>
      </div>

  </form>

<?php }elseif($_GET[act]=='lihat'){ 
  $edit = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.idSiswa='$_GET[id]' AND siswa.stdel='0'");
    $record = mysqli_fetch_array($edit);
    if($record['fotoSiswa'] == ''){
      $foto = $lokasi_default_fotoSiswa;
    }else{
      $foto = $lokasi_penyimpanan_fotoSiswa.$record['fotoSiswa'];
    }
    
    if ($record['tglLahirSiswa'] == '0000-00-00' OR $record['tglLahirSiswa'] == ''){
        $ttl = strtoupper($record['tempatLahirSiswa']);
    }else{
        $ttl = strtoupper($record['tempatLahirSiswa'].', '.tgl_view($record['tglLahirSiswa']));
    }
        
  if (isset($_POST[hapus])){
    $cek_tagihan_bulanan = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM siswa INNER JOIN tagihan_bulanan ON siswa.idSiswa=tagihan_bulanan.idSiswa WHERE siswa.idSiswa='$_GET[id]' AND tagihan_bulanan.statusBayar<>'1'"));
    $cek_tagihan_bebas = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM siswa INNER JOIN tagihan_bebas ON siswa.idSiswa=tagihan_bebas.idSiswa WHERE siswa.idSiswa='$_GET[id]' AND tagihan_bebas.statusBayar<>'1'"));
    if ($cek_tagihan_bulanan == 0 AND $cek_tagihan_bebas == 0){
      mysqli_query($koneksi,"UPDATE siswa SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' where idSiswa='$_GET[id]'");
      $_SESSION['notif'] = 'dsukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'dgagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
  }
?>
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-12">
          <div class="box box-success">
            <div class="box-body">
              <div class="col-md-12 col-sm-12 col-xs-12 pull-left">
              <br>
              <div class="row">
                <div class="col-md-2">
                  <img src="<?= $foto ?>" class="img-responsive avatar">
                </div>
                <div class="col-md-10">
                  <table class="table table-hover">
                    <tbody>
                      <tr>
                        <td width="300px">NIS Siswa</td>
                        <td width="20px">:</td>
                        <td><?= $record['nisSiswa'] ?></td>
                      </tr>
                      <tr>
                        <td>NISN Siswa</td>
                        <td>:</td>
                        <td><?= $record['nisnSiswa'] ?></td>
                      </tr>
                      <tr>
                        <td>Nama lengkap</td>
                        <td>:</td>
                        <td><strong><?= strtoupper($record['nmSiswa']) ?></strong></td>
                      </tr>
                      <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td><?php if ($record['jkSiswa']=='L') { echo 'Laki-laki'; } else { echo 'Perempuan'; } ?></td>
                      </tr>
                      <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td><?= $ttl ?></td>
                      </tr>
                      <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= $record['alamatSiswa'] ?></td>
                      </tr>
                      <tr>
                        <td>Nama Ibu Kandung</td>
                        <td>:</td>
                        <td><?= $record['nmIbu'] ?></td>
                      </tr>
                      <tr>
                        <td>Nama Ayah Kandung</td>
                        <td>:</td>
                        <td><?= $record['nmAyah'] ?></td>
                      </tr>
                      <tr>
                        <td>No. Handphone Orang Tua</td>
                        <td>:</td>
                        <td><?= $record['noHpOrtu'] ?></td>
                      </tr>
                      <tr>
                        <td>Unit Sekolah</td>
                        <td>:</td>
                        <td><?= $record['singkatanUnit'] ?></td>
                      </tr>
                      <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td><?= $record['nmKelas'] ?></td>
                      </tr>
                      <tr>
                        <td>Kamar</td>
                        <td>:</td>
                        <td><?= $record['namaKamar'] ?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-4">
                  <a href="index.php?view=<?= $_GET[view] ?>" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i> Kembali</a>
                  <a href="index.php?view=<?= $_GET[view] ?>&act=edit&id=<?= $_GET[id] ?>" class="btn btn-success">
                    <i class="fa fa-edit"></i> Edit
                  </a>
                  <a href="#hapus" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="" data-original-title="Hapus"></i> Hapus</a>
                  <!-- MODAL HAPUS -->
                  <div class="modal fade" id="hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <form action="index.php?view=<?= $_GET[view] ?>&act=<?= $_GET[act] ?>&id=<?= $record[idSiswa] ?>" method="POST" role="form">
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
                  
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            </div>
          </div>
      </div>

  </form>


<?php }elseif($_GET[act]=='import'){ 
  if (isset($_POST['import'])){
    $file = $_FILES['file']['tmp_name'];
    $load = PHPExcel_IOFactory::load($file);
    $sheets = $load->getActiveSheet()->toArray(null,true,true,true);

    $i = 1;
    foreach ($sheets as $sheet) {
      if ($i > 2) {
        $nisSiswa     = $sheet['A'];
        $nmSiswa      = $sheet['B'];
        $unitSiswa    = $sheet['C'];
        $kelasSiswa   = $sheet['D'];
        if ($sheet['E'] == ''){
           $kamarSiswa   = 0; 
        }else{
            $kamarSiswa   = $sheet['E'];
        }
        $nmAyah       = $sheet['F'];
        $noHpOrtu     = $sheet['G'];
        $alamatSiswa  = $sheet['H'];
        $passwordSiswa  = md5($password_default);

        if($nisSiswa <> "" && $nmSiswa <> "" && $unitSiswa <> "" && $kelasSiswa <> ""){
          // input data ke database (table data siswa)
          $query=mysqli_query($koneksi,"INSERT INTO siswa(nisSiswa,nmSiswa,unitSiswa,kelasSiswa,kamarSiswa,statusSiswa,nmAyah,noHpOrtu,alamatSiswa,password,saldo,stdel,cby,cdate) VALUES ('$nisSiswa','$nmSiswa','$unitSiswa','$kelasSiswa','$kamarSiswa','Aktif','$nmAyah','$noHpOrtu','$alamatSiswa','$passwordSiswa','0','0','$idUsers','$waktu_sekarang')");
         
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
  <div class="col-md-12">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <!-- /.box-header -->
          <div class="box-body table-responsive">
            <h4>Petunjuk Singkat</h4>
            <p>Penginputan data Siswa bisa dilakukan dengan mengcopy data dari file Ms. Excel. Format file excel harus sesuai kebutuhan aplikasi. Silahkan download formatnya <a href="admin/excel/template_data_siswa.php"><span class="label label-success">Disini</span></a>
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
                  <input type="file" name="file" id="fileSiswa" required="">
                </div>
                <div class="form-group">
                  <button type="submit" name="import" class="btn btn-success btn-sm btn-flat">Import</button>
                  <a href="?view=<?= $_GET[view] ?>" class="btn btn-danger btn-sm btn-flat">Kembali</a>
                </div>
              </div>
            </form>                        
          </div>
          </div>
          <!-- /.box-body -->
        </div>

        <!-- /.box -->
      </div>
    </div>
  </div>

<?php }elseif($_GET[act]=='update wa ortu'){ 
  if (isset($_POST['updateNoWA'])){
    $file = $_FILES['file']['tmp_name'];
    $load = PHPExcel_IOFactory::load($file);
    $sheets = $load->getActiveSheet()->toArray(null,true,true,true);

    $i = 1;
    foreach ($sheets as $sheet) {
      if ($i > 2) {
        // menangkap data dan memasukkan ke variabel sesuai dengan kolumnya masing-masing
        $nisSiswa     = $sheet['A'];
        if ($sheet['E'] == ''){
           $kamarSiswa   = 0; 
        }else{
            $kamarSiswa   = $sheet['E'];
        }
        $alamatSiswa  = $sheet['F'];
        $nmAyah       = $sheet['G'];
        $nmIbu        = $sheet['H'];
        $noHpOrtu     = $sheet['I'];

        if($nisSiswa <> ""){
          // update data ke database
          $query=mysqli_query($koneksi,"UPDATE siswa SET kamarSiswa='$kamarSiswa', alamatSiswa='$alamatSiswa', nmAyah='$nmAyah', nmIbu='$nmIbu', noHpOrtu='$noHpOrtu', stdel='0', uby='$idUsers', udate='$waktu_sekarang' WHERE nisSiswa='$nisSiswa'");
        }
      }
      $i++;
    }
    if ($query){
      $_SESSION['notif'] = 'uploadwasukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'uploadwagagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
  }
?>
      <div class="col-xs-12">
        <div class="box box-success">
          <!-- /.box-header --> 
          <div class="box-body table-responsive">
            <h4>Petunjuk Singkat</h4>
            <p>Penginputan No. Whatsapp Ortu Siswa bisa dilakukan dengan mengcopy data dari file Ms. Excel. Format file excel harus sesuai kebutuhan aplikasi. Silahkan download formatnya <a data-toggle="modal" data-target="#template_wa"><span class="label label-success">Disini</span></a>

              <!-- MODAL DOWNLOAD TEMPLATE EXCEL WA ORTU --> 
              <div class="modal fade" id="template_wa" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">×</button>
                      <h4 class="modal-title">Download Template Excel</h4>
                    </div>
                    <form action="admin/excel/template_update_no_wa_ortu.php" method="get" target="_blank">
                    <div class="modal-body">
                      <label>Unit Sekolah</label>
                      <select id="Cunit" name="unit" class="form-control" required=""></select>
                      <br>
                      <label>Kelas</label>
                      <input type="hidden" id="tipe_kelas" value="semuaKelas">
                      <select name="kelas" id="Ckelas" class="form-control">
                    <option disabled selected> - Pilih Kelas - </option>
                  </select>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success"><i class="fa fa-excel-o"></i> Download</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                    </form>
                  </div>
                </div>
               </div>


              <br>
              <strong>CATATAN :</strong>
              </p><ol>
                  <li>
                      Pengisian <strong>No. Whatsapp Ortu</strong>  diisi dengan format <strong>62 + No. Whatsapp Ortu</strong> Contoh <strong>6281234567890</strong>
                  </li>
                  <li>
                      Setelah selesai mengisi save as file excel ke format excel 2003-2007
                  </li>
              </ol>
            <p></p>
            <hr>
            <div class="col-md-4">
              <form action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                <div class="box-body">
                <div class="form-group">
                    <label>Masukkan File (.xls)</label>
                  <input type="file" name="file" id="fileSiswa" required="">
                </div>
                <div class="form-group">
                  <button type="submit" name="updateNoWA" class="btn btn-success btn-sm btn-flat">Update</button>
                  <a href="?view=<?= $_GET[view] ?>" class="btn btn-danger btn-sm btn-flat">Kembali</a>
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



<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#target').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#fotoSiswa").change(function() {
    readURL(this);
  });
</script>


 <script type="text/javascript">
  //    validasi form (hanya file .xls yang diijinkan)
  function validateForm()
  {
    function hasExtension(inputID, exts) {
      var fileName = document.getElementById(inputID).value;
      return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
    }

    if(!hasExtension('fileSiswa', ['.xls'])){
      alert("Hanya file XLS (Excel 2003) yang diizinkan.");
      return false;
    }
  }
</script>

<script type="text/javascript">
         $(document).ready(function(){
          var idUsers = '<?= $idUsers ?>';
          var tipe_unit = '';

          //unit sekolah
          var idUnitCetak = $('#Cunit_buttonCetak').val();
          $.ajax({
              type: 'POST',
              url: "admin/combobox/pilihan_unit.php",
              data: {idUnit: idUnitCetak, idUsers:idUsers, tipe_unit:tipe_unit},
              cache: false,
              success: function(msg){
                $("#Cunit_buttonCetak").html(msg);
              }
          });

          var idUnitExport = $('#Cunit_buttonExport').val();
          $.ajax({
              type: 'POST',
              url: "admin/combobox/pilihan_unit.php",
              data: {idUnit: idUnitExport, idUsers:idUsers, tipe_unit:tipe_unit},
              cache: false,
              success: function(msg){
                $("#Cunit_buttonExport").html(msg);
              }
          });
        });

        //combo bertingkat unit dan kelas CETAK
        $("#Cunit_buttonCetak").change(function(){
          var idUnit = $("#Cunit_buttonCetak").val();
          var idKelas = $("#idKelas_cetak").val();
          var tipe_kelas = $('#tipe_kelas_cetak').val();
          $.ajax({
                  type: 'POST',
                    url: "admin/combobox/pilihan_kelas.php",
                    data: {idUnit: idUnit, idKelas: idKelas, tipe_kelas:tipe_kelas},
                    cache: false,
                    success: function(msg){
                      $("#Ckelas_buttonCetak").html(msg);
                    }
              });
        });

        //combo bertingkat unit dan kamar CETAK
        $("#Cunit_buttonCetak").change(function(){
          var idKamar = $("#idKamar_cetak").val();
          var tipe_kamar = $('#tipe_kamar_cetak').val();
          $.ajax({
                  type: 'POST',
                    url: "admin/combobox/pilihan_kamar.php",
                    data: {idKamar: idKamar, tipe_kamar:tipe_kamar},
                    cache: false,
                    success: function(msg){
                      $("#Ckamar_buttonCetak").html(msg);
                    }
              });
        });


        //combo bertingkat unit dan kelas EXPORT
        $("#Cunit_buttonExport").change(function(){
          var idUnit = $("#Cunit_buttonExport").val();
          var idKelas = $("#idKelas_export").val();
          var tipe_kelas = $('#tipe_kelas_export').val();
          $.ajax({
                  type: 'POST',
                    url: "admin/combobox/pilihan_kelas.php",
                    data: {idUnit: idUnit, idKelas: idKelas, tipe_kelas:tipe_kelas},
                    cache: false,
                    success: function(msg){
                      $("#Ckelas_buttonExport").html(msg);
                    }
              });
        });

        //combo bertingkat unit dan kamar EXPORT
        $("#Cunit_buttonExport").change(function(){
          var idKamar = $("#idKamar_export").val();
          var tipe_kamar = $('#tipe_kamar_export').val();
          $.ajax({
                  type: 'POST',
                    url: "admin/combobox/pilihan_kamar.php",
                    data: {idKamar: idKamar, tipe_kamar:tipe_kamar},
                    cache: false,
                    success: function(msg){
                      $("#Ckamar_buttonExport").html(msg);
                    }
              });
        });

</script>