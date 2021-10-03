<?php

    $idTipeBayar = $_POST['idTipeBayar'];

    echo '<option value="" disabled selected> - Pilih Tipe Bayar - </option>';
    if ($idTipeBayar == 'Bulanan'){
        echo '<option value="Bulanan" selected> Bulanan </option>';
    }else{
        echo '<option value="Bulanan"> Bulanan </option>';
    }

   if ($idTipeBayar == 'Bebas'){
        echo '<option value="Bebas" selected> Bebas </option>';
    }else{
        echo '<option value="Bebas"> Bebas </option>';
    }
?>