
<?php
  include "../../config/koneksi.php";
  $bebas_id = $_POST['bebas_id'];
  for ($i=0; $i < count($bebas_id); $i++) { 
    $TB = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.*,
                                                            jenis_bayar.idPosBayar,
                                                            jenis_bayar.idTahunAjaran,
                                                            pos_bayar.nmPosbayar,
                                                            tahun_ajaran.nmTahunAjaran
                                                    FROM tagihan_bebas 
                                                    LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                    WHERE idTagihanBebas='$bebas_id[$i]'"));
?>
  
  <input class="form-control" name="id_tagihan_bebas[]" type="hidden" value="<?= $TB['idTagihanBebas'] ?>">
  <div class="form-group">
    <label>Nama Pembayaran</label>
    <input class="form-control" readonly="" name="nama_pos_bayar[]" type="text" value="<?= $TB['nmPosbayar'].' - T.A '.$TB['nmTahunAjaran'] ?>">
  </div>
  <div class="row">
    <div class="col-md-6">
      <label>Jumlah Bayar *</label>
      <input type="text" required="" name="nominal_bayar[]" id="nominal_bayar" class="form-control" placeholder="Jumlah Bayar">
    </div>
    <div class="col-md-6">
      <label>Keterangan *</label>
      <input type="text" required="" name="keterangan_bayar[]" id="keterangan_bayar" class="form-control" placeholder="Keterangan">
    </div>
  </div>
  <hr>
<?php
}
?>