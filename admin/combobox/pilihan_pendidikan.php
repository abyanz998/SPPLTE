<?php

    $pendidikan = $_POST['idPendidikan'];

    echo '<option value="" disabled selected> - Pilih Strata - </option>';
    if ($pendidikan == 'SMA'){
        echo '<option value="SMA" selected> SMA </option>';
    }else{
        echo '<option value="SMA"> SMA </option>';
    }

    if ($pendidikan == 'SMK'){
        echo '<option value="SMK" selected> SMK </option>';
    }else{
        echo '<option value="SMK"> SMK </option>';
    }

    if ($pendidikan == 'D1'){
        echo '<option value="D1" selected> D1 </option>';
    }else{
        echo '<option value="D1"> D1 </option>';
    }

    if ($pendidikan == 'D2'){
        echo '<option value="D2" selected> D2 </option>';
    }else{
        echo '<option value="D2"> D2 </option>';
    }

    if ($pendidikan == 'D3'){
        echo '<option value="D3" selected> D3 </option>';
    }else{
        echo '<option value="D3"> D3 </option>';
    }

    if ($pendidikan == 'D4'){
        echo '<option value="D4" selected> D4 </option>';
    }else{
        echo '<option value="D4"> D4 </option>';
    }

    if ($pendidikan == 'S1'){
        echo '<option value="S1" selected> S1 </option>';
    }else{
        echo '<option value="S1"> S1 </option>';
    }

    if ($pendidikan == 'S2'){
        echo '<option value="S2" selected> S2 </option>';
    }else{
        echo '<option value="S2"> S2 </option>';
    }

    if ($pendidikan == 'S3'){
        echo '<option value="S3" selected> S3 </option>';
    }else{
        echo '<option value="S3"> S3 </option>';
    }
?>