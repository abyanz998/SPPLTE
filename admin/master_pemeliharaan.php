<?php
  function &backup_tables($koneksi, $host, $user, $pass, $name, $tables = '*'){
    $data = "\n/*---------------------------------------------------------------".
        "\n  SQL DB BACKUP ".date("d.m.Y H:i")." ".
        "\n  HOST: {$host}".
        "\n  DATABASE: {$name}".
        "\n  TABLES: {$tables}".
        "\n  ---------------------------------------------------------------*/\n";

    mysqli_query($koneksi, "SET NAMES `utf8` COLLATE `utf8_general_ci`"); // Unicode

    if($tables == '*'){ //get all of the tables
      $tables = array();
      $result = mysqli_query($koneksi, "SHOW TABLES");
      while($row = mysqli_fetch_row($result)){
        $tables[] = $row[0];
      }
    }
    else{
      $tables = is_array($tables) ? $tables : explode(',',$tables);
    }

    foreach($tables as $table){
      $data.= "\n/*---------------------------------------------------------------".
      "\n  TABLE: `{$table}`".
      "\n  ---------------------------------------------------------------*/\n";
      $data.= "DROP TABLE IF EXISTS `{$table}`;\n";
      $res = mysqli_query($koneksi, "SHOW CREATE TABLE `{$table}`");
      $row = mysqli_fetch_row($res);
      $data.= $row[1].";\n";

      $result = mysqli_query($koneksi, "SELECT * FROM `{$table}`");
      $num_rows = mysqli_num_rows($result);

      if($num_rows>0){
        $vals = Array(); $z=0;
        for($i=0; $i<$num_rows; $i++){
          $items = mysqli_fetch_row($result);
          $vals[$z]="(";
          for($j=0; $j<count($items); $j++){
            if (isset($items[$j])) { $vals[$z].= "'".mysqli_real_escape_string($koneksi, $items[$j])."'"; } else { $vals[$z].= "NULL"; }
            if ($j<(count($items)-1)){ $vals[$z].= ","; }
          }
          $vals[$z].= ")"; $z++;
        }
        $data.= "INSERT INTO `{$table}` VALUES ";      
        $data .= "  ".implode(";\nINSERT INTO `{$table}` VALUES ", $vals).";\n";
      }
    }
    mysqli_close($koneksi);
    return $data;
  }
  $ubahNamaAplikasi = str_replace(" ", "-", $idt['singkatanAplikasi']);
  $backup_file = 'db-backup-'.$ubahNamaAplikasi.'-'.date('d-m-Y').'.sql';

  // get backup
  $mybackup = backup_tables($koneksi, $server,$username,$password,$database,"*");

  // save to file
  $handle = fopen($backup_file,'w+');
  fwrite($handle,$mybackup);
  fclose($handle);
?>
  <div class="col-md-6">
    <div class="box box-success">
      <div class="box-header">
        <div class="col-md-6">
          <a href="<?php echo $backup_file ?>" onclick="klik()">
          <i class="fa fa-database" style="color:#03C9A9; font-size: 90pt"></i><br>
            Backup Database</a>
        </div>
        <div class="col-md-6">
          <div class="alert alert-danger text-center">
            Warning!... !<br>
            Halaman ini digunakan untuk membackup seluruh database
          </div>
        </div>
      </div>
    </div>
  </div>
  
<script type="text/javascript">
  function klik(){
    toastr["success"]("Berhasil membackup dan mendownload database.","Sukses!")
  }
</script>
