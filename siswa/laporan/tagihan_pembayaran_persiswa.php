<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/rupiah.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/variabel_default.php";
    require_once('../../plugins/tcpdf/tcpdf.php');

        $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
        $TA = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$_GET[thn_ajar]'"));
        $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT siswa.*,
                                                                   kelas_siswa.nmKelas
                                                            FROM siswa
                                                            LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas
                                                            WHERE nisSiswa = '$_GET[nis]'"));

        $total_tagihan_bulanan_bebas = 0;

        if (empty($_GET['bulan1']) && empty($_GET['bulan2'])){
            $bulan_aktif = (int)date('m') + 6;

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
                                                    WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' AND tagihan_bulanan.statusBayar='0' AND bulan.urutan <= '$bulan_aktif' ORDER BY tagihan_bulanan.idTagihanBulanan DESC");

            $tampil_bebas = mysqli_query($koneksi, "SELECT 
                                                        tagihan_bebas.*, 
                                                        SUM(tagihan_bebas.totalTagihan) as totalTagihanBebas, 
                                                        jenis_bayar.idPosBayar, 
                                                        tahun_ajaran.nmTahunAjaran,
                                                        pos_bayar.nmPosBayar
                                                    FROM tagihan_bebas 
                                                    LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                    WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' AND tagihan_bebas.statusBayar!='1'
                                                    GROUP BY tagihan_bebas.idJenisBayar");   
        }else{
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
                                                    WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' AND tagihan_bulanan.statusBayar='0' AND bulan.urutan >= '$_GET[bulan1]' AND bulan.urutan <= '$_GET[bulan2]' ORDER BY tagihan_bulanan.idTagihanBulanan DESC");

            $tampil_bebas = mysqli_query($koneksi, "SELECT 
                                                        tagihan_bebas.*, 
                                                        SUM(tagihan_bebas.totalTagihan) as totalTagihanBebas, 
                                                        jenis_bayar.idPosBayar, 
                                                        tahun_ajaran.nmTahunAjaran,
                                                        pos_bayar.nmPosBayar
                                                    FROM tagihan_bebas 
                                                    LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                                    LEFT JOIN tahun_ajaran ON jenis_bayar.idTahunAjaran = tahun_ajaran.idTahunAjaran
                                                    LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar = pos_bayar.idPosBayar
                                                    WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' AND tagihan_bebas.statusBayar!='1'
                                                    GROUP BY tagihan_bebas.idJenisBayar"); 
        }
        


        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(10,10,10,10);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle('Tagihan '.$siswa['nisSiswa'].' - '.$siswa['nmSiswa']);
        //isi pdf
        $html ='<table border="0" cellpadding="2px">
                    <tr>
                        <td style="font-weight: bold; font-size: 14pt">'.$idt['nmSekolah'].'</td>
                    </tr>
                    <tr>
                        <td style="font-size: 8pt;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</td>
                    </tr>
                    <tr><td style="font-size: 1pt;"></td></tr>
                    <tr>
                        <td><hr style="height:2px"></td>
                    </tr>
                    
                </table><br>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');

        $html = '<table style="font-size: 8pt" cellpadding="1" border="0">
                    <tr>
                        <td>Hal : Pemberitahuan Pembayaran Uang Pembelajaran</td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Kepada Yth.<br>bapak/ibu Orang Tua/Wali Ananda :</td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td>
                            <table style="font-size: 8pt" border="0" cellpadding="1">
                                <tr>
                                    <td width="90px">Nama</td>
                                    <td width="10px">:</td>
                                    <td width="427px">'.$siswa['nmSiswa'].'</td>
                                </tr>
                                <tr>
                                    <td>NIS</td>
                                    <td>:</td>
                                    <td>'.$siswa['nisSiswa'].'</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>:</td>
                                    <td>'.$siswa['nmKelas'].'</td>
                                </tr>
                                <tr>
                                    <td>Tahun Ajaran</td>
                                    <td>:</td>
                                    <td>'.$TA['nmTahunAjaran'].'</td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="justify">Dengan ini kami memberitahukan bahwa bapak/ibu dari ananda tersebut diatas masih memiliki tunggakan dengan rincian sebagai berikut :</td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td>
                            <table style="font-size:8pt" border="0" cellpadding="2">
                                <thead>
                                    <tr align="center">
                                        <th width="45px"></th>
                                        <th width="320px" style="font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Nama Tunggakan</th>
                                        <th width="20px" style="font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;"></th>
                                        <th width="80px" style="font-weight:bold; border-top: 1px solid black;border-bottom: 1px solid black;">Nominal</th>
                                        <th width="50px"></th>
                                    </tr>
                                </thead>
                                <tbody>';

                                    while ($r = mysqli_fetch_array($tampil_bulanan)) {
                                        $pisah_TA = explode('/', $r['nmTahunAjaran']);
                                        if ($r['urutan'] <= 6){
                                            $nmBulan = $r['nmBulan'].' '.$pisah_TA[0];
                                        }else{
                                            $nmBulan = $r['nmBulan'].' '.$pisah_TA[1];
                                        }
                                        $html.='<tr>
                                                    <td></td>
                                                    <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].' - ('.$nmBulan.')</td>
                                                    <td align="right">Rp.</td>
                                                    <td align="right">'.rupiah($r['jumlahTagihan']).'</td>
                                                    <td></td>
                                                </tr>';
                                        $total_tagihan_bulanan_bebas = $total_tagihan_bulanan_bebas + $r['jumlahTagihan'];
                                    }

                                    while ($r = mysqli_fetch_array($tampil_bebas)) {
                                        $totalBayarBebas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(jumlahBayar) as totalBayarBebas FROM tagihan_bebas_bayar WHERE idTagihanBebas='$r[idTagihanBebas]'"));
                                        $sisa_tagihan_bebas = $r['totalTagihanBebas']-$totalBayarBebas['totalBayarBebas'];
                                        $html.= '<tr>
                                                    <td></td>
                                                    <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].'</td>
                                                    <td align="right">Rp.</td>
                                                    <td align="right">'.rupiah($sisa_tagihan_bebas).'</td>
                                                    <td></td>
                                                </tr>';
                                        $total_tagihan_bulanan_bebas = $total_tagihan_bulanan_bebas + $sisa_tagihan_bebas;
                                    }

            $html.='            </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;">Total Tagihan Siswa</td>
                                        <td align="right" style="background-color:#e3e3e3; border-top: 1px solid black;">Rp</td>
                                        <td align="right" style="background-color:#e3e3e3; font-weight:bold; border-top: 1px solid black;">'.rupiah($total_tagihan_bulanan_bebas).'</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td align="justify">Kami mohon dengan sangat kepada bapak/ibu untuk melunasi tunggakan biaya diatas secepatnya. Jika tidak, maka dengan terpakasa anak bapak/ibu tersebut tidak bisa mengikuti ulangan/ujian.</td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td align="justify">Demikian surat pemberitahuan ini kami sampaikan atas perhatian dan kerjasamanya kami ucapkan terima kasih. Apabila ada kekeliruan dengan surat pemberitahuan ini. Kami mohon bapak/ibu melakukan konfirmasi ke bagian keuangan dengan membawa tanda bukti.</td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td align="justify">Atas perhatian dan partisipasinya kami ucapkan terima kasih.</td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td>
                            <table border="0">
                                <tr>
                                    <td width="365px"></td>
                                    <td width="120px" align="center">'.$idt['kabupaten'].', '.tgl_raport(date('Y-m-d')).'</td>
                                    <td width="40px"></td>
                                </tr>
                                 <tr>
                                    <td></td>
                                    <td align="center">Bendahara</td>
                                    <td></td>
                                </tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr><td colspan="3"></td></tr>
                                <tr>
                                    <td></td>
                                    <td align="center" style="font-weight:bold;">'.$idt['nmBendahara'].'</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td align="center">Nip. '.$idt['nipBendahara'].'</td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');

        $file = 'Tagihan Pembayaran Siswa NIS '.$siswa['nisSiswa'].' Nama '.$siswa['nmSiswa'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');

?>