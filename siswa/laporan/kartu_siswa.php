<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/variabel_default.php";
    include "../../config/variabel_url.php";
    include "../../config/setting_barcode.php";
    include "../../config/barcode.php";
    require_once('../../plugins/tcpdf/tcpdf.php');

    

        $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
        $edit = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.idSiswa='$_GET[id]' AND siswa.stdel='0'");
        $record = mysqli_fetch_array($edit);

        if (empty($record['fotoSiswa'])){
            $fotoSiswa = '../../'.$lokasi_default_fotoSiswa;
        }else{
            $fotoSiswa = '../../'.$lokasi_penyimpanan_fotoSiswa.$record['fotoSiswa'];
        }
        
        if ($record['tglLahirSiswa'] == '0000-00-00' OR $record['tglLahirSiswa'] == ''){
            $ttl = strtoupper($record['tempatLahirSiswa']);
        }else{
            $ttl = strtoupper($record['tempatLahirSiswa'].', '.tgl_view($record['tglLahirSiswa']));
        }
        $pisahAlamat = explode('Desa',$record['alamatSiswa']);

        $lokasi = '../../'.$lokasi_barcode_kartu_siswa;
        $value = 'SISWA-'.sprintf("%018s", $record['nisSiswa']);
        $link_barcode = barcode($lokasi,$value,$codetype,$print,$size);

        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(6,6,6,6);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle($record['nmSiswa']);
        $pdf->SetSubject($record['nmSiswa']);

        $pdf->SetFont('helvetica','B',10);
        $html ='<table border="1" style="padding: 5px 5px 5px 5px;" width="336px"><tr><td><img src="../../'.$lokasi_gambar_kartu_siswa_depan.'" width="325.03937px" height="211.653543px"></td></tr><tr><td><img src="../../'.$lokasi_gambar_kartu_siswa_belakang.'" width="325.03937px" height="211.653543px"></td></tr></table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Image('../../'.$lokasi_penyimpanan_logo.$idt['logo_kiri'], 10, 9, 16, 16);
        $pdf->text(29,10,'KARTU TANDA SANTRI');
        $pdf->text(29,14,strtoupper(strtolower($idt['nmSekolah'])));
        $pdf->text(29,18,strtoupper(strtolower($idt['kabupaten'].' '.$idt['propinsi'])));
        $pdf->text(29,22,strtoupper(strtolower('(BOARDING SCHOOL)')));
        $pdf->SetFont('helvetica','',6);
        $pdf->text(9,27,'NSPP : '.$idt['npsn']);
        $pdf->text(29,27,$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].' Website : '.$_SERVER[HTTP_HOST]);
        $pdf->Image($fotoSiswa, 12, 33, 28, 40); 
        $pdf->SetFont('Times','B',9);
        $pdf->text(47,35,'NAMA         :  '.strtoupper($record['nmSiswa']));
        $pdf->text(47,41,'NIS               :  '.strtoupper($record['nisSiswa']));
        $pdf->text(47,46,'TTL              :  '.$ttl);
        $pdf->text(47,51,'ALAMAT    :  '.strtoupper($pisahAlamat[0]));
        $pdf->MultiCell(0, 12, 'PT. ACHMATIM DOT NET');

        $pdf->Image($link_barcode, 47, 61, 70, 12); 

        $file = 'Kartu Siswa NIS'.$record['nisSiswa'].' Nama '.$record['nmSiswa'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
   
?>