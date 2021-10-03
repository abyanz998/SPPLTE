<?php if ($_GET[act]==''){ ?> 
    
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <form action="" method="get" accept-charset="utf-8">

            <input type="hidden" name="view" value="<?= $_GET[view] ?>">
            <div class="row">
              <div class="col-md-2">  
                <div class="form-group">
                  <label>Tahun Ajaran</label>
                  <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
                  <input type="hidden" id="tipe_tahunajaran" value="semuaTahunAjaran">
                  <select class="form-control" name="thn_ajar" id="Ctahunajaran2" required></select>
                </div>
              </div>
              <div class="col-md-2">  
                <div class="form-group">
                  <label>Unit Sekolah</label>
                  <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                  <select id="Cunit" name="unit" class="form-control"></select>
                </div>
              </div>
              <div class="col-md-2">  
                <div class="form-group">
                  <label>Kelas</label>
                  <input type="hidden" id="idKelas" value="<?= $_GET[kelas] ?>">
                  <input type="hidden" id="tipe_kelas" value="semuaKelas">
                  <select id="Ckelas" name="kelas" class="form-control">
                    <option disabled selected>- Pilih Kelas -</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">  
                <div class="form-group">
                  <label>Siswa</label>
                  <input type="hidden" id="idSiswa" value="<?= $_GET[siswa] ?>">
                  <input type="hidden" id="tipe_siswa" value="semuaSiswa">
                  <select id="Csiswa" name="siswa" class="form-control">
                    <option disabled selected>- Pilih Siswa -</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div style="margin-top:25px;">
                  <button type="submit" name="cari" class="btn btn-primary">Cari</button>
                  <?php
                    if (isset($_GET['cari'])) {
                      echo '<a class="btn btn-success" target="_blank" href="admin/excel/export_laporan_tabungan_siswa.php?thn_ajar='.$_GET['thn_ajar'].'&unit='.$_GET['unit'].'&kelas='.$_GET['kelas'].'&siswa='.$_GET['siswa'].'"><i class="fa fa-file-excel-o"></i> Excel</a>';
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

<?php if (isset($_GET['cari'])) {  ?>

  <?php
    $idTahunAjaran = $_GET['thn_ajar'];
    $idUnit = $_GET['unit'];
    $idKelas = $_GET['kelas'];
    $idSiswa = $_GET['siswa'];

  ?>

  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-body table-responsive">
        <table id="example1" class="table table-hover table-bordered dataTable no-footer text-center" style="white-space: nowrap;">
          <thead>
            <tr>
              <th>No</th>
              <th>NIS</th>
              <th>Nama</th>
              <th>Kelas</th>
              <th>Debit</th>
              <th>Kredit</th>
              <th>Saldo</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $no = 1;
              if ($idTahunAjaran=='all'){
                if ($idUnit != ''){
                  if ($idKelas == 'all' OR $idKelas == ''){
                    $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND siswa.unitSiswa='$idUnit' GROUP BY tabungan_siswa.siswa");
                  }else{
                    if ($idSiswa == 'all' OR $idSiswa == ''){
                      $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' GROUP BY tabungan_siswa.siswa");
                    }else{
                      $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' AND tabungan_siswa.siswa='$idSiswa' GROUP BY tabungan_siswa.siswa");
                    }
                  }
                }else{
                  $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' GROUP BY tabungan_siswa.siswa");
                }
              }else{
                if ($idUnit != ''){
                  if ($idKelas == 'all' OR $idKelas == ''){
                    $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND tahunAjaran='$idTahunAjaran' AND siswa.unitSiswa='$idUnit' GROUP BY tabungan_siswa.siswa");
                  }else{
                    if ($idSiswa == 'all' OR $idSiswa == ''){
                      $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND tahunAjaran='$idTahunAjaran' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' GROUP BY tabungan_siswa.siswa");
                    }else{
                      $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND tahunAjaran='$idTahunAjaran' AND siswa.unitSiswa='$idUnit' AND siswa.kelasSiswa='$idKelas' AND tabungan_siswa.siswa='$idSiswa' GROUP BY tabungan_siswa.siswa");
                    }
                  } 
                }else{
                  $TabunganSiswa = mysqli_query($koneksi,"SELECT siswa.*, tabungan_siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN tabungan_siswa ON siswa.idSiswa=tabungan_siswa.siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas WHERE tabungan_siswa.stdel='0' AND siswa.stdel='0' AND tahunAjaran='$idTahunAjaran' GROUP BY tabungan_siswa.siswa");
                }
              }
              
              while ($tabSiswa = mysqli_fetch_array($TabunganSiswa)) {
                $jumlah_debit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as nominalDebit FROM tabungan_siswa WHERE siswa='$tabSiswa[idSiswa]' AND stdel='0' AND kode='SETORAN'"));
                $jumlah_kredit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as nominalKredit FROM tabungan_siswa WHERE siswa='$tabSiswa[idSiswa]' AND stdel='0' AND kode='PENARIKAN'"));
                $saldo = $jumlah_debit['nominalDebit'] - $jumlah_kredit['nominalKredit'];
                echo '<tr>
                        <td>'.$no++.'</td>
                        <td>'.$tabSiswa['nisSiswa'].'</td>
                        <td>'.$tabSiswa['nmSiswa'].'</td>
                        <td>'.$tabSiswa['nmKelas'].'</td>
                        <td>'.buatRp($jumlah_debit['nominalDebit']).'</td>
                        <td>'.buatRp($jumlah_kredit['nominalKredit']).'</td>
                        <td>'.buatRp($saldo).'</td>
                        <td><a href="siswa/laporan/buku_tabungan_siswa.php?nis='.$tabSiswa['nisSiswa'].'&thn_ajar='.$idTahunAjaran.'" target="_blank" class="btn btn-sm btn-danger"><i class="fa fa-print"></i> Cetak Buku Tabungan</a></td>
                      </tr>';

              }
            ?>
          </tbody>
        </table>
      </div>         
    </div>
  </div>

<?php } ?>