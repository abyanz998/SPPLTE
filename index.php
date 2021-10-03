<?php
  session_start();
  error_reporting(0);
  include "config/koneksi.php";
  include "config/library.php";
  include "config/fungsi_indotgl.php";
  include "config/excel_reader2.php";
  include "config/fungsi_seo.php";
  include "config/fungsi_thumb.php";
  include 'config/rupiah.php';
  include 'config/variabel_default.php';
  include 'config/variabel_url.php';
  include 'config/kode_otomatis.php';
  include 'config/user_agent.php';



  if (isset($_SESSION['idUsers'])){
    //buat variabel idUsers
    $idUsers = $_SESSION['idUsers'];
    $idUnitUsers = $_SESSION['unit'];

    //ambil data penguna
    $idt_user = mysqli_fetch_array(mysqli_query($koneksi,"SELECT users.*, users_level.idUsersLevel, users_level.namaUsersLevel FROM users INNER JOIN users_level ON users.level = users_level.idUsersLevel WHERE idUsers='$idUsers'"));

    //cek foto pengguna
    if ($idt_user['foto'] == ''){ $foto_user = $lokasi_default_fotoPengguna; }
    else { $foto_user = $lokasi_foto_pengguna.$idt_user['foto']; }

    //ambil data identitas sistem
    $idt = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM identitas"));
    //ambil data tahun ajaran yang aktif
    $ta = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM tahun_ajaran where status='Aktif'"));
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $idt[nmAplikasi] ?></title>
    <link rel="shortcut icon" href="<?= $lokasi_penyimpanan_logo.$idt['logo_kiri']?>">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./assets/font-awesome-4.6.3/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="./assets/ionicons/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="plugins/datatables/dataTables.checkboxes.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/green.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="plugins/datetimepicker/bootstrap-datetimepicker.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- Bootstrap Select -->
    <link rel="stylesheet" href="assets/bootstrap-select/css/bootstrap-select.min.css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <!-- Full calendar-->
    <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.css">

    <style type="text/css"> .files{ position:absolute; z-index:2; top:0; left:0; filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; opacity:0; background-color:transparent; color:transparent; } </style>

    <style>
      div.over {
        width: 720px;
        height: 230px;
        overflow: scroll;
      }
      div.histori {
        height: 230px;
        overflow-y: scroll;
      }
    </style>
    <script type="text/javascript" src="plugins/jQuery/jquery-1.12.3.min.js"></script>

    <script language="javascript" type="text/javascript">
      var maxAmount = 160;
      function textCounter(textField, showCountField) {
        if (textField.value.length > maxAmount) {
          textField.value = textField.value.substring(0, maxAmount);
        } else {
          showCountField.value = maxAmount - textField.value.length;
        }
      }

    </script>
	<script type="text/javascript" src="plugins/getDataCombo.js"></script>
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <script src="plugins/toastr/toastr.min.js"></script>
  <script type="text/javascript">
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "7000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
      }
    </script>


  </head>

  <body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
          <?php include "main-header.php"; ?>
      </header>

      <aside class="main-sidebar">
        <?php include "menu-admin.php"; ?>
      </aside>

	  <div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php if (empty($_GET['act'])) { echo ucwords($_GET['view']); } else { echo ucwords($_GET['act']." ".$_GET['view']); }; ?>
		  </h1>
      <ol class="breadcrumb">
        <?php  if (($_GET['view']=='dashboard') OR ($_GET['view']=='')){
            echo '<li><a href="#"><i class="fa fa-th"></i> Home</a></li>';
          }else{
            echo '<li><a href="index.php?view=dashboard"><i class="fa fa-th"></i> Home</a></li>';
          }
        ?>

        <li class="active"><?php if (empty($_GET['act'])) { echo ucwords($_GET['view']); } else { echo ucwords($_GET['act']." ".$_GET['view']); }; ?></li>
      </ol>
		</section>

		<section class="content">
      <?php
        include 'config/koneksi.php';
          $menu = mysqli_query($koneksi,"SELECT * FROM menu");
          while($mnu=mysqli_fetch_array($menu)){
              if ($mnu['level'] == 'Admin'){
                  if ($_GET['view'] == $mnu['viewMenu']){
                      echo "<div class='row'>";
                          include $mnu['lokasiFileMenu'];
                      echo "</div>";
                  }
              }
          }
           if ($_GET['view']==''){
                  echo "<div class='row'>";
                      include 'admin/home_admin.php';
                  echo "</div>";
          }
          if ($_GET['view'] == 'tarif pembayaran bebas'){
                  echo "<div class='row'>";
                      include 'admin/master_keuangan_tarif_bebas.php';
                  echo "</div>";
          }

          if ($_GET['view'] == 'tarif pembayaran bulanan'){
                  echo "<div class='row'>";
                      include 'admin/master_keuangan_tarif_bulanan.php';
                  echo "</div>";
          }
      ?>

    </section>
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
          <?php include "footer.php"; ?>
      </footer>
    </div><!-- ./wrapper -->
    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="plugins/highchart/js/highcharts.js"></script>
    <script src="plugins/highchart/js/modules/data.js"></script>
    <script src="plugins/highchart/js/modules/exporting.js"></script>

    <script src="plugins/morris/morris.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="plugins/datatables/dataTables.checkboxes.min.js"></script>
    <!-- Morris.js charts -->
    <script src="plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->

    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/datetimepicker/bootstrap-datetimepicker.js"></script>
    <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>

    <script src="assets/js/script.js"></script>
    <script src="assets/app.js"></script>

    <script src="assets/bootstrap-select/js/bootstrap-select.min.js"></script>
    <!-- FullCalendar -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src='plugins/fullcalendar/fullcalendar.min.js'></script>

    <!-- KHUEUS COMBOBOX -->
    <script type="text/javascript">
      $(document).ready(function(){
          var idUsers = '<?= $idUsers ?>';
          var idUnitUsers = '<?= $idUnitUsers ?>';

          var tipe_unit = $('#tipe_unit').val();

          //unit sekolah
          var idUnit = $('#idUnit').val();
          $.ajax({
              type: 'POST',
              url: "admin/combobox/pilihan_unit.php",
              data: {idUnit: idUnit, idUsers:idUsers, tipe_unit:tipe_unit},
              cache: false,
              success: function(msg){
                $("#Cunit").html(msg);
              }
          });

          //kelas
          var idKelas = $('#idKelas').val();
          var tipe_kelas = $('#tipe_kelas').val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_kelas.php",
            data: {idUnit: idUnit, idKelas: idKelas, tipe_kelas:tipe_kelas},
            cache: false,
            success: function(msg){
                $("#Ckelas").html(msg);
            }
          });

          //kamar
          var idKamar = $('#idKamar').val();
          var tipe_kamar = $('#tipe_kamar').val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_kamar.php",
            data: {idKamar: idKamar, tipe_kamar:tipe_kamar},
            cache: false,
            success: function(msg){
                $("#Ckamar").html(msg);
            }
          });

          //jabatan pegawai
          var idJabatan = $("#idJabatan").val() ;
          var tipe_jabatan = $("#tipe_jabatan").val() ;
          $.ajax({
              type: 'POST',
              url: "admin/combobox/pilihan_jabatan.php",
              data: {idUnit: idUnit, idJabatan: idJabatan, tipe_unit:tipe_unit, tipe_jabatan:tipe_jabatan},
              cache: false,
              success: function(msg){
                $("#Cjabatan").html(msg);
              }
          });
          //kepegawaian
          var idKepegawaian = $("#idKepegawaian").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_kepegawaian.php",
            data: {idKepegawaian : idKepegawaian},
            cache: false,
            success: function(msg){
              $("#Ckepegawaian").html(msg);
            }
          });

          //pendidikan
          var idPendidikan = $("#idPendidikan").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_pendidikan.php",
            data: {idPendidikan : idPendidikan},
            cache: false,
            success: function(msg){
              $("#Cpendidikan").html(msg);
            }
          });

          //tahun ajaran
          var idTahunAjaran = $("#idTahunAjaran").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_tahunajaran.php",
            data: {idTahunAjaran : idTahunAjaran},
            cache: false,
            success: function(msg){
              $("#Ctahunajaran").html(msg);
            }
          });

          //hak akses
          var idLevel = $("#idLevel").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_hakakses.php",
            data: {idLevel : idLevel},
            cache: false,
            success: function(msg){
              $("#Chakakses").html(msg);
            }
          });


          //status siswa
          var idStatusSiswa = $("#idStatusSiswa").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_statussiswa.php",
            data: {idStatusSiswa : idStatusSiswa},
            cache: false,
            success: function(msg){
              $("#Cstatussiswa").html(msg);
            }
          });

          //Tipe Bayar
          var idTipeBayar = $("#idTipeBayar").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_tipebayar.php",
            data: {idTipeBayar : idTipeBayar},
            cache: false,
            success: function(msg){
              $("#Ctipebayar").html(msg);
            }
          });

          //tahun ajaran2
          var idTahunAjaran2 = $("#idTahunAjaran2").val();
          var tipe_tahunajaran = $("#tipe_tahunajaran").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_tahunajaran2.php",
            data: {idTahunAjaran : idTahunAjaran,tipe_tahunajaran:tipe_tahunajaran},
            cache: false,
            success: function(msg){
              $("#Ctahunajaran2").html(msg);
            }
          });

          //Pos Bayar
          var idUnit = $("#idUnit").val();
          var idPosBayar = $("#idPosBayar").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_posbayar.php",
            data: {idUnit: idUnit, idPosBayar: idPosBayar},
            cache: false,
            success: function(msg){
              $("#Cposbayar").html(msg);
            }
          });

          //Bulan
          var idBulan = $("#idBulan").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_bulan.php",
            data: {idBulan: idBulan},
            cache: false,
            success: function(msg){
              $("#Cbulan").html(msg);
            }
          });

          //Akun Hutang
          var idAkunHutang = $("#idAkunHutang").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_akun_hutang.php",
            data: {idAkunHutang: idAkunHutang, idUnitUsers:idUnitUsers},
            cache: false,
            success: function(msg){
              $("#CakunHutang").html(msg);
            }
          });

          //Pos Hutang
          var idPosHutang = $("#idPosHutang").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_pos_hutang.php",
                  data: {idUnit: idUnit, idPosHutang: idPosHutang},
                  cache: false,
                  success: function(msg){
                    $("#Cposhutang").html(msg);
                  }
            });

          //Pegawai
          var idPegawai = $("#idPegawai").val() ;
          var idJabatan = $("#idJabatan").val() ;
          $.ajax({
              type: 'POST',
              url: "admin/combobox/pilihan_pegawai.php",
              data: {idPegawai: idPegawai, idJabatan: idJabatan},
              cache: false,
              success: function(msg){
                $("#Cpegawai").html(msg);
              }
          });

          //Akun Gaji
          var idAkunGaji = $("#idAkunGaji").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_akun_gaji.php",
                  data: {idUnitUsers: idUnitUsers, idAkunGaji: idAkunGaji},
                  cache: false,
                  success: function(msg){
                    $("#Cakungaji").html(msg);
                  }
            });

          //Akun KAS
          var idAkunKas = $("#idAkunKas").val();
          var idUnitPegawai = $("#idUnitPegawai").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_akun_kas.php",
                  data: {idUnitUsers: idUnitUsers, idAkunKas: idAkunKas, idUnitPegawai:idUnitPegawai},
                  cache: false,
                  success: function(msg){
                    $("#Cakunkas").html(msg);
                  }
          });

          //Akun KAS SELECTED
          var idAkunKasSelect = $("#idAkunKas").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_akun_kas_tujuan.php",
                  data: {idAkunKasSelect: idAkunKasSelect},
                  cache: false,
                  success: function(msg){
                    $("#Cakunkastujuan").html(msg);
                  }
            });

          //Modul Transaksi
          var idModul = $("#idModul").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_modul.php",
                  data: {idModul: idModul},
                  cache: false,
                  success: function(msg){
                    $("#Cmodul").html(msg);
                  }
            });

          //Pajak
          var idPajak = $("#idPajak").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_pajak.php",
                  data: {idPajak: idPajak},
                  cache: false,
                  success: function(msg){
                    $("#Cpajak").html(msg);
                  }
          });


          //akun gaji dan biaya
          var id_unit = $('#id_unit_edit').val();
          var idAkunGajiBiaya = $("#idAkunGajiBiaya").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_akun_gaji_biaya.php",
                  data: {idUnitUsers: idUnitUsers, idAkunGajiBiaya: idAkunGajiBiaya, idUnit:id_unit },
                  cache: false,
                  success: function(msg){
                    $("#Cakungajibiaya").html(msg);
                  }
          });

          //unit POS
          var idUnitPos = $("#idUnitPos").val();
          var id_unit = $("#id_unit_edit").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_unit_pos.php",
                  data: {idUnitUsers: idUnitUsers, idUnitPos: idUnitPos, idUnit:id_unit},
                  cache: false,
                  success: function(msg){
                    $("#CunitPos").html(msg);
                  }
            });

          //jenis pembayaran
          var id_unit = $("#idUnit").val();
          var idTahunAjaran = $("#idTahunAjaran").val();
          var idJenisPembayaran = $("#idJenisPembayaran").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_jenis_pembayaran.php",
                  data: {idUnit: id_unit, idTahunAjaran: idTahunAjaran, idJenisPembayaran:idJenisPembayaran},
                  cache: false,
                  success: function(msg){
                    $("#Cjenispembayaran").html(msg);
                  }
            });

          // siswa
          var idSiswa = $("#idSiswa").val();
          var idKelas = $("#idKelas").val();
          var tipe_siswa = $("#tipe_siswa").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_siswa.php",
            data: {idSiswa : idSiswa, idKelas:idKelas, tipe_siswa:tipe_siswa},
            cache: false,
            success: function(msg){
              $("#Csiswa").html(msg);
            }
          });

          // akun Pendapatan
          var idAkunPendapatan = $("#idAkunPendapatan").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_akun_pendapatan.php",
            data: {idAkunPendapatan : idAkunPendapatan, idUnitUsers:idUnitUsers},
            cache: false,
            success: function(msg){
              $("#Cakunpendapatan").html(msg);
            }
          });

          // akun Piutang
          var idAkunPiutang = $("#idAkunPiutang").val();
          $.ajax({
            type: 'POST',
            url: "admin/combobox/pilihan_akun_piutang.php",
            data: {idAkunPiutang : idAkunPiutang, idUnitUsers:idUnitUsers},
            cache: false,
            success: function(msg){
              $("#Cakunpiutang").html(msg);
            }
          });

          //akun biaya masuk
          var idAkunBiaya = $("#idAkunBiaya").val();
          var unit = $("#id_unit_edit").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_akun_masuk.php",
                  data: {idUnitUsers: idUnitUsers, idAkunBiaya: idAkunBiaya, idUnit:unit},
                  cache: false,
                  success: function(msg){
                    $("#Cakunbiayamasuk").html(msg);
                  }
            });
      });
      //combo bertingkat unit dan kelas
      $("#Ckelas").change(function(){
        var idSiswa = $("#idSiswa").val();
        var idKelas = $("#Ckelas").val();
        var tipe_siswa = $("#tipe_siswa").val();
        $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_siswa.php",
                  data: {idSiswa : idSiswa, idKelas:idKelas, tipe_siswa:tipe_siswa},
                  cache: false,
                  success: function(msg){
                    $("#Csiswa").html(msg);
                  }
            });
      });

      //combo bertingkat unit dan kelas
      $("#Cunit").change(function(){
        var idUnit = $("#Cunit").val();
        var idKelas = $("#idKelas").val();
        var tipe_kelas = $('#tipe_kelas').val();
        $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_kelas.php",
                  data: {idUnit: idUnit, idKelas: idKelas, tipe_kelas:tipe_kelas},
                  cache: false,
                  success: function(msg){
                    $("#Ckelas").html(msg);
                  }
            });
      });

      //combo bertingkat unit dan kamar
      $("#Cunit").change(function(){
        var idKamar = $("#idKamar").val();
        var tipe_kamar = $('#tipe_kamar').val();
        $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_kamar.php",
                  data: {idKamar: idKamar, tipe_kamar:tipe_kamar},
                  cache: false,
                  success: function(msg){
                    $("#Ckamar").html(msg);
                  }
            });
      });


      //combo bertingkat unit dan jabatan
      $("#Cunit").change(function(){
        var idUnit = $("#Cunit").val();
        var idJabatan = $("#idJabatan").val();
        var tipe_unit = $('#tipe_unit').val();
        var tipe_jabatan = $("#tipe_jabatan").val() ;
        $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_jabatan.php",
                  data: {idUnit: idUnit, idJabatan: idJabatan, tipe_unit:tipe_unit, tipe_jabatan:tipe_jabatan},
                  cache: false,
                  success: function(msg){
                    $("#Cjabatan").html(msg);
                  }
            });
      });

      //combo bertingkat unit dan pos bayar
      $("#Cunit").change(function(){
        var idUnit = $("#Cunit").val();
        var idPosBayar = $("#idPosBayar").val();
        $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_posbayar.php",
                  data: {idUnit: idUnit, idPosBayar: idPosBayar},
                  cache: false,
                  success: function(msg){
                    $("#Cposbayar").html(msg);
                  }
            });
      });

      //combo bertingkat unit dan Pos Hutang
      $("#Cunit").change(function(){
        var idUnit = $("#Cunit").val();
        var idPosHutang = $("#idPosHutang").val();
        $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_pos_hutang.php",
                  data: {idUnit: idUnit, idPosHutang: idPosHutang},
                  cache: false,
                  success: function(msg){
                    $("#Cposhutang").html(msg);
                  }
            });
      });

      //combo bertingkat jabatan dan pegawai
      $("#Cjabatan").change(function(){
        var idPegawai = $("#idPegawai").val();
        var idJabatan = $("#Cjabatan").val();
        $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_pegawai.php",
                  data: { idPegawai: idPegawai, idJabatan: idJabatan },
                  cache: false,
                  success: function(msg){
                    $("#Cpegawai").html(msg);
                  }
            });
      });

      //combo bertingkat unit dan akun kas
      $("#Cunit").change(function(){
          var idAkunKas = $("#idAkunKas").val();
          var idUnit = $("#Cunit").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_akun_kas.php",
                  data: {idUnitUsers: '', idAkunKas: idAkunKas, idUnitPegawai:idUnit},
                  cache: false,
                  success: function(msg){
                    $("#Cakunkas").html(msg);
                  }
            });
      });

      //combo bertingkat unit dan akun biaya
      $("#Cunit").change(function(){
          var idAkunBiaya = $("#idAkunBiaya").val();
          var idUnit = $("#Cunit").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_akun_biaya.php",
                  data: {idUnitUsers: '', idAkunBiaya: idAkunBiaya, idUnit:idUnit},
                  cache: false,
                  success: function(msg){
                    $("#Cakunbiayakeluar").html(msg);
                  }
            });
      });

      //combo bertingkat unit dan akun biaya
      $("#Cunit").change(function(){
          var idAkunBiaya = $("#idAkunBiaya").val();
          var idUnit = $("#Cunit").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_akun_masuk.php",
                  data: {idUnitUsers: '', idAkunBiaya: idAkunBiaya, idUnit:idUnit},
                  cache: false,
                  success: function(msg){
                    $("#Cakunbiayamasuk").html(msg);
                  }
            });
      });

      //combo bertingkat unit dan unit pos
      $("#Cunit").change(function(){
          var idUnitPos = $("#idUnitPos").val();
          var idUnit = $("#Cunit").val();
          $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_unit_pos.php",
                  data: {idUnitUsers: '', idUnitPos: idUnitPos, idUnit:idUnit},
                  cache: false,
                  success: function(msg){
                    $("#CunitPos").html(msg);
                  }
            });
      });

      //combobox bertingkat unit sekolah dan jenis pembayaran
      $("#Cunit").change(function(){
        var idUnit = $("#Cunit").val();
        var idTahunAjaran = $("#Ctahunajaran2").val();
        $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_jenis_pembayaran.php",
                  data: {idUnit: idUnit, idTahunAjaran: idTahunAjaran},
                  cache: false,
                  success: function(msg){
                    $("#Cjenispembayaran").html(msg);
                  }
            });
      });

      //combobox bertingkat tahun ajaran dan jenis pembayaran
      $("#Ctahunajaran2").change(function(){
        var idUnit = $("#Cunit").val();
        var idTahunAjaran = $("#Ctahunajaran2").val();
        $.ajax({
                type: 'POST',
                  url: "admin/combobox/pilihan_jenis_pembayaran.php",
                  data: {idUnit: idUnit, idTahunAjaran: idTahunAjaran},
                  cache: false,
                  success: function(msg){
                    $("#Cjenispembayaran").html(msg);
                  }
            });
      });
    </script>

    <!-- untuk checklist tabel -->
    <script type="text/javascript">
      $(document).ready(function() {
        $("#selectall").change(function() {
          $(".checkbox").prop('checked', $(this).prop("checked"));
        });
      });
      $(document).ready(function() {
        $("#selectall2").change(function() {
          $(".checkbox2").prop('checked', $(this).prop("checked"));
        });
      });

    </script>
    <script type="text/javascript">
      function readURL(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            $('#target').attr('src', e.target.result);
          };

          reader.readAsDataURL(input.files[0]);
        }
      }

      $("#foto").change(function() {
        readURL(this);
      });
    </script>

  <script type="text/javascript">
    $(document).ready(function(){
      $.get(
        'admin/ajax_bulan.php',
        {idTahun : $('#idTahunAjaran').val()},
        function(data){
          bln_awal = $('#bln1').val();
          console.log(data);
            $('#bulan1').html("<option value=''>- Pilih Bulan -</option>");
            var no = 0;
            $.each(data,function(idx, val){
              if (no < 6){
                if (bln_awal == val.id){
                  var opt = "<option value='"+ val.id + "' selected>"+ val.name +" "+ val.thn_ganjil +"</option>";
                }else{
                  var opt = "<option value='"+ val.id + "'>"+ val.name +" "+ val.thn_ganjil +"</option>";
                }

              }
              else{
                if (bln_awal == val.id){
                  var opt = "<option value='"+ val.id + "' selected>"+ val.name +" "+ val.thn_genap +"</option>";
                }else{
                  var opt = "<option value='"+ val.id + "'>"+ val.name +" "+ val.thn_genap +"</option>";
                }

              }
              no++;
              $('#bulan1').append(opt);
            });

          hasil_bln_awal = parseInt(bln_awal) - 1;
          bln_akhir = $('#bln2').val();
          console.log(data);
            $('#bulan2').html("<option value=''>- Pilih Bulan -</option>");
            var no = 0;
            $.each(data,function(idx, val){
              if (no < 6){
                if (no < hasil_bln_awal){
                  var opt = "<option value='"+ val.id + "' disabled>"+ val.name +" "+ val.thn_ganjil +"</option>";
                }else{
                  if (bln_akhir == val.id){
                    var opt = "<option value='"+ val.id + "' selected>"+ val.name +" "+ val.thn_ganjil +"</option>";
                  }else{
                    var opt = "<option value='"+ val.id + "'>"+ val.name +" "+ val.thn_ganjil +"</option>";
                  }
                }

              }
              else{
                if (no < hasil_bln_awal){
                  var opt = "<option value='"+ val.id + "' disabled>"+ val.name +" "+ val.thn_genap +"</option>";
                }else{
                  if (bln_akhir == val.id){
                    var opt = "<option value='"+ val.id + "' selected>"+ val.name +" "+ val.thn_genap +"</option>";
                  }else{
                    var opt = "<option value='"+ val.id + "'>"+ val.name +" "+ val.thn_genap +"</option>";
                  }
                }
              }
              no++;
              $('#bulan2').append(opt);
            });
        },
        'json'
      );


      $('#Ctahunajaran2').change(function(){
        // get province's value
        var idTahun = $(this).val();
        // request to server with ajax
        $.get(
          'admin/ajax_bulan.php',
          {idTahun : idTahun},
          function(data){
            console.log(data);
              $('#bulan1').html("<option value=''>- Pilih Bulan -</option>");
              var no = 0;
              $.each(data,function(idx, val){
                if (no < 6){
                  var opt = "<option value='"+ val.id + "'>"+ val.name +" "+ val.thn_ganjil +"</option>";
                }
                else{
                  var opt = "<option value='"+ val.id + "'>"+ val.name +" "+ val.thn_genap +"</option>";
                }
                no++;
                $('#bulan1').append(opt);
              });
            },
          'json'
        );
      });

      $('#bulan1').change(function(){
        var idTahun = $('#Ctahunajaran2').val();
        var bulan1 = parseInt($(this).val()) - 1;
        $.get(
          'admin/ajax_bulan.php',
          {idTahun : idTahun},
          function(data){
            console.log(data);
              $('#bulan2').html("<option value=''>- Pilih Bulan -</option>");
              var no = 0;
              $.each(data,function(idx, val){
                if (no < 6){
                  if (no < bulan1){
                    var opt = "<option value='"+ val.id + "' disabled>"+ val.name +" "+ val.thn_ganjil +"</option>";
                  }else{
                    var opt = "<option value='"+ val.id + "'>"+ val.name +" "+ val.thn_ganjil +"</option>";
                  }
                }
                else{
                  if (no < bulan1){
                    var opt = "<option value='"+ val.id + "' disabled>"+ val.name +" "+ val.thn_genap +"</option>";
                  }else{
                    var opt = "<option value='"+ val.id + "'>"+ val.name +" "+ val.thn_genap +"</option>";
                  }
                }
                no++;
                $('#bulan2').append(opt);
              });
            },
          'json'
        );
      });
    });
  </script>

    <script type="text/javascript">
  $(document).ready(function (){
   var table = $('#table_checkbox').DataTable({
      'columnDefs': [{
         'targets': 0,
         'searchable':false,
         'orderable':false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
             return '<input type="checkbox" name="id[]" value="'
                + $('<div/>').text(data).html() + '">';
         }
      }],
      'order': [1, 'asc']
   });

   // Handle click on "Select all" control
   $('#example-select-all').on('click', function(){
      // Check/uncheck all checkboxes in the table
      var rows = table.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

   // Handle click on checkbox to set state of "Select all" control
   $('#example tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#example-select-all').get(0);
         // If "Select all" control is checked and has 'indeterminate' property
         if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control
            // as 'indeterminate'
            el.indeterminate = true;
         }
      }
   });

   $('#frm-example').on('submit', function(e){
      var form = this;

      // Iterate over all checkboxes in the table
      table.$('input[type="checkbox"]').each(function(){
         // If checkbox doesn't exist in DOM
         if(!$.contains(document, this)){
            // If checkbox is checked
            if(this.checked){
               // Create a hidden element
               $(form).append(
                  $('<input>')
                     .attr('type', 'hidden')
                     .attr('name', this.name)
                     .val(this.value)
               );
            }
         }
      });

      // FOR TESTING ONLY

      // Output form data to a console
      $('#example-console').text($(form).serialize());
      console.log("Form submission", $(form).serialize());

      // Prevent actual form submission
      e.preventDefault();
   });
});
</script>


    <script>
      $('.textarea').wysihtml5();

      $(function () {
        //waktu plugin
        $('.jam').datetimepicker({
          format: 'hh:ii',
          language:  'en',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 1,
          minView: 0,
          maxView: 1,
          forceParse: 0
        });

        // year plugin
        $(".years").datepicker({
          format: "yyyy",
          viewMode: "years",
          minViewMode: "years",
          autoclose: true,
          todayHighlight: true
        });

		    // datepicker plugin
        $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true,
          format: 'yyyy-mm-dd'
        });

		    $("#example").DataTable();
        $("#example1").DataTable();

        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });

        $('#example3').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200
        });

        $('#mastersiswa').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": true,
          "ordering": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200
        });

        $('#example5').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "info": false,
          "autoWidth": false,
          "pageLength": 200,
          "order": [[ 5, "desc" ]]
        });

        $('#example6').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": false,
          "autoWidth": false
        });

        $('#tabel_histori').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "info": false,
          "autoWidth": false,
          "pageLength": false,
          "order": [[ 0, "desc" ],[ 1, "desc" ]],

        });

        $('#example7').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "info": false,
          "autoWidth": false,
          "pageLength": false,
          "order": false,

        });
        $('#tabel_laporan_keuangan').DataTable({
          "order": [[ 0, "asc" ]],
        });
      });

		//$('.datepicker').datepicker();

    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
    });

		$('.datetimepicker').datetimepicker({
			format: 'yyyy-mm-dd hh:ii:ss',
			weekStart: 1,
			todayBtn:  1,
			autoclose: 1
		});

		$(".harusAngka").keypress(function (e) {
			//if the letter is not digit then display error and don't type anything
			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				   return false;
			}
		});

    $("#parent").click(function() {
      $(".child").prop("checked", this.checked);
    });

    $('.child').click(function() {
        if ($('.child:checked').length == $('.child').length) {
          $('#parent').prop('checked', true);
        } else {
          $('#parent').prop('checked', false);
        }
    });

		//hitung
		/*
		$('#hitungBayaran').keyup(function(){
			if ($(this).val() > $("#sisa").val()){
				alert('Anda memasukkan nilai melebihi total tagihan!');
				$(this).val($("#sisa").val());
			}
		});
		*/

		$("#allTarif").keypress(function (e) {
			var allTarif = $("#allTarif").val();
			if (e.which == 13) {
				$("#n1").val(allTarif);
				$("#n2").val(allTarif);
				$("#n3").val(allTarif);
				$("#n4").val(allTarif);
				$("#n5").val(allTarif);
				$("#n6").val(allTarif);
				$("#n7").val(allTarif);
				$("#n8").val(allTarif);
				$("#n9").val(allTarif);
				$("#n10").val(allTarif);
				$("#n11").val(allTarif);
				$("#n12").val(allTarif);
			}
		});
		$("#allTarifBebas").keypress(function (e) {
			var allTarif = $("#allTarifBebas").val();
			if (e.which == 13) {
				$(".nTagihan").val(allTarif);
			}
		});
    </script>
