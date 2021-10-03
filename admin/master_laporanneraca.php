<?php if ($_GET[act]==''){ ?> 
  
    <div class="col-md-12">
      <div class="box box-success">
        <div class="box-header">
          <form method="GET">

            <input type="hidden" name="view" value="<?= $_GET[view] ?>">
            <div class="row">
              <div class="col-md-3">
                <label></label>
                <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                <input type="hidden" id="tipe_unit" value="pencarian">
                <select id="Cunit" name="unit" class="form-control" required=""></select>
              </div>
              <div class="col-md-3">
                <label></label>
                <input type="hidden" id="idTahunAjaran" value="<?= $_GET[thn_ajar] ?>">
                <select class="form-control" name="thn_ajar" id="Ctahunajaran2" required=""></select>
              </div>
              <div class="col-md-2">
                <label></label>
                <input type="hidden" id="bln1" value="<?= $_GET[bulan1] ?>">
                <select id="bulan1" name="bulan1" class="form-control" required=>
                  <option disabled selected>- Pilih Bulan -</option>
                </select>
              </div>
              <div class="col-md-2">
                <label></label>
                <input type="hidden" id="bln2" value="<?= $_GET[bulan2] ?>">
                <select id="bulan2" name="bulan2" class="form-control" required=>
                  <option disabled selected>- Pilih Bulan -</option>
                </select>
              </div>
              <div class="col-md-1">
                <div style="margin-top:20px;">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>Cari</button>
                </div>
              </div>
            </div>
            <br>

          </form>
        </div>
      </div>
    </div>
<?php } ?>

