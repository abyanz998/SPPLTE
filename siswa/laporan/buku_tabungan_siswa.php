<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/library.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/rupiah.php";
    include "../../config/variabel_default.php";
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
        
        $nama_file = 'Buku Tabungan Siswa '.$siswa['nmSiswa'].' NIS '.$siswa['nisSiswa'];    

        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(10,15,10,10);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle($nama_file);
        //isi pdf
        $html ='<table border="0" cellpadding="2px">
                    <tr>
                        <td style="font-weight: bold; font-size: 14px">'.$idt['nmSekolah'].'</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; font-size: 8px;">'.$unit.'</td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="font-size: 8px;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].'</td>
                    </tr>
                     <tr>
                        <td style="font-size: 8px;">'.$idt['noTelp'].'</td>
                    </tr>
                    <tr>
                        <td><hr style="height:1px"></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; font-size: 12px;" align="center">RINCIAN TABUNGAN SISWA</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; font-size: 9px;" align="center">Unit Sekolah : '.$siswa['singkatanUnit'].'</td>
                    </tr>
                </table><br><br>';
        $html.= '<table style="font-size: 9px;" cellpadding="2">
                    <tr><td width="100px">NIS</td><td width="10px">:</td><td width="50px">'.$siswa['nisSiswa'].'</td></tr>
                    <tr><td width="100px">Nama</td><td width="10px">:</td><td width="50px">'.$siswa['nmSiswa'].'</td></tr>
                    <tr><td width="100px">Kelas</td><td width="10px">:</td><td width="50px">'.$siswa['nmKelas'].'</td></tr>

                </table><br><br>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $html = '<table border="1" style="font-size: 9px" align="center" cellpadding="1">
                    <thead>
                        <tr>
                            <th style="font-weight: bold">TANGGAL</th>
                            <th style="font-weight: bold">KODE</th>
                            <th style="font-weight: bold">CATATAN</th>
                            <th style="font-weight: bold">DEBIT</th>
                            <th style="font-weight: bold">KREDIT</th>
                            <th style="font-weight: bold">SALDO</th>
                        </tr>
                    </thead>
                    <tbody>'; 
                        $saldo=0;
                        if ($_GET['thn_ajar']=='all'){
                            $Qtabungan = mysqli_query($koneksi,"SELECT * FROM tabungan_siswa WHERE stdel='0' AND siswa='$siswa[idSiswa]' ORDER BY idTabungan ASC");
                        }else{
                            $Qtabungan = mysqli_query($koneksi,"SELECT * FROM tabungan_siswa WHERE stdel='0' AND siswa='$siswa[idSiswa]' AND tahunAjaran='$_GET[thn_ajar]' ORDER BY idTabungan ASC");
                        }
                        while($tabung=mysqli_fetch_array($Qtabungan)){
                            $debit = 0;
                            $kredit = 0;
                            if ($tabung['kode'] == 'SETORAN'){
                                $debit=$tabung['nominal'];
                                $kredit=0;
                                $saldo = $saldo + $debit;
                            }
                            if ($tabung['kode'] == 'PENARIKAN'){
                                $debit=0;
                                $kredit=$tabung['nominal'];
                                $saldo = $saldo - $kredit;
                            }
                            $html.= "<tr>
                                        
                                        <td>".tgl_view($tabung['tgl'])."</td>
                                        <td>".$tabung['kode']."</td>
                                        <td>".$tabung['catatan']."</td>
                                        <td>".buatRp($debit)."</td>
                                        <td>".buatRp($kredit)."</td>
                                        <td>".buatRp($saldo)."</td>
                                     </tr>";
                        }                     
        $html.= '</tbody></table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'R');


        $file = 'Data Pegawai NIP '.$pegawai['nipPegawai'].' Nama '.$pegawai['namaPegawai'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }
?>