<script>
    //   $(function () {
    //     "use strict";

    //     // AREA CHART
    //     var area = new Morris.Area({
    //       element: 'revenue-chart',
    //       resize: true,
    //       data: [
    //         {y: '2011 Q1', item1: 2666, item2: 2666},
    //         {y: '2011 Q2', item1: 2778, item2: 2294},
    //         {y: '2011 Q3', item1: 4912, item2: 1969},
    //         {y: '2011 Q4', item1: 3767, item2: 3597},
    //         {y: '2012 Q1', item1: 6810, item2: 1914},
    //         {y: '2012 Q2', item1: 5670, item2: 4293},
    //         {y: '2012 Q3', item1: 4820, item2: 3795},
    //         {y: '2012 Q4', item1: 15073, item2: 5967},
    //         {y: '2013 Q1', item1: 10687, item2: 4460},
    //         {y: '2013 Q2', item1: 8432, item2: 5713}
    //       ],
    //       xkey: 'y',
    //       ykeys: ['item1', 'item2'],
    //       labels: ['Item 1', 'Item 2'],
    //       lineColors: ['#a0d0e0', '#3c8dbc'],
    //       hideHover: 'auto'
    //     });

    //     // LINE CHART
    //     var line = new Morris.Line({
    //       element: 'line-chart',
    //       resize: true,
    //       data: [
    //         {y: '2011 Q1', item1: 2666},
    //         {y: '2011 Q2', item1: 2778},
    //         {y: '2011 Q3', item1: 4912},
    //         {y: '2011 Q4', item1: 3767},
    //         {y: '2012 Q1', item1: 6810},
    //         {y: '2012 Q2', item1: 5670},
    //         {y: '2012 Q3', item1: 4820},
    //         {y: '2012 Q4', item1: 15073},
    //         {y: '2013 Q1', item1: 10687},
    //         {y: '2013 Q2', item1: 8432}
    //       ],
    //       xkey: 'y',
    //       ykeys: ['item1'],
    //       labels: ['Item 1'],
    //       lineColors: ['#3c8dbc'],
    //       hideHover: 'auto'
    //     });

    //     //DONUT CHART
    //     var donut = new Morris.Donut({
    //       element: 'sales-chart',
    //       resize: true,
    //       colors: ["#3c8dbc", "#f56954", "#00a65a"],
    //       data: [
    //         {label: "Download Sales", value: 12},
    //         {label: "In-Store Sales", value: 30},
    //         {label: "Mail-Order Sales", value: 20}
    //       ],
    //       hideHover: 'auto'
    //     });
    //     //BAR CHART
    //     var bar = new Morris.Bar({
    //       element: 'bar-chart',
    //       resize: true,
    //       data: [
    //         {y: '2006', a: 100, b: 90},
    //         {y: '2007', a: 75, b: 65},
    //         {y: '2008', a: 50, b: 40},
    //         {y: '2009', a: 75, b: 65},
    //         {y: '2010', a: 50, b: 40},
    //         {y: '2011', a: 75, b: 65},
    //         {y: '2012', a: 100, b: 90}
    //       ],
    //       barColors: ['#00a65a', '#f56954'],
    //       xkey: 'y',
    //       ykeys: ['a', 'b'],
    //       labels: ['CPU', 'DISK'],
    //       hideHover: 'auto'
    //     });
    //   });
    </script>




  </body>
</html>

<?php
  }else{
    include "portal.php";

  }
?>
