<?php

    $idKepegawaian = $_POST['idKepegawaian'];

    echo '<option value="" disabled selected> - Pilih Status Kepegawaian - </option>';
    if ($idKepegawaian == 'Pegawai Tetap'){
        echo '<option value="Pegawai Tetap" selected> Pegawai Tetap </option>';
    }else{
        echo '<option value="Pegawai Tetap"> Pegawai Tetap </option>';
    }

    if ($idKepegawaian == 'Pegawai Tidak Tetap'){
        echo '<option value="Pegawai Tidak Tetap" selected> Pegawai Tidak Tetap </option>';
    }else{
        echo '<option value="Pegawai Tidak Tetap"> Pegawai Tidak Tetap </option>';
    }
?>