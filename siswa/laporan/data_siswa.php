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
        $kelas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas_siswa WHERE idKelas='$_GET[kelas]'"));
        $kamar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kamar WHERE idKamar='$_GET[kamar]'"));

        if (($_GET['kelas'] != 'all') && ($_GET['kamar'] == 'all')){
            
            $qSiswa = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]' AND siswa.kelasSiswa='$_GET[kelas]' AND statusSiswa='Aktif'");

        }elseif (($_GET['kelas'] == 'all') && ($_GET['kamar'] != 'all')){
            
            $qSiswa = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]' AND siswa.kamarSiswa='$_GET[kamar]' AND statusSiswa='Aktif'");

        }elseif (($_GET['kelas'] == 'all') && ($_GET['kamar'] == 'all')){
            
            $qSiswa = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]' AND statusSiswa='Aktif'");

        }else{
            
            $qSiswa = mysqli_query($koneksi,"SELECT siswa.*, unit_sekolah.singkatanUnit, kelas_siswa.nmKelas, kamar.namaKamar FROM siswa LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar WHERE siswa.stdel='0' AND siswa.unitSiswa='$_GET[unit]' AND siswa.kelasSiswa='$_GET[kelas]' AND siswa.kamarSiswa='$_GET[kamar]' AND statusSiswa='Aktif'");

        }

        $namaFile = 'Data_Siswa_'.$unit['singkatanUnit'];
        $judul = 'Data Siswa '.$unit['singkatanUnit'];
        if ($_GET['kelas'] != 'all'){
            $judul = $judul.' Kelas '.$kelas['nmKelas'];
        }else{
            $judul = $judul.' Semua Kelas';
        }
        if ($_GET['kamar'] != 'all'){
            $judul = $judul.' Kamar '.$kamar['namaKamar'];
        }else{
            $judul = $judul.' Semua Kamar ';
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
                            <th style="font-weight: bold">No</th>
                            <th style="font-weight: bold">NIS</th>
                            <th style="font-weight: bold">Nama Lengkap</th>
                            <th style="font-weight: bold">Jenis Kelamin</th>
                            <th style="font-weight: bold">Unit</th>
                            <th style="font-weight: bold">Kelas</th>
                            <th style="font-weight: bold">Kamar</th>
                            <th style="font-weight: bold">Alamat</th>
                            <th style="font-weight: bold">Nama Ayah</th>
                            <th style="font-weight: bold">Nama Ibu</th>
                            <th style="font-weight: bold">No. Hp/Telp. Ortu</th>
                        </tr>
                    </thead>
                    <tbody>';    
                        $no = 1;
                        while($siswa=mysqli_fetch_array($qSiswa)){
                            if ($siswa['kamarSiswa'] == '0'){
                                $kamarSiswa = '';
                            }else{
                                $kamarSiswa = $siswa['namaKamar'];
                            }
                            if($siswa['jkSiswa'] == 'L'){
                                $jkSiswa = 'Laki-Laki';
                            }elseif($siswa['jkSiswa'] == 'P'){
                                $jkSiswa = 'Perempuan';
                            }
                            $html.= "<tr>
                                        <td>".$no++."</td>
                                        <td>".$siswa['nisSiswa']."</td>
                                        <td>".$siswa['nmSiswa']."</td>
                                        <td>".$jkSiswa."</td>
                                        <td>".$siswa['singkatanUnit']."</td>
                                        <td>".$siswa['nmKelas']."</td>
                                        <td>".$kamarSiswa."</td>
                                        <td>".$siswa['alamatSiswa']."</td>
                                        <td>".$siswa['nmAyah']."</td>
                                        <td>".$siswa['nmIbu']."</td>
                                        <td>".$siswa['noHpOrtu']."</td>
                                     </tr>";
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