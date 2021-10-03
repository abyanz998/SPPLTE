<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/variabel_default.php";
    require_once('../../plugins/tcpdf/tcpdf.php');

    if (isset($_SESSION['idUsers'])){
        $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));

        $unit = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM unit_sekolah WHERE idUnit='$_GET[unit]'"));
        $jabatan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM jabatan_pegawai WHERE idPegawai='$_GET[jabatan]'"));

        if (($_GET['unit'] != 'all') && ($_GET['jabatan'] == 'all')){
            $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' AND pegawai.unitPegawai='$_GET[unit]' ORDER BY pegawai.idPegawai DESC");
        }elseif (($_GET['unit'] == 'all') && ($_GET['jabatan'] != 'all')){
            $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' AND pegawai.jabatanPegawai='$_GET[jabatan]' ORDER BY pegawai.idPegawai DESC");

        }elseif (($_GET['unit'] == 'all') && ($_GET['jabatan'] == 'all')){
            $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' ORDER BY pegawai.idPegawai DESC");
        }else{
            $tampil = mysqli_query($koneksi,"SELECT pegawai.*, unit_sekolah.singkatanUnit , jabatan_pegawai.namaJabatan, jabatan_pegawai.stdel as jbt_stdel FROM pegawai LEFT JOIN unit_sekolah ON pegawai.unitPegawai = unit_sekolah.idUnit LEFT JOIN jabatan_pegawai ON pegawai.jabatanPegawai = jabatan_pegawai.idJabatan WHERE pegawai.stdel='0' AND pegawai.unitPegawai='$_GET[unit]' AND pegawai.jabatanPegawai='$_GET[jabatan]' ORDER BY pegawai.idPegawai DESC");
        }
        
        $namaFile = 'Data_Pegawai_'.$unit['singkatanUnit'];
        $judul = 'Data Pegawai '.$unit['singkatanUnit'];
        if ($_GET['jabatan'] != 'all'){
            $judul = $judul.' Jabatan '.$jabatan['namaJabatan'];
        }else{
            $judul = $judul.' Semua Jabatan';
        }
            
        //konfigurasi TCPDF
        $pdf= new TCPDF('L','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(10,10,10,10);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle($judul);
        //isi pdf
        $html ='<table border="0" cellpadding="2px">
                    <tr>
                        <td style="font-weight: bold; font-size: 12px">'.$idt['nmSekolah'].'</td>
                    </tr>
                    <tr>
                        <td style="font-size: 8px;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</td>
                    </tr>
                    <tr>
                        <td><hr style="height:1px"></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; font-size: 8px;" align="center">'.$judul.'</td>
                    </tr>
                    <tr></tr>
                </table><br><br>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $html = '<table border="1" style="font-size: 8px" align="center" cellpadding="1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>TTL</th>
                            <th>Alamat</th>
                            <th>Unit Sekolah</th>
                            <th>Jabatan</th>
                            <th>Status Kepegawaian</th>
                            <th>No. Telpon/Hp</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>';    
                        $no = 1;
                        while($r=mysqli_fetch_array($tampil)){
                            if ($r['tglLahirPegawai'] == '0000-00-00' OR $r['tglLahirPegawai'] == ''){
                                $ttl = strtoupper($r['tempatLahirPegawai']);
                            }else{
                                $ttl = strtoupper($r['tempatLahirPegawai'].', '.tgl_view($r['tglLahirPegawai']));
                            }
        
                            if ($r['statusPegawai'] == 'Aktif'){
                              $status = 'Aktif';
                            }else{
                              $status = 'Tidak Aktif';
                            }
                            if ($r['jkPegawai'] == 'L'){
                              $jkPegawai = 'Laki-laki';
                            }elseif ($r['jkPegawai'] == 'P'){
                              $jkPegawai = 'Perempuan';
                            }
                            if ($r['jbt_stdel'] == '1'){
                              $nama_jabatan = '';
                            }else{
                              $nama_jabatan = $r['namaJabatan'];
                            }
                            $html.= "<tr>
                                    <td>$no</td>
                                    <td>$r[nipPegawai]</td>
                                    <td>$r[namaPegawai]</td>
                                    <td>$jkPegawai</td>
                                    <td>$ttl</td>
                                    <td>$r[alamatPegawai]</td>
                                    <td>$r[singkatanUnit]</td>
                                    <td>$nama_jabatan</td>
                                    <td>$r[statusKepegawaian]</td>
                                    <td>$r[noHpPegawai]</td>
                                    <td>$status</td>
                                    </tr>";
                            $no++;
                          }            
        $html.= '</tbody></table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'R');


        $file = $judul.'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }
?>