  
  <style type="text/css">

    td {
      cursor: pointer;
    }

  </style>

    <div class="col-xs-12">  
        <div class="box box-success">
          <div class="box-header with-border">
             <form action="" class="form-horizontal" method="get" accept-charset="utf-8">
                <div class="box-body table-responsive">
                  <table>
                    <tbody>
                      <tr>
                        <td>     
                          <input type="hidden" name="view" value="<?= $_GET[view] ?>">
                          <input type="hidden" id="idUnit" value="<?= $_GET[unit] ?>">
                          <select style="width: 200px;" id="Cunit" name="unit" class="form-control" required></select>
                      </td>
                      <td>
                          &nbsp;&nbsp;
                      </td>
                      <td>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Pilih</button>    
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </form> 
          </div>

          <?php if (isset($_GET['unit'])){ ?>

          <div class="box-body">
             <div class="box-body table-responsive">

              <table id="example1" class="table table-hover dataTable no-footer">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Akun</th>
                    <th>Keterangan</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    
                    $Q_akun = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE stdel='0' AND jenisAkun='Akun Utama' ORDER BY idAkun ASC");
                    $no = 1;
                    while($Autama=mysqli_fetch_array($Q_akun)){
                     if ($Autama['saldo_awal_debit'] == ''){
                      $debit = '-';
                     }
                     if ($Autama['saldo_awal_kredit'] == ''){
                      $kredit = '-';
                     }

                      echo '<tr style="font-weight:bold">
                              <td>'.$no++.'</td>
                              <td>'.$Autama['kodeAkun'].'</td>
                              <td>'.$Autama['keterangan'].'</td>
                              <td>'.$debit.'</td>
                              <td>'.$kredit.'</td>
                             
                            </tr>';

                          if (isset($_GET['unit'])){
                            $Q_Akun_Sub1 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$Autama[idAkun]' AND akun_biaya.unitSekolah='$_GET[unit]' ORDER BY akun_biaya.idAkun ASC");
                          }elseif($_SESSION['unit'] != '0'){
                            $Q_Akun_Sub1 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$Autama[idAkun]' AND akun_biaya.unitSekolah='$_SESSION[unit]' ORDER BY akun_biaya.idAkun ASC");
                          }else{
                            $Q_Akun_Sub1 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$Autama[idAkun]' ORDER BY akun_biaya.idAkun ASC");
                          }
                          while($aSub1=mysqli_fetch_array($Q_Akun_Sub1)){
                             if ($aSub1['saldo_awal_debit'] == ''){
                              $debit = '-';
                             }
                             if ($aSub1['saldo_awal_kredit'] == ''){
                              $kredit = '-';
                             }
                            echo '<tr style="font-weight:bold">
                                    <td>'.$no++.'</td>
                                    <td>'.$aSub1['kodeAkun'].'</td>
                                    <td>'.$aSub1['keterangan'].'</td>
                                    <td>'.$debit.'</td>
                                    <td>'.$kredit.'</td>
                                  </tr>';


                              if (isset($_GET['unit'])){
                                $Q_Akun_Sub2 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub1[idAkun]' AND akun_biaya.unitSekolah='$_GET[unit]' ORDER BY akun_biaya.idAkun ASC");
                              }elseif($_SESSION['unit'] != '0'){
                                $Q_Akun_Sub2 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub1[idAkun]' AND akun_biaya.unitSekolah='$_SESSION[unit]' ORDER BY akun_biaya.idAkun ASC");
                              }else{
                                $Q_Akun_Sub2 = mysqli_query($koneksi,"SELECT * FROM akun_biaya WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub1[idAkun]' ORDER BY akun_biaya.idAkun ASC");
                              }

                              while($aSub2=mysqli_fetch_array($Q_Akun_Sub2)){
                                echo '<tr>
                                        <td>'.$no++.'</td>
                                        <td>'.$aSub2['kodeAkun'].'</td>
                                        <td>'.$aSub2['keterangan'].'</td>
                                        <td>
                                          <span class="caption" data-id="'.$aSub2['idAkun'].'" >'.$aSub2['saldo_awal_debit'].'</span> 
                                          <input type="text" class="field-debit form-control editor" style="display: none;" value="'.$aSub2['saldo_awal_debit'].'" data-id="'.$aSub2['idAkun'].'" data-toggle="tooltip" title="" data-original-title="Tekan Enter Setelah Selesai!" style="display: inline-block;">
                                        </td>
                                        <td>
                                          <span class="caption" data-id="'.$aSub2['idAkun'].'">'.$aSub2['saldo_awal_kredit'].'</span> 
                                          <input type="text" class="field-kredit form-control editor" style="display: none;" value="'.$aSub2['saldo_awal_kredit'].'" data-id="'.$aSub2['idAkun'].'" data-toggle="tooltip" title="" data-original-title="Tekan Enter Setelah Selesai!">
                                        </td>
                                      </tr>';


                              if (isset($_GET['unit'])){
                                $Q_Akun_Sub3 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub2[idAkun]' AND akun_biaya.unitSekolah='$_GET[unit]' ORDER BY akun_biaya.idAkun ASC");
                              }elseif($_SESSION['unit'] != '0'){
                                $Q_Akun_Sub3 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub2[idAkun]' AND akun_biaya.unitSekolah='$_SESSION[unit]' ORDER BY akun_biaya.idAkun ASC");
                              }else{
                                $Q_Akun_Sub3 = mysqli_query($koneksi,"SELECT akun_biaya.*, unit_sekolah.singkatanUnit FROM akun_biaya LEFT JOIN unit_sekolah ON akun_biaya.unitSekolah = unit_sekolah.idUnit WHERE akun_biaya.stdel='0' AND akun_biaya.idSubAkun='$aSub2[idAkun]' ORDER BY akun_biaya.idAkun ASC");
                              }
                                        
                                        while($aSub3=mysqli_fetch_array($Q_Akun_Sub3)){
                                          echo '<tr>
                                                  <td>'.$no++.'</td>
                                                  <td>'.$aSub3['kodeAkun'].'</td>
                                                  <td>'.$aSub3['keterangan'].' '.str_replace('-',' ',$aSub3['singkatanUnit']).'</td>
                                                  <td>'.$aSub3['saldo_awal_debit'].'</td>
                                                  <td>'.$aSub3['saldo_awal_kredit'].'</td>
                                                </tr>';
                          
                                        }
                                  
                            }
                         } 
                    }
                  ?>
                </tbody>
                <tbody>
                  <tr>
                    <td colspan="5" id="saldo_awal">
                      
                    </td>
                  </tr>
                </tbody>
              
              </table>
    
            </div><!-- /.box-body -->
          </div><!-- /.box -->

          <?php } ?>
        </div>

