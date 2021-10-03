<?php

    $idModul = $_POST['idModul'];

    if ($idModul == 'all'){
        echo '<option value="all" selected>- Semua Modul -</option>';
    }else{
        echo '<option value="all">- Semua Modul -</option>';
    }

    if ($idModul == 'Pembayaran'){
        echo '<option value="Pembayaran" selected>Pembayaran</option>';
    }else{
        echo '<option value="Pembayaran">Pembayaran</option>';
    }

    if ($idModul == 'Kas Masuk'){
        echo '<option value="Kas Masuk" selected>Kas Masuk</option>';
    }else{
        echo '<option value="Kas Masuk">Kas Masuk</option>';
    }

    if ($idModul == 'Kas Keluar'){
        echo '<option value="Kas Keluar" selected>Kas Keluar</option>';
    }else{
        echo '<option value="Kas Keluar">Kas Keluar</option>';
    }

    if ($idModul == 'Penggajian'){
        echo '<option value="Penggajian" selected>Penggajian</option>';
    }else{
        echo '<option value="Penggajian">Penggajian</option>';
    }

?>