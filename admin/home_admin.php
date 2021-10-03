<?php 
  $total_penerimaan = 0;
  $total_pengeluaran = 0;
  $total_masuk = 0;
  //penerimaan hari ini
  
  $total_penerimaan_bulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(jumlahTagihan) as totalBulanan FROM tagihan_bulanan WHERE (DATE(tglBayar) = '$tanggal_sekarang') AND statusBayar='1'"));
  $total_penerimaan_bebas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*, SUM(jumlahBayar) as totalBebas FROM tagihan_bebas LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas=tagihan_bebas_bayar.idTagihanBebas WHERE (DATE(tagihan_bebas_bayar.tglBayar) = '$tanggal_sekarang') AND statusBayar!='0'"));
  $total_penerimaan_kas_masuk = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalKasMasuk FROM kas WHERE tanggal='$tanggal_sekarang' AND stdel='0' AND jenis='Masuk'"));

  //pengeluaran hari ini
  $total_pengeluaran_bayar_hutang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as totalBayarKeluar FROM hutang_bayar WHERE tanggalBayar='$tanggal_sekarang' AND stdel='0' AND keterangan='Lunas'"));
  $total_pengeluaran_kas_keluar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalKasKeluar FROM kas WHERE tanggal='$tanggal_sekarang' AND stdel='0' AND jenis='Keluar'"));

  $total_penerimaan = $total_penerimaan_bulanan['totalBulanan'] + $total_penerimaan_bebas['totalBebas'] + $total_penerimaan_kas_masuk['totalKasMasuk'];
  $total_pengeluaran = $total_pengeluaran_kas_keluar['totalKasKeluar'] + $total_penerimaan_bayar_hutang['totalBayarKeluar'];
  $total_masuk = $total_penerimaan - $total_pengeluaran;
  $total_siswa = mysqli_num_rows(mysqli_query($koneksi,"SELECT *  FROM siswa WHERE statusSiswa = 'Aktif' AND stdel='0'"));

