<?php 
          if ($_GET[view]=='home' OR $_GET[view]==''){
				echo "<div class='row'>";
					include "siswa/home_siswa.php";
				echo "</div>";
          }
		  elseif ($_GET[view]=='pengaturan'){
            
            echo "<div class='row'>";
                    include "siswa/pengaturan_identitas.php";
            echo "</div>";
			}
			elseif ($_GET[view]=='kasmas'){
           
            echo "<div class='row'>";
                    include "siswa/com_kas/masuk.php";
            echo "</div>";
			}
			elseif ($_GET[view]=='kaskel'){
           
            echo "<div class='row'>";
                    include "siswa/com_kas/keluar.php";
            echo "</div>";
			}
		  elseif ($_GET[view]=='calendar'){
            
            echo "<div class='row'>";
                    include "siswa/calendar.php";
            echo "</div>";
          }
          elseif ($_GET[view]=='admin'){
            
            echo "<div class='row'>";
                    include "siswa/master_admin.php";
            echo "</div>";
          }
		  elseif ($_GET[view]=='tahun'){
            
            echo "<div class='row'>";
                    include "siswa/master_tahun.php";
            echo "</div>";
          }elseif ($_GET[view]=='kelas'){
            
            echo "<div class='row'>";
                    include "siswa/master_kelas.php";
            echo "</div>";
          }elseif ($_GET[view]=='siswa'){
            
            echo "<div class='row'>";
                    include "siswa/master_siswa.php";
            echo "</div>";
          }elseif ($_GET[view]=='kelulusan'){
            
            echo "<div class='row'>";
                    include "siswa/master_kelulusan.php";
            echo "</div>";
          }elseif ($_GET[view]=='kenaikankelas'){
            
            echo "<div class='row'>";
                    include "siswa/master_kenaikankelas.php";
            echo "</div>";
          }elseif ($_GET[view]=='hutangtoko'){
            
            echo "<div class='row'>";
                    include "siswa/hutangtoko.php";
            echo "</div>";
			}elseif ($_GET[view]=='detailtoko'){
            
            echo "<div class='row'>";
                    include "siswa/detailtoko.php";
            echo "</div>";
			}elseif ($_GET[view]=='posbayar'){
            
            echo "<div class='row'>";
                    include "siswa/keuangan_posbayar.php";
            echo "</div>";
          }elseif ($_GET[view]=='jenisbayar'){
            
            echo "<div class='row'>";
                    include "siswa/keuangan_jenisbayar.php";
            echo "</div>";
			
		  }elseif ($_GET[view]=='tarif' && $_GET[tipe]=='bulanan'){
            
            echo "<div class='row'>";
                    include "siswa/keuangan_tarif_bulanan.php";
            echo "</div>";
			
          }elseif ($_GET[view]=='tarif' && $_GET[tipe]=='bebas'){
            
            echo "<div class='row'>";
                    include "siswa/keuangan_tarif_bebas.php";
            echo "</div>";
			
		  }elseif ($_GET[view]=='pembayaran'){
            
            echo "<div class='row'>";
                    include "siswa/keuangan_pembayaran.php";
            echo "</div>";
		  
		  }elseif ($_GET[view]=='angsuran'){
            
            echo "<div class='row'>";
                    include "siswa/keuangan_pembayaran_bebas.php";
            echo "</div>";
		  
		  }elseif ($_GET[view]=='bayarbulanan'){
            
            echo "<div class='row'>";
                    include "siswa/keuangan_pembayaran_bulanan.php";
            echo "</div>";
			
          }elseif ($_GET[view]=='jurnalumum'){
            
            echo "<div class='row'>";
                    include "siswa/keuangan_jurnalumum.php";
            echo "</div>";

          }elseif ($_GET[view]=='lapsiswa'){
            
            echo "<div class='row'>";
                    include "siswa/laporan_siswa.php";
            echo "</div>";
          }elseif ($_GET[view]=='lappembayaran'){
            
            echo "<div class='row'>";
                    include "siswa/laporan_pembayaran_perkelas.php";
            echo "</div>";
    		  }elseif ($_GET[view]=='lappembayaranperbulan'){
            
            echo "<div class='row'>";
                    include "siswa/laporan_pembayaran_perbulan.php";
            echo "</div>";
          }elseif ($_GET[view]=='lappembayaranperposbayar'){
            
            echo "<div class='row'>";
                    include "siswa/laporan_pembayaran_perposbayar.php";
            echo "</div>";
          }elseif ($_GET[view]=='laptagihansiswa'){
            
            echo "<div class='row'>";
                    include "siswa/laporan_tagihan_siswa.php";
            echo "</div>";
          }elseif ($_GET[view]=='rekapitulasi'){
            
            echo "<div class='row'>";
                    include "siswa/laporan_rekapitulasi.php";
            echo "</div>";
          }elseif ($_GET[view]=='rekappengeluaran'){
            
            echo "<div class='row'>";
                    include "siswa/laporan_rekappengeluaran.php";
            echo "</div>";
          }elseif ($_GET[view]=='rekapkondisikeuangan'){
            
            echo "<div class='row'>";
                    include "siswa/laporan_kondisi_keuangan.php";
            echo "</div>";
			
		  }elseif ($_GET[view]=='backup'){
            
            echo "<div class='row'>";
                    include "siswa/backup-datas.php";
            echo "</div>";
			
		  }elseif ($_GET[view]=='restore'){
            
            echo "<div class='row'>";
                    include "siswa/restore.php";
            echo "</div>";
		}elseif ($_GET[view]=='kelasnya'){
            
            echo "<div class='row'>";
                    include "siswa/com_kelas/kelas.php";
            echo "</div>";
			}elseif ($_GET[view]=='nasabah'){
            
            echo "<div class='row'>";
                    include "siswa/com_nasabah/nasabah.php";
            echo "</div>";
		  	}elseif ($_GET[view]=='transaksi'){
            
            echo "<div class='row'>";
                    include "siswa/com_transaksi/transaksi.php";
            echo "</div>";
			}elseif ($_GET[view]=='laporan-transaksi'){
            
            echo "<div class='row'>";
                    include "siswa/com_laporan/laporan-transaksi.php";
            echo "</div>";	  
			}elseif ($_GET[view]=='pengaturant'){
            
            echo "<div class='row'>";
                    include "siswa/com_pengaturan/pengaturan.php";
            echo "</div>";	  
			}elseif ($_GET[view]=='laptransaksinasabah'){
            
            echo "<div class='row'>";
                    include "siswa/com_laporan/laporan-nasabah.php";
            echo "</div>";	
			}elseif ($_GET[view]=='laptransaksi'){
            
            echo "<div class='row'>";
                    include "siswa/com_laporan/laporan-transaksi.php";
            echo "</div>";	   							
			
          }
		  
		  
        ?>