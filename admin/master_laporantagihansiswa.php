<?php if ($_GET[act]==''){ ?> 
  
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <form method="GET">

            <input type="hidden" name="view" value="<?= $_GET[view] ?>">
            <div class="row">
              <div class="col-md-2">
                <label>Tahun Ajaran</label>
                <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
                <select class="form-control" name="thn_ajar" id="Ctahunajaran2" required=""></select>
              </div>
              <div class="col-md-2">
                <label>Unit Sekolah</label>
                <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                <select id="Cunit" name="unit" class="form-control" required=""></select>
              </div>
              <div class="col-md-2">
                <label>Kelas</label>
                <input type="hidden" id="idKelas" value="<?= $_GET[kelas] ?>">
                <select id="Ckelas" name="kelas" class="form-control" required=>
                  <option disabled selected>- Pilih Kelas -</option>
                </select>
              </div>
              <div class="col-md-2">
                <label>Dari Bulan</label>
                <input type="hidden" id="bln1" value="<?= $_GET[bulan1] ?>">
                <select id="bulan1" name="bulan1" class="form-control" required=>
                  <option disabled selected>- Pilih Bulan -</option>
                </select>
              </div>
              <div class="col-md-2">
                <label>Sampai Bulan</label>
                <input type="hidden" id="bln2" value="<?= $_GET[bulan2] ?>">
                <select id="bulan2" name="bulan2" class="form-control" required=>
                  <option disabled selected>- Pilih Bulan -</option>
                </select>
              </div>
              <div class="col-md-2 text-center">
                <div style="margin-top:25px;">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Cari</button>
                  <?php
                    $siswaTagihanBulanan = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.*, jenis_bayar.* FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa=tagihan_bulanan.idSiswa LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar WHERE siswa.kelasSiswa='$_GET[kelas]' AND jenis_bayar.idUnit='$_GET[unit]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' GROUP BY tagihan_bulanan.idJenisBayar");
                    $siswaTagihanBebas = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bebas.*, jenis_bayar.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa=tagihan_bebas.idSiswa  LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar WHERE siswa.kelasSiswa='$_GET[kelas]' AND jenis_bayar.idUnit='$_GET[unit]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' GROUP BY tagihan_bebas.idJenisBayar");
                    if ((mysqli_num_rows($siswaTagihanBulanan) > 0) OR (mysqli_num_rows($siswaTagihanBebas) > 0)){
                      echo '<a class="btn btn-success" target="_blank" href="admin/excel/export_tagihan_perkelas.php?thn_ajar='.$_GET['thn_ajar'].'&unit='.$_GET['unit'].'&kelas='.$_GET['kelas'].'&bulan1='.$_GET['bulan1'].'&bulan2='.$_GET['bulan2'].'"><i class="fa fa-file-excel-o"></i> Excel</a>';
                      echo '<a style="margin-top:5px" class="btn btn-success" target="_blank" href="admin/excel/export_rekap_tagihan_perkelas.php?thn_ajar='.$_GET['thn_ajar'].'&unit='.$_GET['unit'].'&kelas='.$_GET['kelas'].'&bulan1='.$_GET['bulan1'].'&bulan2='.$_GET['bulan2'].'"><i class="fa fa-file-excel-o"></i> Rekap Excel</a>';
                    }
                  ?>
                </div>
              </div>
            </div>
            <br>

          </form>
        </div>
      </div>
    </div>
<?php } ?>

