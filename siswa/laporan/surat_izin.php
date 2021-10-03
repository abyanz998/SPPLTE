<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/variabel_default.php";
    include "../../config/setting_barcode.php";
    require_once('../../plugins/tcpdf/tcpdf.php');

    if (isset($_SESSION['idUsers'])){
        $idUsers=$_SESSION['idUsers'];
        $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
        $users = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM users WHERE idUsers='$idUsers'"));
        $siswa = mysqli_fetch_array(mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.idSiswa='$_GET[id]' AND siswa.stdel='0'"));
        $kesehatan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa_kesehatan WHERE idKesehatan='$_GET[kesehatan]'"));

        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(20,20,20,20);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle($siswa['nmSiswa']);
        $pdf->SetSubject($siswa['nmSiswa']);
        //isi pdf

        //header
        $html ='<table width="100%" border="0">
                    <tr><td align="center"><font style="font-size:14px; font-weight:bold;">PUSAT KESEHATAN PONDOK PESANTREN (PUSKESTREN)</font></td></tr>
                    <tr><td align="center"><font style="font-size:14px; font-weight:bold;">'.$idt[nmSekolah].'</font></td></tr>
                    <tr><td align="center"><font style="font-size:10px;"><br>'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</font></td></tr>
                </table>
                <hr style="height:1.5px">';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(8);
        $html ='<table width="100%" border="0">
                    <tr><td align="center"><font style="font-size:12px; font-weight:bold; text-decoration: underline;">SURAT KETERANGAN SAKIT</font></td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(10);
        $html ='<table width="100%" border="0" >
                    <tr><td align="justify"><font style="font-size:10px;">Yang bertanda tangan dibawah ini, Bidan / Dokter / Petugas kesehatan, PUSAT KESEHATAN
                                            PONDOK PESANTREN (PUSKESTREN) '.$idt[nmSekolah].' , menerangkan bahwa :</font></td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(10);
        $html ='<table width="100%" border="0" style="font-size:10px;" cellpadding="3">
                    <tr><td width="100px">No. Induk Santri</td><td width="10px">:</td><td>'.$siswa[nisSiswa].'</td></tr>
                    <tr><td>Nama</td><td>:</td><td>'.$siswa[nmSiswa].'</td></tr>
                    <tr><td>Kelas</td><td>:</td><td>'.$siswa[nmKelas].'</td></tr>
                    <tr><td>Kamar</td><td>:</td><td>'.$siswa[namaKamar].'</td></tr>
                    <tr><td>Keluhan</td><td>:</td><td>'.$kesehatan['nmSakit'].'</td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(10);
        $html ='<table width="100%" border="0" style="font-size:10px;">
                    <tr><td align="justify">Berhubung dengan sakit/keluhannya perlu diberi istirahat selama ........... hari Dari tanggal .................... s/d tanggal ....................</td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(10);
        $html ='<table width="100%" border="0" style="font-size:10px;">
                    <tr><td align="right">'.$idt['kabupaten'].', '.tgl_raport($kesehatan['tanggal']).'</td></tr>
                    <tr><td align="right"> </td></tr>
                    <tr><td align="right"> </td></tr>
                    <tr><td align="right"> </td></tr>
                    <tr><td align="right"> </td></tr>
                    <tr><td align="right"> </td></tr>
                    <tr><td align="right"><b>'.$users['nama_lengkap'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'R');

        $file = 'Data Pegawai NIP '.$pegawai['nipPegawai'].' Nama '.$pegawai['namaPegawai'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }
?>