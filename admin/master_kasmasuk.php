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
                    }
                    unset($_SESSION['notif']);
                  ?>
                  <table id="example1" class="table table-hover dataTable no-footer">
          					<thead>
          					  <tr>
          						  <th>No</th>
                        <th>Kas</th>
                        <th>No. Ref</th>
                        <th>Tanggal</th>
          						  <th>Kode Akun</th>
          						  <th>Keterangan</th>
                        <th width="100px">Nominal (Rp.)</th>
                        <th>Pajak</th>
                        <th>Unit POS</th>
                        <th width="100px">Total (Rp.)</th>
          						  <th>Aksi</th>
          					  </tr>
          					</thead>
          					<tbody>
                    <?php 
                      if (isset($_GET['unit'])){
                        if ($_GET['unit'] != 'all'){
                          $tampil = mysqli_query($koneksi,"SELECT kas.*, 
                                                                akun_biaya.keterangan as ketAkun,
                                                                pajak.besaranPajak,
                                                                unit_pos.nmUnitPos
                                                         FROM kas 
                                                         LEFT JOIN akun_biaya ON kas.idAkunKas = akun_biaya.idAkun
                                                         LEFT JOIN pajak ON kas.idPajak = pajak.idPajak
                                                         LEFT JOIN unit_pos ON kas.idUnitPos = unit_pos.idUnitPos
                                                         WHERE kas.stdel='0' AND kas.jenis='Masuk' AND kas.idUnitSekolah='$_GET[unit]' AND kas.tipe<>'Transfer' ORDER BY kas.idKas DESC");
                        }else{
                          $tampil = mysqli_query($koneksi,"SELECT kas.*, 
                                                                akun_biaya.keterangan as ketAkun,
                                                                pajak.besaranPajak,
                                                                unit_pos.nmUnitPos
                                                         FROM kas 
                                                         LEFT JOIN akun_biaya ON kas.idAkunKas = akun_biaya.idAkun
                                                         LEFT JOIN pajak ON kas.idPajak = pajak.idPajak
                                                         LEFT JOIN unit_pos ON kas.idUnitPos = unit_pos.idUnitPos
                                                         WHERE kas.stdel='0' AND kas.jenis='Masuk' AND kas.tipe<>'Transfer' ORDER BY kas.idKas DESC");
                        }
                      }elseif($idUnitUsers != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT kas.*, 
                                                                akun_biaya.keterangan as ketAkun,
                                                                pajak.besaranPajak,
                                                                unit_pos.nmUnitPos
                                                         FROM kas 
                                                         LEFT JOIN akun_biaya ON kas.idAkunKas = akun_biaya.idAkun
                                                         LEFT JOIN pajak ON kas.idPajak = pajak.idPajak
                                                         LEFT JOIN unit_pos ON kas.idUnitPos = unit_pos.idUnitPos
                                                         WHERE kas.stdel='0' AND kas.jenis='Masuk' AND kas.idUnitSekolah='$idUnitUsers' AND kas.tipe<>'Transfer' ORDER BY kas.idKas DESC");
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT kas.*, 
                                                                akun_biaya.keterangan as ketAkun,
                                                                pajak.besaranPajak,
                                                                unit_pos.nmUnitPos
                                                         FROM kas 
                                                         LEFT JOIN akun_biaya ON kas.idAkunKas = akun_biaya.idAkun
                                                         LEFT JOIN pajak ON kas.idPajak = pajak.idPajak
                                                         LEFT JOIN unit_pos ON kas.idUnitPos = unit_pos.idUnitPos
                                                         WHERE kas.stdel='0' AND kas.jenis='Masuk' AND kas.tipe<>'Transfer' ORDER BY kas.idKas DESC");
                      }
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){

                        $kode_akun = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE idAkun='$r[idKodeAkun]'"));
                        if ($r['idPajak'] == '0'){
                          $pajak = '0 %';
                        }else{
                          $pajak = $r['besaranPajak'].' %';
                        }
                        if ($r['idUnitPos'] == '0'){
                          $pos = 'Tidak Ada';
                        }else{
                          $pos = $r['nmUnitPos'].' %';
                        }
                        echo "<tr>
                                <td>".$no++."</td>
                                <td>[".$r['ketAkun']."]</td>
                                <td>".$r['noRefrensi']."</td>
                                <td>".date('d/m/Y',strtotime($r['tanggal']))."</td>
                                <td>".$kode_akun['kodeAkun'].' - '.$kode_akun['keterangan']."</td>
                                <td>".$r['keterangan']."</td>
                                <td>".buatRp($r['nominal'])."</td>
                                <td>".$pajak."</td>
                                <td>".$pos."</td>
                                <td>".buatRp($r['total'])."</td>
                                <td width='80px'><center>
                                  <a class='btn btn-success btn-xs' data-toggle='tooltip' title='' data-original-title='Cetak' target='_blank' href='admin/laporan/transaksi_kas_masuk.php?noref=".$r[noRefrensi]."'><span class='fa fa-print'></span></a> 
                                  <a class='btn btn-warning btn-xs' data-toggle='tooltip' title='' data-original-title='Edit' href='?view=$_GET[view]&act=edit&id=$r[idKas]'><span class='fa fa-edit'></span></a>
                                  <a class='btn btn-danger btn-xs' href='#' data-toggle='modal' data-target='#hapus".$r[idKas]."'><span class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus'></span></a> 
                                </center></td>";
                        echo "</tr>";

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
                                                <input type="hidden" name="kas_noref" value="'.$r[noRefrensi].'">
                                                <input type="hidden" name="tipe" value="'.$r[tipe].'">
                                                <input type="hidden" name="keterangan" value="'.$r[keterangan].'">
                                                <input type="hidden" name="total" value="'.$r[total].'">
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
                      }

                      if (isset($_POST['hapus'])){
                          $query = mysqli_query($koneksi,"UPDATE kas SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idKas='$_POST[id_kas]'");
                          
                          mysqli_query($koneksi,"UPDATE pegawai_gaji_slip SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE noRefrensi='$_POST[kas_noref]' AND stdel='0'");

                          if ($_POST['tipe'] == 'Gaji'){
                            $info = 'No. Ref:'.$_POST['kas_noref'].';Title:Hapus '.$_POST['tipe'].' '.$_POST['keterangan'].' - nominal '.$_POST['total'];
                            mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Kas Masuk','Hapus Gaji','$info','$idUsers','$browser_ok','$user_os','$ip')");
                          }else{
                            $info = 'No. Ref:'.$_POST['kas_noref'].';Title:Hapus '.$_POST['tipe'].' '.$_POST['keterangan'].' - nominal '.$_POST['total'];
                            mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Kas Masuk','Hapus Transaksi','$info','$idUsers','$browser_ok','$user_os','$ip')");
                          }

                          $title = 'Hapus '.$_POST['keterangan'];
                          mysqli_query($koneksi,"INSERT INTO log_kasir(tanggal,jenisBayar,idBayar,modul,aksi,noRefrensi,nis_nip,title,nominal,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Kas','$_POST[id_kas]','Kas Masuk','Hapus Transaksi','$_POST[kas_noref]',null,'$title','$_POST[total]','$idUsers','$browser_ok','$user_os','$ip')");

                          if($query){
                            $_SESSION['notif'] = 'dsukses';
                          }else{
                            $_SESSION['notif'] = 'gagal';
                          }
                          echo "<script>document.location='index.php?view=$_GET[view]';</script>";
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
    $pajak = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM pajak WHERE idPajak='$_POST[id_pajak]'"));
    $biaya_pajak = ($_POST[nominal]*($pajak['besaranPajak']/100));
    $total = $_POST[nominal] + $biaya_pajak;

    $query = mysqli_query($koneksi,"UPDATE kas SET idKodeAkun='$_POST[id_akun_biaya]', keterangan='$_POST[keterangan]', nominal='$_POST[nominal]', idPajak='$_POST[id_pajak]', idUnitPos='$_POST[id_unit_pos]', total='$total', uby='$idUsers', udate='$waktu_sekarang' WHERE idKas = '$_POST[id_kas]'");

    $info = 'No. Ref:'.$_POST['noref'].';Title: Edit '.$_POST['keterangan'].' - nominal '.$total;
    mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Kas Masuk','Edit Transaksi','$info','$idUsers','$browser_ok','$user_os','$ip')");

    mysqli_query($koneksi,"UPDATE log_kasir SET nominal='$total' WHERE idBayar='$_POST[id_kas]'");

    if ($query){
      $_SESSION['notif'] = 'usukses';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]';</script>";
    }
  }
  $edit = mysqli_query($koneksi,"SELECT kas.*,
                                        akun_biaya.keterangan as ketAkun,
                                        unit_sekolah.singkatanUnit,
                                        pajak.besaranPajak,
                                        unit_pos.nmUnitPos
                                 FROM kas 
                                 LEFT JOIN akun_biaya ON kas.idAkunKas = akun_biaya.idAkun
                                 LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                 LEFT JOIN pajak ON kas.idPajak = pajak.idPajak
                                 LEFT JOIN unit_pos ON kas.idUnitPos = unit_pos.idUnitPos 
                                 WHERE idKas='$_GET[id]'");
  $record = mysqli_fetch_array($edit);
?>
  
  <form method="POST" action="" class="form-horizontal">

    <div class="col-md-9">
        <div class="box box-primary">
          <!-- /.box-header -->
          <div class="box-body">
           <input type="hidden" name="id_kas" value="<?= $record[idKas]?>">
              <label>Kas *</label>
              <input type="text" class="form-control" value="[<?= $record['ketAkun'] ?>]" placeholder="kas" readonly="">
              <br>
              <label>No. Referensi *</label>
              <input type="text" name="noref" class="form-control" value="<?= $record['noRefrensi'] ?>" placeholder="No. Referensi" readonly="">
              <br>
              <label>Tanggal </label>
              <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                <input class="form-control" type="text" name="tanggal_kas" readonly="readonly" placeholder="Tanggal Kas Masuk" value="<?= $record['tanggal'] ?>">
              </div>
              <br>
              <label>Unit Sekolah <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="text" class="form-control" value="<?= $record['singkatanUnit'] ?>" placeholder="Unit Sekolah" readonly="">
              <input type="hidden" id="id_unit_edit" value="<?= $record['idUnitSekolah'] ?>"> 
              <br>
              <label>Kode Akun <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="hidden" id="idAkunBiaya" value="<?= $record['idKodeAkun'] ?>"> 
              <select required="" name="id_akun_biaya" id="Cakunbiayamasuk" class="form-control">
                            <option value="">- Pilih Kode Akun -</option>
                        </select>
              <br>
              <label>Keterangan *</label>
              <input type="text" class="form-control" name="keterangan" value="<?= $record['keterangan'] ?>" placeholder="Keterangan Kas Masuk">
              <br>
              <label>Nominal (Rp) *</label>
              <input type="text" class="form-control" name="nominal" value="<?= $record['nominal'] ?>" placeholder="Jumlah">
              <br>
              <label>Pajak <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="hidden" id="idPajak" value="<?= $record['idPajak'] ?>"> 
              <select required="" name="id_pajak" id="Cpajak" class="form-control"></select>
              <br>
              <label>Unit POS <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <input type="hidden" id="idUnitPos" value="<?= $record['idUnitPos'] ?>">
              <select required="" name="id_unit_pos" id="CunitPos" class="form-control"></select>
              <br>
              <p class="text-muted">*) Kolom wajib diisi.</p>
          </div>
          <!-- /.box-body -->
        </div>
      </div>

    <div class="col-md-3">
        <div class="box box-primary">
          <!-- /.box-header -->
          <div class="box-body">
            <button type="submit" name="update" class="btn btn-block btn-success">Simpan</button>
            <a href="index.php?view=<?= $_GET[view]?>" class="btn btn-block btn-danger">Batal</a>
          </div>
          <!-- /.box-body -->
        </div>
      </div>

  </form>

