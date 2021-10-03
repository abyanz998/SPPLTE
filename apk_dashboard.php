<?php
session_start();
// error_reporting(0);
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
include 'apk_login_siswa.php';

  //buat variabel siswa
    $idSiswa = $_GET['idSiswa'];
//$_GET['view']; Sudah terisi otomatis dari json APK

  //ambil data siswa
  $idt_siswa = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM siswa WHERE idSiswa='$idSiswa'"));

  if ($idt_siswa['fotoSiswa'] == '') {
    $foto_siswa = $lokasi_default_fotoSiswa;
  } else {
    $foto_siswa = $lokasi_penyimpanan_fotoSiswa . $idt_siswa['fotoSiswa'];
  }

  $idt = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM identitas"));

  $ta = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tahun_ajaran where status='Aktif'"));

  $bulan_aktif = date('m');
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $idt[nmAplikasi] ?></title>
    <link rel="shortcut icon" href="<?= $lokasi_penyimpanan_logo . $idt['logo_kiri'] ?>">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="stylesheet" href="css/style.css">
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

    <style type="text/css">
      .files {
        position: absolute;
        z-index: 2;
        top: 0;
        left: 0;
        filter: alpha(opacity=0);
        -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
        opacity: 0;
        background-color: transparent;
        color: transparent;
      }
    </style>

    <style>
      div.over {
        width: 720px;
        height: 230px;
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

  <body class="skin-green fixed sidebar-mini sidebar-mini-expand-feature" style="height: auto; min-height: 100%;">
    <div class="wrapper">
      <header class="main-header">
        <?php include "apk_main_headers.php"; ?>
      </header>

      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php if (empty($_GET['act'])) {
              echo ucwords($_GET['view']);
            } else {
              echo ucwords($_GET['act'] . " " . $_GET['view']);
            }; ?>
          </h1>
          <ol class="breadcrumb">
            <?php if (($_GET['view'] == 'dashboard') or ($_GET['view'] == '')) {
              echo '<li><a href="#"><i class="fa fa-th"></i> Home</a></li>';
            } else {
              echo '<li><a href="apk-dashboard.php?view=dashboard"><i class="fa fa-th"></i> Home</a></li>';  // ini koentcinya dia nampilin dashboard dengan inputan view
            }
            ?>

            <li class="active"><?php if (empty($_GET['act'])) {
                                  echo ucwords($_GET['view']);
                                } else {
                                  echo ucwords($_GET['act'] . " " . $_GET['view']);
                                }; ?></li>
          </ol>
        </section>

        <section class="content">                                                 <!-- INI KONTENNYA DISINI -->
          <?php
          $menu = mysqli_query($koneksi, "SELECT * FROM menu");
          while ($mnu = mysqli_fetch_array($menu)) {
            if ($mnu['level'] == 'Siswa') {
              if ($_GET['view'] == $mnu['viewMenu']) {
                echo "<div class='row'>";
                include $mnu['lokasiFileMenu'];
                echo "</div>";
              }
            }
          }
          ?>
        </section>
      </div><!-- /.content-wrapper -->
      <footer class="main-footer hidden-xs">
        <?php include "footer.php"; ?>
      </footer>


      <div class="table-responsive">
        <div class="navbar navbar-default navbar-fixed-bottom hidden-lg hidden-md hidden-sm nav-justified">
          <div class="bott-bar hidden-lg hidden-md hidden-sm">
            <div class="pos-bar">
              <?php
              $menu_siswa = mysqli_query($koneksi, "SELECT * FROM menu WHERE menu.ketMenu='Main Menu' AND menu.level='Siswa' ORDER BY menu.idMenu ASC");
              while ($menu = mysqli_fetch_array($menu_siswa)) {
              ?>
                <a class="content-bar <?php if ($_GET[view] == $menu[viewMenu]) {
                                        echo 'active';
                                      } ?>" href="apk_dashboard.php?view=<?= strtolower($menu['viewMenu']) ?>">
                  <div class="group-bot-bar">
                    <i class="<?= $menu['iconMenu'] ?> icon-bot-bar fa-2x"></i>
                    <p class="text-bot-bar"><?= ucwords($menu['namaMenu']) ?> loken</p>
                  </div>
                </a>
              <?php
              }
              ?>

              <a class="content-bar " href="logout.php">
                <div class="group-bot-bar">
                  <i class="fa fa-sign-out icon-bot-bar fa-2x"></i>
                  <p class="text-bot-bar">Logout</p>
                </div>
              </a>

            </div>
          </div>
        </div>
      </div>
    </div><!-- ./wrapper -->


    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jQueryUI/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- <script src="plugins/highcharts/js/highcharts.js"></script>
    <script src="plugins/highcharts/js/modules/data.js"></script>
    <script src="plugins/highcharts/js/modules/exporting.js"></script> -->
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

    <script>
      var idTahunAjaran = $("#idTahunAjaran").val();
      $.ajax({
        type: 'POST',
        url: "siswa/combobox/pilihan_tahunajaran.php",
        data: {
          idTahunAjaran: idTahunAjaran
        },
        cache: false,
        success: function(msg) {
          $("#Ctahunajaran").html(msg);
        }
      });

      $('.textarea').wysihtml5();

      $(function() {
        // datepicker plugin
        $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true,
          format: 'yyyy-mm-dd'
        });

        $('#tabel_histori').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "info": false,
          "autoWidth": false,
          "pageLength": false,
          "order": [
            [0, "desc"],
            [1, 'false']
          ],
        });

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
          "order": [
            [5, "desc"]
          ]
        });
      });

      //$('.datepicker').datepicker();

      $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
      });

      $('.datetimepicker').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:ss',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1
      });

      $(".harusAngka").keypress(function(e) {
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

      $("#allTarif").keypress(function(e) {
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
      $("#allTarifBebas").keypress(function(e) {
        var allTarif = $("#allTarifBebas").val();
        if (e.which == 13) {
          $(".nTagihan").val(allTarif);
        }
      });
    </script>


  </body>

  </html>

<?php

?>
