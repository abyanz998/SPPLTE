<style type="text/css">
  .sekolah{
    float: left;
    background-color: transparent;
    background-image: none;
    padding: 15px 15px;
    font-family: fontAwesome;
    color:#fff;
  }

  .sekolah:hover{
    color:#fff;
  }
</style>
        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src="<?= $lokasi_penyimpanan_logo.$idt['logo_kiri'] ?>" class="user-image" alt="User Image" width="38px"></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
            <table width="100%">
              <tr>
                <td class="pull-left"><img src="<?= $lokasi_penyimpanan_logo.$idt['logo_kiri'] ?>" class="user-image" alt="User Image" width="38px"> </td>
                <td></td>
                <td class="text-center"><b><?= $idt['singkatanAplikasi'] ?></b></td>
              </tr>
            </table></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar" role="navigation">
          <!-- Sidebar toggle button-->
          <!-- <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a> -->

          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->

              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?= $foto_user ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?= $idt_user['nama_lengkap']; ?></span> <span class='caret'></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?= $foto_user; ?>" class="img-circle" alt="User Image">
                    <p>
                      <?= $idt_user['nama_lengkap']; ?>
                      <small><?= $idt_user['namaUsersLevel']; ?></small>
                      <small><?= $idt_user['email']; ?></small>
                    </p>
                  </li>
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="index.php?view=pengguna&act=detail&id=<?= $idUsers ?>" class="btn btn-default btn-flat">Profil</a>
                    </div>
                    <div class="pull-right">
                      <?php
                        echo "<a href='logout.php' class='btn btn-default btn-flat'>Keluar</a>";
                      ?>
                    </div>
                  </li>
                </ul>
              </li>

            </ul>
          </div>
        </nav>
