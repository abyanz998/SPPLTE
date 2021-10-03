<?php if ($_GET[act]==''){ 
  //notif
  if ($_SESSION['notif'] == 'csukses_bulan'){
    echo '<script>toastr["success"]("Data Pembayaran Bulanan berhasil ditambahkan.","Sukses!")</script>';
  }elseif ($_SESSION['notif'] == 'dsukses_bulan'){
    echo '<script>toastr["success"]("Data Pembayaran Bulanan berhasil dihapus.","Sukses!")</script>';
  }elseif ($_SESSION['notif'] == 'csukses_bebas'){
    echo '<script>toastr["success"]("Data Pembayaran Bebas berhasil ditambahkan.","Sukses!")</script>';
  }elseif ($_SESSION['notif'] == 'dsukses_bebas'){
    echo '<script>toastr["success"]("Data Pembayaran Bebas berhasil dihapus.","Sukses!")</script>';
  }elseif($_SESSION['notif'] == 'gagal'){
    echo '<script>toastr["error"]("Data gagal diproses.","Gagal!")</script>';
  }elseif($_SESSION['notif'] == 'gagal_nominal_transaksi'){
    echo '<script>toastr["error"]("Nominal Pembayaran melebihi Tagihan.","Gagal!")</script>';
  }elseif($_SESSION['notif'] == 'wa_sukses'){
    echo '<script>toastr["success"]("Berhasil mengirimkan Tagihan.","Sukses!")</script>';
  }elseif($_SESSION['notif'] == 'wa_gagal'){
    echo '<script>toastr["error"]("Gagal mengirimkan Tagihan.","Gagal!")</script>';
  }
  elseif($_SESSION['notif'] == 'sukses_transaksi'){
    echo '<script> toastr["success"]("Berhasil menyimpan transaksi ke kas.","Sukses!"); </script>';
  }
  unset($_SESSION['notif']);

?> 
      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Filter Data Pembayaran Santri</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <form action="" class="form-horizontal" method="get" accept-charset="utf-8">
              <input type="hidden" name="view" id="view" value="<?= $_GET['view']?>">
              <div class="form-group">            
                <label for="" class="col-sm-2 control-label">Tahun Ajaran</label>
                <div class="col-sm-2">
                  <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
                  <select class="form-control" name="thn_ajar" id="Ctahunajaran"></select>
                </div>
                <label for="" class="col-sm-2 control-label">Cari Santri</label>
                <div class="col-sm-4">
                  <div class="input-group">
                    <input type="text" class="form-control" autofocus="" name="nis" id="nis" placeholder="NIS Santri" required="" value="<?= $_GET['nis']?>">
                    <span class="input-group-btn">
                      <button class="btn btn-success" type="submit">Cari</button>
                    </span>
                    <span class="input-group-btn"></span>
                    <span class="input-group-btn"></span>
                    <span class="input-group-btn"></span>
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-default" data-toggle="modal" data-target="#dataSantri"><b>Data Santri</b></button>
                    </span>
                  </div>
                </div>
              </div>
            </form>
          </div><!-- /.box-body -->
        </div><!-- /.box -->

        <!-- MODAL CARI DATA SISWA -->
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
                                $tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$idUnitUsers'  AND siswa.statusSiswa='Aktif' ORDER BY siswa.idSiswa DESC");
                              }else{
                                $tampil = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0'  AND siswa.statusSiswa='Aktif' ORDER BY siswa.idSiswa DESC");
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
                                        <center><button type='button' data-dismiss='modal' class='btn btn-primary btn-xs' onclick='ambil_data(".$r['nisSiswa'].")'>Pilih</button></center>
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
        <!-- /.MODAL CARI DATA SISWA -->


    <?php if (isset($_GET['thn_ajar']) && isset($_GET['nis'])) { ?>

      <?php
        $siswa = mysqli_fetch_array(mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.nisSiswa='$_GET[nis]'"));
        $thn = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$_GET[thn_ajar]'"));

        if (empty($siswa['fotoSiswa'])){
          $fotoSiswa = $lokasi_default_fotoSiswa;
        }else{
          $fotoSiswa = $lokasi_penyimpanan_fotoSiswa.$siswa['fotoSiswa'];
        }

        $inisial = "SP".$siswa['singkatanUnit'].$siswa['nisSiswa'].date('dmy');
        $nomor_refrensi = noRefrensiPembayaran($koneksi,$inisial,$tanggal_sekarang,'-2',$siswa['idSiswa']);
      ?>


      <?php
        if (isset($_POST['simpan_bulanan'])){
          $query = mysqli_query($koneksi,"UPDATE tagihan_bulanan SET noRefrensi='$_POST[kas_noref]', tglBayar='$waktu_sekarang', tglBayarSementara='$_POST[tanggal_bayar]', statusBayar='2', idAkunKas='$_POST[id_akun_kas]', statusKas='0' WHERE idTagihanBulanan='$_POST[id_tagihan_bulanan]'");
          $info = 'NIS:'.$siswa['nisSiswa'].';Title:Bayar-'.$_POST['nama_pos_bayar'].' '.$_POST['nama_tahun_ajaran'].' bulan '.$_POST['nama_bulan'].' nominal '.$_POST['jumlah_bayar'];
          mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Pembayaran','Bayar Bulanan','$info','$idUsers','$browser_ok','$user_os','$ip')");

          $title = 'Bayar-'.$_POST['nama_pos_bayar'].' '.$_POST['nama_tahun_ajaran'].' bulan '.$_POST['nama_bulan'];
          mysqli_query($koneksi,"INSERT INTO log_kasir(tanggal,jenisBayar,idBayar,modul,aksi,noRefrensi,nis_nip,title,nominal,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Bulanan','$_POST[id_tagihan_bulanan]','Pembayaran','Bayar','$_POST[kas_noref]','$siswa[nisSiswa]','$title','$_POST[jumlah_bayar]','$idUsers','$browser_ok','$user_os','$ip')");

          if ($query){
            $_SESSION['notif'] = 'csukses_bulan';
            echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";

          }else{
            $_SESSION['notif'] = 'gagal';
            echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
          }
        }

        if (isset($_POST['hapus_bulanan'])){
          $query = mysqli_query($koneksi,"UPDATE tagihan_bulanan SET noRefrensi=null, tglBayar=null, tglBayarSementara=null, statusBayar='0', idAkunKas=null, statusKas='0' WHERE idTagihanBulanan='$_POST[id_tagihan_bulanan]'");

          $info = 'NIS:'.$siswa['nisSiswa'].';Title:Hapus Bayar-'.$_POST['nama_pos_bayar'].' '.$_POST['nama_tahun_ajaran'].' bulan '.$_POST['nama_bulan'].' nominal '.$_POST['jumlah_bayar'];
          mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Pembayaran','Hapus Bayar Bulanan','$info','$idUsers','$browser_ok','$user_os','$ip')");

          $title = 'Hapus Bayar-'.$_POST['nama_pos_bayar'].' '.$_POST['nama_tahun_ajaran'].' bulan '.$_POST['nama_bulan'];
          mysqli_query($koneksi,"INSERT INTO log_kasir(tanggal,jenisBayar,idBayar,modul,aksi,noRefrensi,nis_nip,title,nominal,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Bulanan','$_POST[id_tagihan_bulanan]','Pembayaran','Hapus','$_POST[kas_noref]','$siswa[nisSiswa]','$title','$_POST[jumlah_bayar]','$idUsers','$browser_ok','$user_os','$ip')");

          if ($query){
            $_SESSION['notif'] = 'dsukses_bulan';
            echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";

          }else{
            $_SESSION['notif'] = 'gagal';
            echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
          }
        }


        if (isset($_POST['simpan_bebas'])){
          if ($_POST['sisa_tagihan'] == $_POST['jumlah_bayar']){
            $statusBayar = 1;
          }else{
            $statusBayar = 2;
          }
          if($_POST['sisa_tagihan'] < $_POST['jumlah_bayar']){
            $_SESSION['notif'] = 'gagal_nominal_transaksi';
            echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
          }else{
            $query = mysqli_query($koneksi,"INSERT INTO tagihan_bebas_bayar(idTagihanBebas,noRefrensi,tglBayar,tglBayarSementara,jumlahBayar,idAkunKas,ketBebas) VALUES ('$_POST[id_tagihan_bebas]','$_POST[no_ref]','$waktu_sekarang','$_POST[tanggal_bayar]','$_POST[jumlah_bayar]','$_POST[id_akun_kas]','$_POST[keterangan_bebas]')");
          
            $query1 = mysqli_query($koneksi,"UPDATE tagihan_bebas SET statusBayar='$statusBayar' WHERE idTagihanBebas='$_POST[id_tagihan_bebas]'");
            
            $info ='NIS:'.$siswa['nisSiswa'].';Title:Pelunasan '.$_POST['nama_pos_bayar'].' nominal '.$_POST['jumlah_bayar'];
            mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Pembayaran','Bayar Bebas','$info','$idUsers','$browser_ok','$user_os','$ip')");

            $title = 'Pelunasan '.$_POST['nama_pos_bayar'];
            mysqli_query($koneksi,"INSERT INTO log_kasir(tanggal,jenisBayar,idBayar,modul,aksi,noRefrensi,nis_nip,title,nominal,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Bebas','$_POST[id_tagihan_bebas]','Pembayaran','Bayar','$_POST[kas_noref]','$siswa[nisSiswa]','$title','$_POST[jumlah_bayar]','$idUsers','$browser_ok','$user_os','$ip')");

            if ($query && $query1){
              $_SESSION['notif'] = 'csukses_bebas';
              echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";

            }else{
              $_SESSION['notif'] = 'gagal';
              echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
            }
          }  
        }


        if (isset($_POST['simpan_banyak_bayar_bebas'])){

          $id_tagihan_bebas = $_POST['id_tagihan_bebas'];
          $nama_pos_bayar = $_POST['nama_pos_bayar'];
          $nominal_bayar = $_POST['nominal_bayar'];
          $keterangan_bayar = $_POST['keterangan_bayar'];
          
          for ($i=0; $i < count($id_tagihan_bebas); $i++) { 
            $cek_tagihan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tagihan_bebas WHERE idTagihanBebas='$id_tagihan_bebas[$i]'"));
            $cek_bayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(jumlahBayar) as totalBayar FROM tagihan_bebas WHERE idTagihanBebas='$id_tagihan_bebas[$i]'"));
            $sisa_tagihan = $cek_tagihan['totalTagihan'] - $cek_bayar['totalBayar'];
            if ($nominal_bayar[$i] > $sisa_tagihan){
              $_SESSION['notif'] = 'gagal_nominal_transaksi';
              echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
            }else{
              if ($nominal_bayar[$i] == $sisa_tagihan){
                $statusBayar = 1;
              }else{
                $statusBayar = 2;
              }
              $query = mysqli_query($koneksi,"INSERT INTO tagihan_bebas_bayar(idTagihanBebas,noRefrensi,tglBayar,tglBayarSementara,jumlahBayar,idAkunKas,ketBebas) VALUES ('$id_tagihan_bebas[$i]','$_POST[kas_noref]','$waktu_sekarang','$_POST[tanggal_bayar]','$nominal_bayar[$i]','$_POST[id_akun_kas]','$keterangan_bayar[$i]')");
              $query1 = mysqli_query($koneksi,"UPDATE tagihan_bebas SET statusBayar='$statusBayar' WHERE idTagihanBebas='$id_tagihan_bebas[$i]'");
              
              $info ='NIS:'.$siswa['nisSiswa'].';Title:Pelunasan '.$nama_pos_bayar[$i].' nominal '.$nominal_bayar[$i];
              mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Pembayaran','Simpan Pembayaran','$info','$idUsers','$browser_ok','$user_os','$ip')");
              
              $title = 'Pelunasan '.$nama_pos_bayar[$i];
              mysqli_query($koneksi,"INSERT INTO log_kasir(tanggal,jenisBayar,idBayar,modul,aksi,noRefrensi,nis_nip,title,nominal,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Bebas','$id_tagihan_bebas[$i]','Pembayaran','Bayar','$_POST[kas_noref]','$siswa[nisSiswa]','$title','$nominal_bayar[$i]','$idUsers','$browser_ok','$user_os','$ip')");

              if ($query && $query1){
                $_SESSION['notif'] = 'csukses_bebas';
                echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";

              }else{
                $_SESSION['notif'] = 'gagal';
                echo "<script>document.location='index.php?view=$_GET[view]&thn_ajar=$_GET[thn_ajar]&nis=$_GET[nis]';</script>";
              }
            }
          }
        }

      ?>

        <!-- INFROMASI SISWA -->
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
                    <td>Kelas</td>
                    <td>:</td>
                    <td><?= $siswa['nmKelas'] ?></td> 
                  </tr>
                  <tr>
                    <td>Kamar</td>
                    <td>:</td>
                    <td><?php if (($siswa['kamarSiswa'] == '0') OR ($siswa['kamarSiswa'] == '')){ echo 'Tidak Ada'; } else { echo $siswa['namaKamar'];}  ?></td> 
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-3">
              <img src="<?= $fotoSiswa ?>" class="img-thumbnail img-responsive">
            </div>
          </div>
        <!-- /.INFROMASI SISWA -->


        <!-- List Tagihan Bulanan --> 
          <div class="box box-primary">
            <div class="payment">
              <div class="box-header with-border">
                <h3 class="box-title">Jenis Pembayaran</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                <input type="hidden"required="" name="nis_siswa" id="nis_siswa" class="form-control" value="<?= $siswa['nisSiswa'] ?>" readonly="">
                <div class="row">
                  <div class="col-md-3">
                    <label>No. Referensi</label>
                    <input required="" name="kas_noref" id="kas_noref" class="form-control" value="<?= $nomor_refrensi ?>" readonly="">
                  </div>
                  <div class="col-md-3">
                    <label>Akun Kas *</label>
                    <input type="hidden" id="idUnitPegawai" class="form-control" value="<?= $siswa['unitSiswa'] ?>" readonly="">
                    <select required="" name="id_akun_kas" id="Cakunkas" class="form-control">
                      <option value="">- Pilih Akun Kas -</option>
                    </select>
                  </div>
                  <br>
                </div>
                <br>
            
                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Bulanan</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Bebas</a></li>
                  </ul>
              
                  <div class="tab-content">

                    <!-- List Tagihan Bulanan -->
                    <div class="tab-pane active" id="tab_1">
                      <div class="box-body table-responsive">
                        <table class="table table-bordered" style="white-space: nowrap;">
                          <thead>
                            <tr class="info">
                              <th>No.</th>
                              <th>Nama Pembayaran</th>
                              <th>Sisa Tagihan</th>
                              <?php
                                $bulan = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
                                while ($bln = mysqli_fetch_array($bulan)) {
                                  echo '<th>'.$bln['nmBulan'].'</th>';
                                }
                              ?>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                          $no = 1;
                          $grupJenisBayar = mysqli_query($koneksi, "SELECT 
                                                                      tagihan_bulanan.*, 
                                                                      SUM(tagihan_bulanan.jumlahTagihan) as totalTagihanBulanan,
                                                                      jenis_bayar.idPosBayar, 
                                                                      tahun_ajaran.nmTahunAjaran,
                                                                      pos_bayar.nmPosBayar
                                                                    FROM tagihan_bulanan 
                                                                    LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                                                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                    WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]'
                                                                    GROUP BY tagihan_bulanan.idJenisBayar");
                          while ($gjb = mysqli_fetch_array($grupJenisBayar)) {
                            $jumlahBayarBulanan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(jumlahTagihan) as totalBayarBulanan FROM tagihan_bulanan WHERE idSiswa='$siswa[idSiswa]' AND idJenisBayar='$gjb[idJenisBayar]' AND statusBayar='1' GROUP BY idSiswa"));
                            echo '<tr>';
                              echo '<td>'.$no.'</td>';
                              echo '<td>'.$gjb['nmPosBayar'].' - T.A '.$gjb['nmTahunAjaran'].'</td>';
                              echo '<td>'.buatRp($gjb['totalTagihanBulanan'] - $jumlahBayarBulanan['totalBayarBulanan']).'</td>';
                            $sqlTagihanBulanan = mysqli_query($koneksi,"
                                                             SELECT 
                                                              tagihan_bulanan.*,
                                                              bulan.urutan, 
                                                              bulan.nmBulan, 
                                                              akun_biaya.keterangan, 
                                                              unit_sekolah.singkatanUnit 
                                                             FROM tagihan_bulanan 
                                                             LEFT JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                                             LEFT JOIN akun_biaya ON tagihan_bulanan.idAkunKas = akun_biaya.idAkun
                                                             LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                                             WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND tagihan_bulanan.idJenisBayar='$gjb[idJenisBayar]'
                                                             ORDER BY bulan.urutan ASC"); 
                            while ($TagihanBulanan = mysqli_fetch_array($sqlTagihanBulanan)) {
                              if ($TagihanBulanan['statusBayar'] == '2'){
                                echo '<td class="success">
                                        <a data-toggle="modal" data-target="#del'.$TagihanBulanan[nmBulan].$TagihanBulanan[idTagihanBulanan].'">'.buatRp($TagihanBulanan['jumlahTagihan']).'<br>('.date('d/m/y',strtotime($TagihanBulanan['TglTagihan'])).')</a>
                                      </td>';
                                echo '<div class="modal fade" id="del'.$TagihanBulanan[nmBulan].$TagihanBulanan[idTagihanBulanan].'" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">×</button>
                                                <h4 class="modal-title">Pembayaran Bulan '.$TagihanBulanan[nmBulan].'</h4>
                                              </div>
                                              <form action="" method="post" accept-charset="utf-8">
                                                <div class="modal-body">
                                                  <input class="form-control" required="" type="hidden" name="id_tagihan_bulanan" value="'.$TagihanBulanan[idTagihanBulanan].'">
                                                  <input class="form-control" required="" type="hidden" name="kas_noref" value="'.$nomor_refrensi.'">
                                                  <input class="form-control" required="" type="hidden" name="nama_bulan" value="'.$TagihanBulanan['nmBulan'].'">
                                                  <input class="form-control" required="" type="hidden" name="nama_pos_bayar" value="'.$gjb['nmPosBayar'].'">
                                                  <input class="form-control" required="" type="hidden" name="nama_tahun_ajaran" value="'.$gjb['nmTahunAjaran'].'">
                                                  <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                      <input class="form-control" required="" type="text" name="tanggal_bayar" placeholder="Tanggal Bayar" value="'.date('Y-m-d',strtotime($TagihanBulanan['tglBayarSementara'])).'" readonly>
                                                    </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label>Jumlah Bayar</label>
                                                      <input class="form-control" readonly="" type="text" name="jumlah_bayar" placeholder="Jumlah Bayar" value="'.$TagihanBulanan['jumlahTagihan'].'">
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="submit" name="hapus_bulanan" class="btn btn-danger">Hapus</button>
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                </div>
                                              </form>                           
                                            </div>
                                          </div>
                                        </div>';
                              }else{
                                echo '<td class="danger"> 
                                        <a data-toggle="modal" data-target="#add'.$TagihanBulanan[nmBulan].$TagihanBulanan[idTagihanBulanan].'" onclick="change_kas_account('.$no.')">'.buatRp($TagihanBulanan['jumlahTagihan']).'</a>
                                      </td>';
                                echo '<div class="modal fade" id="add'.$TagihanBulanan[nmBulan].$TagihanBulanan[idTagihanBulanan].'" role="dialog">
                                        <div class="modal-dialog modal-sm">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">×</button>
                                                <h4 class="modal-title">Pembayaran Bulan '.$TagihanBulanan[nmBulan].'</h4>
                                              </div>
                                              <form action="" method="post" accept-charset="utf-8">
                                                <div class="modal-body">
                                                  <input class="form-control" required="" type="hidden" name="id_tagihan_bulanan" value="'.$TagihanBulanan[idTagihanBulanan].'">
                                                  <input class="form-control" required="" type="hidden" name="kas_noref" value="'.$nomor_refrensi.'">
                                                  <input class="form-control" required="" type="hidden" name="id_akun_kas" id="Akun_Kas_Bulanan'.$no.'">
                                                  <input class="form-control" required="" type="hidden" name="nama_bulan" value="'.$TagihanBulanan['nmBulan'].'">
                                                  <input class="form-control" required="" type="hidden" name="nama_pos_bayar" value="'.$gjb['nmPosBayar'].'">
                                                  <input class="form-control" required="" type="hidden" name="nama_tahun_ajaran" value="'.$gjb['nmTahunAjaran'].'">
                                                  <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                      <input class="form-control " required="" type="text" name="tanggal_bayar" placeholder="Tanggal Bayar" value="'.date('Y-m-d').'">
                                                    </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label>Jumlah Bayar</label>
                                                      <input class="form-control" readonly="" type="text" name="jumlah_bayar" placeholder="Jumlah Bayar" value="'.$TagihanBulanan['jumlahTagihan'].'">
                                                  </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="submit" name="simpan_bulanan" class="btn btn-success">Simpan</button>
                                                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                </div>
                                              </form>                           
                                            </div>
                                          </div>
                                        </div>';
                                $no++;
                              }
                            }

                            echo '</tr>';
                          }
                        ?>
                      </tbody>
                        </table>
                      </div>
                    </div>
                  <!-- End List Tagihan Bulanan -->


                  <div class="tab-pane" id="tab_2">
                    

                    <!-- List Tagihan Lainnya (Bebas) -->

                    <div class="box-body">
                        <a data-toggle="modal" class="btn btn-success btn-xs" title="Bayar Banyak" href="#bayarBanyak" onclick="get_form(); change_kas_account(1)"><span class="fa fa-money"></span> Bayar Banyak</a>
                      <a href="" class="btn btn-info btn-xs"><i class="fa fa-refresh"></i> Refresh</a>
                    <div class="box-body table-responsive">
                    
                     <div class="modal fade" id="bayarBanyak" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                              <h4 class="modal-title">Bayar Banyak</h4>
                            </div>
                            <form action="" method="post" accept-charset="utf-8">
                              <div class="modal-body">
                                <div class="form-group">
                                  <label>Tanggal *</label>
                                  <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input class="form-control" required="" type="text" name="tanggal_bayar" id="bebas_pay_date" placeholder="Tanggal Bayar" value="<?= date('Y-m-d')?>">
                                  </div>
                                  <input type="hidden" name="kas_noref" value="<?= $nomor_refrensi ?>">
                                  <input type="hidden" name="id_akun_kas" id="Akun_Kas_Bebas_batch">     
                                </div>
                                <div id="fbatch"></div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" name="simpan_banyak_bayar_bebas" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>


                      <table class="table table-bordered" style="white-space: nowrap;">
                        <thead>
                          <tr class="info">
                            <th><center><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></center></th>
                            <th>No.</th>
                            <th>Jenis Pembayaran</th>
                            <th>Total Tagihan</th>
                            <th>Dibayar</th>
                            <th>Status</th>
                            <th>Bayar</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                           $TagihanBebas = mysqli_query($koneksi, "SELECT 
                                                                      tagihan_bebas.*, 
                                                                      SUM(tagihan_bebas.totalTagihan) as totalTagihanBebas, 
                                                                      jenis_bayar.idPosBayar, 
                                                                      tahun_ajaran.nmTahunAjaran,
                                                                      pos_bayar.nmPosBayar
                                                                    FROM tagihan_bebas 
                                                                    LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                    WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' 
                                                                    GROUP BY tagihan_bebas.idJenisBayar");
                          $no=1;
                          while ($tb = mysqli_fetch_array($TagihanBebas)) {
                            $totalBayarBebas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(jumlahBayar) as totalBayarBebas FROM tagihan_bebas_bayar WHERE idTagihanBebas='$tb[idTagihanBebas]'"));
                            $sisaTagihanBebas = $tb['totalTagihanBebas'] - $totalBayarBebas['totalBayarBebas'];
                            if ($tb['statusBayar'] == '1'){
                               echo '<tr class="success">
                                      <td style="background-color: #fff !important;">
                                        <center><input type="checkbox" disabled="disabled"></center>
                                      </td>
                                      <td style="background-color: #fff !important;">'.$no.'</td>
                                      <td style="background-color: #fff !important;">'.$tb['nmPosBayar'].' - T.A '.$tb['nmTahunAjaran'].'</td>
                                      <td>'.buatRp($sisaTagihanBebas).'</td>
                                      <td>'.buatRp($totalBayarBebas['totalBayarBebas']).'</td>
                                      <td><a data-toggle="modal" title="Lihat" href="#lihat'.$tb['idTagihanBebas'].'" class="view-cicilan label label-success">Lunas</a></td>
                                      <td width="40" style="text-align:center">
                                        <a data-toggle="modal" class="btn btn-success btn-xs disabled" title="Bayar" href="#addCicilan'.$tb['idTagihanBebas'].'" onclick="ambil_idKas_bebas('.$no.')"><span class="fa fa-money"></span> Bayar</a>
                                      </td>
                                    </tr>';
                            }else{
                              echo '<tr class="danger">
                                      <td style="background-color: #fff !important;">
                                        <center><input type="checkbox" class="checkbox" name="msg[]" id="msg" value="'.$tb['idTagihanBebas'].'"></center>
                                      </td>
                                      <td style="background-color: #fff !important;">'.$no.'</td>
                                      <td style="background-color: #fff !important;">'.$tb['nmPosBayar'].' - T.A '.$tb['nmTahunAjaran'].'</td>
                                      <td>'.buatRp($sisaTagihanBebas).'</td>
                                      <td>'.buatRp($totalBayarBebas['totalBayarBebas']).'</td>
                                      <td><a data-toggle="modal" title="Lihat" href="#lihat'.$tb['idTagihanBebas'].'" class="view-cicilan label label-warning">Belum Lunas</a></td>
                                      <td width="40" style="text-align:center">
                                        <a data-toggle="modal" class="btn btn-success btn-xs " title="Bayar" href="#addCicilan'.$tb['idTagihanBebas'].'" onclick="change_kas_account('.$no.')"><span class="fa fa-money"></span> Bayar</a>
                                      </td>
                                    </tr>';

                              echo '<div class="modal fade" id="addCicilan'.$tb['idTagihanBebas'].'" role="dialog">
                                      <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">Tambah Pembayaran/Cicilan</h4>
                                          </div>
                                          <form action="" method="post" accept-charset="utf-8">
                                            <div class="modal-body">
                                              <input class="form-control" required="" type="hidden" name="id_tagihan_bebas" value="'.$tb[idTagihanBebas].'">
                                              <input class="form-control" required="" type="hidden" name="no_ref" value="'.$nomor_refrensi.'">
                                              <input class="form-control" required="" type="hidden" name="id_akun_kas" id="Akun_Kas_Bebas'.$no.'">
                                              <input class="form-control" required="" type="hidden" name="sisa_tagihan" value="'.$sisaTagihanBebas.'">
                                              <div class="form-group">
                                                <label>Nama Pembayaran</label>
                                                <input class="form-control" readonly name="nama_pos_bayar" type="text" value="'.$tb['nmPosBayar'].' - T.A '.$tb['nmTahunAjaran'].'">
                                              </div>
                                              <div class="form-group">
                                                <label>Tanggal *</label>
                                                <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                  <input class="form-control" required="" type="text" name="tanggal_bayar" id="bebas_pay_date" placeholder="Tanggal Bayar" value="'.date('Y-m-d').'">
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-md-6">
                                                  <label>Jumlah Bayar *</label>
                                                  <input type="text" required="" name="jumlah_bayar" class="form-control" placeholder="Jumlah Bayar">
                                                </div>
                                                <div class="col-md-6">
                                                  <label>Keterangan *</label>
                                                  <input type="text" required="" name="keterangan_bebas" class="form-control" placeholder="Keterangan">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="submit" name="simpan_bebas" class="btn btn-success">Simpan</button>
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>';
                            }
                            

                            echo '<div class="modal fade" id="lihat'.$tb['idTagihanBebas'].'" role="dialog">
                                      <div class="modal-dialog modal-md">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">Lihat Pembayaran/Cicilan</h4>
                                          </div>
                                          <form action="" method="post" accept-charset="utf-8">
                                            <div class="modal-body">
                                            <div id="object_detail_bebas">
                                              <object data="admin/pembayaran_tagihan_bebas.php?id='.$tb['idTagihanBebas'].'&view='.$_GET['view'].'&thn_ajar='.$_GET['thn_ajar'].'&nis='.$_GET['nis'].'&posbayar='.$tb['nmPosBayar'].' - T.A '.$tb['nmTahunAjaran'].'" width="100%" height="400px"></object>
                                            </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>';
                            $no++;
                            
                          }
                ?>

                              
                                          
                            </tbody>
                          </table>
                      </div>
                      </div>
                      </div>
                <div class="row">
                    
                      <br>
                      <br>
                    <div class="col-md-9">
          <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Jenis Pembayaran</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_pay" data-toggle="tab">Transaksi Pembayaran</a></li>
                <li><a href="#tab_history" data-toggle="tab">History Pembayaran</a></li>
                <li><a href="#tab_tagihan" data-toggle="tab">Tagihan Pembayaran</a></li>
              </ul>
              <div class="tab-content">
                
                <!-- TAB TRANSAKSI -->
                <div class="tab-pane active" id="tab_pay">
                  <div class="box-body table-responsive">
                    <table class="table table-responsive table-bordered" style="white-space: nowrap;">
                      <tbody>
                        <tr class="info">
                          <th>No</th>
                          <th>No. Ref</th>
                          <th>Tanggal</th>
                          <th>Pembayaran</th>
                          <th>Nominal</th>
                        </tr>
                        <?php
                        $no = 1;
                        $total_transaksi=0;

                        $tampil_bulanan = mysqli_query($koneksi,"SELECT 
                                                                      tagihan_bulanan.*,
                                                                      jenis_bayar.idPosBayar, 
                                                                      tahun_ajaran.nmTahunAjaran,
                                                                      pos_bayar.nmPosBayar,
                                                                      bulan.nmBulan,
                                                                      bulan.urutan
                                                                    FROM tagihan_bulanan 
                                                                    LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                                                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                    LEFT JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                                                    WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' AND tagihan_bulanan.statusBayar='1' AND (DATE(tagihan_bulanan.tglBayar)='$tanggal_sekarang') AND tagihan_bulanan.statusKas='0' ORDER BY tagihan_bulanan.idTagihanBulanan DESC");

                        while ($r = mysqli_fetch_array($tampil_bulanan)) {
                          $pisah_TA = explode('/', $r['nmTahunAjaran']);
                          if ($r['urutan'] <= 6){
                            $nmBulan = $r['nmBulan'].' '.$pisah_TA[0];
                          }else{
                            $nmBulan = $r['nmBulan'].' '.$pisah_TA[1];
                          }
                          echo '<tr>
                                  <td>'.$no++.'</td>
                                  <td>'.$r['noRefrensi'].'</td>
                                  <td>'.date('d/m/Y',strtotime($r['tglBayarSementara'])).'</td>
                                  <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].' - ('.$nmBulan.')</td>
                                  <td>'.buatRp($r['jumlahTagihan']).'</td>
                                </tr>';
                        $total_transaksi = $total_transaksi + $r['jumlahTagihan'];
                        $kas_noref = $r['noRefrensi'];
                        }

                        $tampil_bebas = mysqli_query($koneksi,"SELECT 
                                                                tagihan_bebas.*, 
                                                                tagihan_bebas_bayar.*, 
                                                                jenis_bayar.idPosBayar, 
                                                                tahun_ajaran.nmTahunAjaran,
                                                                pos_bayar.nmPosBayar
                                                              FROM tagihan_bebas 
                                                              LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas
                                                              LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                              LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                              LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                              WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.statusKas='0' AND (DATE(tagihan_bebas_bayar.tglBayar)='$tanggal_sekarang') ORDER BY tagihan_bebas.idTagihanBebas DESC");
                        while ($r = mysqli_fetch_array($tampil_bebas)) {
                          echo '<tr>
                                  <td>'.$no++.'</td>
                                  <td>'.$r['noRefrensi'].'</td>
                                  <td>'.date('d/m/Y',strtotime($r['tglBayarSementara'])).'</td>
                                  <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].'</td>
                                  <td>'.buatRp($r['jumlahBayar']).'</td>
                                </tr>';
                          $total_transaksi = $total_transaksi + $r['jumlahBayar'];
                          $kas_noref = $r['noRefrensi'];
                        }


                        if ((mysqli_num_rows($tampil_bulanan) != '0') OR (mysqli_num_rows($tampil_bebas) != '0')){
                          echo '<tr style="background-color: #bcffc0">
                                  <td colspan="4"></td>
                                    <td>'.buatRp($total_transaksi).'</td>
                                </tr>
                                <tr>
                                  <td colspan="4"></td>
                                  <td>';
                                    $noHp_ortu = $siswa['noHpOrtu'];
                                    $text_wa = 'Terima Kasih, Pembayaran Sekolah a/n '.$siswa[nmSiswa].', Kelas '.$siswa[nmKelas].', telah kami terima tgl '.date('d-m-Y').' sejumlah '.buatRp($total_transaksi).' Referensi ID : '.$kas_noref.' %0A %0A*) Silahkan simpan nomor ini jika link tidak aktif';
                                    echo "<a class='btn btn-primary btn-block' title='Kirimkan Tagihan' href='admin/whatsapp.php?phone=".$noHp_ortu."&text=".$text_wa."&view=".$_GET[view]."&thn_ajar=".$_GET[thn_ajar]."&nis=".$_GET[nis]."' onclick='trxFinish()'><i class='fa fa-send'></i>Simpan Transaksi</a>";
                          echo '  </td>
                                </tr>';
                        }         
                      ?>   
                      </tbody>
                    </table>
                  </div>
                </div>
              <!-- END TAB TRANSAKSI -->

              <!-- TAB HISTORI -->
              <div class="tab-pane" id="tab_history">
                <div class="box-body table-responsive">
                  <div class="over">
                    <table id="tabel_histori" class="table table-responsive table-bordered" width="100%" style="white-space: nowrap;">
                      <thead>
                        <tr class="info">
                          <th>Tanggal</th>
                          <th>No. Ref</th>
                          <th>Pembayaran</th>
                          <th>Nominal</th>
                          <th>Bayar Via</th>
                        </tr>
                      </thead>
                        <tbody>
                        </tr>
                         <?php
                            $tampil_bulanan = mysqli_query($koneksi,"SELECT 
                                                                          tagihan_bulanan.*,
                                                                          jenis_bayar.idPosBayar, 
                                                                          tahun_ajaran.nmTahunAjaran,
                                                                          pos_bayar.nmPosBayar,
                                                                          akun_biaya.keterangan,
                                                                          bulan.nmBulan
                                                                        FROM tagihan_bulanan 
                                                                        LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                                                        LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                        LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                        LEFT JOIN akun_biaya ON tagihan_bulanan.idAkunKas = akun_biaya.idAkun
                                                                        LEFT JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                                                        WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.statusKas='1' ORDER BY tagihan_bulanan.idTagihanBulanan DESC");
                            while ($r = mysqli_fetch_array($tampil_bulanan)) {
                              $pisah_TA = explode('/', $r['nmTahunAjaran']);
                              if ($r['urutan'] <= 6){
                                $nmBulan = $r['nmBulan'].' '.$pisah_TA[0];
                              }else{
                                $nmBulan = $r['nmBulan'].' '.$pisah_TA[1];
                              }
                              echo '<tr>
                                      <td>'.date('d/m/Y',strtotime($r['tglBayar'])).'</td>
                                      <td>'.$r['noRefrensi'].'</td>
                                      <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].' - ('.$nmBulan.')</td>
                                      <td>'.buatRp($r['jumlahTagihan']).'</td>
                                      <td>'.$r['keterangan'].'</td>
                                    </tr>';
                            }

                            $tampil_bebas = mysqli_query($koneksi,"SELECT 
                                                                    tagihan_bebas.*, 
                                                                    tagihan_bebas_bayar.*, 
                                                                    jenis_bayar.idPosBayar, 
                                                                    tahun_ajaran.nmTahunAjaran,
                                                                    pos_bayar.nmPosBayar,
                                                                    akun_biaya.keterangan
                                                                  FROM tagihan_bebas 
                                                                  LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas
                                                                  LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                                  LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                  LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                  LEFT JOIN akun_biaya ON tagihan_bebas_bayar.idAkunKas = akun_biaya.idAkun
                                                                  WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.statusKas='1' ORDER BY tagihan_bebas.idTagihanBebas DESC");
                            while ($r = mysqli_fetch_array($tampil_bebas)) {
                              echo '<tr>
                                      <td>'.date('d/m/Y',strtotime($r['tglBayar'])).'</td>
                                      <td>'.$r['noRefrensi'].'</td>
                                      <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].'</td>
                                      <td>'.buatRp($r['jumlahBayar']).'</td>
                                       <td>'.$r['keterangan'].'</td>
                                    </tr>';
                            }
                          ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- END TAB HISTORI -->

                <!-- TAB TAGIHAN -->
                <div class="tab-pane" id="tab_tagihan">
                  <div class="box-body table-responsive">
                    <div class="over">
                      <table class="table table-responsive table-bordered" style="white-space: nowrap;">
                        <thead>
                          <tr class="info">
                            <th>Rincian Tagihan</th>
                            <th></th>
                            <th>Nominal</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $bulan_aktif = (int)date('m') + 6;
                            $total_tagihan_bulanan_bebas = 0;
                            $tampil_bulanan = mysqli_query($koneksi,"SELECT 
                                                                      tagihan_bulanan.*,
                                                                      jenis_bayar.idPosBayar, 
                                                                      tahun_ajaran.nmTahunAjaran,
                                                                      pos_bayar.nmPosBayar,
                                                                      akun_biaya.keterangan,
                                                                      unit_sekolah.singkatanUnit,
                                                                      bulan.nmBulan,
                                                                      bulan.urutan
                                                                    FROM tagihan_bulanan 
                                                                    LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                                                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                    LEFT JOIN akun_biaya ON tagihan_bulanan.idAkunKas = akun_biaya.idAkun
                                                                    LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                                                    LEFT JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                                                    WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' AND tagihan_bulanan.statusBayar='0' AND bulan.urutan <= '$bulan_aktif' ORDER BY tagihan_bulanan.idTagihanBulanan DESC");

                            while ($r = mysqli_fetch_array($tampil_bulanan)) {
                              $pisah_TA = explode('/', $r['nmTahunAjaran']);
                              if ($r['urutan'] <= 6){
                                $nmBulan = $r['nmBulan'].' '.$pisah_TA[0];
                              }else{
                                $nmBulan = $r['nmBulan'].' '.$pisah_TA[1];
                              }
                            echo '<tr>
                                  <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].' - ('.$nmBulan.')</td>
                                  <td align="right">Rp.</td>
                                  <td align="right">'.rupiah($r['jumlahTagihan']).'</td>
                                </tr>';
                            $total_tagihan_bulanan_bebas = $total_tagihan_bulanan_bebas + $r['jumlahTagihan'];
                            }

                            $tampil_bebas = mysqli_query($koneksi, "SELECT 
                                                                      tagihan_bebas.*, 
                                                                      SUM(tagihan_bebas.totalTagihan) as totalTagihanBebas, 
                                                                      jenis_bayar.idPosBayar, 
                                                                      tahun_ajaran.nmTahunAjaran,
                                                                      pos_bayar.nmPosBayar
                                                                    FROM tagihan_bebas 
                                                                    LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                    WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' AND tagihan_bebas.statusBayar!='1'
                                                                    GROUP BY tagihan_bebas.idJenisBayar");
                          
                          while ($r = mysqli_fetch_array($tampil_bebas)) {
                            $totalBayarBebas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(jumlahBayar) as totalBayarBebas FROM tagihan_bebas_bayar WHERE idTagihanBebas='$r[idTagihanBebas]'"));
                            $sisa_tagihan_bebas = $r['totalTagihanBebas']-$totalBayarBebas['totalBayarBebas'];
                            echo '<tr>
                                  <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].'</td>
                                  <td align="right">Rp.</td>
                                  <td align="right">'.rupiah($sisa_tagihan_bebas).'</td>
                                </tr>';
                            $total_tagihan_bulanan_bebas = $total_tagihan_bulanan_bebas + $sisa_tagihan_bebas;
                            }
                          ?>
                        </tbody>
                      </table>
                    </div>


                  <table class="table table-responsive table-bordered" style="white-space: nowrap;">
                    <tbody>
                      <tr style="background-color: #f0f0f0">
                        <td><b>Total Tagihan</b></td>
                        <td align="right">Rp</td>
                        <td align="right"><?= rupiah($total_tagihan_bulanan_bebas) ?></td>
                      </tr>
                    </tbody>
                  </table>

                  <br>

                  <div class="pull-right">
                      <table>
                        <tbody>
                          <tr>
                            <td>
                              <?php 
                                // kirim Tagihan WA
                                $noHp_ortu = $siswa['noHpOrtu'];
                                $link_url_semua_tagihan= "$page_URL$_SERVER[HTTP_HOST]/".$uri_segments[1]."/siswa/laporan/tagihan_pembayaran_persiswa.php?thn_ajar=".$_GET[thn_ajar]."%26nis=".$_GET[nis];

                                $text_wa = 'Diberitahukan kepada Bapak/Ibu dari Santri A/N '.$siswa[nmSiswa].', Kelas '.$siswa[nmKelas].', untuk segera melunasi biaya pendidikan sejumlah "'.buatRp($total_tagihan_bulanan_bebas).'". Atas perhatiannya kami ucapkan terima kasih. %0A %0ADownload Tagihan : '.$link_url_semua_tagihan.' %0A %0A*) Jika tagihan tidak sesuai dengan kartu syariah atau sudah melakukan pembayaran agar konfirmasi dengan mengirimkan bukti pembayaran / kwitansi yang sah.';
                                echo "<a class='btn btn-info btn-sm' title='Kirimkan Tagihan' href='admin/whatsapp.php?phone=".$noHp_ortu."&text=".$text_wa."&view=".$_GET[view]."&thn_ajar=".$_GET[thn_ajar]."&nis=".$_GET[nis]."'><i class='fa fa-send'></i>Kirim Tagihan</a>";
                              ?>
                            </td>
                            <td>
                              <a href="siswa/laporan/tagihan_pembayaran_persiswa.php?thn_ajar=<?= $_GET[thn_ajar] ?>&nis=<?= $_GET[nis] ?>" target="_blank"><button class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i>  Cetak Tagihan</button></a>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <br>
                      <br>
                    </div>
                  </div>
                </div>
                </div>
                </div>
                </div>
                <!--Tab1-->
            </div>
            </div>
          
            <div class="col-md-3">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">Kalkulator</h3>
              </div>
              <div class="box-body">
                <form id="calcu" name="calcu" method="post" action="">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Total</label>
                        <input type="text" class="form-control" value="<?= $total_transaksi ?>" name="harga" id="harga" placeholder="Total Pembayaran" readonly="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Dibayar</label>
                        <input type="text" class="form-control" value="0" name="bayar" id="bayar" placeholder="Jumlah Uang" onfocus="startCalculate()" onblur="stopCalc()">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Kembalian</label>
                    <input type="text" class="form-control" readonly="" name="kembalian" id="kembalian">
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-9">
          </div>
          <div class="col-md-3">
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Cetak Bukti Pembayaran</h3>
              </div><!-- /.box-header -->
              <div class="box-body">
                <form action="siswa/laporan/bukti_pembayaran_siswa.php" method="GET" class="view-pdf">
                  <input type="hidden" name="thn_ajar" id="thn_ajar" value="<?= $_GET[thn_ajar] ?>">
                  <input type="hidden" name="nis" id="nisSiswa" value="<?= $_GET[nis] ?>">
                  <input type="hidden" id="idSiswa" value="<?= $siswa[idSiswa] ?>">
                  <div class="form-group">
                    <label>Tanggal Transaksi</label>
                    <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      <input class="form-control" readonly required type="text" name="tgl" id="tgl_transaksi" placeholder="Pilih Tanggal" onchange="cari_noref()">
                    </div>

                    <label>No. Referensi</label>
                    <select required="" name="noref" id="Cnorefrensi" class="form-control" onchange="copy_data()">
                      <option value="" disabled="" selected="">- Pilih No. Referensi -</option>
                    </select>           
                  </div>
                  <button class="btn btn-success btn-block" formtarget="_blank" type="submit">Cetak</button>
                </form>
                <form action="siswa/laporan/bukti_pembayaran_siswa_thermal.php" method="GET" class="view-pdf">
                  <input type="hidden" name="thn_ajar" value="<?= $_GET[thn_ajar] ?>">
                  <input type="hidden" name="nis" value="<?= $_GET[nis] ?>">
                  
                  <input type="hidden" name="tgl" id="thermal_tanggal">
                  <input type="hidden" name="noref" id="thermal_noref">
                  <button class="btn btn-danger btn-block" formtarget="_blank" type="submit">Cetak Thermal</button>
                </form>
                <a href="siswa/laporan/semua_pembayaran_siswa.php?thn_ajar=<?= $_GET[thn_ajar] ?>&nis=<?= $_GET[nis] ?>" target="_blank" class="btn btn-warning btn-block pull-right">Cetak Semua Transaksi</a>
              </div>
            </div>
          </div>
                </div>
                                      </div>
                </div>
              </div>
            </div>
          </div>  
            
          <div class="loader">
            <br>
            <br>
            <br>
            <br>
            <center>
                <img src="gambar/loading.gif" height="50" width="50">
                <p>Simpan Pembayaran ...</p>
            </center>
            <br>
            <br>
            <br>
            <br>
          </div>
        </div>
      </div>
    <?php } ?> 


<?php } ?>


<script type="text/javascript">

  function startCalculate(){
      interval=setInterval("Calculate()",10);
  }

  function Calculate() {
    var numberHarga = $('#harga').val(); // a string
    numberHarga = numberHarga.replace(/\D/g, '');
    numberHarga = parseInt(numberHarga, 10);

    var numberBayar = $('#bayar').val(); // a string
    numberBayar = numberBayar.replace(/\D/g, '');
    numberBayar = parseInt(numberBayar, 10);

    var total = numberBayar - numberHarga;
    $('#kembalian').val(total);
  }

  function stopCalc(){
    clearInterval(interval);
  }

  function cari_noref(){
    var tgl_transaksi = $("#tgl_transaksi").val();
    var idSiswa = $("#idSiswa").val();
    $.ajax({
      type: 'POST',
      url: "admin/combobox/pilihan_norefrensi_pembayaran.php",
      data: {tgl_transaksi: tgl_transaksi, idSiswa: idSiswa},
      cache: false,
      success: function(msg){
        $("#Cnorefrensi").html(msg);
      }
    });
  }

  function copy_data() {
    var tanggal  = $("#tgl_transaksi").val();
    var noref    = $("#Cnorefrensi").val();
        
    $("#thermal_tanggal").val(tanggal);
    $("#thermal_noref").val(noref);
  }
</script>

<script>

$(".loader").hide();

    function ambil_data(nis){
      var view        = $("#view").val();
      var nis         = nis;
      var thn_ajar    = $("#Ctahunajaran").val();
        
      window.location.href = 'index.php?view='+view+'&thn_ajar='+thn_ajar+'&nis='+nis;
    }

    function change_kas_account(no){
      var kas = $("#Cakunkas").val();
      
      $("#Akun_Kas_Bulanan"+no).val(kas);
      $("#Akun_Kas_Bebas"+no).val(kas);    
      $("#Akun_Kas_Bebas_batch").val(kas);  
    }

      function get_form(){
        var bebas_id = $('#msg:checked');
        if(bebas_id.length > 0)
        {
            var bebas_id_value = [];
            $(bebas_id).each(function(){
                bebas_id_value.push($(this).val());
            });

            $.ajax({
                url: 'admin/form/form_add_bebas.php',
                method:"POST",
                data: {
                        bebas_id : bebas_id_value,
                },
                success: function(msg){
                        $("#fbatch").html(msg);
                },
            error: function(msg){
                toastr["error"]("msg","Gagal!");
            }
            });
        }
        else
        {
          $("#fbatch").html('');
          toastr["error"]("Belum ada pembayaran yang dipilih","Gagal!");
        }
      }
    
    function trxFinish(){
      var view                = $("#view").val();
      var nis                 = $("#nis_siswa").val();
      var period              = $("#Ctahunajaran").val();
      var Cakunkas            = $("#Cakunkas").val();
      var kas_noref           = $("#kas_noref").val();
        
      if(kas_noref != '' && Cakunkas != ''){
        $.ajax({ 
            url: 'admin/simpan_transaksi_bayar.php',
            type: 'POST', 
            data: {
                    'Cakunkas'              : Cakunkas,
                    'kas_noref'             : kas_noref,
                    'nis_siswa'             : nis,
                    'period'                : period,
            },    
            beforeSend: function () {
                $(".loader").fadeIn("slow");
                $(".payment").fadeOut("slow");
            },    
            success: function(msg) {
              var set = setInterval(function(){ window.location.href = 'index.php?view='+view+'&thn_ajar='+period+'&nis='+nis; }, 5000);
            },
            error: function(msg){
              toastr["error"]("msg","Gagal!");
            }
        });
      } else {
        toastr["error"]("Akun Kas Belum di Pilih","Gagal!");
      } 
    }
    
</script>