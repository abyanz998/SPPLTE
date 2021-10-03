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

        $idTahunAjaran = $_GET['thn_ajar'];
        $idUnit = $_GET['unit'];
        $idJenisBayar = $_GET['jenis'];
        $idKelas = $_GET['kelas'];


        $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));
        $TA = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
        $jenis_bayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT jenis_bayar.*, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idJenisBayar='$idJenisBayar'"));
        if ($idKelas !='all'){
          $kls = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));
          $kelas=$kls['nmKelas'];
        }else{
          $kelas = 'Semua Kelas';
        }

        if ($jenis_bayar['tipeBayar'] == 'Bulanan'){
            if ($idKelas == 'all'){
              $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.* FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' GROUP BY siswa.idSiswa");
            }else{
              $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bulanan.* FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' AND siswa.kelasSiswa='$idKelas' GROUP BY siswa.idSiswa");
            }
        }elseif ($jenis_bayar['tipeBayar'] == 'Bebas'){
            if ($idKelas == 'all'){
              $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bebas.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa = tagihan_bebas.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' GROUP BY siswa.idSiswa");
            }else{
              $sqlSiswa = mysqli_query($koneksi,"SELECT siswa.*, tagihan_bebas.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa = tagihan_bebas.idSiswa WHERE siswa.unitSiswa='$idUnit' AND siswa.statusSiswa='Aktif' AND siswa.stdel='0' AND tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' AND siswa.kelasSiswa='$idKelas' GROUP BY siswa.idSiswa");
            }
        }

        if (isset($_GET['Bulanan'])){
            //konfigurasi TCPDF
            $pdf= new TCPDF('L','mm','A4','true', 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->setMargins(5,5,5,5);
            //menambahkan halaman
            $pdf->AddPage();
            //setting title
            $pdf->SetTitle('Laporan Pembayaran '.$jenis_bayar['nmPosBayar'].' T.A. '.$TA['nmTahunAjaran'].' Kelas '.$kelas);
            //isi pdf
            $html ='<table border="0" cellpadding="2px">
                        <tr>
                            <td style="font-weight: bold; font-size: 14pt">'.$idt['nmSekolah'].'</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</td>
                        </tr>
                        <tr>
                            <td><hr style="height:1px"></td>
                        </tr>
                        
                    </table><br>';
            $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');

            $html = '<table style="font-size: 8pt" cellpadding="1" border="0">
                        <tr>
                            <td align="center" style="font-weight:bold; font-size: 9pt">Laporan Pembayaran '.$jenis_bayar['nmPosBayar'].'</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="font-size: 7pt" border="0" cellpadding="1">
                                    <tr>
                                        <td width="90px">Tahun Ajaran</td>
                                        <td width="10px">:</td>
                                        <td width="427px">'.$TA['nmTahunAjaran'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td>:</td>
                                        <td>'.$kelas.'</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="font-size:7pt; font-family: arial;" border="0" cellpadding="2">
                                    <thead>
                                        <tr align="center">
                                            <th width="20px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">No</th>
                                            <th width="60px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">NIS</th>
                                            <th width="70px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Nama Siswa</th>';
                                            $bulan = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
                                            while ($bln = mysqli_fetch_array($bulan)) {
                                            $html.= '<th style="font-weight:bold;border-top:0.5px solid black;border-bottom:0.5px solid black;">'.getBulan($bln['idBulan']).'</th>';
                                          }
                        $html.='        </tr>
                                    </thead>
                                    <tbody>';
                                       $no = 1;
                                       $total_pembayaran = 0;
                                        while ($siswa = mysqli_fetch_array($sqlSiswa)) {
                                          $html.= '<tr align="center">
                                                  <td>'.$no++.'</td>
                                                  <td>'.$siswa['nisSiswa'].'</td>
                                                  <td>'.$siswa['nmSiswa'].'</td>';
                                                  $bulan = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
                                                  while ($bln = mysqli_fetch_array($bulan)) {
                                                    $tagihanBulanan = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bulanan.*, jenis_bayar.idTahunAjaran FROM tagihan_bulanan LEFT JOIN jenis_bayar ON tagihan_bulanan.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bulanan.idSiswa='$siswa[idSiswa]' AND tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' AND jenis_bayar.idTahunAjaran='$TA[idTahunAjaran]' AND idBulan='$bln[idBulan]'"));
                                                    if ($tagihanBulanan['statusBayar'] == '1'){
                                                      $keterangan = buatRp($tagihanBulanan['jumlahTagihan']).'<br>'.date('d/m/Y',strtotime($tagihanBulanan['tglBayar']));
                                                      $total_pembayaran += $tagihanBulanan['jumlahTagihan'];
                                                    }else{
                                                      $keterangan = '-';
                                                    }
                                                    $html.= '<td>'.$keterangan.'</td>';
                                                  }
                                          $html.= "</tr>";

                                        }


                $html.='            </tbody>
                                    <tfoot>
                                        <tr align="center">
                                            <th style="border-top:0.5px solid black;"></th>
                                            <th style="border-top:0.5px solid black;"></th>
                                            <th style="border-top:0.5px solid black;"></th>';
                                            $bulan = mysqli_query($koneksi,"SELECT * FROM bulan ORDER BY urutan ASC");
                                            while ($bln = mysqli_fetch_array($bulan)) {
                                            $html.= '<th style="border-top:0.5px solid black;"></th>';
                                          }
                        $html.='        </tr>
                                    </tfoot>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <th style="font-weight:bold">Total Pembayaran '.buatRp($total_pembayaran).'</th>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td>
                                <table border="0" style="font-size:7pt">
                                    <tr>
                                        <td width="658px"></td>
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

        }elseif (isset($_GET['Bebas'])){

            //konfigurasi TCPDF
            $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->setMargins(8,8,8,8);
            //menambahkan halaman
            $pdf->AddPage();
            //setting title
            $pdf->SetTitle('Laporan Pembayaran '.$jenis_bayar['nmPosBayar'].' T.A. '.$TA['nmTahunAjaran'].' Kelas '.$kelas);
            //isi pdf
            $html ='<table border="0" cellpadding="2px">
                        <tr>
                            <td style="font-weight: bold; font-size: 14pt">'.$idt['nmSekolah'].'</td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">'.$idt['alamat'].', '.$idt['kecamatan'].', '.$idt['kabupaten'].', '.$idt['propinsi'].' Telp. '.$idt['noTelp'].'</td>
                        </tr>
                        <tr>
                            <td><hr style="height:1px"></td>
                        </tr>
                        
                    </table><br>';
            $pdf->writeHTML($html,FALSE,FALSE,FALSE,'L');

            $html = '<table style="font-size: 8pt" cellpadding="1" border="0">
                        <tr>
                            <td align="center" style="font-weight:bold; font-size: 9pt">Laporan Pembayaran '.$jenis_bayar['nmPosBayar'].'</td>
                        </tr>
                        <tr>
                            <td>
                                <table style="font-size: 7pt" border="0" cellpadding="1">
                                    <tr>
                                        <td width="90px">Tahun Ajaran</td>
                                        <td width="10px">:</td>
                                        <td width="427px">'.$TA['nmTahunAjaran'].'</td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td>:</td>
                                        <td>'.$kelas.'</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="font-size:7pt; font-family: arial;" border="0" cellpadding="2">
                                    <thead>
                                        <tr align="center">
                                            <th width="20px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">No</th>
                                            <th width="100px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">NIS</th>
                                            <th width="110px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Nama Siswa</th>
                                            <th width="75px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Tagihan</th>
                                            <th width="75px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Sudah Dibayar</th>
                                            <th width="75px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Kekurangan</th>
                                            <th width="75px" style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                        $no = 1;
                                        $total_pembayaran_siswa=0;
                                        while ($siswa = mysqli_fetch_array($sqlSiswa)) {
                                          $tagihanBebas = mysqli_fetch_array(mysqli_query($koneksi,"SELECT tagihan_bebas.idTagihanBebas, SUM(tagihan_bebas.totalTagihan) as totalTagihanBebas, jenis_bayar.idTahunAjaran FROM tagihan_bebas LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar=jenis_bayar.idJenisBayar WHERE tagihan_bebas.idSiswa='$siswa[idSiswa]' AND tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' AND jenis_bayar.idTahunAjaran='$TA[idTahunAjaran]'"));
                                          $tagihanBebasBayar = mysqli_fetch_array(mysqli_query($koneksi,"SELECT SUM(jumlahBayar) as totalTagihanBebasBayar FROM tagihan_bebas_bayar WHERE idTagihanBebas='$tagihanBebas[idTagihanBebas]' GROUP BY idTagihanBebas"));
                                          
                                          $sisaTagihanBebas = $tagihanBebas['totalTagihanBebas'] - $tagihanBebasBayar['totalTagihanBebasBayar'];
                                          if ($sisaTagihanBebas == 0){
                                            $keterangan = 'LUNAS';
                                          }else{
                                            $keterangan = 'BELUM LUNAS';
                                          }

                                          $html.= '<tr align="center">
                                                  <td>'.$no++.'</td>
                                                  <td>'.$siswa['nisSiswa'].'</td>
                                                  <td>'.$siswa['nmSiswa'].'</td>
                                                  <td>'.buatRp($tagihanBebas['totalTagihanBebas']).'</td>
                                                  <td>'.buatRp($tagihanBebasBayar['totalTagihanBebasBayar']).'</td>
                                                  <td>'.buatRp($sisaTagihanBebas).'</td>
                                                  <td>'.$keterangan.'</td>
                                                </tr>';
                                          $total_pembayaran_siswa += $tagihanBebasBayar['totalTagihanBebasBayar'];
                                        }
                $html.='            </tbody>
                                    <tfoot>
                                        <tr align="center" style="background-color:#e3e3e3; font-weight:bold">
                                            <th colspan="4" align="left">Total Pembayaran Siswa</th>
                                            <th>'.buatRp($total_pembayaran_siswa).'</th>
                                            <th colspan="2"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td>
                                <table border="0" style="font-size:7pt">
                                    <tr>
                                        <td width="398px"></td>
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

        }

        $file = 'Laporan Pembayaran '.$jenis_bayar['nmPosBayar'].' T.A. '.$TA['nmTahunAjaran'].' Kelas '.$kelas.'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }

?>