<?php

    $idStatusSiswa = $_POST['idStatusSiswa'];

    if ($idStatusSiswa == 'Aktif'){
        echo '<option value="Aktif" selected> Aktif </option>';
    }else{
        echo '<option value="Aktif"> Aktif </option>';
    }

    if ($idStatusSiswa == 'Tidak Aktif'){
        echo '<option value="Tidak Aktif" selected> Tidak Aktif </option>';
    }else{
        echo '<option value="Tidak Aktif"> Tidak Aktif </option>';
    }

    if ($idStatusSiswa == 'Tamat'){
        echo '<option value="Tamat" selected> Tamat </option>';
    }else{
        echo '<option value="Tamat"> Tamat </option>';
    }

    if ($idStatusSiswa == 'Pindah Sekolah'){
        echo '<option value="Pindah Sekolah" selected> Pindah Sekolah </option>';
    }else{
        echo '<option value="Pindah Sekolah"> Pindah Sekolah </option>';
    }

    if ($idStatusSiswa == 'Drop Out'){
        echo '<option value="Drop Out" selected> Drop Out </option>';
    }else{
        echo '<option value="Drop Out"> Drop Out </option>';
    }
?>