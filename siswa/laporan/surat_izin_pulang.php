<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/variabel_default.php";
    include "../../config/library.php";
    include "../../config/setting_barcode.php";
    require_once('../../plugins/tcpdf/tcpdf.php');

    if (isset($_SESSION['idUsers'])){
        $idUsers=$_SESSION['idUsers'];
        $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
        $users = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM users WHERE idUsers='$idUsers'"));
        $sPulang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT izin_pulang.*,siswa.*, kelas_siswa.nmKelas, kamar.namaKamar FROM izin_pulang LEFT JOIN siswa ON izin_pulang.idSiswa=siswa.idSiswa LEFT JOIN kelas_siswa ON siswa.kelasSiswa=kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa=kamar.idKamar WHERE izin_pulang.idPulang='$_GET[id]'"));

        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4',true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(20,10,20,10);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle($sPulang['nisSiswa'].' - '.$sPulang['nmSiswa']);
        //isi pdf
        //header
        $html ='<table width="100%" border="0">
                    <tr>
                        <td width="75px" align="left">
                            <img src="../../'.$lokasi_penyimpanan_logo.$idt['logo_kiri'].'" height="70px">
                        </td>
                        <td  width="398px">
                            <table border="0">
                                <tr><td align="center"><font style="font-size:16px; font-weight:bold; font-family:aefurat">معهد روضة القرآن الإسلامي</font></td></tr>
                                <tr><td align="center"><font style="font-size:14px; font-weight:bold;">PUSAT KEAMANAN '.strtoupper($idt[nmSekolah]).' KOTA '.strtoupper($idt[kabupaten]).'</font></td></tr>
                                <tr><td align="center"><font style="font-size:11px; font-family:courier">(Islamic Boading School)</font></td></tr>
                            </table>
                        </td>
                    </tr>
                     <tr>
                        <td align="center" colspan="2" style="border-top:1px solid black; border-bottom:1px solid black;">
                            <font style="font-size:9px;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</font>
                        </td>
                    </tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(8);
        $html ='<table width="100%" border="0">
                    <tr><td align="center"><font style="font-size:12px; font-weight:bold; text-decoration: underline;">SURAT PERIZINAN PULANG</font></td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(10);
        $html ='<table width="100%" border="0" >
                    <tr><td align="justify"><font style="font-size:10px;">Yang bertanda tangan di bawah ini kami Pusat Keamanan '.ucwords(strtolower($idt['nmSekolah'])).' '.ucwords(strtolower($idt['kabupaten'])).', menerangkan bahwa :</font></td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(10);
        $html ='<table width="100%" border="0" style="font-size:10px; font-weight:bold;" cellpadding="3">
                    <tr><td width="100px">Nomor Induk Santri</td><td width="10px">:</td><td>'.$sPulang['nisSiswa'].'</td></tr>
                    <tr><td>Nama</td><td>:</td><td>'.$sPulang['nmSiswa'].'</td></tr>
                    <tr><td>Kelas</td><td>:</td><td>'.$sPulang['nmKelas'].'</td></tr>
                    <tr><td>Kamar</td><td>:</td><td>'.$sPulang['namaKamar'].'</td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(10);
        $html ='<table width="100%" border="0" style="font-size:10px;">
                    <tr><td align="justify">Untuk kembali kerumah dalam jangka waktu '.$sPulang['waktuIzin'].' hari, dari tanggal '.tgl_raport($sPulang['tanggal']).' dengan keterangan '.$sPulang['keterangan'].'</td></tr>
                    <tr><td></td></tr>
                    <tr><td align="justify">Demikian surat izin ini kami keluarkan, untuk dapat di gunakan sebagai mana <strong>mestinya</strong>.</td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(10);
        $html ='<table width="100%" border="0" style="font-size:10px;">
                    <tr><td align="center">'.$idt['kabupaten'].', '.tgl_raport($tanggal_sekarang).'</td></tr>
                    <tr><td align="center">Pusat Keamanan Pondok Pesantren</td></tr>
                    <tr><td align="center">Pemberi Izin</td></tr>
                    <tr><td align="center"> </td></tr>
                    <tr><td align="center"> </td></tr>
                    <tr><td align="center"> </td></tr>
                    <tr><td align="center"> </td></tr>
                    <tr><td align="center"><b>'.$users['nama_lengkap'].'</b></td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(20);
        $html ='<table width="100%" border="0" style="font-size:10px;">
                    <tr><td colspan="3" align="justify">Cap Legalisir</td></tr>
                    <tr><td width="3%">1.</td><td width="35%">Dewan Pembimbing Asrama</td><td width="62%">(.....................)</td></tr>
                    <tr><td>2.</td><td>Dewan Pengasuhan</td><td>(.....................)</td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(35);
        $html ='<table width="100%" border="0" style="font-size:8px;">
                    <tr><td colspan="3" align="justify">Tembusan</td></tr>
                    <tr><td width="3%"></td><td width="3%">1.</td><td width="94%">Pengasuh '.ucwords(strtolower($idt['nmSekolah'])).' Kota '.ucwords(strtolower($idt['kabupaten'])).'</td></tr>
                    <tr><td width="3%"></td><td width="3%">2.</td><td width="94%">Wali Kelas</td></tr>
                    <tr><td width="3%"></td><td width="3%">3.</td><td width="94%">Wali Santri</td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');


        $file = 'Surat Izin Pulang '.$sPulang['nisSiswa'].' Nama '.$sPulang['nmSiswa'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }
?>

