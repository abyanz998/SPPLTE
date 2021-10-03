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

        $data_detail = mysqli_fetch_array(mysqli_query($koneksi,"
                                                                SELECT hutang_setting_detail.*, hutang_setting.idUnit,hutang_setting.idTahunAjaran, pegawai.namaPegawai, jabatan_pegawai.namaJabatan, unit_sekolah.singkatanUnit, tahun_ajaran.nmTahunAjaran
                                                                FROM hutang_setting_detail 
                                                                LEFT JOIN pegawai ON hutang_setting_detail.idPegawai = pegawai.idPegawai 
                                                                LEFT JOIN jabatan_pegawai ON hutang_setting_detail.idJabatan = jabatan_pegawai.idJabatan 
                                                                LEFT JOIN hutang_setting ON hutang_setting_detail.idSettingHutang = hutang_setting.idSettingHutang
                                                                LEFT JOIN tahun_ajaran ON hutang_setting.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                                LEFT JOIN unit_sekolah ON hutang_setting.idUnit = unit_sekolah.idUnit 
                                                                WHERE hutang_setting_detail.stdel='0' AND hutang_setting_detail.noRefrensi='$_GET[noref]' AND hutang_setting.idTahunAjaran='$_GET[thn_ajar]'"));

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
        $pdf->SetTitle($data_detail['namaPegawai']);
        $pdf->SetSubject($data_detail['namaPegawai']);
        //isi pdf

        //header
        $html ='<table width="100%" border="0">
                    <tr>
                        <td valign="top" width="360px">
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
                        <td width="180px" align="left">
                            <table border="0">
                                <tr><td style="font-size:12px; font-weight:bold;" align="center">Bukti Pembayaran Hutang</td></tr>
                                <tr><td style="font-size:3px; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:8px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit Sekolah : '.$data_detail['singkatanUnit'].'</td></tr>
                                <tr><td style="font-size:2px; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:8px; font-weight:bold;"> <img src="'.$link_barcode.'" width="150px" height="20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$value.'</td></tr>
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
                            <td width="20px"><font style="font-size:8px;"></font></td>

                            <td width="90px"><font style="font-size:8px;">Periode Hutang</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="220px" style="font-size:8px;">'.$data_detail[nmTahunAjaran].'</td>
                            
                            <td width="90px"><font style="font-size:8px;">Tanggal Hutang</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="100px" style="font-size:8px;">'.tgl_raport($data_detail[tanggal]).'</td>
                        </tr>
                        <tr>
                            <td><font style="font-size:8px;"></font></td>

                            <td><font style="font-size:8px;">Nama Kreditur</font></td>
                            <td style="font-size:8px;">:</td>
                            <td style="font-size:8px;">'.$data_detail[namaPegawai].'</td>
                            
                            <td><font style="font-size:8px;">Nominal Hutang</font></td>
                            <td style="font-size:8px;">:</td>
                            <td style="font-size:8px;">'.buatRp($data_detail[nominal]).'</td>
                        </tr>
                        <tr>
                            <td><font style="font-size:8px;"></font></td>

                            <td><font style="font-size:8px;">Posisi</font></td>
                            <td style="font-size:8px;">:</td>
                            <td style="font-size:8px;">'.$data_detail[namaJabatan].'</td>
                            
                            <td><font style="font-size:8px;">Dicicil</font></td>
                            <td style="font-size:8px;">:</td>
                            <td style="font-size:8px;">'.$data_detail[jumlahCicil].' Kali</td>
                        </tr>
                        <tr>
                            <td><font style="font-size:8px;"></font></td>

                            <td><font style="font-size:8px;">No. Ref Hutang</font></td>
                            <td style="font-size:8px;">:</td>
                            <td style="font-size:8px;">'.$data_detail[noRefrensi].'</td>
                            
                            <td><font style="font-size:8px;">Nominal per Cicilan</font></td>
                            <td style="font-size:8px;">:</td>
                            <td style="font-size:8px;">'.buatRp($data_detail[angsuran]).'</td>
                        </tr>
                        
                    </table><hr>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        //bagian isi
        $html='<div></div><table style="font-family: Arial, Helvetica, sans-serif; font-size:8px" border="0" cellpadding="3">
                    <thead>
                        <tr align="center">
                            <th width="30px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">No.</th>
                            <th width="50px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Tanggal</th>
                            <th width="130px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Akun Kas</th>
                            <th width="90px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Cicilan Ke</th>
                            <th width="90px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Nominal</th>
                            <th width="150px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $total_bayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as total_bayar FROM hutang_bayar WHERE hutang_bayar.idDetailHutang='$data_detail[idDetailHutang]' AND hutang_bayar.stdel='0' AND hutang_bayar.tanggalBayar <='$_GET[tgl]' AND keterangan='Lunas' ORDER BY idBayarHutang ASC"));

                    $tampil = mysqli_query($koneksi,"SELECT hutang_bayar.*, akun_biaya.kodeAkun, akun_biaya.keterangan as ket_akun FROM hutang_bayar LEFT JOIN akun_biaya ON hutang_bayar.idAkunKas = akun_biaya.idAkun WHERE hutang_bayar.idDetailHutang='$data_detail[idDetailHutang]' AND hutang_bayar.stdel='0' AND hutang_bayar.tanggalBayar='$_GET[tgl]' AND hutang_bayar.keterangan='Lunas' ORDER BY idBayarHutang ASC");
                    $no = 1;
                    while($r=mysqli_fetch_array($tampil)){
                        
                        $html.='<tr align="center">
                                    <td width="30px" style="border-bottom:1px solid black;">'.$no++.'</td>
                                    <td width="50px" style="border-bottom:1px solid black;">'.date('d/m/Y',strtotime($r['tanggalBayar'])).'</td>
                                    <td width="130px" style="border-bottom:1px solid black;">'.$r['kodeAkun'].' - '.$r['ket_akun'].'</td>
                                    <td width="90px" style="border-bottom:1px solid black;">'.$r['cicilan'].'</td>
                                    <td width="90px" style="border-bottom:1px solid black;">'.buatRp($r['nominal']).'</td>
                                    <td width="150px" style="border-bottom:1px solid black;">'.$r['keterangan'].'</td>
                                </tr>';
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
                            <th align="left" width="127px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">Sisa Hutang</th>
                            <th align="center" width="90px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">
                                <table>
                                    <tr>
                                        <td align="center">'.buatRp($data_detail[nominal] - $total_bayar[total_bayar]).'</td>
                                    </tr>
                                </table>
                            </th>
                            <th align="center" width="152px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;"></th>
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