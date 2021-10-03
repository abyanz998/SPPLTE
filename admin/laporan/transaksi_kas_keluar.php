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
        $TA = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$_GET[thn_ajar]'"));
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

        $kas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT kas.*, akun_biaya.keterangan as ketAkun, unit_sekolah.singkatanUnit FROM kas 
                                         LEFT JOIN akun_biaya ON kas.idAkunKas = akun_biaya.idAkun
                                         LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE noRefrensi='$_GET[noref]' GROUP BY noRefrensi"));

        $tampil = mysqli_query($koneksi,"SELECT kas.*, 
                                                akun_biaya.keterangan as ketAkun,
                                                unit_sekolah.singkatanUnit,
                                                pajak.besaranPajak,
                                                unit_pos.nmUnitPos
                                         FROM kas 
                                         LEFT JOIN akun_biaya ON kas.idAkunKas = akun_biaya.idAkun
                                         LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                         LEFT JOIN pajak ON kas.idPajak = pajak.idPajak
                                         LEFT JOIN unit_pos ON kas.idUnitPos = unit_pos.idUnitPos
                                         WHERE noRefrensi='$kas[noRefrensi]'");

       
        $lokasi = '../../'.$lokasi_barcode_tansaksi_kas_keluar;
        $value = $_GET['noref'];
        $link_barcode = barcode($lokasi,$value,$codetype,$print,$size);


        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(8,8,8,8);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle('Bukti Pengeluaran '.$kas['noRefrensi']);
        //isi pdf

        //header
        $html ='<table width="100%" border="0">
                    <tr>
                        <td width="48px" align="left">
                            <img src="../../'.$lokasi_penyimpanan_logo.$idt['logo_kiri'].'" height="40px">
                        </td>
                        <td valign="top" width="360px">
                            <table border="0">
                                <tr><td style="font-size:16pt; font-weight:bold;">'.$idt['nmSekolah'].'</td></tr>
                                <tr><td style="font-size:1pt;"></td></tr>
                                <tr><td style="font-size:8pt; font-weight:bold;">'.$unit.'</td></tr>
                                <tr><td style="font-size:15pt; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:8pt;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp: '.$idt['noTelp'].'</td></tr>
                                <tr><td style="font-size:3pt; font-weight:bold;"></td></tr>
                            </table>
                        </td>
                        <td width="120" align="left">
                            <table border="0">
                                <tr><td style="font-size:10pt; font-weight:bold;" align="center">Bukti Kas Keluar</td></tr>
                                <tr><td style="font-size:3pt;"></td></tr>
                                <tr><td style="font-size:8pt; font-weight:bold;">&nbsp;&nbsp;Unit Sekolah : '.$kas['singkatanUnit'].'</td></tr>
                                <tr><td style="font-size:2pt;"></td></tr>
                                <tr><td style="font-size:6pt; font-weight:bold;"> <img src="'.$link_barcode.'" width="110px" height="20px">&nbsp;&nbsp;'.$value.'</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <hr>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(1.5);

        //bagian isi
        $html = '<table style="font-size: 8pt" cellpadding="3" border="0">
                    <tr>
                        <td>
                            <table style="font-size: 8pt" border="0" cellpadding="1">
                                <tr>
                                    <td width="90px">No. Refrensi</td>
                                    <td width="10px">:</td>
                                    <td width="200px">'.$kas['noRefrensi'].'</td>

                                    <td width="90px">Tanggal Pengeluaran</td>
                                    <td width="10px">:</td>
                                    <td width="135px">'.tgl_raport($kas['tanggal']).'</td>
                                </tr>
                                <tr>
                                    <td>Akun Kas</td>
                                    <td>:</td>
                                    <td>'.$kas['ketAkun'].' '.$kas['singkatanUnit'].'</td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td style="font-size:9pt; font-weight:bold"><hr><br> Dengan rincian Pengeluaran sebagai berikut:</td></tr>
                    <tr>
                        <td>
                            <table style="font-size:8pt" border="0" cellpadding="2">
                                <thead>
                                    <tr align="left">
                                        <th width="50px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">No.</th>
                                        <th width="208px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Akun</th>
                                        <th width="130px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Keterangan</th>
                                        <th width="20px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;"></th>
                                        <th width="123px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Jumlah Pengeluaran</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                
                                    $no = 1;
                                    while ($r = mysqli_fetch_array($tampil)) {
                                        $html.='<tr>
                                                    <td align="left">'.$no++.'</td>
                                                    <td>'.$r['ketAkun'].' '.$r['singkatanUnit'].'</td>
                                                    <td align="left">'.$r['keterangan'].'</td>
                                                    <td align="left">Rp.</td>
                                                    <td align="right">'.rupiah($r['total']).'</td>
                                                </tr>';
                                        $total_pembayaran=$total_pembayaran+$r['total'];
                                    }
                                    
            $html.='            </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding="3">
                                <tr >
                                    <th width="50px" style="background-color:white; border-top: 1px solid black; font-weight:bold; "></th>
                                    <th width="208px" align="right" style="background-color:white; border-top: 1px solid black; font-weight:bold;"></th>
                                    <th align="left" width="130px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black; border-top: 1px solid black;">Total Pembayaran</th>
                                    <th align="center" width="20px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black; border-top: 1px solid black;">Rp.</th>
                                    <th align="right" width="123px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black; border-top: 1px solid black;">'.rupiah($total_pembayaran).'</th>
                                </tr>
                                <tr>
                                    <th style="background-color:white; font-weight:bold;">Terbilang</th>
                                    <th align="left" colspan="3" style="background-color:white; font-weight:bold;">'.ucwords(terbilang($total_pembayaran)).'</th>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(7);
        $html ='<table width="100%" border="1" style="font-size:8pt" cellpadding="2" align="center">
                    <tr>
                        <td width="110px">Disetujui</td>
                        <td width="110px">Kasir</td>
                        <td width="110px">Penerima</td>
                        <td width="212px">Catatan</td>
                    </tr>
                    <tr>
                        <td><br><br><br><br></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');

        $file = 'Bukti Pengeluaran '.$kas['noRefrensi'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }
?>