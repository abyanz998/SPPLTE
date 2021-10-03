<?php
  session_start();
  session_destroy();
  echo "<script>window.location='index-siswa.php'</script>";
  die();
?>
