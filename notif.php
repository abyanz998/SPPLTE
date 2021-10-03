<?php

namespace Midtrans;
require_once(dirname(__FILE__) . '/vendor/autoload.php');
Config::$isProduction = false;
Config::$serverKey = "SB-Mid-server-PrwY2nxLwTUV7kyfMZVadJDl";
include "config/koneksi.php";
include "config/rupiah.php";
include "config/wa.php";
include "config/fungsi_indotgl.php";


	$da = file_get_contents('php://input');
	$result = json_decode($da);
	$fa = json_encode($result);
	

$notif = new \Midtrans\Notification();
 
$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;

$pr = $notif->gross_amount;
$fraud = $notif->fraud_status;

$str = "-";

if( strpos( $pr, $str ) !== false) {
    $hrg = $pr;
}
else
{
    $hr = explode(".",$pr);
    $hrg = $hr[0];
}

if ($transaction == 'capture') {
  // For credit card transaction, we need to check whether transaction is challenge by FDS or not
  if ($type == 'credit_card'){
    if($fraud == 'challenge'){
      // TODO set payment status in merchant's database to 'Challenge by FDS'
      // TODO merchant should decide whether this transaction is authorized or not in MAP
      echo "Transaction order_id: " . $order_id ." is challenged by FDS";
      }
      else {
      // TODO set payment status in merchant's database to 'Success'
      echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
      
      $up = mysqli_query($koneksi, "UPDATE tagihan_bulanan SET statusBayar='2' WHERE inv='$order_id'");
      $up = mysqli_query($koneksi, "UPDATE tagihan_bebas SET statusBayar='1' WHERE ref='$order_id'");
      }
    }
  }
