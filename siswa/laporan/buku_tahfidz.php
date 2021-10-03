<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/variabel_default.php";
    include "../../config/setting_barcode.php";
    include "../../config/barcode.php";
    require_once('../../plugins/tcpdf/tcpdf.php');

    if (isset($_SESSION['idUsers'])){

        $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
        $TA = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$_GET[thn_ajar]'"));
        $siswa = mysqli_fetch_array(mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.nisSiswa='$_GET[nis]' AND siswa.stdel='0'"));
        
        $unitSekolah = mysqli_query($koneksi, "SELECT * FROM unit_sekolah WHERE status='1' AND stdel='0'");
        $no=1;
        while($r=mysqli_fetch_array($unitSekolah)){
            if ($no == 1){
                $unit = $r['singkatanUnit'];
            }else{
                $unit = $unit.' '.$r['singkatanUnit'];
            }
            $no++;
        }

        $lokasi = '../../'.$lokasi_barcode_tahfidz_siswa;
        $value = 'TAHFIDZ'.$siswa['nisSiswa'];
        $link_barcode = barcode($lokasi,$value,$codetype,$print,$size);


        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(10,10,10,10);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle($siswa['nmSiswa']);
        $pdf->SetSubject($siswa['nmSiswa']);
        //isi pdf

        //header
        $html ='<table width="100%" border="0">
                    <tr>
                        <td width="48px" align="left">
                            <img src="../../'.$lokasi_penyimpanan_logo.$idt['logo_kiri'].'" height="40px">
                        </td>
                        <td valign="top" width="360px">
                            <font style="font-size:16px; font-weight:bold;">'.$idt['nmSekolah'].'</font>
                            <br>
                            <font style="font-size:10px; font-weight:bold;">'.$unit.'</font>
                            <br><br>
                            <font style="font-size:8px;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</font>
                        </td>
                        <td width="120px" align="left">
                            <table border="0">
                                <tr><td style="font-size:12px; font-weight:bold;">&nbsp;&nbsp;Bukti Tahfidz</td></tr>
                                <tr><td style="font-size:3px; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:8px; font-weight:bold;">&nbsp;&nbsp;&nbsp;Unit Sekolah : '.$siswa['singkatanUnit'].'</td></tr>
                                <tr><td style="font-size:2px; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:7px; font-weight:bold;"> <img src="'.$link_barcode.'" width="180px" height="25px">&nbsp;&nbsp;&nbsp;&nbsp;'.$value.'</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <hr>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(1.5);
        //bagian informasi
        $html='<table border="0" style="margin-top:1000px">
                        <tr>
                            <td width="100px"><font style="font-size:8px;">NIS</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="175px" style="font-size:8px;">'.$siswa['nisSiswa'].'</td>
                            
                            <td width="100px"><font style="font-size:8px;">Kelas</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="135px" style="font-size:8px;">'.$siswa['nmKelas'].'</td>
                        </tr>
                        <tr>
                            <td width="100px"><font style="font-size:8px;">Nama</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="175px" style="font-size:8px;">'.$siswa['nmSiswa'].'</td>
                            
                            <td width="100px"><font style="font-size:8px;">Tahun Ajaran</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="135px" style="font-size:8px;">'.$TA['nmTahunAjaran'].'</td>
                        </tr>
                    </table><hr>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        //bagian isi
        $html='<div></div><table style="font-family: Arial, Helvetica, sans-serif; font-size:8px" border="0" cellpadding="3">
                    <thead>
                        <tr>
                            <th width="20px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">No.</th>
                            <th width="70px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Tanggal</th>
                            <th width="90px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Jumlah Hafalan Baru</th>
                            <th width="130px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Keterangan Hafalan Baru</th>
                            <th width="100px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Murojaah</th>
                            <th width="120px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Murojaah Hafalan Baru</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $tampil = mysqli_query($koneksi,"SELECT * FROM siswa_tahfidz WHERE siswa = '$siswa[idSiswa]' AND tahunAjaran='$_GET[thn_ajar]' AND stdel='0'");
                    $no = 1;
                    $total_hafalan = 0;
                    while($r=mysqli_fetch_array($tampil)){
                        $html.='<tr>
                                    <td width="20px" style="border-bottom:1px solid black;">'.$no++.'</td>
                                    <td width="70px" style="border-bottom:1px solid black;">'.tgl_raport($r['tanggal']).'</td>
                                    <td width="90px" style="border-bottom:1px solid black;">'.$r['jumlahHafalan'].'</td>
                                    <td width="130px" style="border-bottom:1px solid black;">'.$r['keteranganHafalan'].'</td>
                                    <td width="100px" style="border-bottom:1px solid black;">'.$r['murojaah'].'</td>
                                    <td width="120px" style="border-bottom:1px solid black;">'.$r['murojaahHafalan'].'</td>
                                </tr>';
                        $total_hafalan=$total_hafalan + $r['jumlahHafalan'];
                    }

            $html.='</tbody>
                    <tfoot>
                        <tr style="font-weight:bold">
                            <th colspan="2" width="90px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">Total Halaman</th>
                            <th colspan="4" align="left" width="440px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">'.$total_hafalan.' Halaman</th>
                        </tr>
                    </tfoot>
                </table>';
        //add halaman
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'R');

        $file = 'Buku Tahfidz Siswa '.$siswa['nisSiswa'].' Nama '.$siswa['nmSiswa'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }
?>