<script type="text/javascript">
  
  get_total();
    
    $(function(){
    
    $.ajaxSetup({
      type:"POST",
      cache:false,
    });
    
    $(document).on("click","td",function(){
        $(this).find("span[class~='caption']").hide();
        $(this).find("input[class~='editor']").fadeIn().focus();
    });
    
    $(document).on("keydown",".editor",function(e){
        
        if(e.keyCode==13){
            
            var target=$(e.target);
            var value=target.val();
            var id=target.attr("data-id");
            var tipe='simpan';
            var data={id:id,value:value,tipe:tipe};
            
            if (target.is(".field-debit")){
            data.modul="saldo_awal_debit";
            } else if (target.is(".field-kredit")){
            data.modul="saldo_awal_kredit";
            }
            
                $.ajax({
                  data:data,
                  url: 'admin/kas/saldo_awal.php',
                  success: function(msg){
                    $("span[class~='caption']").show();
                    $("[data-toggle='tooltip']").tooltip('hide');
                    $("input[class~='editor']").fadeOut();
                   target.hide();
                   target.siblings("span[class~='caption']").html(value).fadeIn();
                   get_total();
                  }
                
                })
            
        }
    
    });
    
    })
    
    function get_total(){
      var id_unit    = $("#idUnit").val();
              
        $.ajax({ 
            url: 'admin/kas/saldo_awal.php',
            type: 'POST', 
            cache:false,
            data: {
                    'id_unit' : id_unit,
                    'tipe'    : 'get_total',
            },    
            success: function(msg) {
                    $("#saldo_awal").html(msg);
            },
            error: function(msg){
              alert('msg');
            }
      });
    }
    </script>