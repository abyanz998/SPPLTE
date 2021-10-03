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
        $TA = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$_GET[thn_ajar]' AND stdel='0'"));
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


        if (empty($_GET['tgl']) && empty($_GET['noref'])){

            $sws =mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisSiswa='$_GET[nis]' AND stdel='0'"));

            $cek_bayar_bulanan = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM tagihan_bulanan WHERE idSiswa='$sws[idSiswa]' AND statusBayar='1' AND statusKas='1'"));
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
                                                            WHERE siswa.nisSiswa='$_GET[nis]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]'
                                                            ORDER BY tagihan_bulanan.idTagihanBulanan ASC"));
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
                                                    WHERE siswa.nisSiswa='$_GET[nis]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]'"));
            }
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
                                                    WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.statusKas='1'
                                                    ORDER BY tagihan_bulanan.idTagihanBulanan ASC");

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
                                                    WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.statusKas='1'");

        }else{
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
                                                    WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND (DATE(tagihan_bebas_bayar.tglBayar)='$_GET[tgl]') AND tagihan_bebas_bayar.noRefrensi='$_GET[noref]'");

        }
        
        
        

        $total_pembayaran = 0;
        
      
        //konfigurasi TCPDF
        $pdf= new TCPDF('P', 'mm', array('330','75'), true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(5,5,5,5);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle('Bukti Pembayaran Thermal '.$siswa['nisSiswa'].' - '.$siswa['nmSiswa']);
        //isi pdf
        //header
        $html ='<table width="100%" border="0">
                    <tr>
                        <td valign="top">
                            <table border="0" align="center">
                                <tr><td style="font-size:12pt; font-weight:bold;">'.$idt['nmSekolah'].'</td></tr>
                                <tr><td style="font-size:1pt;"></td></tr>
                                <tr><td style="font-size:8pt; font-weight:bold;">'.$unit.'</td></tr>
                                <tr><td style="font-size:8pt; font-weight:bold;"></td></tr>
                                <tr><td style="font-size:7pt;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp: '.$idt['noTelp'].'</td></tr>
                                <tr><td style="font-size:3pt; font-weight:bold;"></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <hr>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $pdf->Ln(1.5);
        $html = '<table width="100%" border="0" style="font-size:7pt;">
                    <tr>
                        <td valign="top">
                            <table border="0" cellpadding="1">
                                <tr><td width="70px">No. Referensi</td><td width="10px">:</td><td width="80px">'.$siswa['noRefrensi'].'</td></tr>
                                <tr><td>Tahun Ajaran</td><td>:</td><td>'.$siswa['nmTahunAjaran'].'</td></tr>
                                <tr><td>Tanggal Pembayaran</td><td>:</td><td>'.tgl_raport($siswa['tglBayar']).'</td></tr>
                                <tr><td>Akun Kas</td><td>:</td><td>'.$siswa['keterangan'].'</td></tr>
                                <tr><td>NIS</td><td>:</td><td>'.$siswa['nisSiswa'].'</td></tr>
                                <tr><td>Nama</td><td>:</td><td>'.$siswa['nmSiswa'].'</td></tr>
                                <tr><td>Kelas</td><td>:</td><td>'.$siswa['nmKelas'].'</td></tr>
                                <tr><td>Kamar</td><td>:</td><td>'.$siswa['namaKamar'].'</td></tr>
                                <tr style="font-size:3pt;"><td></td><td></td><td></td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <hr>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
        $html = '<table width="100%" border="0" style="font-size:7pt;" cellpadding="3">
                    <tr>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <th width="20px" style="font-size:8pt; font-weight:bold; border-top:1px solid black; border-bottom:1px solid black;">No</th>
                        <th width="70px"style="font-size:8pt; font-weight:bold; border-top:1px solid black; border-bottom:1px solid black;">Pembayaran</th>
                        <th width="85px"style="font-size:8pt; font-weight:bold; border-top:1px solid black; border-bottom:1px solid black;" colspan="2">Jumlah Pembayaran</th>
                    </tr>';
                    $no = 1;
                                    while ($r = mysqli_fetch_array($tampil_bulanan)) {
                                        $pisah_TA = explode('/', $r['nmTahunAjaran']);
                                        if ($r['urutan'] <= 6){
                                            $nmBulan = $r['nmBulan'].' '.$pisah_TA[0];
                                        }else{
                                            $nmBulan = $r['nmBulan'].' '.$pisah_TA[1];
                                        }

                                        $html.='<tr>
                                                    <td align="center" style="border-bottom:1px solid black;">'.$no++.'</td>
                                                    <td style="border-bottom:1px solid black;">'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].' - ('.$nmBulan.')</td>
                                                    <td width="18px" align="center" style="border-bottom:1px solid black;">Rp.</td>
                                                    <td width="67px" align="right" style="border-bottom:1px solid black;">'.rupiah($r['jumlahTagihan']).'</td>
                                                </tr>';
                                        $total_pembayaran=$total_pembayaran+$r['jumlahTagihan'];
                                    }
                                    
                                    while ($r = mysqli_fetch_array($tampil_bebas)) {
                                        $html.= '<tr>
                                                    <td align="center" style="border-bottom:1px solid black;">'.$no++.'</td>
                                                    <td style="border-bottom:1px solid black;">'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].' ('.$r['ketBebas'].')</td>
                                                    <td align="center" style="border-bottom:1px solid black;">Rp.</td>
                                                    <td align="right" style="border-bottom:1px solid black;">'.rupiah($r['jumlahBayar']).'</td>
                                                </tr>';
                                        $total_pembayaran=$total_pembayaran+$r['jumlahBayar'];
                                    }
        $html.='    <tr>
                        <td colspan="2" style="font-weight:bold; border-bottom:1px solid black;">Total Pembayaran</td>
                        <td style="border-bottom:1px solid black;">Rp.</td>
                        <td align="right" style="border-bottom:1px solid black;">'.rupiah($total_pembayaran).'</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-weight:bold; border-bottom:1px solid black;">Terbilang</td>
                        <td colspan="2" style="font-weight:bold; border-bottom:1px solid black;" align="right">'.ucwords(terbilang($total_pembayaran)).'</td>
                    </tr>

            
                    
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');

        $html = '<table width="100%" border="0" style="font-size:7pt;" align="center">
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td>'.$idt[kabupaten].', '.tgl_raport(date('Y-m-d')).'</td></tr>
                    <tr><td>Bendahara</td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td style="font-weight:bold">'.$idt[nmBendahara].'</td></tr>
                    <tr><td>Nip. '.$idt[nipBendahara].'</td></tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr><td>Simpan Kwitansi Ini Sebagai Bukti <br>Pembayaran yang Sah</td></tr>
                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');
       
        $file = 'Bukti Pembayaran Thermal'.date('d-m-Y').' Nama '.$siswa['nmSiswa'].' Nis '.$siswa['nisSiswa'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }
?>