<?php if (isset($_GET['thn_ajar']) && isset($_GET['unit']) && isset($_GET['kelas']) && isset($_GET['bulan1']) && isset($_GET['bulan2'])) {  ?>

  <?php
    $idTahunAjaran = $_GET['thn_ajar'];
    $idUnit = $_GET['unit'];
    $idKelas = $_GET['kelas'];
    $bln1 = $_GET['bulan1'];
    $bln2 = $_GET['bulan2'];

    $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    $kls = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));


  $siswaTagihanBulanan = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.*, jenis_bayar.* FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa=tagihan_bulanan.idSiswa LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar WHERE siswa.kelasSiswa='$_GET[kelas]' AND jenis_bayar.idUnit='$_GET[unit]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' GROUP BY tagihan_bulanan.idJenisBayar");

  $siswaTagihanBebas = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bebas.*, jenis_bayar.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa=tagihan_bebas.idSiswa  LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar WHERE siswa.kelasSiswa='$_GET[kelas]' AND jenis_bayar.idUnit='$_GET[unit]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' GROUP BY tagihan_bebas.idJenisBayar");

  if ((mysqli_num_rows($siswaTagihanBulanan) > 0) OR (mysqli_num_rows($siswaTagihanBebas) > 0)){

  ?>

  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-body table-responsive">
        <table id="" class="table table-hover table-bordered">
        <thead>
          <tr>
            <th><center><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></center></th>
            <th>No.</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th width="200px">Total Tagihan</th>
            <th width="180px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.idJenisBayar as idJenisBayarBulanan, tagihan_bebas.idJenisBayar as idJenisBayarBebas, kelas_siswa.nmKelas FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa=tagihan_bulanan.idSiswa LEFT JOIN tagihan_bebas ON siswa.idSiswa=tagihan_bebas.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE siswa.kelasSiswa='$idKelas' AND siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' GROUP BY siswa.idSiswa ORDER BY siswa.idSiswa DESC");
            $no=1;
            while($ds=mysqli_fetch_array($sqlSiswa)){
              //$totDibayar = 0;
              $totTagihan = 0;
              $sqlJenisBayar = mysqli_query($koneksi,"SELECT jenis_bayar.*, tagihan_bulanan.idTagihanBulanan, tagihan_bebas.idTagihanBebas, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN tagihan_bulanan ON jenis_bayar.idJenisBayar=tagihan_bulanan.idJenisBayar LEFT JOIN tagihan_bebas ON jenis_bayar.idJenisBayar=tagihan_bebas.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND jenis_bayar.idUnit='$idUnit' GROUP BY jenis_bayar.idJenisBayar");
              while($djb=mysqli_fetch_array($sqlJenisBayar)){
                if($djb['tipeBayar']=='Bulanan'){
                  //menghitung semua tagihan bulanan
                  $tgbul  = mysqli_fetch_array(mysqli_query($koneksi,"SELECT
                              jenis_bayar.idPosBayar,
                              pos_bayar.nmPosBayar,
                              tagihan_bulanan.idSiswa,
                              Sum(tagihan_bulanan.jumlahTagihan) AS TotalSemuaTagihanBulanan
                              FROM tagihan_bulanan
                              INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                              INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                              INNER JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                              WHERE tagihan_bulanan.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bulanan.idSiswa='$ds[idSiswa]' AND bulan.urutan >= '$bln1' AND bulan.urutan <= '$bln2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bulanan.statusBayar <> '1'"));
                  $semuaTagihan = $tgbul['TotalSemuaTagihanBulanan'];
                  $tagihan  = $semuaTagihan;

                }else{
                  //menghitung semua tagihan bebas
                  $tgb  = mysqli_fetch_array(mysqli_query($koneksi,"SELECT
                            tagihan_bebas.idTagihanBebas,
                            jenis_bayar.idPosBayar,
                            pos_bayar.nmPosBayar,
                            tagihan_bebas.idSiswa,
                            SUM(tagihan_bebas.totalTagihan) As TotalSemuaTagihanBebas
                            FROM
                            tagihan_bebas
                            INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                            INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                            WHERE tagihan_bebas.idJenisBayar='$djb[idJenisBayar]' AND tagihan_bebas.idSiswa='$ds[idSiswa]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));
                  $semuaTagihan = $tgb['TotalSemuaTagihanBebas'];

                  $dbayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT
                              tagihan_bebas.idJenisBayar,
                              jenis_bayar.idTahunAjaran,
                              tagihan_bebas_bayar.idTagihanBebas,
                              SUM(tagihan_bebas_bayar.jumlahBayar) AS TotalPembayaranPerJenis,
                              tagihan_bebas_bayar.ketBebas
                              FROM
                              tagihan_bebas_bayar
                              INNER JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas
                              INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                              WHERE tagihan_bebas_bayar.idTagihanBebas='$tgb[idTagihanBebas]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));
                  $jBayar   = $dbayar['TotalPembayaranPerJenis'];
                  $tagihan  = $semuaTagihan - $jBayar;
                }
                //$totDibayar += $jBayar;
                $totTagihan += $tagihan;
              }

              $qthn = mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'");
              if ($qthn) {
                while ($thn = mysqli_fetch_array($qthn)){
                  $nmTahun=$thn['nmTahunAjaran'];
                  $pecah = explode("/", $nmTahun);
                  $thn_ganjil = $pecah[0];
                  $thn_genap = $pecah[1];
                }
              }
              
              $query = mysqli_query($koneksi,"SELECT * FROM bulan WHERE urutan='$bln1' ORDER BY urutan ASC");
              if ($query) {
                while ($bln = mysqli_fetch_array($query)){
                  if ($bln['urutan'] <= 6){
                    $bln_awal = $bln['nmBulan'].' '.$thn_ganjil;
                  }else{
                    $bln_awal = $bln['nmBulan'].' '.$thn_genap;
                  }
                }
              }
              $query = mysqli_query($koneksi,"SELECT * FROM bulan WHERE urutan='$bln2' ORDER BY urutan ASC");
              if ($query) {
                while ($bln = mysqli_fetch_array($query)){
                  if ($bln['urutan'] <= 6){
                    $bln_akhir = $bln['nmBulan'].' '.$thn_ganjil;
                  }else{
                    $bln_akhir = $bln['nmBulan'].' '.$thn_genap;
                  }
                }
              }

              echo "<tr>
                      <td><center><input type='checkbox' class='checkbox' name='msg[]' id='msg' value='".$ds['idSiswa']."'></center></td>
                      <td>".$no++."</td>
                      <td>".$ds['nisSiswa']."</td>
                      <td>".$ds['nmSiswa']."</td>
                      <td>".$kls['nmKelas']."</td>
                      <td class='text-left'>".buatRp($totTagihan)."</td>
                      <td class='text-center'>
                        <a data-toggle='collapse' href='#collapse".$ds['idSiswa']."' class=''><button class='btn btn-info btn-sm'><i class='fa fa-list'></i>  Rician</button></a>
                        <a href='admin/laporan/tagihan_pembayaran_persiswa.php?thn_ajar=".$idTahunAjaran."&nis=".$ds['nisSiswa']."&bulan1=".$bln1."&bulan2=".$bln2."' target='_blank'><button class='btn btn-danger btn-sm'><i class='fa fa-file-pdf-o'></i> Cetak</button></a>
                      </td>
                    </tr>";
              echo '<tr id="collapse'.$ds['idSiswa'].'" class="collapse">
                      <td></td>
                      <td colspan="6">
                        <table id="dtable" class="table table-no-bordered table-responsive table-hover" style="white-space: nowrap;">
                          <thead>
                            <tr>
                              <th width="100px">Rician Tagihan</th>
                              <th></th>
                              <th width="50px">Nominal</th>
                              <th width="350px"></th>
                            </tr>
                          </thead>
                          <tbody>';
                              $total_tagihan_bulanan_bebas = 0;
                              
                              $sqlJenisBayar1 = mysqli_query($koneksi,"SELECT jenis_bayar.*, tagihan_bulanan.idTagihanBulanan, tagihan_bebas.idTagihanBebas, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN tagihan_bulanan ON jenis_bayar.idJenisBayar=tagihan_bulanan.idJenisBayar LEFT JOIN tagihan_bebas ON jenis_bayar.idJenisBayar=tagihan_bebas.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND jenis_bayar.idUnit='$idUnit' GROUP BY jenis_bayar.idJenisBayar");
                              while($djb1=mysqli_fetch_array($sqlJenisBayar1)){
                                if($djb1['tipeBayar']=='Bulanan'){
                                  $sqlBul = mysqli_query($koneksi,"SELECT 
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
                                                                    WHERE tagihan_bulanan.idJenisBayar='$djb1[idJenisBayar]' AND tagihan_bulanan.idSiswa='$ds[idSiswa]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bulanan.statusBayar='0' AND bulan.urutan >= '$bln1' AND bulan.urutan <= '$bln2' ORDER BY tagihan_bulanan.idTagihanBulanan DESC");

                                  while ($dtb = mysqli_fetch_array($sqlBul)) {
                                    $pisah_TA = explode('/', $dtb['nmTahunAjaran']);
                                    if ($dtb['urutan'] <= 6){
                                      $nmBulan = $dtb['nmBulan'].' '.$pisah_TA[0];
                                    }else{
                                      $nmBulan = $dtb['nmBulan'].' '.$pisah_TA[1];
                                    }
                                    echo '<tr>
                                          <td align="left">'.$dtb['nmPosBayar'].' - T.A '.$dtb['nmTahunAjaran'].' - ('.$nmBulan.')</td>
                                          <td align="right">Rp.</td>
                                          <td align="right">'.rupiah($dtb['jumlahTagihan']).'</td>
                                          <td></td>
                                        </tr>';
                                    $total_tagihan_bulanan_bebas = $total_tagihan_bulanan_bebas + $dtb['jumlahTagihan'];
                                  }
                                }else{
                                  $sqlBeb = mysqli_query($koneksi, "SELECT 
                                                                      tagihan_bebas.*, 
                                                                      SUM(tagihan_bebas.totalTagihan) as totalTagihanBebas, 
                                                                      jenis_bayar.idPosBayar, 
                                                                      tahun_ajaran.nmTahunAjaran,
                                                                      pos_bayar.nmPosBayar
                                                                    FROM tagihan_bebas 
                                                                    LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                                    WHERE tagihan_bebas.idJenisBayar='$djb1[idJenisBayar]' AND tagihan_bebas.idSiswa='$ds[idSiswa]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran' AND tagihan_bebas.statusBayar!='1'
                                                                    GROUP BY tagihan_bebas.idJenisBayar");
                          
                                  while ($dts = mysqli_fetch_array($sqlBeb)) {
                                    $totalBayarBebas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(jumlahBayar) as totalBayarBebas FROM tagihan_bebas_bayar WHERE idTagihanBebas='$dts[idTagihanBebas]'"));
                                    $sisa_tagihan_bebas = $dts['totalTagihanBebas']-$totalBayarBebas['totalBayarBebas'];
                                    echo '<tr>
                                          <td>'.$dts['nmPosBayar'].' - T.A '.$dts['nmTahunAjaran'].'</td>
                                          <td align="right">Rp.</td>
                                          <td align="right">'.rupiah($sisa_tagihan_bebas).'</td>
                                          <td></td>
                                        </tr>';
                                    $total_tagihan_bulanan_bebas = $total_tagihan_bulanan_bebas + $sisa_tagihan_bebas;
                                  }
                                }
                              }

              echo'       </tbody>
                          <tfoot>
                            <tr style="background-color: #f0f0f0">
                              <td><b>Total Tagihan</b></td>
                              <td align="right">Rp.</td>
                              <td>'.rupiah($total_tagihan_bulanan_bebas).'</td>
                              <td></td>
                            </tr>
                          </tfoot>
                        </table>
                      </td>
                      <td></td>
                    </tr>';
            }
          ?>
        </tbody>
      </table>
      </div>        
    </div>
  </div>
<?php } else {
          echo '<script> toastr["error"]("Laporan Tagihan untuk Kelas ini belum ada.","Gagal!"); </script>';
      } ?> 

<?php } ?>

