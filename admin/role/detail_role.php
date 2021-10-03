<?php
    include '../../config/koneksi.php';

    $role_id = $_GET['role_id'];
    echo '<table class="table table-hover table-responsive">
            <tbody>
                <tr>
                    <th width="10">No</th>
                    <th>Nama Modul</th>
                    <th>Keterangan</th>
                    <th width="100">Aksi</th>
                </tr>';
        $main_menu = mysqli_query($koneksi, "SELECT * FROM menu WHERE level='Admin' AND ketMenu='Main Menu'");
        $no=1;
        while($r=mysqli_fetch_array($main_menu)){
            echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.$r['namaMenu'].'</td>
                    <td>'.$r['ketMenu'].'</td>
                    <td>';
                    $users_hakakses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users_hak_akses WHERE IdUsersLevel='$role_id' AND idMenu='$r[idMenu]'"));
                    if ($users_hakakses == 1){
                        echo '<input type="checkbox" checked onclick="addRule('.$r['idMenu'].')">';
                    }else{
                        echo '<input type="checkbox" onclick="addRule('.$r['idMenu'].')">';
                    }
                    
            echo    '</td>
                </tr>';

            $sub_menu1 = mysqli_query($koneksi, "SELECT * FROM menu WHERE level='Admin' AND ketMenu='Sub Menu 1' AND noMenu='$r[idMenu]'");
            while($sub1=mysqli_fetch_array($sub_menu1)){
            	echo '<tr>
	                    <td>'.$no.'</td>
	                    <td>'.$sub1['namaMenu'].'</td>
	                    <td>'.$sub1['ketMenu'].'</td>
	                    <td>';
	                    $users_hakakses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users_hak_akses WHERE IdUsersLevel='$role_id' AND idMenu='$sub1[idMenu]'"));
	                    if ($users_hakakses == 1){
	                        echo '<input type="checkbox" checked onclick="addRule('.$sub1['idMenu'].')">';
	                    }else{
	                        echo '<input type="checkbox" onclick="addRule('.$sub1['idMenu'].')">';
	                    }
                    
            	echo '	</td>
               		 </tr>';

               	$sub_menu2 = mysqli_query($koneksi, "SELECT * FROM menu WHERE level='Admin' AND ketMenu='Sub Menu 2' AND noMenu='$sub1[idMenu]'");
	            while($sub2=mysqli_fetch_array($sub_menu2)){
	            	echo '<tr>
		                    <td>'.$no.'</td>
		                    <td>'.$sub2['namaMenu'].'</td>
		                    <td>'.$sub2['ketMenu'].'</td>
		                    <td>';
		                    $users_hakakses = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users_hak_akses WHERE IdUsersLevel='$role_id' AND idMenu='$sub2[idMenu]'"));
		                    if ($users_hakakses == 1){
		                        echo '<input type="checkbox" checked onclick="addRule('.$sub2['idMenu'].')">';
		                    }else{
		                        echo '<input type="checkbox" onclick="addRule('.$sub2['idMenu'].')">';
		                    }
	                    
	            	echo '	</td>
	               		 </tr>';
	               	$no++;
	            }

               	$no++;
            }
           	$no++;
        }
    echo '</tbody></table>';


?>

