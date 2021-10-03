<?php if ($_GET[act]==''){ ?> 
    
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <form action="" method="get" accept-charset="utf-8">

            <input type="hidden" name="view" value="<?= $_GET[view] ?>">
            <div class="row">
              <div class="col-md-3">  
                <div class="form-group">
                  <label>Tahun Ajaran</label>
                  <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
                  <select class="form-control" name="thn_ajar" id="Ctahunajaran2" required=""></select>
                </div>
              </div>
              <div class="col-md-3">  
                <div class="form-group">
                  <label>Unit Sekolah</label>
                  <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                  <select id="Cunit" name="unit" class="form-control" required></select>
                </div>
              </div>
              <div class="col-md-3">  
                <div class="form-group">
                  <label>Kelas</label>
                  <input type="hidden" id="idKelas" value="<?= $_GET[kelas] ?>">
                  <select id="Ckelas" name="kelas" class="form-control" required>
                    <option disabled selected>- Pilih Kelas -</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div style="margin-top:25px;">
                  <button type="submit" class="btn btn-primary">Filter</button>
                  <?php
                    $siswaTagihanBulanan = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.*, jenis_bayar.* FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa=tagihan_bulanan.idSiswa LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar WHERE siswa.kelasSiswa='$_GET[kelas]' AND jenis_bayar.idUnit='$_GET[unit]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' GROUP BY tagihan_bulanan.idJenisBayar");
                    $siswaTagihanBebas = mysqli_query($koneksi,"SELECT  siswa.*, tagihan_bebas.*, jenis_bayar.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa=tagihan_bebas.idSiswa LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar WHERE siswa.kelasSiswa='$_GET[kelas]' AND jenis_bayar.idUnit='$_GET[unit]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' GROUP BY tagihan_bebas.idJenisBayar");
                    if ((mysqli_num_rows($siswaTagihanBulanan) > 0) OR (mysqli_num_rows($siswaTagihanBebas) > 0)){
                      echo '<a class="btn btn-success" target="_blank" href="admin/excel/export_laporan_rekap_pembayaran.php?thn_ajar='.$_GET['thn_ajar'].'&unit='.$_GET['unit'].'&kelas='.$_GET['kelas'].'"><i class="fa fa-file-excel-o"></i> Export Excel</a>';
                    }
                  ?>

                </div>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>

<?php } ?>