?>

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
  <?php if ($idUsers == 1) { ?>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">Penerimaan Hari Ini</span>
              <span class="info-box-number">Rp. <?= rupiah($total_penerimaan) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">Pengeluaran Hari Ini</span>
              <span class="info-box-number">Rp. <?= rupiah($total_pengeluaran) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-bank"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">Total Penerimaan</span>
              <span class="info-box-number">Rp. <?= rupiah($total_masuk) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text">Siswa Aktif</span>
              <span class="info-box-number"><?= $total_siswa;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
  <?php } ?>

   <div class="row">
      <div class="col-md-6">
       <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Informasi</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <!-- Indicators --> 
              <ol class="carousel-indicators ind"> 
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li> 
                <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li> 
                <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li> 
              </ol> 
              <!-- Wrapper for slides --> 
              <div class="carousel-inner"> 
                <?php 
                  $urut = 0;
                  $query_informasi=mysqli_query($koneksi,"SELECT * FROM informasi WHERE publikasiInformasi = '1' AND stdel = '0' ORDER BY idInformasi DESC LIMIT 3");
                  while($info=mysqli_fetch_array($query_informasi)){
                    if ($urut == 0){
                      echo '<div class="item active"> 
                              <div class="row"> 
                                <div class="adjust1"> 
                                  <div class="caption"> 
                                    <p class="text-info lead adjust2 col-sm-12">
                                      <img src="'.$lokasi_foto_informasi.$info['gambarInformasi'].'" width="100%">
                                      '.$info['judulInformasi'].' 
                                    </p>  
                                    <blockquote class="adjust2"> <p>'.$info['isiInformasi'].'</p> </blockquote> 
                                  </div> 
                                </div> 
                              </div> 
                            </div> ';
                    }else{
                      echo '<div class="item"> 
                              <div class="row"> 
                                <div class="adjust1"> 
                                  <div class="caption"> 
                                    <p class="text-info lead adjust2 col-sm-12">
                                      <img src="'.$lokasi_foto_informasi.$info['gambarInformasi'].'" width="100%">
                                      '.$info['judulInformasi'].'
                                    </p>  
                                    <blockquote class="adjust2"> <p>'.$info['isiInformasi'].'</p></blockquote> 
                                  </div> 
                                </div> 
                              </div> 
                            </div> ';
                    }
                    $urut++;
                  }
                ?>
                  
                                </div> <!-- Controls --> 
              <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"> 
                <span class="glyphicon glyphicon-chevron-left" style="font-size:20px"></span> </a> 
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"> 
                  <span class="glyphicon glyphicon-chevron-right" style="font-size:20px"></span> 
                </a> 
              </div> 
            </div>

        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->

      <div class="col-md-6">
       <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Kalender</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div id="calendar" class="col-centered"></div>



          <!-- Modal -->
    <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <form class="form-horizontal" method="POST" action="admin/agenda/agenda.php?id=<?= $idUsers ?>">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Tambah Agenda</h4>
            </div>
            <div class="modal-body">
              <input type="hidden" name="tipe" class="form-control" value="tambah">
              <label>Tanggal Mulai <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <p id="labelDate_mulai"></p>
              <input type="hidden" name="tgl_mulai" id="tgl_mulai" class="form-control">
              <br>
              <label>Tanggal Selesai<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <p id="labelDate_selesai"></p>
              <input type="hidden" name="tgl_selesai" id="tgl_selesai" class="form-control">
              <br>
              <label>Keterangan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <textarea name="keterangan" id="keterangan" class="form-control" required=""></textarea>
              <br>
              <label>Warna <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
              <select name="warna" class="form-control" id="warna" required="">
                <option value="" disabled selected>- Pilih Warna -</option>
                <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                <option style="color:#008000;" value="#008000">&#9724; Green</option>             
                <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                <option style="color:#000;" value="#000">&#9724; Black</option>
              </select>        
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    
    
    
    <!-- Modal -->
    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
      <div class="modal-content">
      <form class="form-horizontal" method="POST" action="admin/agenda/agenda.php?id=<?= $idUsers ?>">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Agenda</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" class="form-control" id="id">
          <input type="hidden" name="tipe" class="form-control" value="edit">
          <label>Tanggal Mulai <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <p id="labelDate_mulai"></p>
          <input type="hidden" name="tgl_mulai" id="tgl_mulai" class="form-control">
          <br>
          <label>Tanggal Selesai<small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <p id="labelDate_selesai"></p>
          <input type="hidden" name="tgl_selesai" id="tgl_selesai" class="form-control">
          <br>
          <label>Keterangan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <textarea name="keterangan" id="keterangan" class="form-control" required=""></textarea>
          <br>
          <label>Warna <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
          <select name="warna" class="form-control" id="warna" required="">
            <option value="" disabled selected>- Pilih Warna -</option>
            <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
            <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
            <option style="color:#008000;" value="#008000">&#9724; Green</option>             
            <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
            <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
            <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
            <option style="color:#000;" value="#000">&#9724; Black</option>
          </select> 
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        </div>
      </form>
      </div>
      </div>
    </div>

        </div>
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
</div>
<script>

  $(document).ready(function() {
    
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'prevYear,nextYear',
      },
      defaultDate: '<?= date('Y-m-d'); ?>',
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      selectable: true,
      selectHelper: true,
      select: function(tgl_mulai, tgl_selesai) {
        $("#ModalAdd #labelDate_mulai").text(moment(tgl_mulai).format('DD-MM-YYYY'));
        $("#ModalAdd #labelDate_selesai").text(moment(tgl_selesai).format('DD-MM-YYYY'));
        $('#ModalAdd #tgl_mulai').val(moment(tgl_mulai).format('YYYY-MM-DD HH:mm:ss'));
        $('#ModalAdd #tgl_selesai').val(moment(tgl_selesai).format('YYYY-MM-DD HH:mm:ss'));
        $('#ModalAdd').modal('show');
      },
      eventRender: function(event, element) {
        element.bind('dblclick', function() {
          $('#ModalEdit #id').val(event.id);
           $("#ModalEdit #labelDate_mulai").text(event.start.format('DD-MM-YYYY'));
          $("#ModalEdit #labelDate_selesai").text(event.end.format('DD-MM-YYYY'));
          $('#ModalEdit #keterangan').val(event.title);
          $('#ModalEdit #warna').val(event.color);
          $('#ModalEdit').modal('show');
        });
      },
      eventDrop: function(event, delta, revertFunc) { // si changement de position

        edit(event);

      },
      eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

        edit(event);

      },

      events: [
      <?php 
       $sql_agenda = mysqli_query($koneksi,"SELECT id, nama, tgl_mulai, tgl_selesai, warna FROM agenda WHERE stdel='0'");
       while ($agenda = mysqli_fetch_array($sql_agenda)) {

        $start = explode(" ", $agenda['tgl_mulai']);
        $end = explode(" ", $agenda['tgl_selesai']);
        if($start[1] == '00:00:00'){
          $start = $start[0];
        }else{
          $start = $agenda['tgl_mulai'];
        }
        if($end[1] == '00:00:00'){
          $end = $end[0];
        }else{
          $end = $agenda['tgl_selesai'];
        }
      ?>
        {
          id: '<?php echo $agenda['id']; ?>',
          title: '<?php echo $agenda['nama']; ?>',
          start: '<?php echo $start; ?>',
          end: '<?php echo $end; ?>',
          color: '<?php echo $agenda['warna']; ?>',
        },
      <?php }?>
      ]
    });
    
    function edit(event){
      start = event.start.format('YYYY-MM-DD HH:mm:ss');
      if(event.end){
        end = event.end.format('YYYY-MM-DD HH:mm:ss');
      }else{
        end = start;
      }
      
      id =  event.id;
      
      Event = [];
      Event[0] = id;
      Event[1] = start;
      Event[2] = end;
      
      $.ajax({
       url: 'admin/agenda/agenda.php?id=<?= $idUsers ?>',
       type: "POST",
       data: {Event:Event,tipe:'edit_tanggal'},
       success: function(rep) {
          if(rep == 'berhasil'){
            toastr["success"]("Data berhasil diupdate.","Sukses!");
          }else{
            toastr["error"]("Data gagal diupdate.","Gagal!");
          }
        }
      });
    }
    
  });

</script>