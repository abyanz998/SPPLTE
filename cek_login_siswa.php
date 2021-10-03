<?php
  session_start();
  error_reporting(0);
  include "config/koneksi.php";
  if (isset($_POST[login])){
    $user   = mysqli_real_escape_string($koneksi,$_POST['username']);
    $pass   =md5(mysqli_real_escape_string($koneksi,$_POST['password']));
    $siswa  = mysqli_query($koneksi,"SELECT * FROM siswa WHERE nisSiswa='$user' AND password='$pass'");

   $hitungsiswa = mysqli_num_rows($siswa);
   if ($hitungsiswa >= 1){
   	session_start();
      $r = mysqli_fetch_array($siswa);
      $_SESSION['idSiswa']     	= $r['idSiswa'];
      $_SESSION['nis']    		= $r['nisSiswa'];
      $_SESSION['nama']        	= $r['nmSiswa'];
      $_SESSION['level']       	= 'Siswa';
      $_SESSION['unit']        	= $r['unitSiswa'];

      echo "<script>document.location='index-siswa.php?view=dashboard';</script>"; // ini koentcinya dia ngirim view bernilai dashboarddd
   }else{
      $_SESSION['notif'] = 'gagalLogin';
      echo "<script>window.location=('login-siswa.php')</script>";
   }
}
?>
