<?php
    include '../../config/koneksi.php';

    $idLevel=$_POST['idLevel'];

    echo '<option value="" disabled="" selected="">- Pilih Hak Akses -</option>';
    $query = mysqli_query($koneksi,"SELECT * FROM users_level ORDER BY idUsersLevel ASC");
    
    while ($q = mysqli_fetch_array($query)) {
        if ($q['idUsersLevel'] != 1){
            if ($idLevel == $q['idUsersLevel']){
                echo '<option value="'.$q['idUsersLevel'].'" selected>'.$q['namaUsersLevel'].'</option>';
            }else{
                echo '<option value="'.$q['idUsersLevel'].'">'.$q['namaUsersLevel'].'</option>';
            }
        }
    }
?>