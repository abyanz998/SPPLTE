<?php if ($_GET[act]==''){ ?> 
            <div class="col-xs-12">  
              <div class="box box-success">
                <div class="box-header with-border">
                  <form action="" class="form-horizontal" method="get" accept-charset="utf-8">
                    <div class="box-body table-responsive">
                    <table>
                      <tbody>
                        <tr>
                          <td>     
                            <input type="hidden" name="view" value="<?= $_GET[view] ?>">
                            <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                            <select style="width: 200px;" id="Cunit" name="unit" class="form-control" required=""></select>
                          </td>
                          <td>
                            <label for="" class="col-sm-1 control-label">Bulan</label>
                          </td>
                          <td>
                            <input type="hidden" id="idJabatan" value="<?= $_GET[jabatan] ?>">
                            <input type="hidden" id="tipe_jabatan" value="pencarian">
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
                    if ($_SESSION['notif'] == 'sukses'){
                      echo '<script>toastr["success"]("Setting Gaji Pegawai berhasil.","Sukses!")</script>';
                    }elseif($_SESSION['notif'] == 'gagal'){
                      echo '<script>toastr["error"]("Setting Gaji Pegawai gagal.","Gagal!")</script>';
                    }
                    unset($_SESSION['notif']);
                  ?>
                  <table id="example1" class="table table-hover dataTable no-footer display">
          					<thead>
          					  <tr>
          						  <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
          						  <th>Unit Sekolah</th>
                        <th>Jabatan</th>
                        <th>Status Kepegawaian</th>
                        <th>Pendidikan Terakhir</th>
          						  <th>Setting</th>
          					  </tr>
          					</thead>
          					<tbody>
                    <?php 
                      if (isset($_GET['unit'])){
                        if ($_GET['jabatan'] != 'all'){
                          $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' AND pegawai.unitPegawai='$_GET[unit]' AND pegawai.jabatanPegawai='$_GET[jabatan]' ORDER BY pegawai.idPegawai DESC");
                        }else{
                          $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' AND pegawai.unitPegawai='$_GET[unit]' ORDER BY pegawai.idPegawai DESC");
                        }
                      }elseif($_SESSION['unit'] != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' AND pegawai.unitPegawai='$_SESSION[unit]' ORDER BY pegawai.idPegawai DESC");
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0'  ORDER BY pegawai.idPegawai DESC");
                      }
                      
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        if ($r['jbt_stdel'] == '1'){
                          $nama_jabatan = '';
                        }else{
                          $nama_jabatan = $r['namaJabatan'];
                        }
                        echo "<tr>
                                <td>$no</td>
                                <td>$r[nipPegawai]</td>
                                <td>$r[namaPegawai]</td>
                                <td>$r[singkatanUnit]</td>
                                <td>$nama_jabatan</td>
                                <td>$r[statusKepegawaian]</td>
                                <td>$r[pendidikanPegawai]</td>
                                <td><center>
                                  <a class='btn btn-success btn-xs' data-toggle='tooltip' title='' data-original-title='Setting Gaji' href='?view=$_GET[view]&act=detail&id=$r[idPegawai]'>Setting Gaji</a>
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

<?php }elseif($_GET[act]=='detail'){ 

  $edit = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE idPegawai = '$_GET[id]'");
  $record = mysqli_fetch_array($edit);
  $gaji = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM pegawai_gaji WHERE idPegawai='$record[idPegawai]'"));
  if ($record['jbt_stdel'] == '1'){
    $nama_jabatan = '';
  }else{
    $nama_jabatan = $record['namaJabatan'];
  }

  if (isset($_POST[simpan])){
    $cek_gaji = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM pegawai_gaji WHERE idPegawai='$_POST[id_pegawai]'"));
    if ($cek_gaji == 0){
      $query = mysqli_query($koneksi,"INSERT INTO pegawai_gaji(idPegawai,idAkunGaji,gajiPokok,gajiLain,potonganSimpanan,potonganBPJSTK,potonganSumbangan,potonganKoperasi,potonganBPJS,potonganPinjaman,potonganLain,stdel,cby,cdate) VALUES ('$_POST[id_pegawai]','$_POST[id_akun_gaji]','$_POST[gaji_pokok]','$_POST[gaji_lain]','$_POST[potongan_simpanan]','$_POST[potongan_bpjstk]','$_POST[potongan_sumbangan]','$_POST[potongan_koperasi]','$_POST[potongan_bpjs]','$_POST[potongan_pinjaman]','$_POST[potongan_lain]','0','$idUsers','$waktu_sekarang')");
    }else{
      $query = mysqli_query($koneksi,"UPDATE pegawai_gaji SET idAkunGaji='$_POST[id_akun_gaji]', gajiPokok='$_POST[gaji_pokok]', gajiLain='$_POST[gaji_lain]', potonganSimpanan='$_POST[potongan_simpanan]', potonganBPJSTK='$_POST[potongan_bpjstk]', potonganSumbangan='$_POST[potongan_sumbangan]', potonganKoperasi='$_POST[potongan_koperasi]', potonganBPJS='$_POST[potongan_bpjs]', potonganPinjaman='$_POST[potongan_pinjaman]', potonganLain='$_POST[potongan_lain]', uby='$idUsers', udate='$waktu_sekarang' WHERE idPegawai='$_POST[id_pegawai]'");
    }
    
    if ($query){
      $_SESSION['notif'] = 'sukses';
        echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      }else{
        $_SESSION['notif'] = 'gagal';
        echo "<script>document.location='index.php?view=$_GET[view]';</script>";
      }      
    }

?>
  
              <div class="col-md-9">
                <div class="box">
                  <table class="table">
                     <tbody><tr>
                         <td width="200">Unit</td>
                         <td width="4">:</td>
                         <td><?= $record['singkatanUnit'] ?></td>
                     </tr>
                     <tr>
                         <td>NIP</td>
                         <td>:</td>
                         <td><?= $record['nipPegawai'] ?></td>
                     </tr>
                     <tr>
                         <td>Nama</td>
                         <td>:</td>
                         <td><?= $record['namaPegawai'] ?></td>
                     </tr>
                     <tr>
                         <td>Jabatan</td>
                         <td>:</td>
                         <td><?= $nama_jabatan ?></td>
                     </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <form action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
              <!-- Small boxes (Stat box) -->
                <div class="col-md-9">
                  <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                      
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-3">
                            <label>Akun Gaji<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                          </div>
                          <div class="col-md-1"><label> = </label></div>
                          <div class="col-md-4">
                            <input type="hidden" id="idAkunGaji" value="<?= $gaji['idAkunGaji'] ?>">
                            <select required="" name="id_akun_gaji" id="Cakungaji" class="form-control">
                              <option value="">-Pilih Kode Akun-</option>
                              
                            </select>
                          </div>
                          <div class="col-md-1">
                          </div>
                        </div>
                      </div>
              
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#tab_1" data-toggle="tab">Gaji</a></li>
                          <li><a href="#tab_2" data-toggle="tab">Potongan</a></li>
                        </ul>
                        <div class="tab-content">
                          <div class="tab-pane active" id="tab_1">
                            <div class="form-group">
                              <div class="row">
                              <div class="col-md-3">
                                <label>Gaji Pokok <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                              </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-4">
                                  <input name="gaji_pokok" type="text" class="form-control" required="" placeholder="Gaji Pokok" value="<?= $gaji['gajiPokok'] ?>">
                              </div>
                              </div>
                            </div>
                
                            <div class="form-group">
                              <div class="row">
                                <div class="col-md-3">
                                  <label>Gaji Lain-lain <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                                </div>
                                <div class="col-md-1"><label> = </label></div>
                                <div class="col-md-4">
                                  <input name="gaji_lain" type="text" class="form-control" required="" placeholder="Gaji Lain-lain" value="<?= $gaji['gajiLain'] ?>">
                                </div>
                              </div>
                            </div>
                          
                          </div>
                
                        <div class="tab-pane" id="tab_2">
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label>Simpanan Wajib &amp; Pengajian <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                              </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-4">
                                <input name="potongan_simpanan" type="text" class="form-control"  required="" placeholder="Simpanan Wajib &amp; Pengajian" value="<?= $gaji['potonganSimpanan'] ?>">
                              </div>
                            </div>
                          </div>
                
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label>BPJS Tenaga Kerja <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                              </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-4">
                                <input name="potongan_bpjstk" type="text" class="form-control"  required="" placeholder="BPJS Tenaga Kerja" value="<?= $gaji['potonganBPJSTK'] ?>">
                              </div>
                            </div>
                          </div>
                    
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label>Sumbangan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                              </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-4">
                                <input name="potongan_sumbangan" type="text" class="form-control"  required="" placeholder="Sumbangan" value="<?= $gaji['potonganSumbangan'] ?>">
                              </div>
                            </div>
                          </div>
                
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label>Belanja Koperasi <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                              </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-4">
                                <input name="potongan_koperasi" type="text" class="form-control"  required="" placeholder="Belanja Koperasi" value="<?= $gaji['potonganKoperasi'] ?>">
                              </div>
                            </div>
                          </div>
                
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label>BPJS <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                              </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-4">
                                <input name="potongan_bpjs" type="text" class="form-control"  required="" placeholder="BPJS" value="<?= $gaji['potonganBPJS'] ?>">
                              </div>
                            </div>
                          </div>
                
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label>Pinjaman <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                              </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-4">
                                <input name="potongan_pinjaman" type="text" class="form-control"  required="" placeholder="Pinjaman" value="<?= $gaji['potonganPinjaman'] ?>">
                              </div>
                            </div>
                          </div>
                
                          <div class="form-group">
                            <div class="row">
                              <div class="col-md-3">
                                <label>Lain-lain <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                              </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-4">
                                <input name="potongan_lain" type="text" class="form-control"  required="" placeholder="Lain-lain" value="<?= $gaji['potonganLain'] ?>">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="id_pegawai" value="<?= $record['idPegawai'] ?>">
                  
                    <p class="text-muted">*) Kolom wajib diisi.</p>
                    <button type="submit" name="simpan" class="btn btn-md btn-success">Simpan</button>
                    <a href="index.php?view=<?= $_GET[view] ?>" type="button" class="btn btn-md btn-danger">Kembali</a>
                  </div>
                  <!-- /.box-body -->
                </div>
              </div>
    
            </form>
    
<?php } ?>
