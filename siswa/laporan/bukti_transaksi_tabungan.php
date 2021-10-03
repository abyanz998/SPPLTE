<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/variabel_default.php";
    include "../../config/setting_barcode.php";
    include "../../config/barcode.php";
    include "../../config/rupiah.php";
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

        $lokasi = '../../'.$lokasi_barcode_tabungan_siswa;
        $value = 'TAB-'.date('dmY',strtotime($_GET['tgl'])).sprintf("%011s", $_GET['nis']);
        $link_barcode = barcode($lokasi,$value,$codetype,$print,$size);


        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(8,8,8,8);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle($siswa['nmSiswa']);
        $pdf->SetSubject($siswa['nmSiswa']);
        //isi pdf

        //header
        $html ='<table width="100%" border="0">
                    <tr>
                        <td valign="top" width="390px">
                            <table border="0">
                                <tr><td style="font-size:16px; font-weight:bold;">'.$idt['nmSekolah'].'</td></tr>
                                <tr><td style="font-size:1px; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:8px; font-weight:bold;">'.$unit.'</td></tr>
                                <tr><td style="font-size:15px; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:8px;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].'</td></tr>
                                <tr><td style="font-size:8px;">'.$idt['noTelp'].'</td></tr>
                                <tr><td style="font-size:3px; font-weight:bold;"></td></tr>
                            </table>
                        </td>
                        <td width="150px" align="left">
                            <table border="0">
                                <tr><td style="font-size:12px; font-weight:bold;">&nbsp;Bukti Transaksi</td></tr>
                                <tr><td style="font-size:3px; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:8px; font-weight:bold;">&nbsp;&nbsp;Unit Sekolah : '.$siswa['singkatanUnit'].'</td></tr>
                                <tr><td style="font-size:2px; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:8px; font-weight:bold;"> <img src="'.$link_barcode.'" width="150px" height="20px">&nbsp;&nbsp;'.$value.'</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <hr>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(1.5);
        //bagian informasi
        $html='<table border="0">
                        <tr>
                            <td width="100px"><font style="font-size:8px;">NIS</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="175px" style="font-size:8px;">'.$siswa['nisSiswa'].'</td>
                            
                            <td width="100px"><font style="font-size:8px;">Tanggal Transaksi</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="135px" style="font-size:8px;">'.tgl_raport($_GET['tgl']).'</td>
                        </tr>
                        <tr>
                            <td width="100px"><font style="font-size:8px;">Nama</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="175px" style="font-size:8px;">'.$siswa['nmSiswa'].'</td>
                            
                            <td width="100px"><font style="font-size:8px;">Tahun Ajaran</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="135px" style="font-size:8px;">'.$TA['nmTahunAjaran'].'</td>
                        </tr>
                        <tr>
                            <td width="100px"><font style="font-size:8px;">Kelas</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="135px" style="font-size:8px;">'.$siswa['nmKelas'].'</td>
                            
                            <td width="100px"><font style="font-size:8px;"></font></td>
                            <td width="10px" style="font-size:8px;"></td>
                            <td width="135px" style="font-size:8px;"></td>
                        </tr>
                    </table><hr>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        //bagian isi
        $html='<div></div><table style="font-family: Arial, Helvetica, sans-serif; font-size:8px" border="0" cellpadding="3">
                    <thead>
                        <tr align="center">
                            <th width="30px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">No.</th>
                            <th width="140px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Kode</th>
                            <th width="190px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Catatan</th>
                            <th width="90px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Debit</th>
                            <th width="90px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Kredit</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $tot_DEBIT = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as total FROM tabungan_siswa WHERE stdel='0' AND kode='SETORAN' AND siswa='$siswa[idSiswa]' AND tahunAjaran='$_GET[thn_ajar]' AND tgl <= '$_GET[tgl]'"));
                    $tot_KREDIT = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as total FROM tabungan_siswa WHERE stdel='0' AND kode='PENARIKAN' AND siswa='$siswa[idSiswa]' AND tahunAjaran='$_GET[thn_ajar]' AND tgl <= '$_GET[tgl]'"));
                    $tampil = mysqli_query($koneksi,"SELECT * FROM tabungan_siswa WHERE stdel='0' AND siswa='$siswa[idSiswa]' AND tahunAjaran='$_GET[thn_ajar]' AND tgl='$_GET[tgl]' ORDER BY idTabungan ASC");
                    $no = 1;
                    $total_debit = 0; $total_kredit = 0;
                    while($r=mysqli_fetch_array($tampil)){
                        $debit = 0;
                        $kredit = 0;
                        if ($r['kode'] == 'SETORAN'){
                            $kode='DEB';
                            $debit=$r['nominal'];
                            $kredit=0;
                            $saldo = $saldo + $debit;
                        }
                        if ($r['kode'] == 'PENARIKAN'){
                            $kode='KRD';
                            $debit=0;
                            $kredit=$r['nominal'];
                            $saldo = $saldo - $kredit;
                        }
                        $html.='<tr>
                                    <td width="30px" style="border-bottom:1px solid black;">'.$no++.'</td>
                                    <td width="140px" style="border-bottom:1px solid black;">'.$kode.'</td>
                                    <td width="190px" style="border-bottom:1px solid black;">'.$r['catatan'].'</td>
                                    <td width="90px" style="border-bottom:1px solid black;">
                                        <table>
                                            <tr>
                                                <td align="left">Rp.</td>
                                                <td align="right">'.rupiah($debit).'</td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="90px" style="border-bottom:1px solid black;">
                                        <table>
                                            <tr>
                                                <td align="left">Rp.</td>
                                                <td align="right">'.rupiah($kredit).'</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>';
                        $total_debit = $total_debit + $debit;
                        $total_kredit = $total_kredit + $kredit;
                    }

            $html.='</tbody>
                    <tfoot>
                        <tr>
                            <th rowspan="4" colspan="2" width="170px" style="background-color:white;">
                               <table align="center" cellpadding="4">
                                    <tr><td>'.$idt['kabupaten'].', '.tgl_raport($_GET['tgl']).'</td></tr>
                                    <tr><td>Bendahara</td></tr>
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                                    <tr><td><font style="font-weight:bold;">'.$idt['nmBendahara'].'</font><br>Nip. '.$idt['nipBendahara'].'</td></tr>
                               </table>
                            </th>
                            <th align="left" width="190px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">Total Transaksi</th>
                            <th align="left" width="90px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">
                                <table>
                                    <tr>
                                        <td align="left">Rp.</td>
                                        <td align="right">'.rupiah($total_debit).'</td>
                                    </tr>
                                </table>
                            </th>
                            <th align="left" width="90px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">
                                <table>
                                    <tr>
                                        <td align="left">Rp.</td>
                                        <td align="right">'.rupiah($total_kredit).'</td>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                        <tr style="font-weight:bold">
                            <th align="left" width="280" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">Saldo Sekarang</th>
                            <th align="left" width="90" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">
                                <table>
                                    <tr>
                                        <td align="left">Rp.</td>
                                        <td align="right">'.rupiah($tot_DEBIT['total'] - $tot_KREDIT['total']).'</td>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                    </tfoot>
                </table>';
        //add halaman
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'R');

        $file = 'Bukti Transaksi Tabungan Nama '.$siswa['nmSiswa'].' Nis '.$siswa['nisSiswa'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }
?>