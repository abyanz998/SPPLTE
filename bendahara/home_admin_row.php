<?php 
include 'config/rupiah.php';
$query_saldo=mysql_query("SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi where kelas='$_SESSION[kelas]' ");
$row_saldo=mysql_fetch_array($query_saldo);
$saldo_keseluruhan= $row_saldo['jumlah_debit'] - $row_saldo['jumlah_kredit'];

$total = 0;
					//$sqlJU = mysql_query("SELECT * FROM jurnal_umum WHERE DATE(tgl) BETWEEN '$tgl1' AND '$tgl2' ORDER BY tgl ASC");

					//hitung pemasukan dan pengeluaran dari jurnal umum
					$dPJU = mysql_fetch_array(mysql_query("SELECT SUM(penerimaan) AS totalMasuk, SUM(pengeluaran) AS totalKeluar FROM jurnal_umum"));
					$totalPemasukan = $dPJU['totalMasuk'];
					$totalPengeluaran = $dPJU['totalKeluar'];
					
					$dPJUs = mysql_fetch_array(mysql_query("SELECT SUM(penerimaan) AS totalMasuk, SUM(pengeluaran) AS totalKeluar FROM saldoawal"));
					$totalPemasukans = $dPJUs['totalMasuk'];
					$totalPengeluarans = $dPJUs['totalKeluar'];

					// Hitung Pembayaran Bulanan
					$dBul = mysql_fetch_array(mysql_query("SELECT SUM(jumlahBayar) AS totalBul FROM tagihan_bulanan WHERE statusBayar='1' AND idKelas='$_SESSION[kelas]' "));
					$totalPendapatanBulanan = $dBul['totalBul'];

					// Hitung Pembayaran Bebas
					$dBeb = mysql_fetch_array(mysql_query("SELECT SUM(jumlahBayar) AS totalBeb FROM tagihan_bebas_bayar where idKelas='$_SESSION[kelas]'"));
					$totalPendapatanBebas = $dBeb['totalBeb'];

$query_saldo=mysql_query("SELECT SUM(sisa) as jumlah_debit FROM hutangtoko");
$row=mysql_fetch_array($query_saldo);
$saldo_keseluruhans= $row['jumlah_debit'];

$bulan = date('m');
$query_saldo=mysql_query("SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE DATE_FORMAT((tanggal),'%m') like '%$bulan%'");
$saldo = mysql_fetch_array($query_saldo);
$saldo_bulan= $saldo['jumlah_debit'] - $saldo['jumlah_kredit'];


$hari = date('d');
$query_hari=mysql_query("SELECT SUM(debit) as jumlah_debit, SUM(kredit) as jumlah_kredit FROM transaksi WHERE DATE_FORMAT((tanggal),'%m') like '%$bulan%'");
$saldo_h = mysql_fetch_array($query_hari);
$saldo_hari= $saldo_h['jumlah_debit'] - $saldo_h['jumlah_kredit'];


$edit = mysql_query("SELECT * FROM identitas ");
$record = mysql_fetch_array($edit);
?>

<div class="col-xs-12">
	<?php if(isset($_GET['alert']) && $_GET['alert']=='updb'){ ?>
		<div class="alert alert-success alert-dismissible text-center" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<p><b>Update Datbase Berhasil..</b></p>
		</div>
	<?php } ?>

  <div class="box box-primary box-solid">
	<div class="box-header with-border">
	  <h3 class="box-title">

	      <SCRIPT language=JavaScript>var d = new Date();
			var h = d.getHours();
			if (h < 11) { document.write('Selamat pagi, '); }
			else { if (h < 15) { document.write('Selamat siang, '); }
			else { if (h < 19) { document.write('Selamat sore, '); }
			else { if (h <= 23) { document.write('Selamat malam, '); }
			}}}</SCRIPT> <?php echo $_SESSION['namalengkap'];?> ||<div class="col" role="main"> </h3>
			  <h3 class="box-title">
		