<?php }elseif($_GET[act]=='tambah'){ ?>
  <form method="POST" action="" class="form-horizontal">

  <div class="col-md-12">
        <div class="box">
          <div class="box-header"></div>
            <div class="box-body">      
              <input type="hidden" name="id_tahun_ajaran" id="id_tahun_ajaran" value="<?= $ta['idTahunAjaran'] ?>">
                  <div class="row">
                    <div class="col-md-3">
                      <label>Unit Sekolah *</label>
                      <select required="" name="id_unit" id="Cunit" class="form-control"></select>
                    </div>
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                    <label>Tanggal *</label>
                    <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      <input class="form-control" required="" type="text" name="tanggal_kas" id="tanggal_kas" placeholder="Tanggal Kas Masuk" value="<?= $tanggal_sekarang ?>">
                    </div>
                    </div>
                    <div class="col-md-3">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label>No. Ref *</label>
                      <input type="text" required="" name="kas_noref" id="kas_noref" class="form-control" placeholder="Nomor Referensi" readonly="">
                    </div>
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                    <div id="div_kas">
                        <label>Akun Kas *</label>
                      <select required="" name="id_akun_kas" id="Cakunkas" class="form-control">
                          <option value="">-Pilih Akun Kas-</option>
                      </select>
                    </div>
                    </div>
                    <div class="col-md-3">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <label>Keterangan *</label>
                      <input type="text" required="" name="keterangan_kas" id="keterangan_kas" class="form-control" placeholder="Keterangan Kas Masuk">
                    </div>
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                      <label>Total *</label>
                      <input type="text" required="" name="total_kas" id="total_kas" class="form-control" placeholder="Total Kas Masuk" readonly="">
                    </div>
                    <div class="col-md-3">
                    </div>
                  </div>
                  <br>
                </div>  
                </div>
            </div>


            <div class="col-md-12">
              <div class="box">
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-2">
                      <div id="div_kode">
                        <label>Kode Akun *</label>
                        <select required="" name="id_akun_biaya" id="Cakunbiayamasuk" class="form-control">
                            <option value="">- Pilih Kode Akun -</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <label>Uraian *</label>
                      <input type="text" required="" name="keterangan" id="keterangan" class="form-control" placeholder="Uraian Kas Masuk">
                    </div>
                    <div class="col-md-2">
                      <label>Nominal (Rp.)*</label>
                      <input type="text" class="form-control" required="" name="nominal" id="nominal" placeholder="Nominal">
                    </div>
                    <div class="col-md-2">
                        <label>Pajak</label>
                        <select name="id_pajak" id="Cpajak" class="form-control">
                          <option value="0">0 %</option>
                        </select>
                    </div>
                    <div id="div_item">
                      <div class="col-md-2">
                          <label>Unit POS</label>
                          <select name="id_unit_pos" id="CunitPos" class="form-control">
                            <option value="0">-Tidak Ada-</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-1">
                      <label><p> </p></label>
                      <input type="button" id="btn_simpan" class="btn btn-success btn-sm form-control" value="Tambah">
                    </div>
                  </div>

                  <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kode Akun</th>
                            <th>Keterangan</th>
                            <th>Nominal (Rp.)</th>
                            <th>Pajak</th>
                            <th>Unit POS</th>
                            <th>Total (Rp.)</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="show_data"></tbody>
                    </table>
                    <div id="btnFinish" style="display: none;">
                      <div class="row">
                        <br>
                          <div class="col-md-8"></div>
                          <div class="col-md-2">
                            <button id="btn_batal" class="btn btn-warning btn-block">Batal</button>
                          </div>
                          <div class="col-md-2">
                            <button id="btn_selesai" class="btn btn-primary btn-block">Simpan Transaksi</button>    
                          </div>    
                        </div>
                      </div>  
                    </div>
                  </div>
                <div>
                <!-- -->
              </div>
            <!-- /.box -->
            </div>
          </div>
  </form>

  <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        <h4 class="modal-title" id="myModalLabel">Hapus Barang</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="id" id="id" value="">
                            <div class="alert alert-danger"><p>Apakah Anda yakin mau memhapus data ini?</p></div>
                                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button class="btn_hapus btn btn-danger" id="btn_hapus">Hapus</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
<?php
}
?>

  <script type="text/javascript">
    $(document).ready(function(){
        var idUnit = $('#idUnit').val();
        var idUsers = '<?= $idUsers ?>';
        var tipe_unit = $('#tipe_unit').val();;
        $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_unit.php",
            data: {idUnit: idUnit, idUsers:idUsers, tipe_unit:tipe_unit},
            cache: false,
            success: function(msg){
              $("#Cunit").html(msg);
            }
        });
    });
  </script>
  <script type="text/javascript">
  
    $("#btnFinish").hide();

    function tampil_data(){
        var kas_noref    = $("#kas_noref").val();
        var idUsers    = '<?= $idUsers ?>';
        
        $.ajax({
            
            url : "admin/kas/transaksi_kas_masuk.php",
            method : "POST",
            data : {'tipe': 'tampil_data','noref' : kas_noref, 'users' : idUsers},
            async : false,
            success : function(data){
              var obj = JSON.parse(data);
              var html    = '';
              var total   = '';
              var tax     = '';
              var grand   = '';
              var sum     = 0;
              var sumLast = 0;
              var tot     = 0;
              var pajak   = 0;
              var pajakAll = 0;
              var sumAll  = 0;
              var no      = 1;
              var i;

              const frmt = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
              })

              for(i=0; i<obj.length; i++){
                    
                    var date = new Date(obj[i].tanggal);
                    var dd = date.getDate();
                    var mm = date.getMonth() + 1;
                        
                    var yyyy = date.getFullYear();
                    if (dd < 10) {
                        dd = '0' + dd;
                      } 
                    if (mm < 10) {
                      mm = '0' + mm;
                    } 
                    var date = dd + '/' + mm + '/' + yyyy;
                    
                    var besaranPajak = '';
                    if (obj[i].besaranPajak == null){
                      besaranPajak = '0';
                    }else{
                      besaranPajak = obj[i].besaranPajak;
                    }
                    sum = parseInt(obj[i].nominal);
                    pajak = parseInt(obj[i].nominal*(besaranPajak/100));
                    sumLast = parseInt(sum+pajak);
                    
                    sumAll += parseInt(obj[i].nominal);
                    pajakAll += parseInt(obj[i].nominal*(besaranPajak/100));
                    
                    var nominal = frmt.format(sum);
                        
                    var lastNominal = frmt.format(sumLast);
                    
                    var namaUnitPos = '';
                    if (obj[i].nmUnitpos == null){
                      namaUnitPos = 'Tidak Ada';
                    }else{
                      namaUnitPos = obj[i].nmUnitpos;
                    }

                    html += '<tr>'+
                            '<td>'+no+'</td>'+
                            '<td>'+date+'</td>'+
                            '<td>'+obj[i].akunBiaya+'</td>'+
                            '<td>'+obj[i].keterangan+'</td>'+
                            '<td>'+nominal+'</td>'+
                            '<td>'+besaranPajak+' %</td>'+
                            '<td>'+namaUnitPos+'</td>'+
                            '<td>'+lastNominal+'</td>'+
                            '<td style="text-align:center;">'+
                                    '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+obj[i].idTransaksiKas+'" title="Hapus"><i class="fa fa-trash"></i></a>'+
                                '</td>'+
                            '</tr>';
                            no++
                }

                var number = frmt.format(sumAll);
                var taxNumber = frmt.format(pajakAll);
                var grandTotal = frmt.format(sumAll+pajakAll);

                total += '<tr>'+
                          '<td colspan="4"></td><td style="text-align:left;"><b>Subtotal</b></td>'+
                          '<td colspan="2"><b>Pajak</b></td>'+
                          '<td colspan="2"><b>Grand Total (Subtotal + Pajak)</b></td>'+
                          '</tr>';
                    
                tax += '<tr>'+
                          '<td colspan="4"></td>'+
                          '<td>'+number+'</td>'+
                          '<td colspan="2">'+taxNumber+'</td>'+
                          '<td colspan="2">'+grandTotal+'</td>'+
                          '</tr>';
                          
                var res = html.concat(total, tax);
                    
                $('#show_data').html(res);
                $('#total_kas').val(sumAll+pajakAll);
            }

        });
    }
  
        $(document).ready(function(){
        
          $("#Cunit").change(function(e){
              var id_unit    = $("#Cunit").val();
              
                $.ajax({ 
                    url: 'admin/kas/cari_noref.php',
                    type: 'POST', 
                    data: {
                            'tipe' : 'Masuk',
                            'id_unit' : id_unit,
                    },
                    cache: false,    
                    success: function(msg) {
                            $("#kas_noref").val(msg);
                            tampil_data();
                            $("#btnFinish").show();
                    },
                    error: function(msg){
                         toastr["error"]("msg","Gagal!");  
                    }
                });
            e.preventDefault();
          });
         


    //Simpan Barang
    $('#btn_selesai').on('click',function(){
            var id_unit=$("#Cunit").val();
            var kas_noref=$("#kas_noref").val();
            var tanggal_kas=$("#tanggal_kas").val();
            var id_akun_kas=$("#Cakunkas").val();
            var id_tahun_ajaran = $("#id_tahun_ajaran").val();
            var keterangan_kas=$("#keterangan_kas").val();
            var total_kas=$("#total_kas").val();
            var idUsers    = '<?= $idUsers ?>';
            
            if(id_unit != '' && kas_noref != '' && tanggal_kas != '' && id_akun_kas != '' && id_tahun_ajaran != '' && keterangan_kas != ''){
            $.ajax({
                type : "POST",
                url   : "admin/kas/transaksi_kas_masuk.php",
                data : {
                        'tipe' : 'simpan_transaksi',
                        'idUsers':idUsers, 
                        'id_unit':id_unit, 
                        'noref':kas_noref, 
                        'tanggal_kas':tanggal_kas, 
                        'id_akun_kas':id_akun_kas, 
                        'id_tahun_ajaran' : id_tahun_ajaran,
                        'keterangan_kas':keterangan_kas,
                        'total_kas':total_kas,
                    },
                success: function(data){
                    changeLoc();
                },
                error: function(msg){
                    toastr["error"]("msg","Gagal!"); 
                }
            });
            return false;
            } else {
                toastr["error"]("Ada Kolom yang Kosong, Tolong Dicek Kembali.","Gagal!");    
            }
        });
        
        $('#btn_simpan').on('click',function(){
            var idUsers  = '<?= $idUsers ?>';
            var keterangan_kas = $("#keterangan_kas").val();
            var tanggal  = '<?= $tanggal_sekarang ?>';
            var kas_noref=$("#kas_noref").val();
            var id_akun_biaya=$("#Cakunbiayamasuk").val();
            var keterangan=$("#keterangan").val();
            var nominal=$("#nominal").val();
            var id_pajak=$("#Cpajak").val();
            var id_unit_pos=$("#CunitPos").val();
            
            if(idUsers != '' && tanggal != '' && kas_noref != '' && id_akun_biaya != '' && keterangan != '' && nominal != ''){
              $.ajax({
                type : "POST",
                url   : "admin/kas/transaksi_kas_masuk.php",
                data : {
                        'tipe' : 'simpan_data',
                        'idUsers':idUsers, 
                        'tanggal':tanggal, 
                        'kas_noref':kas_noref, 
                        'id_akun_biaya':id_akun_biaya, 
                        'keterangan':keterangan, 
                        'nominal':nominal, 
                        'id_pajak':id_pajak, 
                        'id_unit_pos':id_unit_pos,
                },
                success: function(data){
                    if(keterangan_kas == ''){
                        var note = keterangan;
                    }else{
                        var note = keterangan_kas + ', ' + keterangan;
                    }
                    $('[name="keterangan_kas"]').val(note);
                    $('[name="id_akun_biaya"]').val("0");
                    $('[name="keterangan"]').val("");
                    $('[name="nominal"]').val("");
                    $('[name="id_pajak"]').val("0");
                    $('[name="id_unit_pos"]').val("0");
                    tampil_data();
                },
                error: function(msg){
                  toastr["error"]("msg","Gagal!");
                }
              });
            return false;
          } else {
            toastr["error"]("Ada Kolom yang Kosong, Tolong Dicek Kembali.","Gagal!");
          }
        });
        
        $('#btn_batal').on('click',function(){
            var kas_noref=$("#kas_noref").val();
            $.ajax({
                type : "POST",
                url   : "admin/kas/transaksi_kas_masuk.php",
                data : { 
                        tipe:'batal',
                        'kas_noref':kas_noref,
                    },
                success: function(data){
                    window.location = 'index.php?view=<?= $_GET[view] ?>';
                },
                error: function(msg){
                    toastr["error"]("msg","Gagal!");
                }
            });
            return false;
        });
        
    //GET HAPUS
    $('#show_data').on('click','.item_hapus',function(){
            var id=$(this).attr('data');
            $('#ModalHapus').modal('show');
            $('[name="id"]').val(id);
        });

        //Hapus Barang
        $('#btn_hapus').on('click',function(){
            var id=$('#id').val();
            $.ajax({
            type : "POST",
            url  : "admin/kas/transaksi_kas_masuk.php",
                    data : {
                            'id': id,'tipe':'hapus_data'
                        },
                    success: function(data){
                            $('#ModalHapus').modal('hide');
                            tampil_data();
                    }
                });
                return false;
            });

  });
  
    function changeLoc() {
      window.location = 'index.php?view=<?= $_GET[view] ?>';
    }

</script>

