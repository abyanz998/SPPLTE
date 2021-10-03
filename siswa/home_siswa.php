  

  <?php
    $bln_aktif = (int)$bln_sekarang;
    $bln = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM bulan WHERE idBulan='$bln_aktif'"));

    $tagihanBulanAktif = mysqli_fetch_array(mysqli_query($koneksi,"SELECT 
                                                                      tagihan_bulanan.*,
                                                                      SUM(tagihan_bulanan.jumlahTagihan) as totalTagihanBulanan,
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
                                                                    WHERE tagihan_bulanan.idSiswa='$idSiswa' AND jenis_bayar.idTahunAjaran='$ta[idTahunAjaran]' AND tagihan_bulanan.statusBayar='0' AND bulan.urutan <= '$bln[urutan]' GROUP BY tagihan_bulanan.idJenisBayar"));

    $sqlTagihanBebas = mysqli_query($koneksi, "SELECT
                                          tagihan_bebas.*,
                                          jenis_bayar.idPosBayar
                                        FROM
                                          tagihan_bebas
                                        LEFT JOIN jenis_bayar ON tagihan_bebas.idJenisBayar = jenis_bayar.idJenisBayar
                                        WHERE tagihan_bebas.idSiswa='$idSiswa' AND jenis_bayar.idTahunAjaran='$ta[idTahunAjaran]' AND tagihan_bebas.statusBayar!='1'");

    while($rtb=mysqli_fetch_array($sqlTagihanBebas)){
      $dtBayar=mysqli_fetch_array(mysqli_query($koneksi, "SELECT sum(jumlahBayar) as totalDibayar FROM tagihan_bebas_bayar WHERE idTagihanBebas='$rtb[idTagihanBebas]'"));
      $sisaTagihanBebas=$rtb['totalTagihan'] - $dtBayar['totalDibayar']; 
    }
  ?>
  <div class="col-xs-12">  
    <div class="row">
      <div class="col-md-6">
       <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">Informasi</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <!-- Indicators --> 
              <ol class="carousel-indicators ind"> 
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li> 
                <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li> 
                <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li> 
              </ol> 
              <!-- Wrapper for slides --> 
              <div class="carousel-inner"> 
                <?php 
                  $urut = 0;
                  $query_informasi=mysqli_query($koneksi,"SELECT * FROM informasi WHERE publikasiInformasi = '1' AND stdel = '0' ORDER BY idInformasi DESC LIMIT 3");
                  while($info=mysqli_fetch_array($query_informasi)){
                    if ($urut == 0){
                      echo '<div class="item active"> 
                              <div class="row"> 
                                <div class="adjust1"> 
                                  <div class="caption"> 
                                    <p class="text-info lead adjust2 col-sm-12">
                                      <img src="'.$lokasi_foto_informasi.$info['gambarInformasi'].'" width="100%">
                                      '.$info['judulInformasi'].' 
                                    </p>  
                                    <blockquote class="adjust2"> <p>'.$info['isiInformasi'].'</p> </blockquote> 
                                  </div> 
                                </div> 
                              </div> 
                            </div> ';
                    }else{
                      echo '<div class="item"> 
                              <div class="row"> 
                                <div class="adjust1"> 
                                  <div class="caption"> 
                                    <p class="text-info lead adjust2 col-sm-12">
                                      <img src="'.$lokasi_foto_informasi.$info['gambarInformasi'].'" width="100%">
                                      '.$info['judulInformasi'].'
                                    </p>  
                                    <blockquote class="adjust2"> <p>'.$info['isiInformasi'].'</p></blockquote> 
                                  </div> 
                                </div> 
                              </div> 
                            </div> ';
                    }
                    $urut++;
                  }
                ?>
                  
            </div> <!-- Controls --> 
              <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"> 
                <span class="glyphicon glyphicon-chevron-left" style="font-size:20px"></span> </a> 
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"> 
                  <span class="glyphicon glyphicon-chevron-right" style="font-size:20px"></span> 
                </a> 
              </div> 
            </div>
        </div>
      </div>



        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-dollar"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text" style="text-transform: capitalize;">Tagihan Bulan <?= $bln['nmBulan'] ?></span>
              <span class="info-box-number">Rp. <?= rupiah($tagihanBulanAktif['totalTagihanBulanan']) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text dash-text" style="text-transform: capitalize;">Tagihan Lainnya</span>
              <span class="info-box-number">Rp. <?= rupiah($sisaTagihanBebas) ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


    </div>
  </div>