<?php
$hari = date('l');
/*$new = date('l, F d, Y', strtotime($Today));*/
if ($hari=="Sunday") {
	echo "Minggu";
}elseif ($hari=="Monday") {
	echo "Senin";
}elseif ($hari=="Tuesday") {
	echo "Selasa";
}elseif ($hari=="Wednesday") {
	echo "Rabu";
}elseif ($hari=="Thursday") {
	echo("Kamis");
}elseif ($hari=="Friday") {
	echo "Jum'at";
}elseif ($hari=="Saturday") {
	echo "Sabtu";
}
?>,
<?php
$tgl =date('d');
echo $tgl;
$bulan =date('F');
if ($bulan=="January") {
	echo " Januari ";
}elseif ($bulan=="February") {
	echo " Februari ";
}elseif ($bulan=="March") {
	echo " Maret ";
}elseif ($bulan=="April") {
	echo " April ";
}elseif ($bulan=="May") {
	echo " Mei ";
}elseif ($bulan=="June") {
	echo " Juni ";
}elseif ($bulan=="July") {
	echo " Juli ";
}elseif ($bulan=="August") {
	echo " Agustus ";
}elseif ($bulan=="September") {
	echo " September ";
}elseif ($bulan=="October") {
	echo " Oktober ";
}elseif ($bulan=="November") {
	echo " November ";
}elseif ($bulan=="December") {
	echo " Desember ";
}
$tahun=date('Y');
echo $tahun;
?> ||<script type="text/javascript">    
    //fungsi displayTime yang dipanggil di bodyOnLoad dieksekusi tiap 1000ms = 1detik
    function tampilkanwaktu(){
        //buat object date berdasarkan waktu saat ini
        var waktu = new Date();
        //ambil nilai jam, 
        //tambahan script + "" supaya variable sh bertipe string sehingga bisa dihitung panjangnya : sh.length
        var sh = waktu.getHours() + ""; 
        //ambil nilai menit
        var sm = waktu.getMinutes() + "";
        //ambil nilai detik
        var ss = waktu.getSeconds() + "";
        //tampilkan jam:menit:detik dengan menambahkan angka 0 jika angkanya cuma satu digit (0-9)
        document.getElementById("clock").innerHTML = (sh.length==1?"0"+sh:sh) + ":" + (sm.length==1?"0"+sm:sm) + ":" + (ss.length==1?"0"+ss:ss);
    }
</script>	
<body onload="tampilkanwaktu();setInterval('tampilkanwaktu()', 1000);">								
<span id="clock"></span> </h3>
	</div><!-- /.box-header -->
	<section class="content">
    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-bank"></i></span>

          <div class="info-box-content">
            <span class="info-box-text dash-text">Nama Sekolah</span>
            <span class="info-box-number"><?php echo $record['nmSekolah']; ?> </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
		  

          <div class="info-box-content">
            <span class="info-box-text dash-text">Nama Kepala Sekolah</span>
            <span class="info-box-number"><?php echo $record['nmKepsek']; ?> </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
<?php 
                $query_pegawai=mysql_query("SELECT *  FROM users");
                $num_pegawai = mysql_num_rows($query_pegawai);
                $query_nasabah=mysql_query("SELECT *  FROM siswa where idKelas='$_SESSION[kelas]' ");
                $num_nasabah = mysql_num_rows($query_nasabah);

                
                ?>
      <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>

          <div class="info-box-content">
            
            <span class="info-box-text dash-text">User Aktif</span>
            <span class="info-box-number"><?php echo $num_pegawai;?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
		
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

          <div class="info-box-content">
            <span class="info-box-text dash-text">Siswa Aktif</span>
            <span class="info-box-number"><?php echo $num_nasabah;?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
	   <!-- /.col -->
      
      <!-- /.col -->
	   <!-- /.col -->
     
      <!-- /.col -->
       <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-toggle-down text-azure"></i></span>

          <div class="info-box-content">
            <span class="info-box-text dash-text">Total Pemasukan Pembayaran</span>
            <span class="info-box-number">Rp. <?php echo rupiah ($totalPendapatanBulanan+$totalPendapatanBebas);?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

	 
	  	  <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-blue"><i class="fa fa-usd"></i></span>

          <div class="info-box-content">
            <span class="info-box-text dash-text">Saldo Tabungan </span>
            <span class="info-box-number">Rp. <?php echo rupiah($saldo_keseluruhan);?></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
	   
      <!-- /.col -->
	   
    </div><br>
	
		<div class="alert alert-info">
			<!-- panggil file "content" untuk menampilkan content -->
			
			<p>Ini adalah halaman Dashboard yang digunakan untuk mengelola Pembayaran Sekolah,Tabungan Siswa, dan Hutang Piutang ditampilkannya
		  halaman ini adalah bukti bahwa anda adalah pengguna resmi aplikasi ini.
			Silahkan digunakan dengan baik, dan sampaikan jika ada keluhan dalam masalah penggunaan aplikasi ini. Terima kasih atas kepercayaan anda!</p>
		</div>
	</div>
  </div>
</div>
 
	