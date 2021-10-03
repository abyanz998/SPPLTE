<?php
    session_start();
    error_reporting(0);
    include "../../config/koneksi.php";
    include "../../config/rupiah.php";
    include "../../config/library.php";
    include "../../config/fungsi_indotgl.php";
    include "../../config/variabel_default.php";
    require_once('../../plugins/tcpdf/tcpdf.php');

    if (isset($_SESSION['idUsers'])){
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
        $siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT siswa.*,
                                                                   kelas_siswa.nmKelas,
                                                                   unit_sekolah.singkatanUnit
                                                            FROM siswa
                                                            LEFT JOIN kelas_siswa ON siswa.kelasSiswa = kelas_siswa.idKelas
                                                            LEFT JOIN unit_sekolah ON siswa.unitSiswa = unit_sekolah.idUnit
                                                            WHERE nisSiswa = '$_GET[nis]'"));

        $total_tagihan_bulanan_bebas = 0;
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
                                                WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]' ORDER BY tagihan_bulanan.idTagihanBulanan ASC");

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
                                                WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND jenis_bayar.idTahunAjaran='$_GET[thn_ajar]'
                                                GROUP BY tagihan_bebas.idJenisBayar");

    
        //konfigurasi TCPDF
        $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->setMargins(7,7,7,7);
        //menambahkan halaman
        $pdf->AddPage();
        //setting title
        $pdf->SetTitle('Pembayaran '.$siswa['nisSiswa'].' - '.$siswa['nmSiswa']);
        //isi pdf
        $html ='<table border="0" cellpadding="2px">
                    <tr>
                        <td style="font-weight: bold; font-size: 14pt">'.$idt['nmSekolah'].'</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; font-size: 8pt;">'.$unit.'</td>
                    </tr>
                    <tr><td style="font-size: 8pt;"></td></tr>
                    <tr>
                        <td style="font-size: 8pt;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].'</td>
                    </tr>
                    <tr><td style="font-size: 8pt;">Telp. '.$idt['noTelp'].'</td></tr>
                    <tr>
                        <td><hr style="height:2px"></td>
                    </tr>
                    
                </table><br>';
        $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');

        $html = '<table style="font-size: 8pt" cellpadding="1" border="0">
                    <tr>
                        <td align="center" style="font-weight:bold; font-size: 14pt">RINCIAN PEMBAYARAN ADMINISTRASI</td>
                    </tr>
                    <tr><td style="font-size: 2pt"></td></tr>
                    <tr>
                        <td align="center" style="font-weight:bold; font-size: 12pt">TAHUN PELAJARAN '.$TA[nmTahunAjaran].'</td>
                    </tr>
                    <tr><td style="font-size: 2pt"></td></tr>
                    <tr>
                        <td align="center" style="font-weight:bold; font-size: 10pt">Unit Sekolah : '.$siswa[singkatanUnit].'</td>
                    </tr>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr>
                        <td>
                            <table style="font-size: 9pt" border="0" cellpadding="1">
                                <tr>
                                    <td width="90px">NIS</td>
                                    <td width="10px">:</td>
                                    <td width="427px">'.$siswa['nisSiswa'].'</td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>'.$siswa['nmSiswa'].'</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>:</td>
                                    <td>'.$siswa['nmKelas'].'</td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style="font-size:8pt" border="1" cellpadding="2">
                                <thead>
                                    <tr align="center">
                                        <th width="20px" style="font-weight:bold;">No</th>
                                        <th width="190px" style="font-weight:bold;">NAMA PEMBAYARAN</th>
                                        <th width="80px" style="font-weight:bold;">TANGGAL BAYAR</th>
                                        <th width="80px" style="font-weight:bold;">NOMINAL</th>
                                        <th width="80px" style="font-weight:bold;">KETERANGAN</th>
                                        <th width="85px" style="font-weight:bold;">DIBAYAR VIA</th>
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

                                        if ($r['statusBayar'] == '1'){
                                            $tagihan = '-';
                                            $keterangan = 'Lunas';
                                        }else{
                                            $tagihan = buatRp($r['jumlahTagihan']);
                                            $keterangan = 'Belum Lunas';
                                        }

                                        if ($r['tglBayar'] == '' OR $r['tglBayar'] == '0000-00-00 00:00:00'){
                                            $tanggalBayar = '-';
                                            $viaAkun = '-';
                                        }else{
                                            $tanggalBayar = tgl_raport($r['tglBayar']);
                                            $viaAkun = $r['keterangan'];
                                        }
                                        $html.='<tr>
                                                    <td align="center">'.$no++.'</td>
                                                    <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].' - ('.$nmBulan.')</td>
                                                    <td align="center">'.$tanggalBayar.'</td>
                                                    <td align="right">'.$tagihan.'</td>
                                                    <td align="center">'.$keterangan.'</td>
                                                    <td align="center">'.$viaAkun.'</td>
                                                </tr>';
                                    }
                                    
                                    while ($r = mysqli_fetch_array($tampil_bebas)) {
                                        $totalBayarBebas = mysqli_fetch_array(mysqli_query($koneksi, "SELECT SUM(jumlahBayar) as totalBayarBebas FROM tagihan_bebas_bayar WHERE idTagihanBebas='$r[idTagihanBebas]'"));
                                        $tglBayar = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tagihan_bebas_bayar WHERE idTagihanBebas='$r[idTagihanBebas]' ORDER BY idTagihanBebasBayar DESC LIMIT 1"));
                                        $sisa_tagihan_bebas = $r['totalTagihanBebas']-$totalBayarBebas['totalBayarBebas'];

                                        if ($sisa_tagihan_bebas != 0){
                                            $tanggalBayar = '-';
                                            $tagihan = buatRp($sisa_tagihan_bebas);
                                            $keterangan = 'Belum Lunas';
                                            $viaAkun = '-';
                                        }else{
                                            $tanggalBayar=  tgl_raport($tglBayar['tglBayar']);
                                            $tagihan = '-';
                                            $keterangan = 'Lunas';
                                            $viaAkun = '-';
                                        }
                                        $html.= '<tr>
                                                    <td align="center">'.$no++.'</td>
                                                    <td>'.$r['nmPosBayar'].' - T.A '.$r['nmTahunAjaran'].'</td>
                                                    <td align="center">'.$tanggalBayar.'</td>
                                                    <td align="right">'.$tagihan.'</td>
                                                    <td align="center">'.$keterangan.'</td>
                                                    <td align="center">'.$viaAkun.'</td>
                                                </tr>';
                                    }


            $html.='            </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <td>
                            <table border="0">
                                <tr>
                                    <td width="385px"></td>
                                    <td width="120px" align="center">'.$idt['kabupaten'].', '.tgl_raport(date('Y-m-d')).'</td>
                                    <td width="20px"></td>
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

        $file = 'Semua Pembayaran Siswa NIS '.$siswa['nisSiswa'].' Nama '.$siswa['nmSiswa'].'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');

    }else{
        include "../../login.php";
    }
?>