<?php if (isset($_GET['thn_ajar']) && isset($_GET['unit']) && isset($_GET['kelas'])) {  ?>

  <?php
    $idTahunAjaran = $_GET['thn_ajar'];
    $idUnit = $_GET['unit'];
    $idKelas = $_GET['kelas'];

    $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    $kls = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));

    $siswaTagihanBulanan = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.*, jenis_bayar.* FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa=tagihan_bulanan.idSiswa LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar WHERE siswa.kelasSiswa='$idKelas' AND jenis_bayar.idUnit='$idUnit' AND jenis_bayar.idTahunAjaran='$idTahunAjaran' GROUP BY tagihan_bulanan.idJenisBayar");
    $siswaTagihanBebas = mysqli_query($koneksi,"SELECT  siswa.*, tagihan_bebas.*, jenis_bayar.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa=tagihan_bebas.idSiswa LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar WHERE siswa.kelasSiswa='$idKelas' AND jenis_bayar.idUnit='$idUnit' AND jenis_bayar.idTahunAjaran='$idTahunAjaran' GROUP BY tagihan_bebas.idJenisBayar");
    if ((mysqli_num_rows($siswaTagihanBulanan) > 0) OR (mysqli_num_rows($siswaTagihanBebas) > 0)){
  ?>

  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-body table-responsive">
        <table id="example7" class="table table-hover table-bordered dataTable no-footer text-center" style="white-space: nowrap;">
          <thead>
            <tr>
              <th rowspan="2">Kelas</th>
              <th rowspan="2">Nama</th>
              <?php 
                $sqljenisBayar = mysqli_query($koneksi,"SELECT jenis_bayar.*, tagihan_bulanan.idTagihanBulanan, tagihan_bebas.idTagihanBebas, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN tagihan_bulanan ON jenis_bayar.idJenisBayar=tagihan_bulanan.idJenisBayar LEFT JOIN tagihan_bebas ON jenis_bayar.idJenisBayar=tagihan_bebas.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND jenis_bayar.idUnit='$idUnit' GROUP BY jenis_bayar.idJenisBayar");
                while ($jb = mysqli_fetch_array($sqljenisBayar)) {
                  if ($jb['tipeBayar'] == 'Bulanan'){
                    echo '<th colspan="12">'.$jb['nmPosBayar'].' T.A. '.$ta['nmTahunAjaran'].'</th>';
                  }else if ($jb['tipeBayar'] == 'Bebas'){
                    echo '<th rowspan="2">'.$jb['nmPosBayar'].' T.A. '.$ta['nmTahunAjaran'].'</th>';
                  }
                }
              ?>
            </tr>
            <tr>
              <?php
                $sqljenisBayar = mysqli_query($koneksi,"SELECT jenis_bayar.*, tagihan_bulanan.idTagihanBulanan, tagihan_bebas.idTagihanBebas, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN tagihan_bulanan ON jenis_bayar.idJenisBayar=tagihan_bulanan.idJenisBayar LEFT JOIN tagihan_bebas ON jenis_bayar.idJenisBayar=tagihan_bebas.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND jenis_bayar.idUnit='$idUnit' GROUP BY jenis_bayar.idJenisBayar");
                while ($jb = mysqli_fetch_array($sqljenisBayar)) {
                  if ($jb['tipeBayar'] == 'Bulanan'){
                    $bulan = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
                    while ($bln = mysqli_fetch_array($bulan)) {
                      echo '<th>'.$bln['nmBulan'].'</th>';
                    }
                  }
                }
                
              ?>
            </tr>
          </thead>
          <tbody>
            <?php
              
              $siswaTagihan = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.idJenisBayar as idJenisBayarBulanan, tagihan_bebas.idJenisBayar as idJenisBayarBebas, kelas_siswa.nmKelas FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa=tagihan_bulanan.idSiswa LEFT JOIN tagihan_bebas ON siswa.idSiswa=tagihan_bebas.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE siswa.kelasSiswa='$idKelas' AND siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' GROUP BY siswa.idSiswa ORDER BY siswa.idSiswa DESC");
                while ($siswa = mysqli_fetch_array($siswaTagihan)) {
                  echo '<tr>';
                  echo '<td>'.$kls['nmKelas'].'</td>';
                  echo '<td>'.$siswa['nmSiswa'].'</td>';
                  
                  $sqljenisBayar = mysqli_query($koneksi,"SELECT jenis_bayar.*, tagihan_bulanan.idTagihanBulanan, tagihan_bebas.idTagihanBebas, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN tagihan_bulanan ON jenis_bayar.idJenisBayar=tagihan_bulanan.idJenisBayar LEFT JOIN tagihan_bebas ON jenis_bayar.idJenisBayar=tagihan_bebas.idJenisBayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idTahunAjaran='$idTahunAjaran' AND jenis_bayar.idUnit='$idUnit' GROUP BY jenis_bayar.idJenisBayar");
                  while ($jb = mysqli_fetch_array($sqljenisBayar)) {
                    if ($jb['tipeBayar'] == 'Bulanan'){
                      //TAGIHAN BULANAN
                      $TagihanBulanan = mysqli_query($koneksi,"SELECT tagihan_bulanan.*, bulan.urutan FROM tagihan_bulanan LEFT JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND tagihan_bulanan.idJenisBayar='$jb[idJenisBayar]' ORDER BY bulan.urutan ASC");
                      if (mysqli_num_rows($TagihanBulanan) == 0){
                        echo '<td colspan="12"> - </td>';
                      }else{
                        while ($bln = mysqli_fetch_array($TagihanBulanan)) {
                          if ($bln['statusBayar'] == '1'){
                            $ket = '<label style="color:#00E640">Lunas</label>';
                          }else{
                            $ket = '<label style="color:red">'.rupiah($bln['jumlahTagihan']).'</label>';
                          }
                          echo '<td>'.$ket.'</td>';
                        }
                      }
                      
                    }else if ($jb['tipeBayar'] == 'Bebas'){
                      //TAGIHAN BEBAS
                      $TagihanBebas = mysqli_query($koneksi,"SELECT idTagihanBebas, SUM(totalTagihan) as totalTagihanBebas, statusBayar FROM tagihan_bebas WHERE idSiswa='$siswa[idSiswa]' AND idJenisBayar='$jb[idJenisBayar]' GROUP BY idSiswa");
                      if (mysqli_num_rows($TagihanBebas) == 0){
                        echo '<td> - </td>';
                      }else{
                        while ($bebas = mysqli_fetch_array($TagihanBebas)) {
                          if ($bebas['statusBayar'] == '1'){
                            $ket = '<label style="color:#00E640">Lunas</label>';
                          }else{
                            $TagihanBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(jumlahBayar) as totalTagihanBebasBayar FROM tagihan_bebas_bayar WHERE idTagihanBebas='$bebas[idTagihanBebas]' GROUP BY idTagihanBebas")); 
                            $sisaTagihan = $bebas['totalTagihanBebas'] - $TagihanBebasBayar['totalTagihanBebasBayar'];
                            $ket = '<label style="color:red">'.rupiah($sisaTagihan).'</label>';
                          }
                          echo '<td>'.$ket.'</td>';
                        }
                      }
                    }
                  }
                  echo '</tr>'; 
                }
            ?>

          </tbody>
        </table>
      </div>         
    </div>
  </div>

<?php } else {
          echo '<script> toastr["error"]("Laporan Rekap Pembayaran untuk Kelas ini belum ada.","Gagal!"); </script>';
      } ?> 

<?php } ?>