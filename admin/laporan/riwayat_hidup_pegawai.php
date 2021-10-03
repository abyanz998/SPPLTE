<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/variabel_default.php";
    require_once('../../plugins/tcpdf/tcpdf.php');

    if (isset($_SESSION['idUsers'])){

        $pegawai = mysqli_fetch_array(mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.namaUnit , jabatan_pegawai.namaJabatan FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.idPegawai='$_GET[id]'"));
        if (empty($pegawai['fotoPegawai'])) { $fotoPegawai = '../../'.$lokasi_default_fotoPegawai; }else{ $fotoPegawai = '../../'.$lokasi_penyimpanan_fotoPegawai.$pegawai['fotoPegawai']; }
        if ($pegawai['jkPegawai'] == 'L') {$jkPegawai='Laki-laki';} else if ($pegawai['jkPegawai'] == 'P') {$jkPegawai='Perempuan';} else {$jkPegawai='-';}
        if ($pegawai['statusKepegawaian'] == '') { $statusKepegawaian='-'; } else { $statusKepegawaian=$pegawai['statusKepegawaian']; }
        if ($pegawai['noHpPegawai'] == '') { $noHpPegawai='-'; } else { $noHpPegawai=$pegawai['noHpPegawai']; }
        if ($pegawai['emailPegawai'] == '') { $emailPegawai='-'; } else { $emailPegawai=$pegawai['emailPegawai']; }
        if ($pegawai['tglKeluarPegawai'] == '0000-00-00'){ $tgl_keluar = date('Y-m-d'); } else{ $tgl_keluar = $pegawai['tglKeluarPegawai']; }
            

        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(10,10,10,10);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle($pegawai['namaPegawai']);
        //isi pdf
        $html ='<table><tr><td align="center" style="font-size:12px"><b>RIWAYAT HIDUP</b></td></tr></table>';
        $html.='<br><br>';
        //biodata
        $html.='<table border="1" style="font-size:10px; padding:2px;"><tr><td align="center"><b>I. BIODATA PEGAWAI</b></td></tr></table>';
            $html.='<br><br>';
            
            $html.= '<table>
                        <tr>
                            <td>
                                <table style="font-size:10px;">
                                    <tr>
                                        <td width="120px">No. Induk Pegawai</td>
                                        <td width="5px">:</td>
                                        <td width="230px">'.$pegawai['nipPegawai'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Pegawai</td>
                                        <td>:</td>
                                        <td>'.$pegawai['namaPegawai'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td>
                                        <td>:</td>
                                        <td>'.$jkPegawai.'</td>
                                    </tr>
                                    <tr>
                                        <td>Tempat, Tanggal Lahir</td>
                                        <td>:</td>
                                        <td>'.$pegawai['tempatLahirPegawai'].', '.tgl_raport($pegawai['tglLahirPegawai']).'</td>
                                    </tr>
                                    <tr>
                                        <td>Pendidikan Terakhir</td>
                                        <td>:</td>
                                        <td>'.$pegawai['pendidikanPegawai'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td>'.$pegawai['alamatPegawai'].'</td>
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
                                    <tr>
                                        <td>Status Kepegawaian</td>
                                        <td>:</td>
                                        <td>'.$statusKepegawaian.'</td>
                                    </tr>
                                    <tr>
                                        <td>No. HP/Telpon</td>
                                        <td>:</td>
                                        <td>'.$noHpPegawai.'</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td>'.$emailPegawai.'</td>
                                    </tr>
                                    <tr>
                                        <td>Masa Kerja</td>
                                        <td>:</td>
                                        <td>'.hitungMasaKerja($pegawai['tglMasukPegawai'],$tgl_keluar).'</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:</td>
                                        <td>'.$pegawai['statusPegawai'].'</td>
                                    </tr>
                                </table>
                            </td>
                            <td align="right"><img src="'.$fotoPegawai.'" width="150px" height="150px"></td>
                        </tr>
                    </table>';
            $html.='<br><br>';

        //pendidikan
        $html.='<table border="1" style="font-size:10px;"><tr><td align="center"><b>II. RIWAYAT PENDIDIKAN</b></td></tr></table>';
            $html.='<br><br>';
            $no = 1;
            $q_pendidikan = mysqli_query($koneksi,"select * from pegawai_pendidikan WHERE idPegawai='$_GET[id]' AND stdel='0'");
            while($r=mysqli_fetch_array($q_pendidikan)){
                $html.='<table style="font-size:10px;">
                        <tr>
                            <td>'.$no++.'. '.$r['pendidikanSekolah'].' '.$r['pendidikanLokasi'].'</td>
                            <td align="right">('.$r['pendidikanMasuk'].' - '.$r['pendidikanKeluar'].')</td>
                        </tr>
                    </table>';
            }
            $html.='<br><br>';

        //seminar dan pelatihan
        $html.='<table border="1" style="font-size:10px;"><tr><td align="center"><b>III. RIWAYAT SEMINAR DAN PELATIHAN</b></td></tr></table>';
            $html.='<br><br>';
            $no = 1;
            $q_seminar = mysqli_query($koneksi,"select * from pegawai_seminar WHERE idPegawai='$_GET[id]' AND stdel='0'");
            while($r=mysqli_fetch_array($q_seminar)){
                $html.='<table style="font-size:10px;">
                        <tr>
                            <td>'.$no++.'. '.$r['seminarPenyelenggara'].' '.$r['seminarLokasi'].'</td>
                            <td align="right">('.tgl_raport($r['seminarMulai']).' - '.tgl_raport($r['seminarSelesai']).')</td>
                        </tr>
                    </table>';
            }
            $html.='<br><br>';

        //keluarga
        $html.='<table border="1" style="font-size:10px;"><tr><td align="center"><b>IV. DATA KELUARGA</b></td></tr></table>';
            $html.='<br><br>';
            $no = 1;
            $q_keluarga = mysqli_query($koneksi,"select * from pegawai_keluarga WHERE idPegawai='$_GET[id]' AND stdel='0'");
            while($r=mysqli_fetch_array($q_keluarga)){
                $html.='<table style="font-size:10px;">
                        <tr>
                            <td>'.$no++.'. '.$r['keluargaNama'].'</td>
                            <td align="right">('.$r['keluargaHubungan'].')</td>
                        </tr>
                    </table>';
            }
            $html.='<br><br>';

        //jabatan
        $html.='<table border="1" style="font-size:10px;"><tr><td align="center"><b>V. RIWAYAT JABATAN</b></td></tr></table>';
            $html.='<br><br>';
            $no = 1;
            $q_jabatan = mysqli_query($koneksi,"select * from pegawai_jabatan WHERE idPegawai='$_GET[id]' AND stdel='0'");
            while($r=mysqli_fetch_array($q_jabatan)){
                $html.='<table style="font-size:10px;">
                        <tr>
                            <td>'.$no++.'. '.$r['jabatanKeterangan'].'</td>
                            <td align="right">('.tgl_raport($r['jabatanMulai']).' - '.tgl_raport($r['jabatanSelesai']).')</td>
                        </tr>
                    </table>';
            }
            $html.='<br><br>';

        //mengajar
        $html.='<table border="1" style="font-size:10px;"><tr><td align="center"><b>VI. RIWAYAT MENGAJAR</b></td></tr></table>';
            $html.='<br><br>';
            $no = 1;
            $q_mengajar = mysqli_query($koneksi,"select * from pegawai_mengajar WHERE idPegawai='$_GET[id]' AND stdel='0'");
            while($r=mysqli_fetch_array($q_mengajar)){
                $html.='<table style="font-size:10px;">
                        <tr>
                            <td>'.$no++.'. '.$r['mengajarMP'].' '.$r['mengajarKeterangan'].'</td>
                            <td align="right">('.tgl_raport($r['mengajarMulai']).' - '.tgl_raport($r['mengajarSelesai']).')</td>
                        </tr>
                    </table>';
            }
            $html.='<br><br>';

        //penghargaan
        $html.='<table border="1" style="font-size:10px;"><tr><td align="center"><b>VII. DAFTAR PENGHARGAAN</b></td></tr></table>';
            $html.='<br><br>';
            $no = 1;
            $q_penghargaan = mysqli_query($koneksi,"select * from pegawai_penghargaan WHERE idPegawai='$_GET[id]' AND stdel='0'");
            while($r=mysqli_fetch_array($q_penghargaan)){
                $html.='<table style="font-size:10px;">
                        <tr>
                            <td>'.$no++.'. '.$r['penghargaanNama'].'</td>
                            <td align="right">('.$r['penghargaanTahun'].')</td>
                        </tr>
                    </table>';
            }
            $html.='<br><br>';

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