<?php if (isset($_GET['unit']) && isset($_GET['thn_ajar']) && isset($_GET['bulan1']) && isset($_GET['bulan2'])) {  ?>

  <?php
    $bulan1 = $_GET['bulan1'];
    $bulan2 = $_GET['bulan2'];
    $idTahunAjaran = $_GET['thn_ajar'];
    $idUnit = $_GET['unit'];

    $bln1=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM bulan WHERE urutan='$bulan1'"));
    $bln2=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM bulan WHERE urutan='$bulan2'"));
    $thn_ajar=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
    
  ?>

  <div class="col-md-12">
    <div class="box box-primary box-solid">
      <div class="box-header with-border">
        <h3 class="box-title"><span class="fa fa-file-text-o"></span> Laporan Neraca per Bulan <?= $bln1['nmBulan'] ?> Sampai <?= $bln2['nmBulan'] ?> Tahun Ajaran <?= $thn_ajar['nmTahunAjaran'] ?></h3>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-responsive" style="white-space: nowrap;">
          <tbody>
            <tr>
              <td align="center">
                <div class="md-6">
                  <b>AKTIVA</b>
                </div>
              </td>
              <td align="center">
                <div class="md-6">
                  <b>PASSIVA</b>
                </div>                  
              </td>
            </tr>
            <tr>
              <td>
                <table class="table table-responsive" style="white-space: nowrap;">
                  <tbody>
                    <tr>
                      <th colspan="3">KAS</th>
                    </tr>
                    <?php
                      $subtotal_kas = 0;
                      if ($idUnit == 'all'){
                        $akun_biaya_KAS = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Kas%' ORDER BY kodeAkun ASC");
                      }else{
                         $akun_biaya_KAS = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$idUnit' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Kas%' ORDER BY kodeAkun ASC");
                      }
                      while ($kas = mysqli_fetch_array($akun_biaya_KAS)) {
                        $saldo_kas = 0;
                        $TBulananBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalBayar, bulan.urutan, jenis_bayar.idTahunAjaran FROM tagihan_bulanan INNER JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bulanan.idAkunKas='$kas[idAkun]' AND tagihan_bulanan.statusBayar='1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                        $TBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*, SUM(tagihan_bebas_bayar.jumlahBayar) as totalBayar, jenis_bayar.idTahunAjaran FROM tagihan_bebas INNER JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas=tagihan_bebas_bayar.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bebas_bayar.idAkunKas='$kas[idAkun]' AND tagihan_bebas.statusBayar!='0' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                        $TKasMasuk = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalMasuk FROM kas WHERE stdel='0' AND jenis='Masuk' AND idAkunKas='$kas[idAkun]' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) >= '$bulan1' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) <= '$bulan2' AND idTahunAjaran='$idTahunAjaran'"));

                        $TKasKeluar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalKeluar FROM kas WHERE stdel='0' AND jenis='Keluar' AND idAkunKas='$kas[idAkun]' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) >= '$bulan1' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) <= '$bulan2' AND idTahunAjaran='$idTahunAjaran'"));

                        $ThutangBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(hutang_bayar.nominal) as totalBayar FROM hutang_bayar INNER JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.stdel='0' AND hutang_bayar.idAkunKas='$kas[idAkun]' AND hutang_bayar.keterangan='Lunas' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) >= '$bulan1' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) <= '$bulan2' AND hutang_setting.idTahunAjaran='$idTahunAjaran'"));

                        $saldo_kas = $TBulananBayar['totalBayar'] + $TBebasBayar['totalBayar'] + $TKasMasuk['totalMasuk'] - $TKasKeluar['totalKeluar'] - $ThutangBayar['totalBayar'];
                        echo '<tr>
                                <td>'.$kas['kodeAkun'].'</td>
                                <td>'.$kas['keterangan'].'</td>
                                <td>'.buatRp($saldo_kas).'</td>
                             </tr>';
                        $subtotal_kas += $saldo_kas;
                      }
                     
                    ?>
                    <tr style="background-color: #fcfdff;">
                      <td colspan="2" align="right"><strong>Subtotal Kas</strong></td>
                      <td><?= buatRp($subtotal_kas) ?></td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <td>
                <table class="table table-responsive" style="white-space: nowrap;">
                  <tbody>
                    <tr>
                      <th colspan="3">HUTANG</th>
                    </tr>
                    <?php
                      $subtotal_Hutang = 0;
                      if ($idUnit == 'all'){
                        $akun_hutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%2-2%' AND keterangan LIKE '%hutang%' ORDER BY kodeAkun ASC");
                      }else{
                         $akun_hutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$idUnit' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%2-2%' AND keterangan LIKE '%hutang%' ORDER BY kodeAkun ASC");
                      }
                      while ($Ahutang = mysqli_fetch_array($akun_hutang)) {
                        $total = 0;
                        $Thutang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(hutang_setting_detail.nominal) as totalHutang, hutang_setting.idTahunAjaran, hutang_setting.idUnit, hutang_pos.idAkunHutang FROM hutang_setting_detail INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_setting_detail.stdel='0' AND hutang_setting.idTahunAjaran='$idTahunAjaran' AND hutang_pos.idAkunHutang='$Ahutang[idAkun]'"));
                        
                        $ThutangBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT  SUM(hutang_bayar.nominal) as totalBayarHutang FROM hutang_bayar INNER JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.stdel='0' AND hutang_pos.idAkunHutang='$Ahutang[idAkun]' AND hutang_bayar.keterangan='Lunas' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) >= '$bulan1' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) <= '$bulan2'  AND hutang_setting.idTahunAjaran='$idTahunAjaran'"));
                        $total = $Thutang['totalHutang'] - $ThutangBayar['totalBayarHutang'];
                        echo '<tr>
                                <td>'.$Ahutang['kodeAkun'].'</td>
                                <td>'.$Ahutang['keterangan'].'</td>
                                <td>'.buatRp($total).'</td>
                             </tr>';
                        $subtotal_Hutang += $total;
                      }
                    ?>
                    <tr style="background-color: #fcfdff;">
                      <td colspan="2" align="right"><strong>Subtotal Hutang</strong></td>
                      <td><?= buatRp($subtotal_Hutang) ?></td>
                    </tr>
                  </tbody>
                </table>            
              </td>
            </tr>
            <tr>
              <td>
                <table class="table table-responsive" style="white-space: nowrap;">
                  <tbody>
                    <tr>
                      <th colspan="3">PIUTANG</th>
                    </tr>
                    <?php
                      $subtotal_piutang = 0;
                      if ($idUnit == 'all'){
                        $akun_piutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Piutang%' ORDER BY kodeAkun ASC");
                      }else{
                         $akun_piutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$idUnit' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Piutang%' ORDER BY kodeAkun ASC");
                      }
                      while ($piutang = mysqli_fetch_array($akun_piutang)) {
                        $saldo_piutang = 0;
                        $TBulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalTagihan, jenis_bayar.idPosBayar FROM tagihan_bulanan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));
                        $TBulananBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalBayar, jenis_bayar.idPosBayar FROM tagihan_bulanan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                        $TBebas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bebas.totalTagihan) as totalTagihan, jenis_bayar.idPosBayar FROM tagihan_bebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                        $TBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*, SUM(tagihan_bebas_bayar.jumlahBayar) as totalBayar, jenis_bayar.idPosBayar FROM tagihan_bebas INNER JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas=tagihan_bebas_bayar.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                        $saldo_piutang = ($TBulanan['totalTagihan'] - $TBulananBayar['totalBayar']) + ($TBebas['totalTagihan'] - $TBebasBayar['totalBayar']);
                        echo '<tr>
                                <td>'.$piutang['kodeAkun'].'</td>
                                <td>'.$piutang['keterangan'].'</td>
                                <td>'.buatRp($saldo_piutang).'</td>
                             </tr>';
                        $subtotal_piutang += $saldo_piutang;
                      }
                     
                    ?>
                    <tr style="background-color: #fcfdff;">
                      <td colspan="2" align="right"><strong>Subtotal Piutang</strong></td>
                      <td><?= buatRp($subtotal_piutang) ?></td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <td>
                <table class="table table-responsive" style="white-space: nowrap;">
                  <tbody>
                    <tr>
                      <th colspan="3">MODAL</th>
                    </tr>
                    </tr>
                    <?php
                      $subtotal_modal = 0;
                      if ($idUnit == 'all'){
                        $akun_modal = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%3-3%' AND keterangan LIKE '%Modal%' ORDER BY kodeAkun ASC");
                      }else{
                         $akun_modal = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$idUnit' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%3-3%' AND keterangan LIKE '%Modal%' ORDER BY kodeAkun ASC");
                      }
                      while ($modal = mysqli_fetch_array($akun_modal)) {
                        $saldo_modal = 0;
                        //hitung untuk kas
                          $akun_biaya_KAS = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$modal[unitSekolah]' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Kas%' ORDER BY kodeAkun ASC");
                          $saldo_kas = 0;
                          while ($kas = mysqli_fetch_array($akun_biaya_KAS)) {
                            $TBulananBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalBayar, bulan.urutan, jenis_bayar.idTahunAjaran FROM tagihan_bulanan INNER JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bulanan.idAkunKas='$kas[idAkun]' AND tagihan_bulanan.statusBayar='1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                            $TBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*, SUM(tagihan_bebas_bayar.jumlahBayar) as totalBayar, jenis_bayar.idTahunAjaran FROM tagihan_bebas INNER JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas=tagihan_bebas_bayar.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bebas_bayar.idAkunKas='$kas[idAkun]' AND tagihan_bebas.statusBayar!='0' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                            $TKasMasuk = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalMasuk FROM kas WHERE stdel='0' AND jenis='Masuk' AND idAkunKas='$kas[idAkun]' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) >= '$bulan1' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) <= '$bulan2' AND idTahunAjaran='$idTahunAjaran'"));

                            $TKasKeluar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(total) as totalKeluar FROM kas WHERE stdel='0' AND jenis='Keluar' AND idAkunKas='$kas[idAkun]' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) >= '$bulan1' AND IF(month(tanggal) <= 6,month(tanggal)+6, month(tanggal)-6) <= '$bulan2' AND idTahunAjaran='$idTahunAjaran'"));

                            $ThutangBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(hutang_bayar.nominal) as totalBayar FROM hutang_bayar INNER JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.stdel='0' AND hutang_bayar.idAkunKas='$kas[idAkun]' AND hutang_bayar.keterangan='Lunas' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) >= '$bulan1' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) <= '$bulan2' AND hutang_setting.idTahunAjaran='$idTahunAjaran'"));

                            $saldo_kas += $TBulananBayar['totalBayar'] + $TBebasBayar['totalBayar'] + $TKasMasuk['totalMasuk'] - $TKasKeluar['totalKeluar'] - $ThutangBayar['totalBayar'];
                          }

                          //hitung piutang
                          $akun_piutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$modal[unitSekolah]' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%1-1%' AND keterangan LIKE '%Piutang%' ORDER BY kodeAkun ASC");
                          $saldo_piutang = 0;
                          while ($piutang = mysqli_fetch_array($akun_piutang)) {
                            $TBulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalTagihan, jenis_bayar.idPosBayar FROM tagihan_bulanan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));
                            $TBulananBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalBayar, jenis_bayar.idPosBayar FROM tagihan_bulanan INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bulanan.tglBayar) <= 6,month(tagihan_bulanan.tglBayar)+6, month(tagihan_bulanan.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                            $TBebas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bebas.totalTagihan) as totalTagihan, jenis_bayar.idPosBayar FROM tagihan_bebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                            $TBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*, SUM(tagihan_bebas_bayar.jumlahBayar) as totalBayar, jenis_bayar.idPosBayar FROM tagihan_bebas INNER JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas=tagihan_bebas_bayar.idTagihanBebas INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar INNER JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE pos_bayar.akunPiutang='$piutang[idAkun]' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) >= '$bulan1' AND IF(month(tagihan_bebas_bayar.tglBayar) <= 6,month(tagihan_bebas_bayar.tglBayar)+6, month(tagihan_bebas_bayar.tglBayar)-6) <= '$bulan2' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'"));

                            $saldo_piutang += ($TBulanan['totalTagihan'] - $TBulananBayar['totalBayar']) + ($TBebas['totalTagihan'] - $TBebasBayar['totalBayar']);
                          }

                          //hitung Hutang
                          $akun_hutang = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE unitSekolah='$modal[unitSekolah]' AND jenisAkun='Sub Menu 2' AND kategori='Keuangan' AND kodeAkun LIKE '%2-2%' AND keterangan LIKE '%hutang%' ORDER BY kodeAkun ASC");
                          $total_hutang = 0;
                          while ($Ahutang = mysqli_fetch_array($akun_hutang)) {
                            $Thutang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(hutang_setting_detail.nominal) as totalHutang, hutang_setting.idTahunAjaran, hutang_setting.idUnit, hutang_pos.idAkunHutang FROM hutang_setting_detail INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_setting_detail.stdel='0' AND hutang_setting.idTahunAjaran='$idTahunAjaran' AND hutang_pos.idAkunHutang='$Ahutang[idAkun]'"));
                            $ThutangBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT  SUM(hutang_bayar.nominal) as totalBayarHutang FROM hutang_bayar INNER JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang INNER JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang INNER JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang WHERE hutang_bayar.stdel='0' AND hutang_pos.idAkunHutang='$Ahutang[idAkun]' AND hutang_bayar.keterangan='Lunas' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) >= '$bulan1' AND IF(month(hutang_bayar.tanggalBayar) <= 6,month(hutang_bayar.tanggalBayar)+6, month(hutang_bayar.tanggalBayar)-6) <= '$bulan2'  AND hutang_setting.idTahunAjaran='$idTahunAjaran'"));
                            
                            $total_hutang += $Thutang['totalHutang'] - $ThutangBayar['totalBayarHutang'];
                          }

                        $saldo_modal = $saldo_kas + $saldo_piutang - $total_hutang;
                        echo '<tr>
                                <td>'.$modal['kodeAkun'].'</td>
                                <td>'.$modal['keterangan'].'</td>
                                <td>'.buatRp($saldo_modal).'</td>
                             </tr>';
                        $subtotal_modal += $saldo_modal;
                      }
                     
                    ?>
                    <tr style="background-color: #fcfdff;">
                      <td colspan="2" align="right"><strong>Subtotal Modal</strong></td>
                      <td><?= buatRp($subtotal_modal) ?></td>
                    </tr>
                  </tbody>
                </table>            
              </td>
            </tr>
            <tr>
              <td>
                <table class="table table-responsive" style="white-space: nowrap;">
                  <tbody>
                    <tr style="background-color: #dee0e3;">
                      <td align="left"><strong>Total Aktiva</strong></td>
                      <td align="right"><strong><?= buatRp($subtotal_kas + $subtotal_piutang) ?></strong></td>
                    </tr>
                  </tbody>
                </table>
              </td>
              <td>
                <table class="table table-responsive" style="white-space: nowrap;">
                  <tbody>
                    <tr style="background-color: #dee0e3;">
                      <td align="left"><strong>Total Passiva</strong></td>
                      <td align="right"><strong><?= buatRp($subtotal_Hutang + $subtotal_modal) ?></strong></td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      </div>         
      <div class="box-footer">
        <table class="table">
          <tbody>
            <tr>
              <td>
                <div class="pull-right">
                  <a class="btn btn-danger" target="_blank" href="admin/laporan/rekap_laporan_neraca.php?unit=<?= $_GET[unit] ?>&thn_ajar=<?= $_GET[thn_ajar] ?>&bulan1=<?= $_GET[bulan1] ?>&bulan2=<?= $_GET[bulan2] ?>"><span class="fa fa-file-pdf-o"></span> Cetak PDF
                  </a>
                  <a class="btn btn-success" target="_blank" href="admin/excel/rekap_laporan_neraca.php?unit=<?= $_GET[unit] ?>&thn_ajar=<?= $_GET[thn_ajar] ?>&bulan1=<?= $_GET[bulan1] ?>&bulan2=<?= $_GET[bulan2] ?>"><span class="fa fa-file-excel-o"></span> Cetak Excel
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>


<?php } ?>
