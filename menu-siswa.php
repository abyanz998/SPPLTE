<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
	<div class="pull-left image">
	  <img src="<?= $foto_siswa; ?>" class="img-circle" alt="User Image">
	</div>
	<div class="pull-left info">
	  <p><?= $idt_siswa['nmSiswa']; ?></p>
	  <a href="#"><i class="fa fa-circle text-success"></i>Tahun Ajaran : <?= $ta['nmTahunAjaran']; ?></a>
	</div>
  </div>

  <!-- sidebar menu: : style can be found in sidebar.less -->

  	<ul class="sidebar-menu">
		<li class="header">Menu</li>
			<?php
				$users_hak_akses_main_menu = mysqli_query($koneksi,"SELECT * FROM menu WHERE menu.ketMenu='Main Menu' AND menu.level='Siswa' ORDER BY menu.idMenu ASC");
				while($menu=mysqli_fetch_array($users_hak_akses_main_menu)){
					if ($_GET['view']==$menu['viewMenu'])
          { $aktifMainMenu = 'active'; }
					else{ $aktifMainMenu = ''; }

					if ($menu['viewMenu'] != '-'){
						echo '<li class="'.$aktifMainMenu.'"><a href="index-siswa.php?view='.strtolower($menu['viewMenu']).'">
            <i class="'.$menu['iconMenu'].' text-stock"></i> <span>'.ucwords($menu['namaMenu']).'</span></a></li>';
					}else{
						echo '<li class="treeview '.$aktifMainMenu.'">
								<a href="#">
									<i class="'.$menu['iconMenu'].' text-stock"></i>
										<span>'.ucwords($menu['namaMenu']).'</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>';
							echo '<ul class="treeview-menu">';
							$users_hak_akses_sub_menu1 = mysqli_query($koneksi,"SELECT * FROM menu WHERE AND menu.ketMenu='Sub Menu 1' AND menu.noMenu='$menu[idMenu]' AND menu.level='Siswa' ORDER BY menu.idMenu ASC");
							while($submenu1=mysqli_fetch_array($users_hak_akses_sub_menu1)){

								if ($_GET['view']==$submenu1['viewMenu'])
                { $aktifSub1 = 'active'; }
								else{ $aktifSub1 = ''; }

								if ($submenu1['viewMenu'] != '-'){
									echo '<li class="'.$aktifSub1.'"><a href="index-siswa.php?view='.strtolower($submenu1['viewMenu']).'">
                  <i class="'.$submenu1['iconMenu'].'"></i> '.ucwords($submenu1['namaMenu']).'</a></li>';
								}else{
									echo '<li class="treeview '.$aktifSub1.'">
										<a href="#">
											<i class="'.$submenu1['iconMenu'].' text-stock"></i>
												<span>'.ucwords($submenu1['namaMenu']).'</span>
											<i class="fa fa-angle-left pull-right"></i>
										</a>';
									echo '<ul class="treeview-menu">';
										$users_hak_akses_sub_menu2 =  mysqli_query($koneksi,"SELECT * FROM menu WHERE AND menu.ketMenu='Sub Menu 2' AND menu.noMenu='$menu[idMenu]' AND menu.noMenu='$submenu1[idMenu]' AND menu.level='Siswa' ORDER BY menu.idMenu ASC");
										while($submenu2=mysqli_fetch_array($users_hak_akses_sub_menu2)){

											if ($_GET['view']==$submenu2['viewMenu'])
                      { $aktifSub2 = 'active'; }
											else{ $aktifSub2 = ''; }

											echo '<li class="'.$aktifSub2.'"><a href="index-siswa.php?view='.strtolower($submenu2['viewMenu']).'">
                      <i class="'.$submenu2['iconMenu'].'"></i> '.ucwords($submenu2['namaMenu']).'</a></li>';
										}

									echo '</ul></li>';
								}
							}
						echo '</ul></li>';
					}

				}
			?>
		 <li><a href="logout.php" ><i class="fa fa-reply-all"></i>Keluar</a></li>
</section>
