<?php 
function rupiah($rp){
    if($rp!=0){
      $hasil = number_format($rp, 0, ',', '.');
        }else{
      $hasil=0;
         }
       return $hasil;
       }
?>