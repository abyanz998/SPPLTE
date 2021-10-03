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
        
        $idTahunAjaran = $_GET['thn_ajar'];
        $idUnit = $_GET['unit'];
        $idKelas = $_GET['kelas'];
        $tgl_mulai = $_GET['tgl_mulai'];
        $tgl_akhir = $_GET['tgl_akhir'];

        $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran WHERE idTahunAjaran='$idTahunAjaran'"));
        if ($_GET['kelas'] !='all'){
          $kls = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM kelas_siswa WHERE idKelas='$idKelas'"));
          $kelas=$kls['nmKelas'];
        }else{
          $kelas = 'Semua Kelas';
        }


            //konfigurasi TCPDF
            $pdf= new TCPDF('P','mm','A4','true', 'UTF-8', false);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->setMargins(5,5,5,5);
            //menambahkan halaman
            $pdf->AddPage();
            //setting title
            $pdf->SetTitle('Laporan Pembayaran Kelas '.$kelas.' T.A.'.$ta['nmTahunAjaran'].' Tanggal '.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir));
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
                            <td align="center" style="font-weight:bold; font-size: 8pt">Laporan Pembayaran Tanggal '.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir).'</td>
                        </tr>
                        <tr><td></td></tr>
                        <tr>
                            <td>
                                <table style="font-size: 7pt" border="0" cellpadding="1">
                                    <tr>
                                        <td width="90px">Tahun Ajaran</td>
                                        <td width="10px">:</td>
                                        <td width="427px">'.$ta['nmTahunAjaran'].'</td>
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
                            <td>';

                                $total_pembayaran_keseluruhan = 0;
                                $sql_jenis_bayar = mysqli_query($koneksi,"SELECT jenis_bayar.*, pos_bayar.nmPosBayar FROM jenis_bayar LEFT JOIN pos_bayar ON jenis_bayar.idPosBayar=pos_bayar.idPosBayar WHERE jenis_bayar.idUnit='$idUnit' AND jenis_bayar.idTahunAjaran='$idTahunAjaran'");
                                while ($jenis_bayar = mysqli_fetch_array($sql_jenis_bayar)) {
                                    $html .= '<h4><strong>'.$jenis_bayar['nmPosBayar'].' - T.A.'.$ta['nmTahunAjaran'].'</strong></h4>';
                                    $html .= '<div class="box-body table-responsive">
                                                <table style="font-size:7pt; font-family: arial;" border="0" cellpadding="2" width="99%">
                                                    <thead>
                                                        <tr>
                                                            <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">No.</th>
                                                            <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Tanggal</th>
                                                            <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">NIS</th>
                                                            <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Nama</th>
                                                            <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Nominal</th>
                                                            <th style="font-weight:bold; border-top:0.5px solid black; border-bottom:0.5px solid black;">Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                <tbody>';

                                    $total_pembayaran = 0;

                                    if ($jenis_bayar['tipeBayar'] == 'Bulanan'){

                                        if ($idKelas == 'all'){
                                            $sqlBayarBulanan=mysqli_query($koneksi,"SELECT siswa.nisSiswa, siswa.nmSiswa, tagihan_bulanan.*, bulan.nmBulan FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa LEFT JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan WHERE tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.tglBayar BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa.stdel='0' ORDER BY tagihan_bulanan.tglBayar ASC");
                                        }else{
                                            $sqlBayarBulanan=mysqli_query($koneksi,"SELECT siswa.nisSiswa, siswa.nmSiswa, tagihan_bulanan.*, bulan.nmBulan FROM siswa LEFT JOIN tagihan_bulanan ON siswa.idSiswa = tagihan_bulanan.idSiswa LEFT JOIN bulan ON tagihan_bulanan.idBulan=bulan.idBulan WHERE tagihan_bulanan.idJenisBayar='$jenis_bayar[idJenisBayar]' AND tagihan_bulanan.statusBayar='1' AND tagihan_bulanan.tglBayar BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa.stdel='0' AND siswa.kelasSiswa='$idKelas' ORDER BY tagihan_bulanan.tglBayar ASC");
                                        }

                                        $no = 1;
                                        while ($bayarBulanan = mysqli_fetch_array($sqlBayarBulanan)) {
                                            $html .= '<tr>
                                                        <td>'.$no++.'</td>
                                                        <td>'.tgl_miring(date('Y-m-d',strtotime($bayarBulanan['tglBayar']))).'</td>
                                                        <td>'.$bayarBulanan['nisSiswa'].'</td>
                                                        <td>'.$bayarBulanan['nmSiswa'].'</td>
                                                        <td>'.buatRp($bayarBulanan['jumlahTagihan']).'</td>
                                                        <td>'.$bayarBulanan['nmBulan'].'</td>
                                                      </tr>';
                                            $total_pembayaran += $bayarBulanan['jumlahTagihan'];
                                            $total_pembayaran_keseluruhan += $bayarBulanan['jumlahTagihan'];
                                        } 

                                    }else{

                                        if ($idKelas == 'all'){
                                            $sqlBayarBebas=mysqli_query($koneksi,"SELECT siswa.nisSiswa, siswa.nmSiswa, tagihan_bebas_bayar.*, tagihan_bebas.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa = tagihan_bebas.idSiswa LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas WHERE tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.tglBayar BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa.stdel='0' ORDER BY tagihan_bebas_bayar.tglBayar ASC");
                                        }else{
                                            $sqlBayarBebas=mysqli_query($koneksi,"SELECT siswa.nisSiswa, siswa.nmSiswa, tagihan_bebas_bayar.*, tagihan_bebas.* FROM siswa LEFT JOIN tagihan_bebas ON siswa.idSiswa = tagihan_bebas.idSiswa LEFT JOIN tagihan_bebas_bayar ON tagihan_bebas.idTagihanBebas = tagihan_bebas_bayar.idTagihanBebas WHERE tagihan_bebas.idJenisBayar='$jenis_bayar[idJenisBayar]' AND tagihan_bebas.statusBayar!='0' AND tagihan_bebas_bayar.tglBayar BETWEEN '$tgl_mulai' AND '$tgl_akhir' AND siswa.kelasSiswa='$idKelas' AND siswa.stdel='0' ORDER BY tagihan_bebas_bayar.tglBayar ASC");
                                        }

                                        $no = 1;
                                        while ($bayarBebas = mysqli_fetch_array($sqlBayarBebas)) {
                                            $html .= '<tr>
                                                        <td>'.$no++.'</td>
                                                        <td>'.tgl_miring(date('Y-m-d',strtotime($bayarBebas['tglBayar']))).'</td>
                                                        <td>'.$bayarBebas['nisSiswa'].'</td>
                                                        <td>'.$bayarBebas['nmSiswa'].'</td>
                                                        <td>'.buatRp($bayarBebas['jumlahBayar']).'</td>
                                                        <td>'.$bayarBebas['ketBebas'].'</td>
                                                      </tr>';
                                            $total_pembayaran += $bayarBebas['jumlahBayar'];
                                            $total_pembayaran_keseluruhan += $bayarBebas['jumlahBayar'];
                                        } 

                                    }

                                    $html .= '  </tbody>
                                                <tfoot>
                                                  <tr style="background-color: #f0f0f0">
                                                    <td colspan="4"><strong>Total Pembayaran</strong></td>
                                                    <td>'.buatRp($total_pembayaran).'</td>
                                                    <td></td>
                                                  </tr>
                                                </tfoot>
                                              </table>
                                            </div>';
                   
                                }
                     
            $html .='       </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr><td><table style="font-size:8pt; font-weight:bold"><tr><td>Total Keseluruhan : '.buatRp($total_pembayaran_keseluruhan).'</td></tr></table></td></tr>
                        <tr><td></td></tr>
                        <tr>
                            <td>
                                <table border="0" style="font-size:7pt">
                                    <tr>
                                        <td width="388px"></td>
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


        $file = 'Laporan Pembayaran Kelas '.$kelas.' T.A.'.$ta['nmTahunAjaran'].' Tanggal '.tgl_raport($tgl_mulai).' Sampai '.tgl_raport($tgl_akhir).'.pdf';
        $nama_file    =str_replace(' ', '_', $file);
        //hasil print
        $pdf->Output($nama_file,'I');
    }else{
        include "../../login.php";
    }

?>