<?php
session_start();
error_reporting(0);
include "config/koneksi.php";
if (isset($_POST[login])) {
  $user   = mysqli_real_escape_string($koneksi, $_POST[username]);
  $pass   = md5(mysqli_real_escape_string($koneksi, $_POST[password]));

  $admin  = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$user' AND password='$pass'");

  $hitungadmin = mysqli_num_rows($admin);

  if ($hitungadmin >= 1) {
    session_start();
    $r = mysqli_fetch_array($admin);
    $_SESSION[idUsers]         = $r[idUsers];
    $_SESSION[namalengkap]    = $r[nama_lengkap];
    $_SESSION[email]          = $r[email];
    $_SESSION[level]          = $r[level];
    $_SESSION[unit]            = $r[unit];

    $waktu_sekarang = date('Y-m-d H:i:s');
    mysqli_query($koneksi, "UPDATE users SET last_login='$waktu_sekarang' WHERE idUsers='$_SESSION[idUsers]'");


    echo "<script>document.location='index.php?view=dashboard';</script>";
  } else {
    $_SESSION['notif'] = 'gagalLogin';
    echo "<script>window.location=('login.php')</script>";
  }
}
