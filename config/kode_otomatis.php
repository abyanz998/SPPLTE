<?php
      function kode_otomatis($query,$no_tambah){
            $data = mysqli_fetch_array($query);
            $kodeBarang = $data['kodeTerbesar'];
            $urutan = substr($kodeBarang, 2, 7);
            $urutan = $urutan + $no_tambah;
            $huruf = substr($kodeBarang, 0,2);
            $kodeBarang = $huruf.$urutan;
            return $kodeBarang;
      }
?>