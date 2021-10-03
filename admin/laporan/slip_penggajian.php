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
        
        $slip = mysqli_fetch_array(mysqli_query($koneksi,"SELECT 
                                                     pegawai_gaji_slip.*, bulan.nmBulan, bulan.urutan, tahun_ajaran.nmTahunAjaran, akun_biaya.keterangan
                                                     FROM pegawai_gaji_slip 
                                                     LEFT JOIN bulan ON pegawai_gaji_slip.idBulan=bulan.idBulan 
                                                     LEFT JOIN tahun_ajaran ON pegawai_gaji_slip.idTahunAjaran=tahun_ajaran.idTahunAjaran
                                                     LEFT JOIN akun_biaya ON pegawai_gaji_slip.idAkunKas=akun_biaya.idAkun 
                                                     WHERE pegawai_gaji_slip.noRefrensi='$_GET[noref]' AND pegawai_gaji_slip.stdel='0'"));
        $pegawai = mysqli_fetch_array(mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.namaUnit, unit_sekolah.singkatanUnit, jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.idPegawai='$slip[idPegawai]'"));

        if ($pegawai['jbt_stdel'] == '1'){ $jabatan=''; }else{ $jabatan=$pegawai['namaJabatan']; }
        $pisah_TA = explode('/', $slip['nmTahunAjaran']);
        if ($slip['urutan'] < 7){
            $bulan = $slip['nmBulan'].' '.$pisah_TA[0];
        }else{
            $bulan = $slip['nmBulan'].' '.$pisah_TA[1];
        }

        $tgl_masuk = $pegawai['tglMasukPegawai'];
        if ($pegawai['tglKeluarPegawai'] == '0000-00-00'){
            $tgl_keluar = $slip['tanggal'];
        }else{
            $tgl_keluar = $pegawai['tglKeluarPegawai'];
        }
        $masa_kerja = hitungMasaKerja($tgl_masuk,$tgl_keluar);

        $gaji_pokok = $slip['gajiPokok'] + $slip['gajiLain'];
        $gaji_potongan = $slip['potonganSimpanan'] + $slip['potonganBPJSTK'] + $slip['potonganSumbangan'] + $slip['potonganKoperasi'] + $slip['potonganBPJS'] + $slip['potonganPinjaman'] + $slip['potonganLain'];
        $sisa_gaji = $gaji_pokok - $gaji_potongan;


        $lokasi = '../../'.$lokasi_barcode_pegawai_slip;
        $value = $slip['noRefrensi'];
        $link_barcode = barcode($lokasi,$value,$codetype,$print,$size);


        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(15,15,15,15);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle($pegawai['namaPegawai']);
        $pdf->SetSubject($pegawai['namaPegawai']);
        //isi pdf

        //header
        $html ='<table width="100%" border="0">
                    <tr>
                        <td valign="top" width="330px"><br><br>
                            <font style="font-size:14px; font-weight:bold;">'.$idt['nmSekolah'].'</font>
                            <br>
                            <font style="font-size:8px;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</font>
                        </td>
                        <td width="170px" align="center">
                            <table border="0">
                                <tr><td style="font-size:12px; font-weight:bold;">&nbsp;&nbsp;SLIP GAJI</td></tr>
                                <tr><td style="font-size:3px; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:8px;"><img src="'.$link_barcode.'" width="150px" height="25px"></td></tr>
                                <tr><td style="font-size:8px;">'.$value.'</td></tr>
                                <tr><td style="font-size:8px;">Dibayar Via :'.$slip['keterangan'].'</td></tr>
                                 <tr><td style="font-size:4px;"></td></tr>
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
                            <td width="100px"><font style="font-size:8px;">Unit</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="140px" style="font-size:8px;">'.$pegawai['singkatanUnit'].'</td>
                            
                            <td width="100px"><font style="font-size:8px;">Bulan</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="140px" style="font-size:8px;">'.$bulan.'</td>
                        </tr>
                        <tr>
                            <td width="100px"><font style="font-size:8px;">Nama</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="140px" style="font-size:8px;">'.$pegawai['namaPegawai'].'</td>
                            
                            <td width="100px"><font style="font-size:8px;">Status</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="140px" style="font-size:8px;">'.$pegawai['statusKepegawaian'].'</td>

                        </tr>
                        <tr>
                            <td width="100px"><font style="font-size:8px;">Jabatan</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="140px" style="font-size:8px;">'.$jabatan.'</td>

                            <td width="100px"><font style="font-size:8px;">Masa Kerja</font></td>
                            <td width="10px" style="font-size:8px;">:</td>
                            <td width="140px" style="font-size:8px;">'.$masa_kerja.'</td>
                        </tr>
                    </table><hr>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        //bagian isi
        $html='<div></div>
                <table border="1" cellpadding="3" style="font-size:8px;">
                    <tr>
                        <td>
                            <table border="0">
                                <tr>
                                    <td width="50px">Gaji Pokok</td>
                                    <td width="110px">:</td>
                                    <td width="15px">Rp.</td>
                                    <td align="right">'.rupiah($slip['gajiPokok']).'</td>
                                </tr>
                                <tr>
                                    <td width="50px">Gaji Lainnya</td>
                                    <td width="110px">:</td>
                                    <td width="15px">Rp.</td>
                                    <td align="right">'.rupiah($slip['gajiLain']).'</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table border="0">
                                <tr style="font-weight:bold">
                                    <td width="50px">Gaji</td>
                                    <td width="110px"></td>
                                    <td width="15px">Rp.</td>
                                    <td align="right">'.rupiah($gaji_pokok).'</td>
                                </tr>
                                <tr>
                                    <td>Potongan : </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>1. Simpanan & Pengajian</td>
                                    <td>Rp.</td>
                                    <td align="right">'.rupiah($slip['potonganSimpanan']).'</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>2. BPJS Tenaga Kerja</td>
                                    <td>Rp.</td>
                                    <td align="right">'.rupiah($slip['potonganBPJSTK']).'</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>3. Sumbangan</td>
                                    <td>Rp.</td>
                                    <td align="right">'.rupiah($slip['potonganSumbangan']).'</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>4. Belanja Koperasi</td>
                                    <td>Rp.</td>
                                    <td align="right">'.rupiah($slip['potonganKoperasi']).'</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>5. BPJS</td>
                                    <td>Rp.</td>
                                    <td align="right">'.rupiah($slip['potonganBPJS']).'</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>6. Pinjaman</td>
                                    <td>Rp.</td>
                                    <td align="right">'.rupiah($slip['potonganPinjaman']).'</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>7. Potongan Lain</td>
                                    <td>Rp.</td>
                                    <td align="right">'.rupiah($slip['potonganLain']).'</td>
                                </tr>
                                <tr>
                                    <td style="font-weight:bold" colspan="2">Jumlah Potongan</td>
                                    <td>Rp.</td>
                                    <td align="right">'.rupiah($gaji_potongan).'</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0">
                                <tr>
                                    <td width="50px" style="font-weight:bold">TOTAL</td>
                                    <td width="110px"></td>
                                    <td width="15px">Rp.</td>
                                    <td align="right">'.rupiah($gaji_pokok).'</td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table border="0" >
                                <tr style="font-weight:bold">
                                    <td width="100px">GAJI DITERIMA</td>
                                    <td width="60px"></td>
                                    <td width="15px">Rp.</td>
                                    <td align="right">'.rupiah($sisa_gaji).'</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table border="0" cellpadding="3" >
                    <tr style="font-weight:bold; font-size:8px" >
                        <td colspan="2">TERBILANG : '.ucwords(penyebut($sisa_gaji)).'</td>
                    </tr>
                </table>';
        //add halaman
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'R');
        $html='<div></div>
                <table border="0" cellpadding="1" style="font-size:8px;"  align="center">
                    <tr>
                        <td>
                        </td>
                        <td>
                            '.$idt['kabupaten'].', '.tgl_raport($tanggal_sekarang).'
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Bendahara
                        </td>
                        <td>
                            diterima oleh
                        </td>
                    </tr>
                    <tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr><td></td><td></td></tr>
                    <tr>
                        <td>'.$idt['nmBendahara'].'</td>
                        <td>'.$pegawai['namaPegawai'].'</td>
                    </tr>
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