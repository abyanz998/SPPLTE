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
                                                                WHERE hutang_setting_detail.stdel='0' AND hutang_setting_detail.noRefrensi='$_GET[noref]'"));

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

        $html ='<table width="100%" border="0">
                    <tr>
                        <td width="48px" align="left">
                            <img src="../../'.$lokasi_penyimpanan_logo.$idt['logo_kiri'].'" height="40px">
                        </td>
                        <td valign="top" width="303px">
                            <font style="font-size:16px; font-weight:bold;">'.$idt['nmSekolah'].'</font>
                            <br>
                            <font style="font-size:10px; font-weight:bold;">'.$unit.'</font>
                            <br><br>
                            <font style="font-size:8px;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</font>
                        </td>
                        <td width="190px" align="center">
                            <table border="0">
                                <tr><td style="font-size:12px; font-weight:bold;">Pembayaran Hutang</td></tr>
                                <tr><td style="font-size:3px; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:8px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit Sekolah : '.$data_detail['singkatanUnit'].'</td></tr>
                                <tr><td style="font-size:2px; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:7px; font-weight:bold;"> <img src="'.$link_barcode.'" width="180px" height="20px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$value.'</td></tr>
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
                            <th width="150px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Keterangan</th>
                            <th width="90px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>';
                    $total_bayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(nominal) as total_bayar FROM hutang_bayar WHERE hutang_bayar.idDetailHutang='$data_detail[idDetailHutang]' AND hutang_bayar.stdel='0' AND keterangan='Lunas' ORDER BY idBayarHutang ASC"));

                    $tampil = mysqli_query($koneksi,"SELECT hutang_bayar.*, hutang_setting_detail.idPegawai, pegawai.namaPegawai,hutang_setting.idPosHutang, hutang_pos.idAkunHutang, akun_biaya.kodeAkun, akun_biaya.keterangan as ket_akun FROM hutang_bayar LEFT JOIN hutang_setting_detail ON hutang_bayar.idDetailHutang=hutang_setting_detail.idDetailHutang LEFT JOIN pegawai ON hutang_setting_detail.idPegawai=pegawai.idPegawai LEFT JOIN hutang_setting ON hutang_setting_detail.idSettingHutang=hutang_setting.idSettingHutang LEFT JOIN hutang_pos ON hutang_setting.idPosHutang=hutang_pos.idPosHutang LEFT JOIN akun_biaya ON hutang_bayar.idAkunKas=akun_biaya.idAkun WHERE hutang_setting.idTahunAjaran='$data_detail[idTahunAjaran]' AND hutang_bayar.idDetailHutang='$data_detail[idDetailHutang]' AND hutang_bayar.stdel='0' ORDER BY idBayarHutang ASC");
                    $no = 1;
                    while($r=mysqli_fetch_array($tampil)){
                        
                        $html.='<tr align="center">
                                    <td width="30px" style="border-bottom:1px solid black;">'.$no++.'</td>';
                                    if (!empty($r['tanggalBayar'])){
                                        $html.='<td width="50px" style="border-bottom:1px solid black;">'.date('d/m/Y',strtotime($r['tanggalBayar'])).'</td>';
                                    }else{
                                        $html.='<td width="50px" style="border-bottom:1px solid black;">-</td>';
                                    }
                        $html.='    <td width="130px" style="border-bottom:1px solid black;">'.$r['kodeAkun'].' - '.$r['ket_akun'].'</td>
                                    <td width="90px" style="border-bottom:1px solid black;">'.$r['cicilan'].'</td>
                                    <td width="150px" style="border-bottom:1px solid black;">'.$r['keterangan'].'</td>
                                    <td width="90px" style="border-bottom:1px solid black;" align="right">'.buatRp($r['nominal']).'</td>
                                </tr>';
                    }

            $html.='</tbody>
                    <tfoot>
                        <tr>
                            <th align="left" colspan="4" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">Total Bayar</th>
                            <th align="center" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;"></th>
                            <th align="center" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">
                                <table>
                                    <tr>
                                        <td align="right">'.buatRp($total_bayar[total_bayar]).' </td>
                                    </tr>
                                </table>
                            </th>
                            
                        </tr>
                        <tr>
                            <th align="left" colspan="4"  style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">Total Hutang</th>
                            <th align="center" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;"></th>
                            <th align="center" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">
                                <table>
                                    <tr>
                                        <td align="right">'.buatRp($data_detail[nominal]).' </td>
                                    </tr>
                                </table>
                            </th>
                        </tr>
                        <tr>
                            <th align="left" colspan="4"  style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">Sisa Hutang</th>
                            <th align="center" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;"></th>
                            <th align="center" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black;">
                                <table>
                                    <tr>
                                        <td align="right">'.buatRp($data_detail[nominal] - $total_bayar[total_bayar]).' </td>
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