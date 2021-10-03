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
        $pegawai = mysqli_fetch_array(mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.namaUnit , jabatan_pegawai.namaJabatan FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.idPegawai='$_GET[id]'"));
        if (empty($pegawai['fotoPegawai'])) { $fotoPegawai = '../../'.$lokasi_default_fotoPegawai; }else{ $fotoPegawai = '../../'.$lokasi_penyimpanan_fotoPegawai.$pegawai['fotoPegawai']; }
        
        if ($pegawai['tglLahirPegawai'] == '0000-00-00' OR $pegawai['tglLahirPegawai'] == ''){
            $ttl = strtoupper($pegawai['tempatLahirPegawai']);
        }else{
            $ttl = strtoupper($pegawai['tempatLahirPegawai'].', '.tgl_view($pegawai['tglLahirPegawai']));
        }
    
        $lokasi = '../../'.$lokasi_barcode_pagawai;
        $value = 'PEG-'.sprintf("%018s", $pegawai['nipPegawai']);
        $link_barcode = barcode($lokasi,$value,$codetype,$print,$size);

        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(3,3,3,3);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle($pegawai['namaPegawai']);
        $pdf->SetSubject($pegawai['namaPegawai']);
        //isi pdf
        $html ='<table border="1" width="50%" style="padding:5px">
                    <tr>
                        <td>
                            <table border="0" style="padding:1px" width="98%">
                                <tr><td align="center" style="font-size:11px"><b>'.$idt['nmSekolah'].'</b></td></tr>
                                <tr><td align="center" style="font-size:7px"><i>'.$idt['alamat'].'</i></td></tr>
                                <tr><td align="center" style="font-size:7px"><i>Telp.'.$idt['noTelp'].'</i></td></tr>
                                <tr><td align="center" style="font-size:7px"><hr></td></tr>
                            </table>
                            <br>
                            <table border="0" width="98%" style="font-weight: bold;">
                                <tr>
                                    <td align="left" width="60px"><img src="'.$fotoPegawai.'"  width="60px" height="63px"></td>
                                    <td align="left" style="font-size:7.5px;" width="206px">
                                        <table border="0" cellpadding="2">
                                            <tr>
                                                <td width="85px">NIP</td>
                                                <td width="7px">:</td>
                                                <td width="150px">'.$pegawai['nipPegawai'].'</td>
                                            </tr>
                                            <tr>
                                                <td>Nama</td>
                                                <td>:</td>
                                                <td>'.$pegawai['namaPegawai'].'</td>
                                            </tr>
                                            <tr>
                                                <td>Tempat, Tanggal Lahir</td>
                                                <td>:</td>
                                                <td>'.$ttl.'</td>
                                            </tr>
                                            <tr>
                                                <td>Unit Sekolah</td>
                                                <td>:</td>
                                                <td>'.$pegawai['namaUnit'].'</td>
                                            </tr>
                                            <tr>
                                                <td>Jabatan</td>
                                                <td>:</td>
                                                <td>'.$pegawai['namaJabatan'].'</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <br><br>
                            <table border="0" width="98%">
                                <tr>
                                    <td align="center" style="font-size:9px"><img src="'.$link_barcode.'" width="190px" height="30px" /><br>'.date('d m Y').'</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>';
        
        //add halaman
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'R');

        $file = 'Data Pegawai NIP '.$pegawai['nipPegawai'].' Nama '.$pegawai['namaPegawai'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }
?>