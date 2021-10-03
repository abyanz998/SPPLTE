<?php
//date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$tgl_sekarang = date("Ymd");
$tgl_cetak = date("j F Y");
$tgl_skrg     = date("d");
$bln_sekarang = date("m");
$thn_sekarang = date("Y");
$jam_sekarang = date("H:i:s");
$tanggal_sekarang = date("Y-m-d");

$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");

function noRefrensiPembayaran($koneksi, $inisial, $tgl, $karakter, $id){
	$query = mysqli_query($koneksi, "SELECT max(transaksi_pembayaran.noRefrensi) as kodeTerbesar FROM transaksi_pembayaran WHERE transaksi_pembayaran.idSiswa='$id'");
	$data = mysqli_fetch_array($query);
	$kode = $data['kodeTerbesar'];
	$urutan = (int) substr($kode, $karakter);
	$urutan++;
	$kodeREFF = $inisial . sprintf("%02s", $urutan);

	return $kodeREFF;  
}

function noRefPembayaranSiswaBebas($koneksi, $inisial, $tgl, $karakter, $id){
	$query = mysqli_query($koneksi, "SELECT max(tagihan_bebas_bayar.noRefrensi) as kodeTerbesar, tagihan_bebas.idSiswa FROM tagihan_bebas_bayar LEFT JOIN tagihan_bebas ON tagihan_bebas_bayar.idTagihanBebas = tagihan_bebas.idTagihanBebas WHERE (DATE(tagihan_bebas_bayar.tglBayar)='$tgl') AND tagihan_bebas.idSiswa='$id'");
	$data = mysqli_fetch_array($query);
	$kode = $data['kodeTerbesar'];
	$urutan = (int) substr($kode, $karakter);
	$urutan++;
	$kodeREFF = $inisial . sprintf("%02s", $urutan);

	return $kodeREFF;  
}

function noRefSlipGaji($koneksi, $inisial, $tgl, $karakter, $id){
	$query = mysqli_query($koneksi, "SELECT max(noRefrensi) as kodeTerbesar FROM pegawai_gaji_slip WHERE tanggal='$tgl' AND stdel='0' AND idPegawai='$id'");
	$data = mysqli_fetch_array($query);
	$kode = $data['kodeTerbesar'];
	$urutan = (int) substr($kode, $karakter);
	$urutan++;
	$kodeREFF = $inisial . sprintf("%02s", $urutan);

	return $kodeREFF;  
}

function noRefHutang($koneksi, $inisial, $tgl, $karakter){
	$query = mysqli_query($koneksi, "SELECT max(noRefrensi) as kodeTerbesar FROM hutang_setting_detail WHERE tanggal='$tgl' AND stdel='0'");
	$data = mysqli_fetch_array($query);
	$kode = $data['kodeTerbesar'];
	$urutan = (int) substr($kode, $karakter);
	$urutan++;
	$kodeREFF = $inisial . sprintf("%02s", $urutan);

	return $kodeREFF;
}
function buatRp($angka)
{
	$jadi = "Rp " . number_format($angka,0,',','.');
	return $jadi;
}

//terbilang
function penyebut($nilai) {
	$nilai = abs($nilai);
	$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
	$temp = "";
	if ($nilai < 12) {
		$temp = " ". $huruf[$nilai];
	} else if ($nilai <20) {
		$temp = penyebut($nilai - 10). " belas";
	} else if ($nilai < 100) {
		$temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
	} else if ($nilai < 200) {
		$temp = " seratus" . penyebut($nilai - 100);
	} else if ($nilai < 1000) {
		$temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
	} else if ($nilai < 2000) {
		$temp = " seribu" . penyebut($nilai - 1000);
	} else if ($nilai < 1000000) {
		$temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
	} else if ($nilai < 1000000000) {
		$temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
	} else if ($nilai < 1000000000000) {
		$temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
	} else if ($nilai < 1000000000000000) {
		$temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
	}     
	return $temp;
}

function terbilang($nilai) {
	if($nilai<0) {
		$hasil = "minus ". trim(penyebut($nilai));
	} else {
		$hasil = trim(penyebut($nilai));
	}     		
	return $hasil.' rupiah';
}
?>
