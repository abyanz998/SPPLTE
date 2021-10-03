
  <?php

    error_reporting(0);
    include "config/koneksi.php";
  
      $user   = mysqli_real_escape_string($koneksi,$_POST['username']);
      $pass   =md5(mysqli_real_escape_string($koneksi,$_POST['password']));
      $siswa  = mysqli_query($koneksi,"SELECT * FROM siswa WHERE nisSiswa='$user' AND password='$pass'");

     $hitungsiswa = mysqli_num_rows($siswa);
     if ($hitungsiswa >= 1){

        $r = mysqli_fetch_array($siswa);
        $_SESSION['idSiswa']     	= $r['idSiswa'];
        $_SESSION['nis']    		= $r['nisSiswa'];
        $_SESSION['nama']        	= $r['nmSiswa'];
        $_SESSION['level']       	= 'Siswa';
        $_SESSION['unit']        	= $r['unitSiswa'];

        // mengirimkan json data ke APK untuk LOGIN dan menampilkan webview
        echo json_encode(
          array(
            'response' => true,
            'payload' => $_SESSION["idSiswa"]
          )
        );

     }else{

        $_SESSION['notif'] = 'gagalLogin';
          echo json_encode(
          array(
            'response' => false,
            'payload' => null
          )
        );

     }
  ?>
