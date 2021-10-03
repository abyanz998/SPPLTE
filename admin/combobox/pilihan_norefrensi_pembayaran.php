<?php
    include '../../config/koneksi.php';

    $tgl_transaksi=$_POST['tgl_transaksi'];
    $idSiswa=$_POST['idSiswa'];

    echo '<option disabled selected value="">- Pilih No. Referensi -</option>';

    $trx_pembayaran = mysqli_query($koneksi,"SELECT 
                                                transaksi_pembayaran.*,
                                                tagihan_bulanan.tglBayar,
                                                tagihan_bebas_bayar.tglBayar
                                             FROM transaksi_pembayaran 
                                             LEFT JOIN tagihan_bulanan ON transaksi_pembayaran.noRefrensi = tagihan_bulanan.noRefrensi
                                             LEFT JOIN tagihan_bebas_bayar ON transaksi_pembayaran.noRefrensi = tagihan_bebas_bayar.noRefrensi
                                             WHERE transaksi_pembayaran.idSiswa='$idSiswa' AND ((DATE(tagihan_bulanan.tglBayar)='$tgl_transaksi') OR (DATE(tagihan_bebas_bayar.tglBayar)='$tgl_transaksi')) GROUP BY transaksi_pembayaran.noRefrensi");
    while ($trx = mysqli_fetch_array($trx_pembayaran)) {
        echo '<option value="'.$trx['noRefrensi'].'">'.$trx['noRefrensi'].'</option>';
    }

    
?>
  