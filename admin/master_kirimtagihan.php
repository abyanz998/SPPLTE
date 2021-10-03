<?php if ($_GET[act]==''){ ?> 
  
  <?php  
    //notif
    if($_SESSION['notif'] == 'wa_sukses'){
      echo '<script>toastr["success"]("Berhasil mengirimkan Tagihan.","Sukses!")</script>';
    }elseif($_SESSION['notif'] == 'wa_gagal'){
      echo '<script>toastr["error"]("Gagal mengirimkan Tagihan.","Gagal!")</script>';
    }unset($_SESSION['notif']);

 
  if (isset($_POST['kirim_tagihan_wa'])){
    $id_siswa = $_POST['id_siswa'];
    $id_tahun_ajaran = $_POST['id_tahun_ajaran'];
    $id_unit = $_POST['id_unit'];
    $id_kelas = $_POST['id_kelas'];
  
    for ($i=0; $i < count($id_siswa); $i++) { 
      $bulan_aktif = (int)date('m') + 6;
      $total_tagihan_bulanan_bebas = 0;

      $siswa=mysqli_fetch_array(mysqli_query($koneksi,"SELECT siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas WHERE siswa.idSiswa='$id_siswa[$i]' AND siswa.unitSiswa='$id_unit' AND siswa.kelasSiswa='$id_kelas' AND siswa.statusSiswa='Aktif'"));

      $tagihan_bulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT 
                                                                    tagihan_bulanan.*,
                                                                    SUM(tagihan_bulanan.jumlahTagihan) as totalTagihanBulanan, 
                                                                    jenis_bayar.idPosBayar,
                                                                    bulan.urutan
                                                                  FROM tagihan_bulanan 
                                                                  LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                                                  LEFT JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                                                  WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$id_tahun_ajaran' AND jenis_bayar.idUnit='$siswa[unitSiswa]' AND tagihan_bulanan.statusBayar='0' AND bulan.urutan <= '$bulan_aktif'"));

      $tagihan_bebas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT 
                                                tagihan_bebas.*, 
                                                SUM(tagihan_bebas.totalTagihan) as totalTagihanBebas, 
                                                jenis_bayar.idPosBayar
                                                FROM tagihan_bebas 
                                                LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND tagihan_bebas.statusBayar!='1' AND jenis_bayar.idTahunAjaran='$id_tahun_ajaran' AND jenis_bayar.idUnit='$siswa[unitSiswa]'"));
      $tagihan_bebas_bayar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(jumlahBayar) as totalBayarBebas FROM tagihan_bebas_bayar WHERE idTagihanBebas='$tagihan_bebas[idTagihanBebas]'"));                  
      $total_tagihan_bulanan_bebas = ($tagihan_bulanan['totalTagihanBulanan'] + ($tagihan_bebas['totalTagihanBebas'] - $tagihan_bebas_bayar['totalBayarBebas']));

      // kirim Tagihan WAu
      $noHp_ortu = $siswa['noHpOrtu'];
      $link_url_semua_tagihan= "$page_URL$_SERVER[HTTP_HOST]/".$uri_segments[1]."/admin/laporan/tagihan_pembayaran_persiswa.php?thn_ajar=".$_GET[thn_ajar]."%26nis=".$siswa[nisSiswa];

      $text_wa = 'Diberitahukan kepada Bapak/Ibu dari Santri A/N '.$siswa[nmSiswa].', Kelas '.$siswa[nmKelas].', untuk segera melunasi biaya pendidikan sejumlah "'.buatRp($total_tagihan_bulanan_bebas).'". Atas perhatiannya kami ucapkan terima kasih. %0A %0ADownload Tagihan : '.$link_url_semua_tagihan.' %0A %0A*) Jika tagihan tidak sesuai dengan kartu syariah atau sudah melakukan pembayaran agar konfirmasi dengan mengirimkan bukti pembayaran / kwitansi yang sah. %0A %0A*) Silahkan simpan nmor ini jika link tidak aktif';

      echo "<script>document.location='admin/whatsapp.php?phone=".$noHp_ortu."&text=".$text_wa."&view=".$_GET[view]."&thn_ajar=".$id_tahun_ajaran."&unit=".$id_unit."&kelas=".$id_kelas."';</script>";
    }
  }
?> 
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
                    <select class="form-control" name="thn_ajar" id="Ctahunajaran"></select>
                  </div>
                </div>
                <div class="col-md-2">  
                  <div class="form-group">
                    <label>Unit Sekolah</label>
                    <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                    <select class="form-control" name="unit" id="Cunit" onchange="get_kelas()" required=""></select>
                  </div>
                </div>
                <div class="col-md-2">  
                  <div class="form-group">
                    <label>Kelas</label>
                    <input type="hidden" id="idKelas" value="<?= $_GET[kelas] ?>">
                    <select class="form-control" name="kelas" id="Ckelas" required="">
                      <option value="">- Pilih Kelas -</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div style="margin-top:25px;">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Cari</button>
                    <?php 
                      if (isset($_GET['thn_ajar']) && isset($_GET['unit']) && isset($_GET['kelas'])) {
                        echo "<a data-toggle='modal' class='btn btn-success' title='Kirimkan Tagihan' href='#kirimTagihan' onclick='get_form()'><i class='fa fa-whatsapp'></i>Kirim Tagihan</a>";
                      }
                    ?>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>



                      <div class="modal fade in" id="kirimTagihan" role="dialog">
                        <div class="modal-dialog modal-md">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">×</button>
                              <h4 class="modal-title">Kirim Tagihan</h4>
                            </div>
                            <form action="" method="POST" accept-charset="utf-8">
                              <div class="modal-body">
                                <p>Anda Yakin Mau Mengirim Tagihan ke Orang Tua Santri Tersebut?</p>
                                <input type="hidden" class="form-group" name="id_tahun_ajaran" value="<?= $_GET[thn_ajar] ?>">
                                <input type="hidden" class="form-group" name="id_unit" value="<?= $_GET[unit] ?>">
                                <input type="hidden" class="form-group" name="id_kelas" value="<?= $_GET[kelas] ?>">
                                <div id="fbatch"></div>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" name="kirim_tagihan_wa" class="btn btn-success">Kirim</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
<?php } ?>

