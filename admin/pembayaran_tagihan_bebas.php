
<?php 
  session_start();
  include "../config/koneksi.php";
  include "../config/library.php";
  include '../config/user_agent.php';
  include '../config/variabel_default.php';

  $idUsers = $_SESSION['idUsers'];
  
  if (isset($_GET['hapus_bebas'])){

    $cek_totalBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT idTagihanBebas, SUM(jumlahBayar) as nominalBayar FROM tagihan_bebas_bayar WHERE idTagihanBebasBayar='$_GET[idBayar]' GROUP BY idTagihanBebas"));
    $cek_totalTagihan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(totalTagihan) as nominalTagihan FROM tagihan_bebas WHERE idTagihanBebas='$cek_totalBayar[idTagihanBebas]'"));

    if ($cek_totalBayar['nominalBayar'] != '0' && $cek_totalBayar['nominalBayar'] < $cek_totalTagihan['nominalTagihan']){
      $statusBayar = '2';
    }else{
      $statusBayar = '0';
    }

    $query = mysqli_query($koneksi,"DELETE FROM tagihan_bebas_bayar WHERE idTagihanBebasBayar='$_GET[idBayar]'");
    $query1 = mysqli_query($koneksi,"UPDATE tagihan_bebas SET statusBayar='$statusBayar' WHERE idTagihanBebas='$cek_totalBayar[idTagihanBebas]'");

    $info ='NIS:'.$_GET['nis'].';Title:Hapus Pelunasan '.$_GET['posbayar'].' nominal '.$_GET['nominal'];
    mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Pembayaran','Hapus Bayar Bebas','$info','$idUsers','$browser_ok','$user_os','$ip')");

    $title = 'Hapus Pelunasan '.$_GET['posbayar'];
    mysqli_query($koneksi,"INSERT INTO log_kasir(tanggal,jenisBayar,idBayar,modul,aksi,noRefrensi,nis_nip,title,nominal,penulis,browser,os,ip_address) VALUES ('$waktu_sekarang','Bebas','$cek_totalBayar[idTagihanBebas]','Pembayaran','Hapus','$_POST[noref]','$_GET[nis]','$title','$_GET[nominal]','$idUsers','$browser_ok','$user_os','$ip')");

    if ($query && $query1){
      $_SESSION['notif'] = 'dsukses_bebas';
    }else{
      $_SESSION['notif'] = 'gagal';
    }
  }

?>
<script type="text/javascript" src="../plugins/jQuery/jquery-latest.js"></script>
<script>
    var refreshId = setInterval(function()
    {
       $('#responsecontainer').load('pembayaran_tagihan_bebas.php?id="<?= $_GET[id] ?>"');
    }, 1000);
</script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<div id="responsecontainer">
<table class="table table-bordered" style="white-space: nowrap; font-size: 10pt">
 <thead>
  <tr class="info">
    <th>No</th>
    <th>Tanggal</th>
    <th>Jumlah Bayar</th>
    <th>Keterangan</th>
    <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
      
      $tampil = mysqli_query($koneksi,"SELECT * FROM tagihan_bebas_bayar WHERE idTagihanBebas='$_GET[id]'");
      $totalTagihan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(totalTagihan) as totalTagihan FROM tagihan_bebas WHERE idTagihanBebas='$_GET[id]'"));
      $no = 1;
      $total_bayar = 0;
      while ($r = mysqli_fetch_array($tampil)) {
        echo '<tr>
                <td>'.$no++.'</td>
                <td>'.date('m/d/Y',strtotime($r['tglBayarSementara'])).'</td>
                <td>'.buatRp($r['jumlahBayar']).'</td>
                <td>'.$r['ketBebas'].'</td>
                <td>
                  <a class="btn btn-danger btn-sm" title="Hapus" href="?hapus_bebas&idBayar='.$r['idTagihanBebasBayar'].'&id='.$r['idTagihanBebas'].'&thn_ajar='.$_GET['thn_ajar'].'&nis='.$_GET['nis'].'&posbayar='.$_GET['posbayar'].'&noref='.$r['noRefrensi'].'&nominal='.$r['jumlahBayar'].'" onclick=\'return confirm("Apa anda yakin untuk hapus Data ini? (Menghapus siswa berarti juga akan menghapus tagihan dan pembayaran!)")\'><span class="glyphicon glyphicon-trash"></span></a>
                </td>
              </tr>';
        $total_bayar = $total_bayar + $r['jumlahBayar'];
      }
      $tunggakan = $totalTagihan['totalTagihan'] - $total_bayar;
    ?>
  </tbody>
  <tfoot>
    <tr>
    <td colspan="2">Total Sudah Bayar</td>
    <td><?= buatRp($total_bayar) ?></td>
    <td colspan="2">Tunggakan : <?= buatRp($tunggakan) ?></td>
    </tr>
  </tfoot>
</table>
</div>
<script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>