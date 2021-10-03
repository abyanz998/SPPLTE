<?php if ($_GET[act]==''){ 

  if ($_SESSION['notif'] == 'sukses'){
    echo '<script>toastr["success"]("Slip Gaji Pegawai berhasil disimpan.","Sukses!")</script>';
  }elseif($_SESSION['notif'] == 'gagal'){
    echo '<script>toastr["error"]("Slip Gaji Pegawai gagal disimpan.","Gagal!")</script>';
  }elseif ($_SESSION['notif'] == 'dsukses'){
    echo '<script>toastr["success"]("Slip Gaji Pegawai berhasil dihapus.","Sukses!")</script>';
  }elseif($_SESSION['notif'] == 'dgagal'){
    echo '<script>toastr["error"]("Slip Gaji Pegawai gagal dihapus.","Gagal!")</script>';
  }
  unset($_SESSION['notif']);


?> 

  <div class="col-xs-12">  
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">Filter Data Penggajian Pegawai</h3>
      </div>
      <div class="box-body">
        <form action="" class="form-horizontal" method="get" accept-charset="utf-8">
          <input type="hidden" name="view" value="<?= $_GET['view']?>">
          <div class="form-group">            
            <label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
            <div class="col-sm-2">
              <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
              <select class="form-control" name="thn_ajar" id="Ctahunajaran"></select>
            </div>
            <label for="" class="col-sm-1 control-label">Bulan</label>
            <div class="col-sm-2">
              <input type="hidden" id="idBulan" value="<?= $_GET[bulan] ?>">
              <select class="form-control" name="bulan" id="Cbulan"></select>
            </div>
              <label for="" class="col-sm-1 control-label">Nip</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input type="text" class="form-control" autofocus="" name="nip" id="nip" placeholder="NIP Pegawai" required="" value="<?= $_GET['nip']?>">
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
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#dataPegawai"><b>Data Pegawai</b></button>
                  </span>
                </div>
              </div>
            </div>
          </form>
        </div>
    </div><!-- /.box -->
  </div>


  <div class="modal fade in" id="dataPegawai" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Cari Data Pegawai</h4>
        </div>
        <div class="modal-body">
            <div class="box-body table-responsive">
              <table id="example1" class="table table-hover dataTable no-footer">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Unit Sekolah</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      if($idUnitUsers != '0'){
                        $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' AND pegawai.unitPegawai='$idUnitUsers' ORDER BY pegawai.idPegawai DESC");
                      }else{
                        $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' ORDER BY pegawai.idPegawai DESC");
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
                              <td>
                                <center><button type='button' data-dismiss='modal' class='btn btn-primary btn-xs' onclick=\"ambil_data('$r[nipPegawai]')\">Pilih</button></center>
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
<?php } ?>

 <script>
    function ambil_data(nipPegawai){
      var nipPegawai = nipPegawai;
      var bln    = $("#Cbulan").val();
      var thAjaran    = $("#Ctahunajaran").val();
            
      window.location.href = 'index.php?view=<?= $_GET[view]?>&thn_ajar='+thAjaran+'&bulan='+bln+'&nip='+nipPegawai;
    }
</script>


<?php if (isset($_GET['thn_ajar']) && isset($_GET['nip'])) { 

  $pegawai = mysqli_fetch_array(mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.namaUnit, unit_sekolah.singkatanUnit, jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' AND pegawai.nipPegawai='$_GET[nip]'"));
  
  $thn = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$_GET[thn_ajar]'"));
  $bln = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM bulan WHERE idBulan='$_GET[bulan]'"));

  $gaji = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM pegawai_gaji WHERE idPegawai='$pegawai[idPegawai]'"));
  $total_gajipokok = $gaji['gajiPokok'] + $gaji['gajiLain'];
  $total_gajiPotongan = $gaji['potonganSimpanan'] + $gaji['potonganBPJSTK'] + $gaji['potonganSumbangan'] + $gaji['potonganKoperasi'] + $gaji['potonganBPJS'] + $gaji['potonganPinjaman'] + $gaji['potonganLain'];
  $total_gaji = $total_gajipokok - $total_gajiPotongan;


if (empty($pegawai['fotoPegawai'])){
  $fotoPegawai = $lokasi_default_fotoPegawai;
}else{
  $fotoPegawai = $lokasi_penyimpanan_fotoPegawai.$pegawai['fotoPegawai'];
}
$tgl = date('Y-m-d');


  if (isset($_POST['simpan'])){

  	//simpan gaji
    $query = mysqli_query($koneksi,"INSERT INTO pegawai_gaji_slip(idGaji,noRefrensi,tanggal,idPegawai,idAkunKas,idBulan,idTahunAjaran,gajiPokok,gajiLain,potonganSimpanan,potonganBPJSTK,potonganSumbangan,potonganKoperasi,potonganBPJS,potonganPinjaman,potonganLain,stdel,cby,cdate) VALUES ('$_POST[id_gaji]','$_POST[kas_noref]','$tgl','$_POST[id_pegawai]','$_POST[id_akun_kas]','$_POST[id_bulan]','$_POST[id_tahun_ajaran]','$_POST[gaji_pokok]','$_POST[gaji_lain]','$_POST[potongan_simpanan]','$_POST[potongan_bpjstk]','$_POST[potongan_sumbangan]','$_POST[potongan_koperasi]','$_POST[potongan_bpjs]','$_POST[potongan_pinjaman]','$_POST[potongan_lain]','0','$idUsers','$waktu_sekarang')");
    //ambil noref terbaru
    $noref_terbaru = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM pegawai_gaji_slip WHERE tanggal='$tgl' ORDER BY idSlipGaji DESC LIMIT 1"));
    
    //simpan gaji dikas keluar
    mysqli_query($koneksi,"INSERT INTO kas(jenis,tipe,tanggal,idUnitSekolah,noRefrensi,idAkunKas,idKodeAkun,idTahunAjaran,keterangan,nominal,idPajak,idUnitPos,total,stdel,cby,cdate) VALUES ('Keluar','Gaji','$tgl','$pegawai[unitPegawai]','$_POST[kas_noref]','$_POST[id_akun_kas]','$_POST[id_kode_akun]','$_POST[id_tahun_ajaran]','$pegawai[namaPegawai] - $bln[nmBulan] $thn[nmTahunAjaran]','$_POST[jumlah_gaji]','0','0','$_POST[jumlah_gaji]','0','$idUsers','$waktu_sekarang')");

    //simpan logs transaksi
    $info = 'NIP:'.$pegawai['nipPegawai'].';Title:Input Gaji Bulan '.$bln['nmBulan'].' '.$thn['nmTahunAjaran'].' No. Ref '.$_POST['kas_noref'].' nominal '.$_POST['jumlah_gaji'];
    mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Penggajian','Simpan Gaji','$info','$idUsers','$browser_ok','$user_os','$ip')");

    $ambil_idGaji=mysqli_fetch_array(mysqli_query($koneksi,"SELECT idSlipGaji FROM pegawai_gaji_slip WHERE idPegawai='$_POST[id_pegawai]' ORDER BY idSlipGaji DESC LIMIT 1"));
    $title = 'Input Gaji Bulan '.$bln['nmBulan'].' '.$thn['nmTahunAjaran'];
    mysqli_query($koneksi,"INSERT INTO log_kasir(tanggal,jenisBayar,idBayar,modul,aksi,noRefrensi,nis_nip,title,nominal,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Gaji','$ambil_idGaji[idSlipGaji]','Penggajian','Bayar','$_POST[kas_noref]','$pegawai[nipPegawai]','$title','$_POST[jumlah_gaji]','$idUsers','$browser_ok','$user_os','$ip')");

    if ($query){
      $_SESSION['notif'] = 'sukses';
      echo "<script>document.location='admin/laporan/slip_penggajian.php?noref=".$noref_terbaru['noRefrensi']."';</script>";

    }else{
      $_SESSION['notif'] = 'gagal';
      echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&bulan=$_GET[bulan]&nip=$_GET[nip]';</script>";
    }


  }

  $inisial = "GK".$pegawai['singkatanUnit'].$pegawai['nipPegawai'].date('dmy');

?> 
<div class="col-md-12">
      
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Informasi Pegawai</h3>
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
                    <td>NIP</td>
                    <td>:</td>
                    <td><?= $pegawai['nipPegawai'] ?></td> 
                  </tr>
                  <tr>
                    <td>Nama Pegawai</td>
                    <td>:</td>
                    <td><?= $pegawai['namaPegawai'] ?></td> 
                  </tr>
                  <tr>
                    <td>Unit Sekolah</td>
                    <td>:</td>
                    <td><?= $pegawai['namaUnit'] ?> (<?= $pegawai['singkatanUnit'] ?>)</td> 
                  </tr>
                  <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><?php  if ($pegawai['jbt_stdel'] == '1'){ echo ''; }else{ echo $pegawai['namaJabatan']; } ?></td> 
                  </tr>
                   <tr>
                    <td>Pendidikan Terakhir</td>
                    <td>:</td>
                    <td><?= $pegawai['pendidikanPegawai'] ?></td> 
                  </tr>
                  <tr>
                    <td>Status Kepegawaian</td>
                    <td>:</td>
                    <td><?= $pegawai['statusKepegawaian']?></td> 
                  </tr>
                  <tr>
                    <td>Masa Kerja</td>
                    <td>:</td>
                    <td>
                      <?php
                            $tgl_masuk = $pegawai['tglMasukPegawai'];
                            if ($pegawai['tglKeluarPegawai'] == '0000-00-00'){
                              $tgl_keluar = date('Y-m-d');
                            }else{
                              $tgl_keluar = $pegawai['tglKeluarPegawai'];
                            }

                            echo hitungMasaKerja($tgl_masuk,$tgl_keluar);
                      ?>
                    </td> 
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-3">

              <img src="<?= $fotoPegawai ?>" class="img-thumbnail img-responsive">
            </div>
          </div>
        </div>
        

        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Histori Penggajian</h3>
            <a href="" class="btn btn-info btn-xs"><i class="fa fa-refresh"></i> Refresh</a>
          </div><!-- /.box-header -->
              
          <div class="box-body table-responsive">
            <div class="histori">
              <table class="table table-responsive table-bordered" style="white-space: nowrap;">
                <thead>
                  <tr class="info">
                    <th>No. Referensi</th>
                    <th>Tanggal</th>
                    <th>Bulan</th>
                    <th>Dibayar Via Akun</th>
                    <th>Gaji</th>
                    <th>Potongan</th>
                    <th>Gaji Diterima</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $tampil = mysqli_query($koneksi,"SELECT 
                                                     pegawai_gaji_slip.*, bulan.nmBulan, bulan.urutan, tahun_ajaran.nmTahunAjaran, akun_biaya.keterangan
                                                     FROM pegawai_gaji_slip 
                                                     LEFT JOIN bulan ON pegawai_gaji_slip.idBulan=bulan.idBulan 
                                                     LEFT JOIN tahun_ajaran ON pegawai_gaji_slip.idTahunAjaran=tahun_ajaran.idTahunAjaran
                                                     LEFT JOIN akun_biaya ON pegawai_gaji_slip.idAkunKas=akun_biaya.idAkun
                                                     WHERE pegawai_gaji_slip.idPegawai='$pegawai[idPegawai]' AND pegawai_gaji_slip.idTahunAjaran='$_GET[thn_ajar]' AND pegawai_gaji_slip.stdel='0' 
                                                     ORDER BY pegawai_gaji_slip.noRefrensi DESC");
                      
                      $no = 1;
                      while($r=mysqli_fetch_array($tampil)){
                        $gaji_pokok = $r['gajiPokok'] + $r['gajiLain'];
                        $gaji_potongan = $r['potonganSimpanan'] + $r['potonganBPJSTK'] + $r['potonganSumbangan'] + $r['potonganKoperasi'] + $r['potonganBPJS'] + $r['potonganPinjaman'] + $r['potonganLain'];
                        $sisa_gaji = $gaji_pokok - $gaji_potongan;

                        $pisah_TA = explode('/', $r['nmTahunAjaran']);
                        if ($r['urutan'] < 7){
                          $bulan = $r['nmBulan'].' '.$pisah_TA[0];
                        }else{
                          $bulan = $r['nmBulan'].' '.$pisah_TA[1];
                        }
                        echo "<tr>
                                <td>".$r['noRefrensi']."</td>
                                <td>".date('d/m/Y',strtotime($r['tanggal']))."</td>
                                <td>".$bulan."</td>
                                <td>".$r['keterangan']."</td>
                                <td>Rp. ".rupiah($gaji_pokok)."</td>
                                <td>Rp. ".rupiah($gaji_potongan)."</td>
                                <td>Rp. ".rupiah($sisa_gaji)."</td>
                                <td><center>
                                  <a class='btn btn-danger btn-xs' href='#' data-toggle='modal' data-target='#hapus".$r[idSlipGaji]."'><span class='fa fa-trash' data-toggle='tooltip' title='' data-original-title='Hapus'></span></a> 

                                  <a class='btn btn-success btn-xs' data-toggle='tooltip' title='' data-original-title='Cetak' target='_blank' href='admin/laporan/slip_penggajian.php?noref=".$r[noRefrensi]."'><span class='fa fa-print'></span></a> 
                                </center></td>";
                        echo "</tr>";

                        echo '<div class="modal fade" id="hapus'.$r[idSlipGaji].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <form action="?view='.$_GET[view].'&thn_ajar='.$_GET[thn_ajar].'&bulan='.$_GET[bulan].'&nip='.$_GET[nip].'&hapus" method="POST" role="form">
                                            <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel"><span class="fa fa-exclamation-triangle"></span> Hapus Data</h4> 
                                              </div>
                                              <div class="modal-body">
                                                <input type="hidden" name="id_slip_gaji" value="'.$r['idSlipGaji'].'">
                                                <input type="hidden" name="kas_noref" value="'.$r['noRefrensi'].'">
                                                <input type="hidden" name="nip_pegawai" value="'.$pegawai['nipPegawai'].'">
                                                <input type="hidden" name="jumlah_gaji" value="'.$sisa_gaji.'">
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
                      
                        if (isset($_GET[hapus])){
                          $query = mysqli_query($koneksi,"UPDATE pegawai_gaji_slip SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE idSlipGaji='$_POST[id_slip_gaji]'");
                          mysqli_query($koneksi,"UPDATE kas SET stdel='1', dby='$idUsers', ddate='$waktu_sekarang' WHERE noRefrensi='$_POST[kas_noref]'");
                          
                          //simpan logs transaksi    
                          $info = 'NIP:'.$pegawai['nipPegawai'].';Title:Hapus Gaji Bulan '.$bln['nmBulan'].' '.$thn['nmTahunAjaran'].' No. Ref '.$_POST['kas_noref'].' nominal '.$_POST['jumlah_gaji'];
                          mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Penggajian','Hapus Gaji','$info','$idUsers','$browser_ok','$user_os','$ip')");
                               
                          $title = 'Hapus Gaji Bulan '.$bln['nmBulan'].' '.$thn['nmTahunAjaran'];
                          mysqli_query($koneksi,"INSERT INTO log_kasir(tanggal,jenisBayar,idBayar,modul,aksi,noRefrensi,nis_nip,title,nominal,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Gaji','$_POST[id_slip_gaji]','Penggajian','Hapus','$_POST[kas_noref]','$pegawai[nipPegawai]','$title','$_POST[jumlah_gaji]','$idUsers','$browser_ok','$user_os','$ip')");

                          if($query){
                            $_SESSION['notif'] = 'dsukses';
                          }else{
                            $_SESSION['notif'] = 'dgagal';
                          }
                          echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&bulan=$_GET[bulan]&nip=$_GET[nip]';</script>";
                        }
                      ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Kelola Penggajian </h3>
          </div><!-- /.box-header -->
          <form action="" method="post">  
            <div class="box-body">  
              <div class="row">
                <div class="col-md-3">
                  <label>No. Referensi</label>
                  <input required="" name="kas_noref" id="kas_noref" class="form-control" value="<?= noRefSlipGaji($koneksi, $inisial, $tgl, '-2', $pegawai[idPegawai]) ?>" readonly="">
                </div>
                <div class="col-md-3">
                  <input type="hidden" id="idUnitPegawai" class="form-control" value="<?= $pegawai[unitPegawai] ?>" readonly="" required="">
                  <label>Pembayaran Gaji Via *</label>
                  <select name="id_akun_kas" id="Cakunkas" class="form-control" required>
                    <option value="" disabled="" selected="">-- Pilih Akun Kas --</option>
                                     
                  </select>
                </div>
                <div class="col-md-3">
                </div>
              </div>
      
              <br><br>
              
              <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Gaji</a></li>
                <li><a href="#tab_2" data-toggle="tab">Potongan</a></li>
                <li><a href="#tab_3" data-toggle="tab">Cetak Slip</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <input name="id_gaji" type="hidden" class="form-control" value="<?= $gaji['idGaji'] ?>" readonly="">
                    <?php
                      if ($gaji['idAkunGaji'] == ''){
                        $id_akun_gaji = mysqli_fetch_array(mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.kodeAkun like '%5-5%' AND akun_biaya.keterangan like '%Biaya Gaji%' AND akun_biaya.stdel='0' AND akun_biaya.jenisAkun='Sub Menu 2' AND akun_biaya.unitSekolah='$pegawai[unitPegawai]' ORDER BY akun_biaya.idAkun ASC"));
                        $akun_gaji = $id_akun_gaji['idAkun'];
                      }else{
                        $akun_gaji = $gaji['idAkunGaji'];
                      }
                    ?>
                    <input name="id_kode_akun" type="hidden" class="form-control" value="<?= $akun_gaji ?>" readonly="">
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                                <label>Gaji Pokok <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                              </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-2">
                                  <input name="gaji_pokok" type="text" class="form-control" value="<?= $gaji['gajiPokok'] ?>" readonly="" placeholder="Gaji Pokok">
                              </div>
                              </div>
                          </div>
                
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            <label>Gaji Lain-lain <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                            </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-2">
                            <input name="gaji_lain" type="text" class="form-control" value="<?= $gaji['gajiLain'] ?>" readonly="" placeholder="Gaji Lain-lain">
                            </div>
                              </div>
                          </div>
                          <hr>
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            <label>GAJI</label>
                            </div>
                              <div class="col-md-1"><label>=</label></div>
                              <div class="col-md-2">
                            <input name="subtotal_pokok" id="subtotal_pokok" type="text" class="form-control" value="<?= $total_gajipokok ?>" readonly="">
                            </div>
                              </div>
                          </div>
                          
                </div>
                
                <div class="tab-pane" id="tab_2">
                    
                    <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            <label>Simpanan Wajib &amp; Pengajian <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                            </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-2">
                            <input name="potongan_simpanan" id="potongan_simpanan" type="text" class="form-control" value="<?= $gaji['potonganSimpanan'] ?>" placeholder="Simpanan Wajib &amp; Pengajian" onkeyup="change_data()">
                            </div>
                              </div>
                          </div>
                
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            <label>BPJS Tenaga Kerja <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                            </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-2">
                            <input name="potongan_bpjstk" id="potongan_bpjstk" type="text" class="form-control" value="<?= $gaji['potonganBPJSTK'] ?>" placeholder="BPJS Tenaga Kerja" onkeyup="change_data()">
                            </div>
                              </div>
                          </div>
                    
                    <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            <label>Sumbangan <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                            </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-2">
                            <input name="potongan_sumbangan" id="potongan_sumbangan" type="text" class="form-control" value="<?= $gaji['potonganSumbangan'] ?>" placeholder="Sumbangan" onkeyup="change_data()">
                            </div>
                              </div>
                          </div>
                
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            <label>Belanjar Koperasi <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                            </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-2">
                            <input name="potongan_koperasi" id="potongan_koperasi" type="text" class="form-control" value="<?= $gaji['potonganKoperasi'] ?>" placeholder="Belanja Koperasi" onkeyup="change_data()">
                            </div>
                              </div>
                          </div>
                
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            <label>BPJS <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                            </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-2">
                            <input name="potongan_bpjs" id="potongan_bpjs" type="text" class="form-control" value="<?= $gaji['potonganBPJS'] ?>"  placeholder="BPJS" onkeyup="change_data()">
                            </div>
                              </div>
                          </div>
                
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            <label>Pinjaman <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                            </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-2">
                            <input name="potongan_pinjaman" id="potongan_pinjaman" type="text" class="form-control" value="<?= $gaji['potonganPinjaman'] ?>"  placeholder="Pinjaman" onkeyup="change_data()">
                            </div>
                              </div>
                          </div>
                
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            <label>Lain <small data-toggle="tooltip" title="" data-original-title="Wajib diisi">*</small></label>
                            </div>
                              <div class="col-md-1"><label> = </label></div>
                              <div class="col-md-2">
                            <input name="potongan_lain" id="potongan_lain" type="text" class="form-control" value="<?= $gaji['potonganLain'] ?>"  placeholder="Lain" onkeyup="change_data()">
                            </div>
                              </div>
                          </div>
                          
                          <hr>
                                              <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            <label>TOTAL POTONGAN</label>
                            </div>
                              <div class="col-md-1"><label>=</label></div>
                              <div class="col-md-2">
                            <input name="subtotal_potongan" id="subtotal_potongan" type="text" class="form-control" readonly="" value="<?= $total_gajiPotongan?>">
                            </div>
                              </div>
                          </div>
                          
                </div>
                
                <div class="tab-pane" id="tab_3">
                    
                    <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                                  <label>Gaji</label>
                              </div>
                              <div class="col-md-1"><label>=</label></div>
                              <div class="col-md-2">
                            <input name="pokok" id="pokok" type="text" class="form-control" readonly="" value="<?= $total_gajipokok ?>">
                              </div>
                              </div>
                          </div>
                          
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-2"><label>Potongan</label></div>
                              <div class="col-md-1"><label>=</label></div>
                              <div class="col-md-2">
                            <input name="potongan" id="potongan" type="text" class="form-control" readonly="" value="<?= $total_gajiPotongan?>">
                              </div>
                              </div>
                          </div>
                    <hr>
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            <label>GAJI DITERIMA</label>
                            </div>
                              <div class="col-md-1"><label>=</label></div>
                              <div class="col-md-2">
                            <input name="jumlah_gaji" id="jumlah_gaji" type="text" class="form-control" readonly="" value="<?= $total_gaji ?>">
                            </div>
                              </div>
                          </div>
                          
                          <div class="form-group">
                              <div class="row">
                              <div class="col-md-2">
                            </div>
                              <div class="col-md-1"></div>
                              <div class="col-md-2">
                                <button type="submit" name="simpan" class="btn btn-block btn-success">Cetak Slip Gaji</button>
                            </div>
                            </div>
                          </div>
                  </div>
              </div>
            </div>
              <input type="hidden" name="id_pegawai" value="<?= $pegawai[idPegawai]?>">
              <input type="hidden" name="id_tahun_ajaran" value="<?= $_GET[thn_ajar]?>">
              <input type="hidden" name="id_bulan" value="<?= $_GET[bulan]?>">
    
            <p class="text-muted">*) Kolom wajib diisi.</p>
          </div>
          </form>
        </div>

      </div>



       


<?php } ?>


<script type="text/javascript">
function change_data(){
    
    var simpanan    = $('#potongan_simpanan').val();
    var bpjstk      = $('#potongan_bpjstk').val();
    var sumbangan   = $('#potongan_sumbangan').val();
    var koperasi    = $('#potongan_koperasi').val();
    var bpjs        = $('#potongan_bpjs').val();
    var pinjaman    = $('#potongan_pinjaman').val();
    var lain        = $('#potongan_lain').val();
    var pokok       = $('#pokok').val();
    var potongan    = $('#potongan').val();
    
    if(simpanan == ''){
        simpanan = '0';
        //$('#potongan_simpanan').val(simpanan);
    }
    
    if(bpjstk  == ''){
        bpjstk = '0';
        //$('#potongan_bpjstk').val(bpjstk);
    }
    
    if(sumbangan  == ''){
        sumbangan = '0';
        //$('#potongan_sumbangan').val(sumbangan);
    }
    
    if(koperasi  == ''){
        koperasi = '0';
        //$('#potongan_koperasi').val(koperasi);
    }
    
    if(bpjs == ''){
        bpjs = '0';
        //$('#potongan_bpjs').val(bpjs);
    }
    
    if(pinjaman  == ''){
        pinjaman = '0';
        //$('#potongan_pinjaman').val(pinjaman);
    }
    
    if(lain  == ''){
        lain = '0';
        //$('#potongan_lain').val(lain);
    }
    
    var subpotongan = parseInt(simpanan) + parseInt(bpjstk) + parseInt(sumbangan) + parseInt(koperasi) + parseInt(bpjs) + parseInt(pinjaman) + parseInt(lain);
    
    if(isNaN(subpotongan)){
        subpotongan = '0';
    }
    
    $("#subtotal_potongan").val(subpotongan);
    $("#potongan").val(subpotongan);
    
    var total = parseInt(pokok) - parseInt(subpotongan);
    
    if(isNaN(total)){
        total = '0';
    }
    
    $("#jumlah_gaji").val(total);
    
    
}

</script>