<?php if (isset($_GET['thn_ajar']) && isset($_GET['unit']) && isset($_GET['kelas'])) { 

  $kls = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$_GET[kelas]'"));
?>

      <div class="col-md-12">
        <div class="box box-success">
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered" style="white-space: nowrap;">
                <thead>
                  <tr>
                    <th><center><input type="checkbox" id="selectall" value="checkbox" name="checkbox"></center></th>
                    <th>No.</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Wa Ortu</th>
                    <th>Total Tagihan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no = 1;
                    $total_seluruh_tagihan = 0;
                    $sql_siswa = mysqli_query($koneksi,"SELECT siswa.*, kelas_siswa.nmKelas FROM siswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas WHERE siswa.unitSiswa='$_GET[unit]' AND siswa.kelasSiswa='$_GET[kelas]' AND siswa.statusSiswa='Aktif'");
                    while ($siswa = mysqli_fetch_array($sql_siswa)) {

                      $tagihanBulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bulanan.jumlahTagihan) as totalTagihanBulanan, jenis_bayar.idTahunAjaran FROM tagihan_bulanan LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND tagihan_bulanan.statusBayar='0' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]'"));

                      $tagihanBebas= mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.idTagihanBebas, SUM(tagihan_bebas.totalTagihan) as totalTagihanBebas, jenis_bayar.idTahunAjaran FROM tagihan_bebas LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND tagihan_bebas.statusBayar!='1' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]'"));

                      $tagihanBebasBayar= mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(tagihan_bebas_bayar.jumlahBayar) as totalTagihanBebasBayar FROM tagihan_bebas_bayar WHERE idTagihanBebas='$tagihanBebas[idTagihanBebas]' GROUP BY idTagihanBebas"));
                      
                      $totalTagihan = ($tagihanBulanan['totalTagihanBulanan'] + ($tagihanBebas['totalTagihanBebas'] - $tagihanBebasBayar['totalTagihanBebasBayar'])) ;

                      echo '<tr>
                              <td style="background-color: #fff !important;">';
                                if ($totalTagihan == '0'){
                                  echo '<center><input type="checkbox" disabled="disabled"></center>';
                                }else{
                                  echo '<center><input type="checkbox" class="checkbox" name="msg[]" id="msg" value="'.$siswa['idSiswa'].'"></center>';
                                }
                      echo   '</td>
                              <td>'.$no++.'</td>
                              <td>'.$siswa['nisSiswa'].'</td>
                              <td>'.$siswa['nmSiswa'].'</td>
                              <td>'.$siswa['nmKelas'].'</td>
                              <td>'.$siswa['noHpOrtu'].'</td>
                              <td>'.buatRp($totalTagihan).'</td>
                            </tr>';
                      $total_seluruh_tagihan = $total_seluruh_tagihan + $totalTagihan;
                    }
                  ?>
                  
                </tbody>
                <tfoot>
                  <tr style="background-color: #f0f0f0;">
                    <td colspan="6" align="center" style="font-weight: bold;">Total Tagihan Kelas <?= ucwords($kls['nmKelas']) ?></td>
                    <td><?= buatRp($total_seluruh_tagihan) ?></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>


<?php } ?>

<script type="text/javascript">
  function get_form(){
        var id_siswa = $('#msg:checked');
        if(id_siswa.length > 0)
        {
            var id_siswa_value = [];
            $(id_siswa).each(function(){
                id_siswa_value.push($(this).val());
            });

            $.ajax({
                url: 'admin/form/form_add_kirim_tagihan_siswa.php',
                method:"POST",
                data: {
                        id_siswa : id_siswa_value,
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
          toastr["error"]("Belum ada Siswa yang dipilih","Gagal!");
        }
      }

</script>