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

    if (isset($_SESSION['idUsers']) OR isset($_SESSION['idSiswa']) ){
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

        $cek_bayar_bulanan = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tagihan_bulanan WHERE noRefrensi='$_GET[noref]' AND (DATE(tagihan_bulanan.tglBayar)='$_GET[tgl]')"));
        if ($cek_bayar_bulanan > 0){
             $siswa = mysqli_fetch_array(mysqli_query($koneksi,"SELECT 
                                                    tagihan_bulanan.*, 
                                                    jenis_bayar.idPosBayar, 
                                                    tahun_ajaran.nmTahunAjaran,
                                                    pos_bayar.nmPosBayar,
                                                    akun_biaya.keterangan,
                                                    unit_sekolah.singkatanUnit,
                                                    bulan.nmBulan,
                                                    bulan.urutan,
                                                    siswa.*,
                                                    kelas_siswa.nmKelas,
                                                    kamar.namaKamar
                                                FROM tagihan_bulanan 
                                                LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                                LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                LEFT JOIN akun_biaya ON tagihan_bulanan.idAkunKas = akun_biaya.idAkun
                                                LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                                LEFT JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                                LEFT JOIN siswa ON tagihan_bulanan.idSiswa = siswa.idSiswa
                                                LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas
                                                LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar
                                                WHERE siswa.nisSiswa='$_GET[nis]' AND (DATE(tagihan_bulanan.tglBayar)='$_GET[tgl]') AND tagihan_bulanan.noRefrensi='$_GET[noref]' ORDER BY tagihan_bulanan.idTagihanBulanan ASC"));
        }else{
            $siswa = mysqli_fetch_array(mysqli_query($koneksi,"SELECT 
                                                    tagihan_bebas.*, 
                                                    tagihan_bebas_bayar.*,
                                                    jenis_bayar.idPosBayar, 
                                                    tahun_ajaran.nmTahunAjaran,
                                                    pos_bayar.nmPosBayar,
                                                    akun_biaya.keterangan,
                                                    unit_sekolah.singkatanUnit,
                                                    siswa.*,
                                                    kelas_siswa.nmKelas,
                                                    kamar.namaKamar
                                                FROM tagihan_bebas 
                                                LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas
                                                LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                LEFT JOIN akun_biaya ON tagihan_bebas_bayar.idAkunKas = akun_biaya.idAkun
                                                LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                                LEFT JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
                                                LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas
                                                LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar
                                                WHERE siswa.nisSiswa='$_GET[nis]' AND (DATE(tagihan_bebas_bayar.tglBayar)='$_GET[tgl]') AND tagihan_bebas_bayar.noRefrensi='$_GET[noref]'"));
            
        }
        
        

        $total_pembayaran = 0;
        $tampil_bulanan = mysqli_query($koneksi,"SELECT 
                                                    tagihan_bulanan.*,
                                                    jenis_bayar.idPosBayar, 
                                                    tahun_ajaran.nmTahunAjaran,
                                                    pos_bayar.nmPosBayar,
                                                    akun_biaya.keterangan,
                                                    unit_sekolah.singkatanUnit,
                                                    bulan.nmBulan,
                                                    bulan.urutan
                                                FROM tagihan_bulanan 
                                                LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar = jenis_bayar.idJenisBayar
                                                LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                LEFT JOIN akun_biaya ON tagihan_bulanan.idAkunKas = akun_biaya.idAkun
                                                LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                                LEFT JOIN bulan ON tagihan_bulanan.idBulan = bulan.idBulan
                                                WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND (DATE(tagihan_bulanan.tglBayar)='$_GET[tgl]') AND tagihan_bulanan.noRefrensi='$_GET[noref]' ORDER BY tagihan_bulanan.idTagihanBulanan ASC");

        $tampil_bebas = mysqli_query($koneksi, "SELECT 
                                                    tagihan_bebas.*, 
                                                    tagihan_bebas_bayar.*,
                                                    jenis_bayar.idPosBayar, 
                                                    tahun_ajaran.nmTahunAjaran,
                                                    pos_bayar.nmPosBayar,
                                                    akun_biaya.keterangan,
                                                    unit_sekolah.singkatanUnit,
                                                    siswa.*,
                                                    kelas_siswa.nmKelas,
                                                    kamar.namaKamar
                                                FROM tagihan_bebas 
                                                LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas
                                                LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                LEFT JOIN akun_biaya ON tagihan_bebas_bayar.idAkunKas = akun_biaya.idAkun
                                                LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit
                                                LEFT JOIN siswa ON tagihan_bebas.idSiswa = siswa.idSiswa
                                                LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas
                                                LEFT JOIN kamar ON siswa.kamarSiswa = kamar.idKamar
                                                WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND (DATE(tagihan_bebas_bayar.tglBayar)='$_GET[tgl]') AND tagihan_bebas_bayar.noRefrensi='$_GET[noref]' 
                                                ");

        $lokasi = '../../'.$lokasi_barcode_pembayaran_siswa;
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
        $pdf->SetTitle('Bukti Pembayaran '.$siswa['nisSiswa'].' - '.$siswa['nmSiswa']);
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
                                <tr><td style="font-size:10pt; font-weight:bold;" align="center">Bukti Pembayaran</td></tr>
                                <tr><td style="font-size:3pt;"></td></tr>
                                <tr><td style="font-size:8pt; font-weight:bold;">&nbsp;&nbsp;Unit Sekolah : '.$siswa['singkatanUnit'].'</td></tr>
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
                                    <td width="90px">NIS</td>
                                    <td width="10px">:</td>
                                    <td width="200px">'.$siswa['nisSiswa'].'</td>

                                    <td width="90px">Tanggal Pembayaran</td>
                                    <td width="10px">:</td>
                                    <td width="135px">'.tgl_raport($siswa['tglBayar']).'</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>'.$siswa['nmSiswa'].'</td>

                                    <td>Tahun Ajaran</td>
                                    <td>:</td>
                                    <td>'.$TA['nmTahunAjaran'].'</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>:</td>
                                    <td>'.$siswa['nmKelas'].'</td>

                                    <td>Akun Kas</td>
                                    <td>:</td>
                                    <td>'.$siswa['keterangan'].'</td>
                                </tr>
                                <tr>
                                    <td>Kamar</td>
                                    <td>:</td>
                                    <td>'.$siswa['namaKamar'].'</td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td>
                            <table style="font-size:8pt" border="0" cellpadding="2">
                                <thead>
                                    <tr align="center">
                                        <th width="30px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">No.</th>
                                        <th width="230px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Pembayaran</th>
                                        <th width="130px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Total Tagihan</th>
                                        <th width="20px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;"></th>
                                        <th width="123px" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Jumlah Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    $no = 1;
                                    while ($r = mysqli_fetch_array($tampil_bulanan)) {
                                        $pisah_TA = explode('/', $r['nmTahunAjaran']);
                                        if ($r['urutan'] <= 6){
                                            $nmBulan = $r['nmBulan'].' '.$pisah_TA[0];
                                        }else{
                                            $nmBulan = $r['nmBulan'].' '.$pisah_TA[1];
                                        }

                                        $html.='<tr>
                                                    <td align="center">'.$no++.'</td>
                                                    <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].' - ('.$nmBulan.')</td>
                                                    <td align="center">'.buatRp($r['jumlahTagihan']).'</td>
                                                    <td align="center">Rp.</td>
                                                    <td align="right">'.rupiah($r['jumlahTagihan']).'</td>
                                                </tr>';
                                        $total_pembayaran=$total_pembayaran+$r['jumlahTagihan'];
                                    }
                                    
                                    while ($r = mysqli_fetch_array($tampil_bebas)) {
                                        $totalTagihanBebas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(totalTagihan) as totalTagihanBebas FROM tagihan_bebas WHERE idTagihanBebas='$r[idTagihanBebas]'"));
                                        $totalBayarBebas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(jumlahBayar) as totalBayarBebas FROM tagihan_bebas_bayar WHERE idTagihanBebas='$r[idTagihanBebas]' AND (DATE(tglBayar)='$_GET[tgl]')"));
                                       
                                        $html.= '<tr>
                                                    <td align="center">'.$no++.'</td>
                                                    <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].' ('.$r['ketBebas'].')</td>
                                                    <td align="center">'.buatRp($totalTagihanBebas['totalTagihanBebas']).'</td>
                                                    <td align="center">Rp.</td>
                                                    <td align="right">'.rupiah($r['jumlahBayar']).'</td>
                                                </tr>';
                                        $total_pembayaran=$total_pembayaran+$r['jumlahBayar'];
                                    }
            $html.='            </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table cellpadding="3">
                                <tr >
                                    <th rowspan="4" colspan="2" style="background-color:white; border-top: 1px solid black;">
                                       <table align="center" cellpadding="4">
                                            <tr><td>'.$idt['kabupaten'].', '.tgl_raport($_GET['tgl']).'</td></tr>
                                            <tr><td>Bendahara</td></tr>
                                            <tr><td></td></tr>
                                            <tr><td></td></tr>
                                            <tr><td><font style="font-weight:bold;">'.$idt['nmBendahara'].'</font><br>Nip. '.$idt['nipBendahara'].'</td></tr>
                                       </table>
                                    </th>
                                    <th align="left" width="178px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black; border-top: 1px solid black;">Total Pembayaran</th>
                                    <th align="center" width="20px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black; border-top: 1px solid black;">Rp.</th>
                                    <th align="right" width="123px" style="background-color:#e3e3e3; font-weight:bold; border-bottom: 1px solid black; border-top: 1px solid black;">'.rupiah($total_pembayaran).'</th>
                                </tr>
                                <tr>
                                    
                                    <th align="left" style="background-color:#e3e3e3; font-weight:bold;">Terbilang</th>
                                    <th align="right" colspan="2" style="background-color:#e3e3e3; font-weight:bold;">'.ucwords(terbilang($total_pembayaran)).'</th>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
       
        $file = 'Bukti Pembayaran '.date('d-m-Y').' Nama '.$siswa['nmSiswa'].' Nis '.$siswa['nisSiswa'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }
?>