else if ($transaction == 'settlement'){
  // TODO set payment status in merchant's database to 'Settlement'
  echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
  
      $be = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tagihan_bebas WHERE ref='$order_id'"));
      
      $or = explode("-",$order_id);
    
      $tg = date("Y-m-d");
      $nw = date("Y-m-d H:i:s");
      $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran where status='Aktif'"));
      $thn = $ta['idTahunAjaran'];
      
      if($be)
      {
              
              $fee = 'Bayar Bebas';
              $da = [$be['idTagihanBebas'],$be['idSiswa'],$be['totalTagihan']];
              $ids = $be['idSiswa'];
              
              
              $siswa = mysqli_fetch_array(mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa 
                                    LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit 
                                    LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas 
                                    LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.idSiswa='$da[1]'"));
                                    
              $inisial = "SP".$siswa['singkatanUnit'].$siswa['nisSiswa'].date('dmy');
              
              $karakter = '-2';
              $query = mysqli_query($koneksi, "SELECT max(transaksi_pembayaran.noRefrensi) as kodeTerbesar FROM transaksi_pembayaran WHERE transaksi_pembayaran.idSiswa='$da[1]'");
              $data = mysqli_fetch_array($query);
              $kode = $data['kodeTerbesar'];
              $urutan = (int) substr($kode, $karakter);
              $urutan++;
              $kodeREFF = $inisial . sprintf("%02s", $urutan);
              
              
            $id_unit = $or[1];
        	$unit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$id_unit' "));
        	$ini = 'JK'.$unit['singkatanUnit'].date('dmy');
        
        	$que = mysqli_query($koneksi, "SELECT max(noRefrensi) as kodeTerbesar FROM kas WHERE idUnitSekolah='$id_unit' AND tanggal='$tg' AND stdel='0'");
        	$datas = mysqli_fetch_array($que);
        	$kod = $datas['kodeTerbesar'];
        	$ur = (int) substr($kod, -4);
        	$ur++;
        	$noref = $ini . sprintf("%04s", $ur);
        	
        	
        	$q3 = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE keterangan='Akun Bank' AND unitSekolah='$or[1]' "));
            $fa = $q3['idAkun'];
        	
        	
            $q2 = mysqli_query($koneksi, "INSERT INTO kas(jenis,tipe,tanggal,idUnitSekolah,noRefrensi,idAkunKas,idAkunKasTujuan,idTahunAjaran, keterangan,total,stdel,cby,cdate,SiswaId) VALUES
                                                ('Masuk','Transfer','$tg','$or[1]','$noref','$fa','$fa','$thn','Terima Tagihan bebas midtransi','$hrg','0','$or[1]','$nw',$da[1])");
    	
            
                    
            $fi = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(jumlahBayar) AS Total FROM tagihan_bebas_bayar WHERE idTagihanBebas='$da[0]'"));
            $sm = empty($fi['Total']) ? 0 : $fi['Total'];
            
            $ns = (int) $sm;
            $tot = (int) $da[2];
            $num = (int) $hrg;
            $sis = $tot-($num+$ns);
            
            if($sis == 0)
            {
                $bs = mysqli_query($koneksi, "UPDATE tagihan_bebas SET statusBayar='1' WHERE ref='$order_id'");
            }
            
            
             $na = mysqli_query($koneksi, "SELECT * FROM tagihan_bebas
                                                INNER JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                WHERE ref='$order_id'");
                                                
             $an = mysqli_fetch_array($na);
             
             $pos = $an['nmPosBayar']. " T.A. " . $ta['nmTahunAjaran'];
            
            $con = 'tot ='.$tot.' sum = '.$ns.' pay = '.$num.' sisa = '.$sis;
            $query=mysqli_query($koneksi,"INSERT INTO tb_tes(con) VALUES ('$con')");
            
            $query = mysqli_query($koneksi,"INSERT INTO tagihan_bebas_bayar
                    (idTagihanBebas,noRefrensi,tglBayar,tglBayarSementara,jumlahBayar,idAkunKas,ketBebas) VALUES 
                    ('$da[0]','$kodeREFF','$nw','$nw','$hrg','76','transfer bank midtrans')");
      }
      else
      {
          $de = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tagihan_bulanan WHERE inv='$order_id'"));
          $ids = $de['idSiswa'] ;
          $fee = 'Bayar Bulanan';
          $da = explode("-",$order_id);
          
            $id_unit = $da[1];
        	$unit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM unit_sekolah WHERE idUnit='$id_unit' "));
        	$inisial = 'JK'.$unit['singkatanUnit'].date('dmy');
        
        	$query = mysqli_query($koneksi, "SELECT max(noRefrensi) as kodeTerbesar FROM kas WHERE idUnitSekolah='$id_unit' AND tanggal='$tg' AND stdel='0'");
        	$data = mysqli_fetch_array($query);
        	$kode = $data['kodeTerbesar'];
        	$urutan = (int) substr($kode, -4);
        	$urutan++;
        	$kodeREFF = $inisial . sprintf("%04s", $urutan);
    	
            $noref = $kodeREFF;
            $tot = $hrg;
          
            $q = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE keterangan='Akun Bank' AND unitSekolah='$da[1]' "));
            $fa = $q['idAkun'];
            
            $qu = mysqli_query($koneksi, "INSERT INTO kas(jenis,tipe,tanggal,idUnitSekolah,noRefrensi,idAkunKas,idAkunKasTujuan,idTahunAjaran, keterangan,total,stdel,cby,cdate,SiswaId) VALUES
                                                ('Masuk','Transfer','$tg','$da[1]','$noref','$fa','$fa','$thn','Terima Tagihan bulan midtrans','$tot','0','$da[1]','$nw','$ids')");
                                                
            $bul = mysqli_query($koneksi, "UPDATE tagihan_bulanan SET statusBayar='2', idAkunKas = '$fa', tglBayar = '$nw' WHERE inv='$order_id'");
            
            $na = mysqli_query($koneksi, "SELECT * FROM tagihan_bulanan
                                    INNER JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                    INNER JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                    WHERE inv='$order_id'");
                                    
            $an = mysqli_fetch_array($na);
            
            $pos = $an['nmPosBayar']. " T.A. " . $ta['nmTahunAjaran'];
      }
        //log
        $sis = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas WHERE idSiswa='$ids'"));
        $info ='NIS:'.$sis['nisSiswa'].';Title:Bayar '.$pos.' nominal '.$hrg;
        mysqli_query($koneksi,"INSERT INTO log_transaksi(tanggal,modul,aksi,info,penulis,browser,os,ip_address) VALUES 
        ('$nw','Pembayaran','$fee','$info','Midtrans','Midtrans','Midtrans','Midtrans')");
        
        
      $nam = $sis['nmSiswa']; $kls = $sis['nmKelas']; $jml = rupiah($hrg); $no = $sis['noHpOrtu']; $tgl = tgl_indo($tg);
      $ps = 'Terima Kasih, Pembayaran Sekolah a/n '.$nam.', Kelas '.$kls.'%0D%0Atelah kami terima tgl '.$tgl.' sejumlah Rp '.$jml.'%0D%0AReferensi ID : '.$noref.'%0D%0A*) Silahkan simpan nomor ini jika link tidak aktif';
      send($no,$ps);
  }
  else if($transaction == 'pending'){
  // TODO set payment status in merchant's database to 'Pending'
  echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
  
   $up = mysqli_query($koneksi, "UPDATE tagihan_bulanan SET statusBayar='1' WHERE inv='$order_id'");
   
   $up = mysqli_query($koneksi, "UPDATE tagihan_bebas SET statusBayar='2' WHERE ref='$order_id'");
  }
  else if ($transaction == 'deny') {
  // TODO set payment status in merchant's database to 'Denied'
  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
  }
  else if ($transaction == 'expire') {
  // TODO set payment status in merchant's database to 'expire'
  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
  }
  else if ($transaction == 'cancel') {
  // TODO set payment status in merchant's database to 'Denied'
  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
}





?>