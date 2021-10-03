<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/variabel_default.php";
    include "../../config/setting_barcode.php";
    include "../../config/barcode.php";
    include "../../config/rupiah.php";
    include "../../config/library.php";
    require_once('../../plugins/tcpdf/tcpdf.php');

   
    if (isset($_SESSION['idUsers'])){
        $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
        $users = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM users WHERE idUsers='$_SESSION[idUsers]'"));
        $TA = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$_GET[thn_ajar]' AND stdel='0'"));
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

        $skeluar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT izin_keluar.*,siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_keluar LEFT JOIN siswa ON izin_keluar.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE izin_keluar.idKeluar='$_GET[id]'"));
      
        //konfigurasi TCPDF
        $pdf= new TCPDF('P', 'mm', array('170','75'), true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(5,5,5,5);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle('Surat Izin Keluar Pesantren Thermal '.$skeluar['nisSiswa'].' - '.$skeluar['nmSiswa']);
        //isi pdf
        //header
        $html ='<table width="100%" border="0" align="center">
                    <tr><td style="font-size:12pt; font-weight:bold;">'.$idt['nmSekolah'].'</td></tr>
                    <tr><td style="font-size:1pt;"></td></tr>
                    <tr><td style="font-size:8pt; font-weight:bold;">'.$unit.'</td></tr>
                    <tr><td style="font-size:8pt; font-weight:bold;"></td></tr>
                    <tr><td style="font-size:7pt;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].'<br> Telp: '.$idt['noTelp'].'</td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(1.5);

        $html ='<hr><table width="100%" border="0" cellpadding="2">
                    <tr>
                        <td align="center" style="font-size:12pt; font-weight:bold;">
                            Surat Izin <br> Keluar Pesantren
                        </td>
                    </tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');

        $html ='<table width="100%" border="0" cellpadding="2" style="font-size:9pt">
                    <tr><td align="center">Nis</td></tr>
                    <tr><td align="center" style="font-size:10pt"><strong>'.$skeluar['nisSiswa'].'</strong></td></tr>
                    <tr><td align="center">Nama</td></tr>
                    <tr><td align="center" style="font-size:10pt"><strong>'.$skeluar['nmSiswa'].'</strong></td></tr>
                    <tr><td align="center">Kelas</td></tr>
                    <tr><td align="center" style="font-size:10pt"><strong>'.$skeluar['nmKelas'].'</strong></td></tr>
                    <tr><td align="center">Kamar</td></tr>
                    <tr><td align="center" style="font-size:10pt"><strong>'.$skeluar['namaKamar'].'</strong></td></tr>
                    <tr><td align="center">Tanggal</td></tr>
                    <tr><td align="center" style="font-size:10pt"><strong>'.tgl_raport($skeluar['tanggal']).'</strong></td></tr>
                    <tr><td align="center">Jam Izin</td></tr>
                    <tr><td align="center" style="font-size:12pt"><strong>'.$skeluar['jamKeluar'] .' : '.$skeluar['jamKembali'] .'</strong></td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');

       

        $html = '<table width="100%" border="0" style="font-size:8pt;" align="center">
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td>'.$idt['kabupaten'].', '.tgl_raport(date('Y-m-d')).'</td></tr>
                    <tr><td>Pemberi Izin</td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td style="font-weight:bold">'.$users['nama_lengkap'].'</td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td>Wajib di kembalikan ke pemberi izin <br>sebelum batas waktu berakhir</td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
       
        $file = 'Bukti Pembayaran Thermal'.date('d-m-Y').' Nama '.$siswa['nmSiswa'].' Nis '.$siswa['nisSiswa'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }
?>