
<?php
  include "../../config/koneksi.php";
  $id_siswa = $_POST['id_siswa'];
  for ($i=0; $i < count($id_siswa); $i++) { 
    echo '<input type="hidden" name="id_siswa[]" id="id_siswa" value="'.$id_siswa[$i].'">';
  }
?>