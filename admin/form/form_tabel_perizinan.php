
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  $("#example").DataTable();
</script>
<?php
  include "../../config/koneksi.php";
  include "../../config/fungsi_indotgl.php";
	$kategori = $_POST['kategori'];
  $idSiswa = $_POST['idSiswa'];
  $view = $_POST['view'];
  $nisSiswa=$_POST['nisSiswa'];
  $idTahunAjaran=$_POST['tahun_ajaran'];

	if ($kategori == 'Pulang Kerumah'){
?>
		<table id="example" class="table table-bordered" style="white-space: nowrap;">
      <thead>
        <tr class="info">
          <th>No.</th>
          <th>Tanggal</th>
          <th>Penjemput</th>
          <th>Waku Izin</th>
          <th>Keterangan</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
          <?php
            $tampil = mysqli_query($koneksi,"SELECT * FROM izin_pulang WHERE idSiswa = '$idSiswa' AND stdel='0'");
            $no = 1;
            while($r=mysqli_fetch_array($tampil)){
              echo '<tr>
                      <td>'.$no++.'</td>
                      <td>'.tgl_miring($r['tanggal']).'</td>
                      <td>'.$r['penjemput'].'</td>
                      <td>'.$r['waktuIzin'].' Hari</td>
                      <td>'.$r['keterangan'].'</td>
                      <td>
                        <a href="siswa/laporan/surat_izin_pulang.php?id='.$r['idPulang'].'" target="_BLANK" class="btn btn-xs btn-default" data-toggle="tooltip" title="" data-original-title="Cetak"><i class="fa fa-print"></i></a>
                        <a href="#del'.$r['idPulang'].'" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="" data-original-title="Hapus"></i></a>
                      </td>
                    </tr>';  

              echo '<div class="modal modal-default fade" id="del'.$r['idPulang'].'">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                            <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                          </div>
                          <div class="modal-body">
                            <p>Apakah anda yakin akan menghapus data ini?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                            <a href="index.php?view='.$view.'&thn_ajar='.$idTahunAjaran.'&nis='.$nisSiswa.'&idPulang='.$r['idPulang'].'&kategori='.$kategori.'&hapus"  class="btn btn-danger"><span class="fa fa-check"></span> Hapus </a>
                          </div>
                        </div>
                      </div>
                    </div>';         
            }
          ?>    
        </tbody>
      </table>
      
<?php        
	}elseif ($kategori == 'Keluar Pesantren'){
?>		
    <table id="example" class="table table-bordered" style="white-space: nowrap;">
      <thead>
        <tr class="info">
          <th>No.</th>
          <th>Tanggal</th>
          <th>Jam Keluar</th>
          <th>Jam Kembali</th>
          <th>Keterangan</th>
          <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
          <?php
            $tampil = mysqli_query($koneksi,"SELECT * FROM izin_keluar WHERE idSiswa = '$idSiswa' AND stdel='0'");
            $no = 1;
            while($r=mysqli_fetch_array($tampil)){
              echo '<tr>
                      <td>'.$no++.'</td>
                      <td>'.tgl_miring($r['tanggal']).'</td>
                      <td>'.$r['jamKeluar'].'</td>
                      <td>'.$r['jamKembali'].'</td>
                      <td>'.$r['keterangan'].'</td>
                      <td>
                        <a href="siswa/laporan/surat_keluar_thermal.php?id='.$r['idKeluar'].'" target="_BLANK" class="btn btn-xs btn-default" data-toggle="tooltip" title="" data-original-title="Cetak"><i class="fa fa-print"></i></a>
                        <a href="#del'.$r['idKeluar'].'" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" title="" data-original-title="Hapus"></i></a>
                      </td>
                    </tr>';     
              echo '<div class="modal modal-default fade" id="del'.$r['idKeluar'].'">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                            <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                          </div>
                          <div class="modal-body">
                            <p>Apakah anda yakin akan menghapus data ini?</p>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                            <a href="index.php?view='.$view.'&thn_ajar='.$idTahunAjaran.'&nis='.$nisSiswa.'&idKeluar='.$r['idKeluar'].'&kategori='.$kategori.'&hapus"  class="btn btn-danger"><span class="fa fa-check"></span> Hapus </a>
                          </div>
                        </div>
                      </div>
                    </div>';        
            }
          ?>        
        </tbody>
      </table>

<?php  
	}
?>