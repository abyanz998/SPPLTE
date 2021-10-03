<?php
      function barcode($lokasi, $value, $codetype, $print, $size){
            $tempdir    = $lokasi;
        if (!file_exists($tempdir))
            mkdir($tempdir, 0755);
           
            $target_path    =$tempdir . $value. ".png";
           
            //cek apakah server menggunakan http atau https
            $protocol   =stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
           
            //url file image barcode 
            $fileImage  =$protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'],3) . "/plugins/php-barcode/barcode.php?text=" . $value . "&codetype=".$codetype."&print=".$print."&size=".$size;
           
            //ambil gambar barcode dari url diatas
            $content    =file_get_contents($fileImage);
           
            //simpan gambar ke folder
            file_put_contents($target_path, $content);
           
            //link barcode
            $link_barcode = $tempdir.$value.'.png';

            return $link_barcode;
      }
?>